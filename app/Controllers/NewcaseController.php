<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NewDMModel;
use App\Models\NewHTModel;
use App\Models\NewdmhtModel;
use App\Models\OldDmModel;
use App\Models\OldHtModel;
use App\Models\OfficeModel;

class NewcaseController extends BaseController
{
    private $NewDMModel;
    private $NewHTModel;
    private $officeModel;
    private $NewDMHTModel;
    private $OldDmModel;
    private $OldHtModel;

    public function __construct()
    {
        $this->NewDMModel = new NewDMModel();
        $this->NewHTModel = new NewHTModel();
        $this->officeModel = new OfficeModel();
        $this->NewDMHTModel = new NewdmhtModel();
        $this->OldDmModel = new OldDmModel();
        $this->OldHtModel = new OldHtModel();
    }
    public function newDm_page()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
        $seleoffice  =$this->officeModel->get()->getResultArray();
        $newDM = $this->NewDMModel->countAllResults();
        $oldDM = $this->OldDmModel->countAllResults();
        $newDMHT = $this->NewDMHTModel->countAllResults();
        $data = [
            'title-page'=> 'newDM-page',
            'userHcode' => $userData->hcode,
            'userRole' => $userData->role,
            'seleoffice' => $seleoffice,
            'office' => $officeData,
            'newDM' => $newDM,
            'oldDM' => $oldDM,
            'newDMHT' => $newDMHT
            ];
        return view('hlcoach/newDM',$data);
    }
    public function fecth_dm_newcase($hcode)
    {
        $userData = $this->request->user;
         $data = [
            'newdmresult' => $this->NewDMModel->getNewDmByhcode($hcode)
            ];
        return $this->response->setJSON($data);
    }
    public function newHt_page()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
        $seleoffice  =$this->officeModel->get()->getResultArray();
        $oldHT = $this->OldHtModel->countAllResults();
        $newHT = $this->NewHTModel->countAllResults();
        $newDMHT = $this->NewDMHTModel->countAllResults();
        $data = [
            'title-page'=> 'newDM-page',
            'userHcode' => $userData->hcode,
            'userRole' => $userData->role,
            'office' => $officeData,
            'seleoffice' => $seleoffice,
            'oldHT' => $oldHT,
            'newHT' => $newHT,
            'newDMHT' => $newDMHT
            ];
        return view('hlcoach/newHT',$data);
    }
    public function fecth_ht_newcase($hcode)
    {
        $userData = $this->request->user;
         $data = [
            'newhtresult' => $this->NewHTModel->getNewHtByhcode($hcode)
            ];
        return $this->response->setJSON($data);
    }
    public function newDmHt_page()
    {
        $userData = $this->request->user;
        $officeData = $this->officeModel->find($userData->hcode);
        $seleoffice  =$this->officeModel->get()->getResultArray();
        $newDM = $this->NewDMModel->countAllResults();
        $newHT = $this->NewHTModel->countAllResults();
        $newDMHT = $this->NewDMHTModel->countAllResults();
        $data = [
            'title-page'=> 'newDMHT-page',
            'userHcode' => $userData->hcode,
            'userRole' => $userData->role,
            'seleoffice' => $seleoffice,
            'office' => $officeData,
            'newDM' => $newDM,
            'newHT' => $newHT,
            'newDMHT' => $newDMHT
            ];
        return view('hlcoach/newDMHT',$data);
    }
    public function fecth_dmht_newcase($hcode)
    {
         $data = [
            'newdmhtresult' => $this->NewDMHTModel->getNewDmHtByhcode($hcode)
            ];
        return $this->response->setJSON($data);
    }
    public function get_Chart_hba1c()
    {
        $userData = $this->request->user;
        if($userData->role =='auth')
            {
                $userHcode = "";
            } else {
                $userHcode = (!empty($this->request->getVar('hcode'))) ? $this->request->getVar('hcode') : $userData->hcode;
            }
        $hba1c = $this->NewDMHTModel->getOldDmHtByHbA1C($userHcode);
        $riskhb = [];
        $counts = [];
        foreach($hba1c as $item)
            {
                array_push($riskhb,$item['res_hba1c']);
                array_push($counts,$item['c_hba1c']);
            }
        $data = [
            'riskhb'=> $riskhb,
            'counts'=> $counts 
        ];
        return $this->response->setJSON($data);
    }
    public function get_chart_fpg($hcode = null)
    {
        $userData = $this->request->user;
        if($userData->role =='auth')
            { 
                $userHcode = ($hcode != null) ? $hcode : $userData->hcode;
            } else {
                $userHcode = $userData->hcode;
            }
        $resfpg1 = $this->NewDMHTModel->getOldDmHtByFpg1($userHcode);
        $resfpg2 = $this->NewDMHTModel->getOldDmHtByFpg2($userHcode);
        $riskfpg1 = [];
        $counts1 = [];
        $riskfpg2 = [];
        $counts2 = [];
        foreach($resfpg1 as $item)
            {
                array_push($riskfpg1,$item['res_fpg1']);
                array_push($counts1,$item['c_fpg1']);
            }
        foreach($resfpg2 as $item2)
            {
                array_push($riskfpg2,$item2['res_fpg2']);
                array_push($counts2,$item2['c_fpg2']);
            }
        $data = [
            'riskfpg1'=> $riskfpg1,
            'counts1'=> $counts1,
            'riskfpg2'=> $riskfpg2,
            'counts2'=> $counts2  
        ];
        return $this->response->setJSON($data);
    }
}
