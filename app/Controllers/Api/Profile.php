<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait; // <-- 1. อย่าลืมเพิ่ม!

class Profile extends BaseController
{
    use ResponseTrait; // <-- 2. อย่าลืมเพิ่ม!

    public function index()
    {
        // $this->request->user ถูกสร้างและแนบมาให้
        // โดย Filter ของเรา (JwtAuth.php)
        // มันคือส่วน 'data' ที่เรายัดไว้ใน $payload ตอนสร้าง token
        
        $userData = $this->request->user; 

        if (!$userData) {
            return $this->fail('ไม่พบข้อมูลผู้ใช้จาก Token', 400);
        }

        // คืนค่า JSON ของข้อมูลผู้ใช้
        return $this->respond([
            'message' => 'เข้าถึงข้อมูลสำเร็จ (Protected data)',
            'user' => [
                'id'       => $userData->user_id,
                'email'    => $userData->email,
                'username' => $userData->username,
                'role'     => $userData->role,
                'hcode'    => $userData->hcode
            ]
        ]);
    }
}