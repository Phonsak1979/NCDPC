<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel; // สมมติว่าคุณมี UserModel
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    use ResponseTrait; 
    
    public function register()
    {
        $userModel = new UserModel();

        // รับข้อมูล JSON ที่ส่งมา
        // ใช้ getVar() จะยืดหยุ่นกว่า getJSON() เล็กน้อย
        $data = [
            'hcode'    => $this->request->getVar('hcode'),
            'email'    => $this->request->getVar('email'),
            'fname'    => $this->request->getVar('fname'),
            'username' => $this->request->getVar('username'),
            'permis'   => $this->request->getVar('usercode') ?? 'user', // ถ้าไม่ส่งมา ให้เป็น 'user'
            'password' => $this->request->getVar('password') // <--- รับรหัสผ่าน (plaintext)
        ];

        // $userModel->save($data) จะ:
        // 1. ตรวจสอบ Validation Rules (ที่กำหนดใน Model)
        // 2. ถ้าผ่าน, เรียก Callback 'beforeInsert' (hashPassword)
        // 3. Insert ข้อมูลลง DB
        if ($userModel->save($data) === false) {
            // ถ้า Validation ไม่ผ่าน
            return $this->fail($userModel->errors(), 400); // 400 Bad Request
        }

        // ลงทะเบียนสำเร็จ
        return $this->respondCreated(['message' => 'สร้างผู้ใช้งานสำเร็จ']);
    }

    /**
     * ฟังก์ชันสำหรับ Login และสร้าง JWT Token
     */
    public function login()
    {
        // 1. รับค่า 'login' (ซึ่งอาจเป็น email หรือ username)
        $login_identity = $this->request->getVar('login'); 
        $password = $this->request->getVar('password');

        if (!$login_identity || !$password) {
            return $this->fail('กรุณาส่งข้อมูล Login และ Password', 400); 
        }

        $userModel = new UserModel();
        
        // 2. ค้นหาทั้งสองคอลัมน์ (email หรือ username)
        $user = $userModel->where('email', $login_identity)
                          ->orWhere('username', $login_identity)
                          ->first(); 

        // 3. ตรวจสอบว่าพบผู้ใช้หรือไม่
        if (!$user) {
            return $this->failUnauthorized('Email/Username หรือ รหัสผ่านไม่ถูกต้อง');
        }

        // 4. ตรวจสอบรหัสผ่าน
        if (!password_verify($password, $user->password_hash)) {
            return $this->failUnauthorized('Email/Username หรือ รหัสผ่านไม่ถูกต้อง2');
        }
        // --- (ถ้ามาถึงตรงนี้ แสดงว่า Login ถูกต้อง) ---

        // 6. เตรียมข้อมูลสำหรับสร้าง Token (Payload)
        $key  = getenv('jwt.secretkey');
        $algo = getenv('jwt.algo');
        
        $iat = time(); // Issued at: เวลาที่ออก token
        $duration = 3600; // 1 ชั่วโมง
        $exp = $iat + $duration; // Expiration time

        $payload = [
            'iss' => base_url(), 
            'aud' => base_url(),
            'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'user_id'  => $user->id,
                'email'    => $user->email,
                'username' => $user->username,
                'fname'    => $user->fname, // (อย่าลืมเพิ่ม fname ตอน Login)
                'role'     => $user->permis,
                'hcode'    => $user->hcode
            ]
        ];

        // 7. สร้าง (Encode) JWT Token
        $token = JWT::encode($payload, $key, $algo);

        // 8. (สำคัญ) เก็บ Token ไว้ใน Session ของ Server
        session()->set('jwt_token', $token);
        
        // (ทางเลือก) เก็บข้อมูลหลักไว้ใน Session เพื่อเรียกใช้ง่ายๆ
        session()->set('user_info', [
            'user_id'  => $user->id,
            'username' => $user->username,
            'fname'    => $user->fname,
            'role'     => $user->permis,
        ]);


        // 9. ส่ง JSON กลับไปให้ AJAX (สำหรับ localStorage)
        return $this->respond([
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'token'   => $token, // (สำหรับ localStorage)
            'user'    => [
                'email' => $user->email,
                'fname' => $user->fname,
                'hcode' => $user->hcode,
                'username' => $user->username,
                'role'  => $user->permis
            ]
        ]);
    }
}