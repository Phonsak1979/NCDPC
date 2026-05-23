<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OfficeModel; // <-- (สำคัญ) 1. Import OfficeModel
use App\Models\personModel;
use App\Models\RiskdmModel;
use App\Models\RiskhtModel;
use App\Models\SeledmModel;
use App\Models\SeleHtModel;
use App\Models\NewDMModel;
use App\Models\NewHTModel;
use App\Models\OldDmModel;
use App\Models\OldHtModel;
use App\Models\NewdmhtModel;
use App\Models\DmckdModel;
use App\Models\tumbonModel;
use App\Models\VillageModel;
use App\Models\OsmModel;
use App\Models\HlSurvay;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\UserAgent;
use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\throwException;

class Admin extends BaseController
{
    use ResponseTrait; 
    protected $officeModel; 
    protected $personModel; 
    protected $RiskdmModel; 
    protected $RiskhtModel;
    protected $SeledmModel;
    protected $SelehtModel;
    protected $NewDMMOdel;
    protected $NewHTModel;
    protected $OldDmModel;
    protected $OldHtModel;
    protected $NewdmhtModel;
    protected $dmckdModel;
    protected $tumbonModel;
    protected $villageModel;
    protected $OsmModel;
    protected $hlSurveyModel;
    protected $userAgent;

    public function __construct()
    {
        $this->officeModel  = new OfficeModel();
        $this->personModel = new personModel();
        $this->RiskdmModel = new RiskdmModel();
        $this->RiskhtModel = new RiskhtModel();
        $this->SeledmModel = new SeledmModel();
        $this->SelehtModel = new SeleHtModel();
        $this->NewDMMOdel = new NewDMModel();
        $this->NewHTModel = new NewHTModel();
        $this->OldDmModel = new OldDmModel();
        $this->OldHtModel = new OldHtModel();
        $this->NewdmhtModel = new NewdmhtModel();
        $this->dmckdModel = new DmckdModel();
        $this->tumbonModel = new tumbonModel();
        $this->villageModel = new VillageModel();
        $this->OsmModel = new OsmModel();
        $this->hlSurveyModel = new HlSurvay();
        $this->userAgent = new UserAgent();
    }
    public function loginPage()
    {
        if ($this->userAgent->isMobile()) {
            return view('mobile/login');
        }
        return view('auth/login');
    }

    /**
     * แสดงหน้าฟอร์ม Register
     */
    public function registerPage()
    {
        $userData = $this->request->user;
         if (!$userData) {
            return $this->fail('ไม่พบข้อมูลผู้ใช้จาก Token', 400);
        }
        return view('auth/register');
    }

    public function dashboard()
    {
        $userAgent = $this->request->getUserAgent();
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
        $officeData = $this->officeModel->find($userData->hcode);
       
        if($userAgent->isMobile()){
             
             $data = [
                'user' => $userData,
                'office' => $officeData,
             ];
             return view('mobile/menu',$data);
        } else {
             if($userData->role == 'auth')
            {
               $data = [
                    'population'  => $this->personModel->countAllResults(),
                    'riskNcds' => ceil($this->RiskdmModel->countAllResults() + $this->RiskhtModel->countAllResults()),
                    'newcase' => ceil($this->NewDMMOdel->countAllResults()+$this->NewHTModel->countAllResults()),
                    'inproj' => ceil($this->SeledmModel->countAllResults()),
                    'chronicAll' => ceil($this->OldDmModel->countAllResults()+$this->OldHtModel->countAllResults()),
                    'dmCkd' => $this->dmckdModel->countAllResults(),
                    'office'=> $officeData
                ];
            } else {
                $data = [
                    'population'  => $this->personModel->where('hospcode', $userHcode)->countAllResults(),
                    'riskNcds' => ceil($this->RiskdmModel->where('hospcode', $userHcode)->countAllResults() + $this->RiskhtModel->where('hospcode', $userHcode)->countAllResults()),
                    'newcase' => ceil($this->NewDMMOdel->where('hospcode', $userHcode)->countAllResults()+$this->NewHTModel->where('hospcode', $userHcode)->countAllResults()),
                    'inproj' => ceil($this->SeledmModel->where('hospcode', $userHcode)->countAllResults()),
                    'chronicAll' => ceil($this->OldDmModel->where('hospcode', $userHcode)->countAllResults()+$this->OldHtModel->where('hospcode', $userHcode)->countAllResults()),
                    'dmCkd' => $this->dmckdModel->where('hospcode', $userHcode)->countAllResults(),
                    'office'=> $officeData
                ];
            }
            
            return view('dashboard/index',$data);
        }
    }
    
