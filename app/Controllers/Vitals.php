<?php

namespace App\Controllers;

use App\Models\VitalsModel;
use App\Models\personModel;
use App\Models\SeledmModel;
use App\Models\HlSurvay;
use CodeIgniter\HTTP\ResponseInterface;

class Vitals extends BaseController
{
    protected VitalsModel $model;
    protected personModel $personModel;
    protected SeledmModel $seledmModel;
    protected HlSurvay $hlSurveyModel;

    public function __construct()
    {
        $this->model = new VitalsModel();
        $this->personModel = new personModel();
        $this->seledmModel = new SeledmModel();
        $this->hlSurveyModel = new HlSurvay();
    }

    /**
     * GET /vitals/{patient_id}
     * แสดงฟอร์มบันทึกข้อมูลสุขภาพ
     */
    public function index(string $hospcode, string $pid)
    {
        if($this->hlSurveyModel->getLatest($hospcode, $pid) === null) {
            return redirect()->to(base_url("public/health-literacy/survey/$hospcode/$pid"));
        }
        // ตรวจสอบว่า patient_id เป็นตัวเลขจริง (ป้องกัน IDOR เบื้องต้น)
        if ($pid <= 0) {
            return redirect()->back()->with('error', 'patient_id ไม่ถูกต้อง');
        }
        $riskname = $this->personModel->getPersonName($hospcode, $pid)->pname ?? 'ไม่พบข้อมูล';
        $data = [
            'latest'     => $this->model->getLatest($hospcode, $pid),
            'riskname' => $riskname,
            'hcoachname' => session()->get('hcoachname'),
            'hospcode' => $hospcode,
            'pid' => $pid,
        ];
        return view('vitals/form', $data);
    }

    /**
     * POST /vitals/{patient_id}/save  (AJAX JSON)
     * รับ patient_id จาก URL — ไม่เชื่อค่าจาก body
     */
    public function save(string $hospcode, string $pid)
    {
        if ($pid <= 0) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'patient_id ไม่ถูกต้อง']);
        }

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

        $weight     = (float) ($json['weight']       ?? 0);
        $height     = (float) ($json['height']       ?? 0);
        $systolic   = (int)   ($json['bp_systolic']  ?? 0);
        $diastolic  = (int)   ($json['bp_diastolic'] ?? 0);
        $sugar      = (float) ($json['blood_sugar']  ?? 0);
        $sugarType  = $json['sugar_type']            ?? 'fasting';
        $note       = $json['note']                  ?? null;
        $recordedAt = $json['recorded_at']           ?? date('Y-m-d H:i:s');
        $hcoachname = $json['hcoachname']           ?? session()->get('hcoachname') ?? 'unknown';
        switch($sugarType) {
            CASE 'fasting' :
                $bstest = 1;
                break;
            CASE '2h_postprandial' :
                $bstest = 3;
                break;
            CASE 'random' :
                $bstest = 2;
                break;
            CASE 'other' :
                $bstest = 0;
                break;
            default :
                $bstest = 0;
                break;
        }
        // คำนวณค่าอัตโนมัติ
        $bmiData = $this->model->calcBmi($weight, $height);
        $bpLevel = $this->model->calcBpLevel($systolic, $diastolic);
        $sLevel  = $this->model->calcSugarLevel($sugar, $sugarType);

        $insertData = [
            'hospcode'     => $hospcode,
            'pid'          => $pid,          // << มาจาก URL เสมอ
            'weight'       => $weight,
            'height'       => $height,
            'bmi'          => $bmiData['bmi'],
            'bmi_level'    => $bmiData['bmi_level'],
            'bp_systolic'  => $systolic,
            'bp_diastolic' => $diastolic,
            'bp_level'     => $bpLevel,
            'blood_sugar'  => $sugar,
            'sugar_type'   => $sugarType,
            'sugar_level'  => $sLevel,
            'note'         => $note,
            'recorded_at'  => $recordedAt,
            'hcoachname'   => $hcoachname,
        ];
        $data2 = [
            'bstest2' => $bstest,
            'bslevel2' => $sugar,
            'dbp2' => $diastolic,
            'sbp2' => $systolic,
            'result2' => $bpLevel,
        ];
        if (!$this->model->validate($insertData)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                ->setJSON([
                    'success' => false,
                    'message' => 'ข้อมูลไม่ถูกต้อง',
                    'errors'  => $this->model->errors(),
                ]);
        }

        if (!$this->model->insert($insertData)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['success' => false, 'message' => 'บันทึกไม่สำเร็จ']);
        }
        $this->seledmModel->updateData(['hospcode'=> $hospcode, 'pid'=> $pid], $data2);
        return $this->response->setJSON([
            'success'     => true,
            'message'     => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'id'          => $this->model->getInsertID(),
            'hospcode'    => $hospcode,
            'pid'         => $pid,
            'weight'      => $weight,
            'height'      => $height,
            'bmi'         => $bmiData['bmi'],
            'bmi_level'   => $bmiData['bmi_level'],
            'bp_systolic' => $systolic,
            'bp_diastolic'=> $diastolic,
            'bp_level'    => $bpLevel,
            'blood_sugar' => $sugar,
            'sugar_type'  => $sugarType,
            'sugar_level' => $sLevel,
            'note'        => $note,
            'recorded_at' => $recordedAt,
            'hcoachname'  => $hcoachname,
        ]);
    }

    /**
     * GET /vitals/{patient_id}/history
     * ดูประวัติของ patient นั้น
     */
    public function history(string $hospcode, string $pid)
    {
        if ($pid <= 0) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'patient_id ไม่ถูกต้อง']);
        }
        $data = $this->model->getHistory($hospcode, $pid, 20);
        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
}
