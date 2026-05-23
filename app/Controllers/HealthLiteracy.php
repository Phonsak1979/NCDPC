<?php

namespace App\Controllers;

use App\Models\HlSurvay;
use App\Models\OfficeModel;
use App\Models\SeledmModel;
use App\Models\SeleHtModel;
use CodeIgniter\HTTP\ResponseInterface;

class HealthLiteracy extends BaseController
{
    protected $model;
    protected $officeModel;
    protected $seledmModel;
    protected $selehtModel;


    public function __construct()
    {
        $this->model = new HlSurvay();
        $this->officeModel =  new OfficeModel();
        $this->seledmModel = new SeledmModel();
        $this->selehtModel = new SeleHtModel();
    }

    /**
     * GET /health-literacy
     * แสดงหน้าแบบสอบถาม
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('public/mb-login'));
        }
        $userHcode = session()->get('hcode');
        $userTel = session()->get('user_tel');
        $officeData = $this->officeModel->find($userHcode);
        $riskper = $this->seledmModel->get_risk_per($userTel);        
        $data = [
            'hcoachname' => session()->get('hcoachname'),
            'page' => 'health-literacy',
            'office' => $officeData,
            'csrf_token'  => csrf_token(),
            'csrf_hash'   => csrf_hash(),
            'riskper' => $riskper
        ];
        return view('mobile/hl_listper', $data);

    }
    public function survey(string $hospcode, string $pid)
    {
        // ถ้ามีระบบ patient ส่ง patient_id มาด้วย เช่น จาก session
        $userHcode = session()->get('hcode');
        $officeData = $this->officeModel->find($userHcode);
           
        $data = [
            'hcoachname' => session()->get('hcoachname'),
            'office' => $officeData,
            'hospcode' => $hospcode,
            'pid' => $pid,
            'csrf_token'  => csrf_token(),
            'csrf_hash'   => csrf_hash(),
        ];
        return view('healthliteracy/survey', $data);
    }

    /**
     * POST /health-literacy/save  (AJAX JSON)
     * รับคำตอบจาก JavaScript แล้วบันทึก DB
     */
    public function save(string $hospcode, string $pid)
    {
        // รับเฉพาะ JSON request
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

        // ดึงคำตอบ q1–q12 จาก JSON
        $answers = [];
        for ($i = 1; $i <= 12; $i++) {
            $answers["q{$i}"] = (int) ($json["q{$i}"] ?? 0);
        }

        // Validate ด้วย Model rules
        if (!$this->model->validate($answers)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                ->setJSON([
                    'success' => false,
                    'message' => 'ข้อมูลไม่ถูกต้อง',
                    'errors'  => $this->model->errors(),
                ]);
        }

        // คำนวณคะแนน
        $scores = $this->model->calculateScores($answers);

        // รวมข้อมูลทั้งหมดสำหรับ insert
        $insertData = array_merge($answers, $scores, [
            'hospcode'   => $hospcode, // มาจาก URL
            'pid'        => $pid, // มาจาก URL
            'hcoachname' => session()->get('hcoachname') ?? ($json['hcoachname'] ?? null),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // บันทึก DB
        if (!$this->model->insert($insertData)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }

        $insertId = $this->model->getInsertID();

        return $this->response->setJSON([
            'success'    => true,
            'message'    => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'id'         => $insertId,
            'scores'     => $scores,
        ]);
    }

    /**
     * GET /health-literacy/result/{id}
     * แสดงผลลัพธ์หลังบันทึก
     */
    public function result(int $id)
    {
        $record = $this->model->find($id);
        if (!$record) {
            return redirect()->to('/health-literacy')->with('error', 'ไม่พบข้อมูล');
        }
        return view('healthliteracy/result', ['record' => $record]);
    }

    public function inproject()
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
        return view('hlcoach/inproject',$data);
    }
}
