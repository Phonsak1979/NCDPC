<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OfficeModel; // <-- (สำคัญ) 1. Import OfficeModel
use App\Models\RiskdmModel;
use App\Models\SeledmModel;
use App\Models\HcoachModel;
use App\Models\personModel;
use App\Models\HealthlitModel;
use CodeIgniter\API\ResponseTrait;
use Config\Validation;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\Switch_;

class MobileController extends BaseController
{
    public $officeModel; // <-- (สำคัญ) 2. สร้าง property สำหรับเก็บ object officeModel
    public $officeData;
    private $seledmModel; 
    private $hcoachModel;
    private $personModel;
    private $healthlitModel;

    use ResponseTrait; 

    public function __construct()
    {
        helper('form');
        $this->officeModel = new OfficeModel();
        $this->seledmModel = new SeledmModel();
        $this->hcoachModel = new HcoachModel();
        $this->personModel = new personModel();
        $this->healthlitModel = new HealthlitModel();
    }
    public function login()
    {
        return view('mobile/login');
    }
    public function login_process()
    {
       $code = $this->request->getPost('access_code');
       $user = $this->hcoachModel->where('tel', $code)->first();
        if ($user) {
            session()->set(['user_id' => $user['id'],'hcode' => $user['hcode'], 'user_tel' => $user['tel'], 'isLoggedIn' => true, 'hcoachname' => $user['hcoachname']]);
            return $this->response->setJSON(['msg'=>'success', 'text'=>'เข้าสู่ระบบสำเร็จ']);
        } else {
            return $this->response->setJSON(['msg'=>'error', 'text'=>'รหัสไม่ถูกต้อง']);
        
        }
        return $this->response->setJSON(['msg'=>'error', 'text'=>'เกิดข้อผิดพลาด']);
    }
    public function risk_login()
    {
        return view('riskgroup/login');
    }
    public function risk_login_process()
    {
        $code = $this->request->getPost('access_code');
        $user = $this->seledmModel->where('cid', $code)->first();
        if ($user) {
            session()->set(['user_id' => $user['id'],'hcode' => $user['hcode'],'isLoggedIn' => true, 'hcoachname' => $user['hcoachname']]);
            return $this->response->setJSON(['msg'=>'success', 'text'=>'เข้าสู่ระบบสำเร็จ']);
        } else {
            return $this->response->setJSON(['msg'=>'error', 'text'=>'รหัสไม่ถูกต้อง']);
        
        }
        return $this->response->setJSON(['msg'=>'error', 'text'=>'เกิดข้อผิดพลาด']);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('public/mb-login'));
    }
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('public/mb-login'));
        }
        $userHcode = session()->get('hcode');
        $officeData = $this->officeModel->find($userHcode);
        $data = [
            'page' => 'menu-page', // (สำหรับไฮไลท์เมนู)
            'hcoachname' => session()->get('hcoachname'),
            'office' => $officeData // (ส่ง object ผู้ใช้ทั้งก้อน)
        ];
        return view('mobile/menu',$data);
    }
    public function riskList()
    {
        if (!session()->get('isLoggedIn')) {
                return redirect()->to(base_url('public/mb-login'));
        }
        $userHcode = session()->get('hcode');
        $userTel = session()->get('user_tel');
        $officeData = $this->officeModel->find($userHcode);
        $riskper = $this->seledmModel->get_risk_per($userTel);
        $data = [
            'page' => 'HealthLit-page', // (สำหรับไฮไลท์เมนู)
            'hcoachname' => session()->get('hcoachname'),
            'office' => $officeData,
            'riskper' => $riskper
        ];
        return view('mobile/listper',$data);

    }
    public function riskList_menu($id,$hoscode,$pid)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('public/mb-login'));
        }
        $officeData = $this->officeModel->find($hoscode);
        $pername = $this->personModel->getPersonName($hoscode,$pid);
        $data = [
            'page' => 'menu-page', // (สำหรับไฮไลท์เมนู)
            'pername' => $pername,
            'office' => $officeData,
            'id' => $id,
        ];
        return view('mobile/mobile_menu',$data);

    }
    public function healthLiteracy()
    {
        $data = [
            'videoname' => $this->healthlitModel->orderBy('d_update', 'DESC')->get()->getResultArray(),
            'page' => 'HealthLit-page',
        ];
       
        return view('mobile/Hliteracy',$data);
    }
    public function viewVideo($videoname)
    {
        $data = [
            'page' => 'video-page', // (สำหรับไฮไลท์เมนู)
            'videoname' => $videoname
        ];
        return view('mobile/view_video',$data);
    }
    public function HLmanage()
    {
        $data = [
            'page' => 'HLmanage-page', // (สำหรับไฮไลท์เมนู)
        ];

        return view('mobile/HL_manage',$data);
    }
    public function getHliteracy()
    {
        $Hliteracy = $this->healthlitModel->get()->getResultArray();
        
        return $this->response->setJSON($Hliteracy);
    }
    public function hl_survay($id)
    {
        $userHcode = session()->get('hcode');
        $officeData = $this->officeModel->find($userHcode);
        $data = [
            'page' => 'video-page', // (สำหรับไฮไลท์เมนู)
            'hcoachname' => session()->get('hcoachname'),
            'office' => $officeData
        ];
        return view('mobile/hl_survay',$data);
    
    }
}
   
