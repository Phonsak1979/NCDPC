<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtAuthWeb implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('jwt.secretkey');
        $algo = getenv('jwt.algo');
        
        // 1. (แก้ไข) อ่าน Token จาก Session (ไม่ใช่ Cookie)
        $token = session()->get('jwt_token');

        if (!$token) {
            // ถ้าไม่มี Token ใน Session, กลับไปหน้า Login
            return redirect()->to(base_url('public/login'));
        }

        try {
            // 2. ถอดรหัส Token
            $decoded = JWT::decode($token, new Key($key, $algo));
            
            // 3. แนบข้อมูลผู้ใช้ (Payload) ไปกับ Request
            $request->user = $decoded->data; 

        } catch (Exception $e) {
            // 4. ถ้า Token ผิด (เช่น หมดอายุ), ลบ Session แล้วกลับไปหน้า Login
            session()->remove('jwt_token');
            session()->remove('user_info');
            return redirect()->to(base_url('public/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ไม่ต้องทำอะไร
    }
}