    public function getChart_data()
    {
        $userData = $this->request->user;
        if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $chart_riskdm = $this->RiskdmModel->getRiskByOrgan_chart($userHcode);
        $chart_riskht = $this->RiskhtModel->getRiskByOrgan_chart($userHcode);
        $labels = [];
        $counts = [];
        $labels2 = [];
        $counts2 = [];
        foreach($chart_riskdm  as $val)
        {
            array_push($labels,$val['villname']);
            array_push($counts,$val['countID']);
        }
        foreach($chart_riskht  as $val)
        {
            array_push($labels2,$val['villname']);
            array_push($counts2,$val['countID']);
        }
        $data = [
            'labels' => $labels,
            'counts' => $counts,
            'labels2' => $labels2,
            'counts2' => $counts2
        ];
        return $this->response->setJSON($data);
    }
    public function getChart_patient()
    {
        $userData = $this->request->user;
        if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $chart_patient = $this->OldDmModel->getPatientByOrgan_chart($userHcode);
        //print_r($chart_patient);
        $labels = [];
        $counts_dm = [];
        $labels2 = [];
        $counts_ht = [];
        
        foreach($chart_patient  as $val)
        {
            if($val['type'] == 'dm')
                {
                array_push($labels,$val['hospcode']);
                array_push($counts_dm,$val['countpid']);
            } else if($val['type'] == 'ht')
            {
                array_push($labels2,$val['hospcode']);
                array_push($counts_ht,$val['countpid']);
            }
        }
        
        $data = [
            'labels' => $labels,
            'counts_dm' => $counts_dm,
            'labels2' => $labels2,
            'counts_ht' => $counts_ht
        ];
        
        return $this->response->setJSON($data);
    }
    public function get_data_chartInproj()
    {
        $userData = $this->request->user;
        if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $chart_riskdm = $this->SeledmModel->getRiskByOrgan_chart($userHcode);
        $chart_riskht = $this->SelehtModel->getRiskByOrgan_chart($userHcode);
        $labels = [];
        $counts = [];
        $labels2 = [];
        $counts2 = [];
        foreach($chart_riskdm  as $val)
        {
            array_push($labels,$val['villname']);
            array_push($counts,$val['countID']);
        }
        foreach($chart_riskht  as $val)
        {
            array_push($labels2,$val['villname']);
            array_push($counts2,$val['countID']);
        }
        $data = [
            'labels' => $labels,
            'counts' => $counts,
            'labels2' => $labels2,
            'counts2' => $counts2
        ];
        return $this->response->setJSON($data);
    }
    public function get_risk_Chart_bf()
    {
        $userData = $this->request->user;
        if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $chart_riskdm = $this->SeledmModel->get_risk_inproj_bf($userHcode);
        $labels = [];
        $counts = [];
        
        foreach($chart_riskdm  as $val)
        {
            array_push($labels,$val['result']);
            array_push($counts,$val['countid']);
        }

        $data = [
            'labels' => $labels,
            'counts' => $counts
        ];
        return $this->response->setJSON($data);
        
    }
    public function get_risk_Chart_af()
    {
        $userData = $this->request->user;
        if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $chart_riskdm = $this->SeledmModel->get_risk_inproj_af($userHcode);
        $labels = [];
        $counts = [];
        
        foreach($chart_riskdm  as $val)
        {
            array_push($labels,$val['result2']);
            array_push($counts,$val['countid']);
        }

        $data = [
            'labels' => $labels,
            'counts' => $counts
        ];
        return $this->response->setJSON($data); 
    }
    public function getChart_All()
    {
         $userData = $this->request->user;
         if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $riskAll = $this->RiskdmModel->getRiskAll($userHcode);
        $risks = [];
        $counts = [];
        foreach($riskAll as $risk)
            {
                array_push($risks,$risk['result']);
                array_push($counts,$risk['countID']);
            }
        $data = [
            'riskAll'=> $risks,
            'counts' => $counts
        ];
        return $this->response->setJSON($data);

    }
    public function getChart_newcase()
    {
        $userData = $this->request->user;
         if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $newcase = $this->NewDMMOdel->getNewcaseByhcode($userHcode);
        $labels = [];
        $labels_ht = [];
        $labels_dmht = [];
        $counts_dm = [];
        $counts_ht = [];
        $counts_dmht = [];
        foreach($newcase as $new)
            {
                if($new['type']=== 'dm')
                    {
                        array_push($labels,$new['hospcode']);
                        array_push($counts_dm,$new['countpid']);
                    } elseif($new['type']=== 'ht')
                    {
                        array_push($labels_ht,$new['hospcode']);
                        array_push($counts_ht,$new['countpid']);
                    } else {
                        array_push($labels_dmht,$new['hospcode']);
                        array_push($counts_dmht,$new['countpid']);
                    }
            }
        $data = [
                'labels' => $labels,
                'labels_ht' => $labels_ht,
                'labels_dmht' => $labels_dmht,
                'counts_dm' => $counts_dm,
                'counts_ht' => $counts_ht,
                'counts_dmht' => $counts_dmht,
        ];
        return $this->response->setJSON($data);
    }
    public function getChart_ckd()
    {
        $userData = $this->request->user;
         if($userData->role == 'admin'){
            $userHcode = $userData->hcode;
        } else {
            $userHcode = "";
        }
        $dmckd = $this->dmckdModel->getDmCkdByhcode($userHcode);
        $labels = [];
        $counts = [];
        foreach ($dmckd as $item) {
            array_push($labels,$item['hospcode']);
            array_push($counts,$item['countid']);
        }
        $data = [
            'labels' => $labels,
            'counts' => $counts,
        ];
        return $this->response->setJSON($data);
    }
    public function getCkd_data()
    {
        $userData = $this->request->user;
        if($userData->role == 'auth')
            {
                $userHcode = "";
            } else {
                $userHcode = $userData->hcode;
            }
        $dmckd = $this->dmckdModel->getDmCkdData($userHcode);
        return $this->response->setJSON($dmckd);
    }
    public function getChart_healthLit()
    {
        $userData = $this->request->user;
         if($userData->role == 'auth'){
            $userHcode = "";
        } else {
            $userHcode = $userData->hcode;
        }
        $healthLit = $this->hlSurveyModel->getHlbyall($userHcode);
        $hl = [];
        foreach ($healthLit as $item) {
            array_push($hl, $item['score_access']);
            array_push($hl, $item['score_understand']);
            array_push($hl, $item['score_apply']);
            array_push($hl, $item['score_eval']);
        }
        $data = [
            'counts' => $hl,
        ];
        //print_r($data);
        return $this->response->setJSON($data);
    }
    public function getChart_result()
    {
        $userData = $this->request->user;
         if($userData->role == 'auth'){
            $userHcode = "";
        } else {
            $userHcode = $userData->hcode;
        }  
        $labels = [];
        $hcoachs = [];
        $results = [];
        
        $result = $this->SeledmModel->get_result_by_hcode($userHcode);
        foreach($result as $item)
            {   
                array_push($labels, $item['hospcode']);
                array_push($hcoachs, $item['hcoachs']);
                array_push($results, $item['results']);
            }
        $data = [
            'labels' => $labels,
            'hcoachs' => $hcoachs,
            'results' => $results
        ];
        return $this->response->setJSON($data);
    }
     
