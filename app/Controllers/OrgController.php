<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OfficeModel;
use App\Models\CaregiverModel;
use App\Models\ltcModel;

class OrgController extends BaseController
{
    private $officeModel;
    private $caregiverModel;
    private $ltcModel;
    public function __construct()
    {
        $this->officeModel = new OfficeModel();
        $this->caregiverModel = new CaregiverModel();
        $this->ltcModel = new LtcModel();
    }

    public function index()
    {
        $userData = $this->request->user;
        if ($userData->role <> 'org') {     
            return redirect()->to(base_url('public/login'));
        }
        $data = [
            'page' => 'org-page', // (สำหรับไฮไลท์เมนู)
            'user' => $userData,
        ];
        return view('org/index', $data);
    }

    public function profile()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
        $data = [
            'page' => 'profile-page', // (สำหรับไฮไลท์เมนู)
            'user' => $userData,
            'office' => $officeData,
        ];
        return view('org/profile', $data);
    }

    public function caregiver()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
        $caregiverData = $this->caregiverModel->where('hcode', $userData->hcode)->findAll();
        $data = [
            'page' => 'caregiver-page', // (สำหรับไฮไลท์เมนู)
            'user' => $userData,
            'office' => $officeData,
            'caregiver' => $caregiverData,
        ];
        return view('org/caregiver', $data);
    }
       
}
