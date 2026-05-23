<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\personModel;
use App\Models\OfficeModel;
use App\Models\RiskdmModel;
use App\Models\RiskhtModel;
use App\Models\ScreenDMModel;
use App\Models\ScreenHTModel;
use App\Models\ScreenCKDModel;
use App\Models\ScreenCVDModel;

class ScreenController extends BaseController
{
    private $personModel;
    private $riskdmModel;
    private $riskhtModel;
    private $officeModel;
    private $screendmModel;
    private $screenhtModel;
    private $screenckdModel;
    private $screencvdModel;

    public function __construct()
    {
        $this->personModel = new personModel();
        $this->riskdmModel = new RiskdmModel();
        $this->riskhtModel = new RiskhtModel();
        $this->officeModel = new OfficeModel();
        $this->screendmModel = new ScreenDMModel();
        $this->screenhtModel = new ScreenHTModel();
        $this->screenckdModel = new ScreenCKDModel();
        $this->screencvdModel = new ScreenCVDModel();
        helper('form');
    }
    public function index()
    {
        
    }
    public function screenDM()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
         if($userData->role =='auth')
            {
                $userHcode = '';
                $seleoffice  =$this->officeModel->get()->getResultArray();
            } else {
                $userHcode =  $userData->hcode;
                $seleoffice  =$this->officeModel->where('hcode', $userHcode)->get()->getResultArray();
            }
       
        $data = [
            'pageTitle' => 'หน้าคัดกรองความเสี่ยง DM',
            'userHcode' => $userData->hcode,
            'userRole' => $userData->role,
            'office' => $officeData,
            'seleoffice' => $seleoffice
        ];
        return view('screen/screen_dm', $data);
    }
    
    public function screenHT()
    {
        return view('screen/screen_ht');
    }
    
    public function screenCKD()
    {
        return view('screen/screen_ckd');
    }
    public function screenCVD()
    {
        return view('screen/screen_cvd');
    }
    public function fetch_screen_dm($hcode = null, $villcode = null)
    {
        if($hcode == 'null') $hcode = null;
        if($villcode == 'null') $villcode = null;
         $data = $this->screendmModel->getPerScreenByHoscode($hcode, $villcode);
        return $this->response->setJSON($data);
    }
    public function fetch_non_screen_dm($hcode = null, $villcode = null)
    {
        if($hcode == 'null') $hcode = null;
        if($villcode == 'null') $villcode = null;           
        $data = $this->screendmModel->getPerScreenByHoscode($hcode, $villcode);
        return $this->response->setJSON($data);
    }
        
    public function fetch_screen_ht()
    {
        $userData = $this->request->user;
        $hcode = $userData->hcode;
        $data = $this->screenhtModel->getPerScreenByHoscode($hcode);
        return $this->response->setJSON($data);
    }
    public function fetch_screen_ckd()
    {
        $userData = $this->request->user;
        $hcode = $userData->hcode;
        $data = $this->screenckdModel->getPerScreenByHoscode($hcode);
        return $this->response->setJSON($data);
    }
}
