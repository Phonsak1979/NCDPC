<?php

namespace App\Controllers;
use App\Models\HlSurvay;
use App\Models\NewDMModel;
use App\Models\NewHTModel;
use App\Models\RiskdmModel;
use App\Models\RiskhtModel;
use App\Models\OfficeModel;
use App\Models\SeledmModel;
use App\Models\SeleHtModel;
use App\Models\HcoachModel;
use App\Models\OsmModel;
use App\Models\VillageModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use SebastianBergmann\Environment\Console;

class HlController extends BaseController
{
    private $HlSurvay;
    private $NewDMModel;
    private $NewHTModel;
    private $riskDMModel;
    private $riskHTModel;
    private $officeModel;
    private $seleDmModel;
    private $seleHtModel;
    private $hcoachModel;
    private $osmModel;
    private $villageModel;
    

    public function __construct()
    {
        helper('form');
        $this->HlSurvay = new HlSurvay();
        $this->NewDMModel = new NewDMModel();
        $this->NewHTModel = new NewHTModel();
        $this->riskDMModel = new RiskdmModel();
        $this->riskHTModel = new RiskhtModel();
        $this->officeModel = new OfficeModel();
        $this->seleDmModel = new SeledmModel();
        $this->seleHtModel = new SeleHtModel();
        $this->hcoachModel = new HcoachModel();
        $this->osmModel = new OsmModel();
        $this->villageModel = new VillageModel();
    }
    public function riskDm_HL()
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
            'title-page'=> 'HL-page',
            'userHcode' => $userHcode,
            'userRole' => $userData->role,
            'office' => $officeData,
            'seleoffice' => $seleoffice
            ];
        return view('hlcoach/index',$data);
    }
    public function fecth_dm_risk()
    {
         $userData = $this->request->user;
        
         if($userData->role =='auth')
            {
                $userHcode = '';
            } else {
                $userHcode =  $userData->hcode;
            }
    
         $result = $this->riskDMModel->getRiskDmByhcode($userHcode);
         $data = [
                'riskdmresult' => $result
            ];
         
        return $this->response->setJSON($data);
    }
    public function selected_dm_risk()
    {
        $userData = $this->request->user;
        $office  =$this->officeModel->get()->getResultArray();
        $data = [
            'title-page'=> 'selected-page',
            'userHcode' => $userData->hcode,
            'userRole' => $userData->role,
            'seleoffice' => $seleoffice,
            ];
        return view('hlcoach/selected_dm_risk',$data);
    }
    public function fecth_selected_dm($hcode)
    {
        $userData = $this->request->user;
         if($userData->role =='auth')
            {
                if(!empty($hcode)){
                    $riskdm = $this->seleDmModel->getCaseinProj($hcode);
                } else {
                    $riskdm = $this->seleDmModel->getCaseinProj();
                }
                
            } else {
                $userHcode =  $userData->hcode;
                $riskdm = $this->seleDmModel->getCaseinProj($userHcode);
            }
        $data = [
            'riskdmresult' => $riskdm
        ];
        return $this->response->setJSON($data);
    }
    public function save_selected_dm()
    {
        $id = $this->request->getPost('rid');
        if(!empty($id)){
            $this->seleDmModel->getRisk_dm_to_selected($id);
            $this->seleDmModel->updateData(['id'=>$this->seleDmModel->insertID()],['risktype' => 'dm', 'inprojected' => 1,'d_update' => date('Y-m-d H:i:s')]);
            $this->riskDMModel->updateData($id,['inprojected' => 1]);
            return $this->response->setJSON(['status'=>'success','msg'=>'นำเข้าสู่โครงการปรับเปลี่ยนพฤตกรรม..สำเร็จ']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถเลือกเคสนี้ได้']);
    }
    public function del_selected_dm()
    {
        $id = $this->request->getPost('rid');
        if(!empty($id)){
            $this->seleDmModel->delete_selected($id);
            $data = [
                'inprojected' => 0,
            ];
            $this->riskDMModel->updateData($id,$data);
            return $this->response->setJSON(['status'=>'success','msg'=>'ลบรายนี้ออกจากโครงการปรับเปลี่ยนพฤตกรรม..สำเร็จ']);
        } 
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถลบเคสนี้ได้']);
    }
   
    public function riskHT_HL()
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
            'title-page'=> 'HL-page',
            'userHcode' => $userHcode,
            'userRole' => $userData->role,
            'office' => $officeData,
            'seleoffice' => $seleoffice
            ];
        return view('hlcoach/HT_risk',$data);
    }
     public function fecth_ht_risk()
    {
        $userData = $this->request->user;
         if($userData->role =='auth')
            {
                $userHcode = '';
            } else {
                $userHcode =  $userData->hcode;
            }
         $data = [
            'riskhtresult' => $this->riskHTModel->getRiskHtByhcode($userHcode)
            ];
        return $this->response->setJSON($data);
    }
    public function selected_ht_risk()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
        $seleoffice  =$this->officeModel->get()->getResultArray();
        $data = [
            'title-page'=> 'selected-page',
            'userHcode' => $userData->hcode,
            'userRole' => $userData->role,
            'office' => $office,
            'seleoffice' => $seleoffice,
            ];
        return view('hlcoach/selected_ht_risk',$data);
    }
    public function fecth_selected_ht($hcode)
    {
        $userData = $this->request->user;
         if($userData->role =='auth')
            {
                $userHcode = (!empty($hcode)) ? $hcode : '';
            } else {
                $userHcode =  $userData->hcode;
            }
        $data = [
            'riskhtresult' => $this->seleHtModel->getCaseinProj($userHcode)
        ];
        return $this->response->setJSON($data);
    }
    public function save_selected_ht()
    {
        $id = $this->request->getPost('rid');
        if(!empty($id)){
            $this->seleDmModel->getRisk_ht_to_selected($id);
            $this->seleDmModel->updateData(['id'=>$this->seleDmModel->insertID()],['risktype' => 'ht', 'inprojected' => 1,'d_update' => date('Y-m-d H:i:s')]);
            $this->riskHTModel->updateData($id,['inprojected' => 1]);
            return $this->response->setJSON(['status'=>'success','msg'=>'นำเข้าสู่โครงการปรับเปลี่ยนพฤตกรรม..สำเร็จ']);
        } 
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถเลือกเคสนี้ได้']);
    }
    public function del_selected_ht()
    {
        $id = $this->request->getPost('rid');
        if(!empty($id)){
            $this->seleHtModel->delete_selected($id);
            $data = [
                'inprojected' => 0,
            ];
            $this->riskHTModel->updateData($id,$data);
            return $this->response->setJSON(['status'=>'success','msg'=>'ลบรายนี้ออกจากโครงการปรับเปลี่ยนพฤตกรรม..สำเร็จ']);
        } 
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถลบเคสนี้ได้']);
    }

    function calculateHLScore($answers) {
        // $answers คือ array ของคะแนน 1-4
        $total_questions = count($answers);
        if ($total_questions == 0) return 0;

        $avg_score = array_sum($answers) / $total_questions;
        
        // สูตรคำนวณคะแนนมาตรฐาน (0-50)
        $final_score = ($avg_score - 1) * (50 / 3);
        
        return round($final_score, 2);
    }
    public function save_hl_survey()
    {
        $questions = [];
        for ($i = 1; $i <= 12; $i++) {
            $questions[] = (int)$this->request->getPost("q$i");
        }

        $avg_score = array_sum($questions) / 12;
        // สูตรคำนวณมาตรฐาน (0-50): (ค่าเฉลี่ย - 1) * (50 / 3)
        $final_score = ($avg_score - 1) * (50 / 3);

        $data = [
            'user_id'  => $this->request->getPost('user_id'),
            'coach_id' => session()->get('user_id'),
            'raw_score_avg'  => $avg_score,
            'final_hl_score' => round($final_score, 2),
            'created_at'     => date('Y-m-d H:i:s')
        ];
        foreach ($questions as $key => $val) {
        $data['q' . ($key + 1)] = $val;
        }

        $db = \Config\Database::connect();
        $db->table('hl_survey_logs')->insert($data);

        return $this->response->setJSON([
            'status' => 'success',
            'score'  => $data['final_hl_score']
        ]);

    }

    public function hl_page()
    {
        $userData = $this->request->user;
        $userHcode =  $userData->hcode;
        $officeData = $this->officeModel->find($userHcode);
        $hlcoach = $this->hcoachModel->get()->getResultArray();
        $osm = $this->osmModel->get()->getResultArray();
        $data = [
            'title-page'=> 'HL-page',
            'user' => $userData,
            'office' => $officeData,
            'hlcoach' => $hlcoach,
            'osmAll' => $osm
            ];
        return view('hlcoach/hl_page',$data);
    }
    public function hcoachData()
    {
        $cid = $this->request->getPost('txtcid');
        $personData = $this->osmModel->getperByhcodepid($cid);
        //print_r($personData); // Debug: แสดงข้อมูลที่ได้จากฐานข้อมูล
        if($personData){
            return $this->response->setJSON(['status'=>'success','data'=>$personData]);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่พบข้อมูลผู้ป่วย']);
    }
    public function save_hcoach(){
        $data = [
            'cid' => $this->request->getPost('txtcid2'),
            'hcoachname' => $this->request->getPost('txtname'),
            'hcode' => $this->request->getPost('txthcode'),
            'birth' => $this->request->getPost('txtdob'),
            'tel' => $this->request->getPost('txttel'),
            'acc_number' => $this->request->getPost('txtaccnumber'),
            'bank' => $this->request->getPost('txtbank'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if($this->hcoachModel->where('cid', $data['cid'])->first()){
            $this->hcoachModel->where('cid', $data['cid'])->update(null, $data);
            return $this->response->setJSON(['status'=>'success','msg'=>'อัปเดตข้อมูลนักจัดการความรอบรู้ด้านสุขภาพสำเร็จ']);
        } else {
            if($this->hcoachModel->insert($data)){
                return $this->response->setJSON(['status'=>'success','msg'=>'บันทึกข้อมูลนักจัดการความรอบรู้ด้านสุขภาพสำเร็จ']);
            }
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถบันทึกข้อมูลนักจัดการความรอบรู้ด้านสุขภาพได้']);
    }
    public function fetch_hcoach()
    {
        $userData = $this->request->user;
        if($userData->role =='auth')
            {
                $data = $this->hcoachModel->get()->getResultArray();
            } else {
                $data = $this->hcoachModel->where('hcode', $userData->hcode)->get()->getResultArray();
            }
        
        return $this->response->setJSON($data);
    }
    public function update_Send_Status()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('send');
        if($this->seleDmModel->updateData($id,['send'=>$status]))
            {
                return $this->response->setJSON(['status'=>'success','msg'=>'ส่งให้ HL-Coach สำเร็จ']);
            }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถส่งให้ HL-Coach ได้']);
    }

    public function get_hcoach_by_hcode($hcode)
    {
        $data = $this->hcoachModel->where('hcode', $hcode)->get()->getResultArray();
        return $this->response->setJSON($data);
    }
    public function get_hcoach_by_id($id)
    {
        $data = $this->hcoachModel->where('id', $id)->first();
        if($data){
            return $this->response->setJSON(['status'=>'success','data'=>$data]);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่พบข้อมูลนักจัดการความรอบรู้ด้านสุขภาพ']);
    }
     
    public function update_hcoach()
    {
        $id = $this->request->getPost('id');
        $data = [
            'cid' => $this->request->getPost('txtcid2'),
            'hcoachname' => $this->request->getPost('txtname'),
            'hcode' => $this->request->getPost('txthcode'),
            'birth' => $this->request->getPost('txtdob'),
            'tel' => $this->request->getPost('txttel'),
            'acc_number' => $this->request->getPost('txtaccnumber'),
            'bank' => $this->request->getPost('txtbank'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if($this->hcoachModel->update($id,$data)){
            return $this->response->setJSON(['status'=>'success','msg'=>'อัปเดตข้อมูลนักจัดการความรอบรู้ด้านสุขภาพสำเร็จ']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถอัปเดตข้อมูลนักจัดการความรอบรู้ด้านสุขภาพได้']);
    }
    public function delete_hcoach($id)
    {
        //$id = $this->request->getPost('id');
        if($this->hcoachModel->delete($id)){    
            return $this->response->setJSON(['status'=>'success','msg'=>'ลบข้อมูลนักจัดการความรอบรู้ด้านสุขภาพสำเร็จ']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถลบข้อมูลนักจัดการความรอบรู้ด้านสุขภาพได้']);
    }
    public function save_hcoach_to_risk()
    {
        $id = $this->request->getPost('pid');
        $hcode = $this->request->getPost('hcode');
        $tel = $this->request->getPost('tel');
        $selerisk = $this->seleDmModel->where(['pid'=>$id,'hospcode'=>$hcode])->first();
        if($selerisk){
            $data = [
                'hcoach' => $tel,
                'd_update' => date('Y-m-d H:i:s'),
            ];
            if($this->seleDmModel->updateData(['pid'=>$id,'hospcode'=>$hcode], $data)){
                return $this->response->setJSON(['status'=>'success','msg'=>'บันทึกข้อมูลนักจัดการความรอบรู้ด้านสุขภาพสู่รายเสี่ยงสำเร็จ']);
            }
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถบันทึกข้อมูลนักจัดการความรอบรู้ด้านสุขภาพสู่รายเสี่ยงได้']);
    }
    public function get_village_by_hcode($hcode)
    {
        $data = $this->villageModel->where('hoscode', $hcode)->findAll();
        if($data){
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่พบข้อมูลหมู่บ้าน']);
    }
}