    public function profile()
    {
        // 1. ดึงข้อมูลผู้ใช้ที่ Filter 'jwtweb' ถอดรหัสมาให้
        // $this->request->user คือ object ที่มาจาก $payload['data']
        $userData = $this->request->user;

        // 2. เตรียมข้อมูลส่งให้ View
        $data = [
            'page' => 'profile-page', // (สำหรับไฮไลท์เมนู)
            'user' => $userData // (ส่ง object ผู้ใช้ทั้งก้อน)
        ];

        // 3. โหลด View (Star Admin)
        return view('dashboard/profile', $data);
    }
    /**
     * (เพิ่ม) แสดงหน้าข้อมูลหน่วยงาน (ดึง hcode จาก Token)
     */
    public function office()
    {
        // 2. ดึงข้อมูลผู้ใช้ (Payload) ที่ Filter ถอดรหัสมาให้
        $userData = $this->request->user;

        // 3. ดึง hcode จาก Payload
        $userHcode = $userData->hcode;

        // 4. เตรียม Model และค้นหาข้อมูลหน่วยงาน
        $officeModel = new OfficeModel();
        
        // $officeModel->find($userHcode)
        // จะค้นหา Primary Key (hcode) ในตาราง ltc_office
        $officeData = $officeModel->find($userHcode);

        // 5. เตรียมข้อมูลส่งให้ View
        $data = [
            'page'   => 'office-page', // สำหรับไฮไลท์เมนู
            'user'   => $userData,    // ส่งข้อมูลผู้ใช้ไปด้วย (สำหรับ Layout)
            'office' => $officeData  // ส่งข้อมูลหน่วยงานที่ค้นหาเจอ
        ];
        
        return view('dashboard/office', $data);
    }

