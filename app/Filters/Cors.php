<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // กำหนด CORS headers ให้กับทุก Request
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

        // หากเบราว์เซอร์ส่ง OPTIONS request (Preflight) เข้ามา ให้สิ้นสุดการทำงานทันที
        if (strtolower($request->getMethod()) === 'options') {
            exit;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // เนื่องจากกำหนดใน before() ไปแล้ว ใน after() ไม่จำเป็นต้องทำซ้ำ
        return $response;
    }
}
