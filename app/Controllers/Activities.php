<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ActivityModel;
use App\Models\OfficeModel; 
use App\Models\NeedModel;

class Activities extends BaseController
{
    private $ActivityModel;
    private $officeModel;
    private $Needmodel;

    public function __construct()
    {
        $this->ActivityModel = new ActivityModel();
        $this->officeModel = new OfficeModel();
        $this->Needmodel = new NeedModel();
    }
    public function index()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
        $officeData = $this->officeModel->find($userHcode);
        $data = [
            'page' => 'activity_page',
            'user' => $userData, 
            'office' => $officeData,
        ];
        return view('caregiver/activity',$data);
    }
    public function getActdata()
    {
        $userData = $this->request->user;
        $data = [
           'actData' => $this->ActivityModel->where('hcode',$userData->hcode)->where('use',1)->findAll()
        ]; 
        return $this->response->setJSON($data);
    }
    public function save() {
        
        $id = $this->request->getPost('act_code');
        
        $data = [
            'act_code'   => $id,
            'activities' => $this->request->getPost('activities'),
            'use'        => $this->request->getPost('use') ?? 0
        ];

        if ($this->ActivityModel->save($data)) {
            return $this->response->setJSON(['status' => 'success', 'msg' => 'บันทึกข้อมูลเรียบร้อย']);
        }
            return $this->response->setJSON(['status' => 'error', 'msg' => 'ไม่สามารถบันทึกได้']);
    }
    public function addActivity()
    {
        $userData = $this->request->user;
        $data = [
            'Activities' => $this->request->getPost('activities'),
            'hcode' => $userData->hcode,
            'use' => '1',
            'adl' => $this->request->getPost('adl')
        ];
        if($this->ActivityModel->addAct($data)){
            return $this->response->setJSON(['status'=>'success','msg'=>'เพิ่มรายการเรียบร้อย']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'ไม่สามารถเพิ่มรายการได้']);
    }

    public function needs_index()
    {
        $userData = $this->request->user;
        $userHcode = $userData->hcode;
        $officeData = $this->officeModel->find($userHcode);
        $needData = $this->Needmodel->where('hcode','1')->findAll();
        $data = [
            'page' => 'needs_page',
            'user' => $userData, 
            'office' => $officeData,
            'needsData' => $needData
        ];
        return view('caregiver/needs',$data);
    }
    public function getNeedsData()
    {
        $userData = $this->request->user;
        $data = [
            'needsData' => $this->Needmodel->where('hcode',$userData->hcode)->findAll()
        ];
        return $this->response->setJSON($data);
    }

    public function addNeeds()
    {
        $userData = $this->request->user;
        $send = $this->request->getPost('send');
        if($send == 1){ 
        $needs = explode(',',implode(',',$this->request->getPost('seleneed'))); // -1 to exclude empty last element

        for($i=0; $i < count($needs); $i++){
            $need = trim($needs[$i]);
            $data = [
                'needs' => $need,
                'hcode' => $userData->hcode,
                'use' => '1'
            ];
            if (!$this->Needmodel->addneeds($data)) {
                return $this->response->setJSON(['status' => 'error', 'msg' => 'ไม่สามารถเพิ่มรายการได้']);
            }
        }
        } else {
            $needs = $this->request->getPost('seleneed');
            $data = [
                'needs' => $needs,
                'hcode' => $userData->hcode,
                'use' => '1'
            ];
            if (!$this->Needmodel->addneeds($data)) {
                return $this->response->setJSON(['status' => 'error', 'msg' => 'ไม่สามารถเพิ่มรายการได้']);
            }
        }
        return $this->response->setJSON(['status' => 'success', 'msg' => 'เพิ่มรายการความต้องการสำเร็จ']);
    }
    public function delNeeds()
    {
        $userData = $this->request->user;
        $id = $this->request->getPost('ncode');
        if($this->Needmodel->delete_need(['ncode'=>$id])){
            return $this->response->setJSON(['status'=>'success','msg'=>'ลบรายการสำเร็จ']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'มีปัญหาสำหรับการลบรายการ']);
    }

    public function updateStatusNeeds()
    {
        $userData = $this->request->user;
        $id = $this->request->getPost('ncode');
        $use = $this->request->getPost('use');
        $data = [
            'use' => $use
        ];
        if($this->Needmodel->update_needs(['ncode'=>$id],$data)){
            return $this->response->setJSON(['status'=>'success','msg'=>'อัปเดตสถานะเรียบร้อย']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'มีปัญหาสำหรับการอัปเดตสถานะ']);
    }
    
    public function updateStatusActivity()
    {
        $userData = $this->request->user;
        $id = $this->request->getPost('act_code');
        $use = $this->request->getPost('use');
        $data = [
            'use' => $use
        ];
        if($this->ActivityModel->update_Activity(['act_code'=>$id],$data)){
            return $this->response->setJSON(['status'=>'success','msg'=>'อัปเดตสถานะเรียบร้อย']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'มีปัญหาสำหรับการอัปเดตสถานะ']);
    }
    public function deleteActivity()
    {
        $userData = $this->request->user;
        $id = $this->request->getPost('act_code');
        if($this->ActivityModel->deleteEntry(['act_code'=>$id])){
            return $this->response->setJSON(['status'=>'success','msg'=>'ลบรายการสำเร็จ']);
        }
        return $this->response->setJSON(['status'=>'error','msg'=>'มีปัญหาสำหรับการลบรายการ']);
    }
}