    public function offices()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
        $OfficeModel = new OfficeModel();
        if($userData->role == 'auth')
            {
                $officeData = $OfficeModel->get()->getResultArray();
            } else {
                $officeData = $OfficeModel->where('hcode',$userHcode)->get()->getResultArray();
            }
        return view('dashboard/officesAll',$officeData);
    }
    public function get_office()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
        $OfficeModel = new OfficeModel();
         if($userData->role == 'auth')
            {
                $officeData = $OfficeModel->get()->getResultArray();
            } else {
                $officeData = $OfficeModel->where('hcode',$userHcode)->get()->getResultArray();
            }
        return $this->response->setJSON($officeData);
    }
    public function get_office_by_code()
    {
        $userData =  $this->request->user;
        $hcode = $this->request->getVar('hcode');
        $office = $this->officeModel->where('hcode',$hcode)->get()->getResultArray();
        return $this->response->setJSON($office);
    }
    public function addOffice()
    {
        $userData = $this->request->user;
        if($userData->role == 'auth')
            {
                $hcode = $this->request->getPost('hcode');
                $hname = $this->request->getPost('hname');
                $htype = $this->request->getPost('htype');
                $hdepart = $this->request->getPost('hdepart');
                $tumbon = $this->request->getPost('tumbon');
                $ampname = $this->request->getPost('ampname');
                $province = $this->request->getPost('province');
                $data = [
                    'hcode' => $hcode,
                    'hname' => $hname,
                    'htype' => $htype,
                    'hdepart' => $hdepart,
                    'tmb_code' => $tumbon,
                    'amp_code' => $ampname,
                    'chw_code' => $province,
                    'd_update' => date('Y-m-d H:i:s'),
                    
                ];
                if($this->officeModel->bulkInsert($data)){
                    return $this->response->setJSON(['status'=>'success','msg'=>'เพิ่มหน่วยงานเรียบร้อย']);
                } else {
                    return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถเพิ่มหน่วยงานได้']);
                }
            } 
        return false;
        
    }
    public function editOffice()
    {
        $userData = $this->request->user;
        $hcode = $this->request->getPost('hcode');
        $hname = $this->request->getPost('hname');
        $htype = $this->request->getPost('htype');
        $hdepart = $this->request->getPost('hdepart');
        $tumbon = $this->request->getPost('tumbon');
        $ampname = $this->request->getPost('ampname');
        $province = $this->request->getPost('province');
        $data = [
            'hcode' => $hcode,
            'hname' => $hname,
            'htype' => $htype,
            'hdepart' => $hdepart,
            'tmb_code' => $tumbon,
            'amp_code' => $ampname,
            'chw_code' => $province,
            'd_update' => date('Y-m-d H:i:s'),
        ];
        if($this->officeModel->where('hcode',$hcode)->update($data)){
            return $this->response->setJSON(['status'=>'success','msg'=>'แก้ไขข้อมูลหน่วยงานเรียบร้อย']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถแก้ไขข้อมูลหน่วยงานได้']);
    }
    public function deleteOffice()
    {
        $hcode = $this->request->getPost('hcode');
        if($this->officeModel->delete($hcode)){
            return $this->response->setJSON(['status'=>'success','msg'=>'ลบข้อมูลหน่วยงานเรียบร้อย']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถลบข้อมูลหน่วยงานได้']);
    }
     public function tumbons()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
        $OfficeModel = new OfficeModel();
        if($userData->role == 'auth')
            {
                $officeData = $OfficeModel->get()->getResultArray();
            } else {
                $officeData = $OfficeModel->where('hcode',$userHcode)->get()->getResultArray();
            }
        return view('dashboard/tumbonMuban',$officeData);
    }
    public function get_tumbon()
    {
        $userData = $this->request->user;
        $officeData = $this->tumbonModel->get()->getResultArray();
        return $this->response->setJSON($officeData);
    }
    public function get_village()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
         if($userData->role == 'auth')
            {
                $officeData = $this->villageModel->get()->getResultArray();
            } else {
                $officeData =  $this->villageModel->where('hoscode',$userHcode)->get()->getResultArray();
            }
        return $this->response->setJSON($officeData);
    }
    public function get_osm()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
         if($userData->role == 'auth')
            {
                $officeData = $this->OsmModel->get()->getResultArray();
            } else {
                $officeData =  $this->OsmModel->where('hcode',$userHcode)->get()->getResultArray();
            }
         return $this->response->setJSON($officeData);
    }
}