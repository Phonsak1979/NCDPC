<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('jwt.secretkey');
        $algo = getenv('jwt.algo');
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');

        if (!$authHeader) {
            // ไม่ได้ส่ง Authorization header มา
            return service('response')
                ->setJSON(['message' => 'ไม่พบ Token (Access denied)'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Token มักจะมาในรูปแบบ "Bearer <token>"
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            // รูปแบบ Header ไม่ถูกต้อง
            return service('response')
                ->setJSON(['message' => 'รูปแบบ Token ไม่ถูกต้อง (Invalid token format)'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        try {
            // พยายามถอดรหัส Token
            // **สำคัญ:** v6+ ของ php-jwt ต้องใช้ Key object
            $decoded = JWT::decode($token, new Key($key, $algo));

            // (ทางเลือก) คุณสามารถเก็บข้อมูล user ที่ถอดรหัสไว้ใน Request
            // เพื่อให้ Controller ที่ถูกเรียกใช้ต่อ นำไปใช้ได้
            $request->user = $decoded->data;

        } catch (Exception $e) {
            // Token ไม่ถูกต้อง (เช่น หมดอายุ, signature ผิด)
            return service('response')
                ->setJSON(['message' => 'Token ไม่ถูกต้องหรือหมดอายุ (Invalid or expired token)'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ไม่ต้องทำอะไรหลัง
    }
}