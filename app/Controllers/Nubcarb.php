<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Nubcarb extends BaseController
{
    public function index()
    {
        $userHcode = session()->get('hcode');
        $data = [
            'hcoachname' => session()->get('hcoachname'),
            'page' => 'nubcarb',
            'csrf_token'  => csrf_token(),
            'csrf_hash'   => csrf_hash(),
        ];
        return view('nubcarb/form', $data);
    }
    public function save()
    {
        if (!$this->request->is('post')) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                ->setJSON(['success' => false, 'message' => 'Method not allowed']);
        }

        $json = $this->request->getJSON(true);
        if (empty($json)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'ไม่พบข้อมูล']);
        }
    }
}
