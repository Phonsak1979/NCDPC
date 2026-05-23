<?php

namespace App\Models;

use CodeIgniter\Model;

class HlSurvay extends Model
{
    protected $table            = 'hl_survey';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','hcoachname',
        'q1', 'q2', 'q3', 'q4', 'q5', 'q6',
        'q7', 'q8', 'q9', 'q10', 'q11', 'q12',
        'score_access', 'score_understand', 'score_apply', 'score_eval',
        'score_total', 'level','created_at'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'q1'  => 'required|in_list[1,2,3,4]',
        'q2'  => 'required|in_list[1,2,3,4]',
        'q3'  => 'required|in_list[1,2,3,4]',
        'q4'  => 'required|in_list[1,2,3,4]',
        'q5'  => 'required|in_list[1,2,3,4]',
        'q6'  => 'required|in_list[1,2,3,4]',
        'q7'  => 'required|in_list[1,2,3,4]',
        'q8'  => 'required|in_list[1,2,3,4]',
        'q9'  => 'required|in_list[1,2,3,4]',
        'q10' => 'required|in_list[1,2,3,4]',
        'q11' => 'required|in_list[1,2,3,4]',
        'q12' => 'required|in_list[1,2,3,4]',
    ];

    protected $validationMessages = [
        'q1'  => ['required' => 'กรุณาตอบข้อ 1',  'in_list' => 'คำตอบข้อ 1 ไม่ถูกต้อง'],
        'q2'  => ['required' => 'กรุณาตอบข้อ 2',  'in_list' => 'คำตอบข้อ 2 ไม่ถูกต้อง'],
        'q3'  => ['required' => 'กรุณาตอบข้อ 3',  'in_list' => 'คำตอบข้อ 3 ไม่ถูกต้อง'],
        'q4'  => ['required' => 'กรุณาตอบข้อ 4',  'in_list' => 'คำตอบข้อ 4 ไม่ถูกต้อง'],
        'q5'  => ['required' => 'กรุณาตอบข้อ 5',  'in_list' => 'คำตอบข้อ 5 ไม่ถูกต้อง'],
        'q6'  => ['required' => 'กรุณาตอบข้อ 6',  'in_list' => 'คำตอบข้อ 6 ไม่ถูกต้อง'],
        'q7'  => ['required' => 'กรุณาตอบข้อ 7',  'in_list' => 'คำตอบข้อ 7 ไม่ถูกต้อง'],
        'q8'  => ['required' => 'กรุณาตอบข้อ 8',  'in_list' => 'คำตอบข้อ 8 ไม่ถูกต้อง'],
        'q9'  => ['required' => 'กรุณาตอบข้อ 9',  'in_list' => 'คำตอบข้อ 9 ไม่ถูกต้อง'],
        'q10' => ['required' => 'กรุณาตอบข้อ 10', 'in_list' => 'คำตอบข้อ 10 ไม่ถูกต้อง'],
        'q11' => ['required' => 'กรุณาตอบข้อ 11', 'in_list' => 'คำตอบข้อ 11 ไม่ถูกต้อง'],
        'q12' => ['required' => 'กรุณาตอบข้อ 12', 'in_list' => 'คำตอบข้อ 12 ไม่ถูกต้อง'],
    ];

    /**
     * คำนวณคะแนนและระดับจากคำตอบ 12 ข้อ
     */
    public function calculateScores(array $answers): array
    {
        $access     = $answers['q1'] + $answers['q2'] + $answers['q3'];
        $understand = $answers['q4'] + $answers['q5'] + $answers['q6'];
        $apply      = $answers['q7'] + $answers['q8'] + $answers['q9'];
        $eval       = $answers['q10'] + $answers['q11'] + $answers['q12'];
        $total      = $access + $understand + $apply + $eval;

        if ($total <= 24) {
            $level = 'low';
        } elseif ($total <= 36) {
            $level = 'medium';
        } else {
            $level = 'high';
        }

        return [
            'score_access'     => $access,
            'score_understand' => $understand,
            'score_apply'      => $apply,
            'score_eval'       => $eval,
            'score_total'      => $total,
            'level'            => $level,
        ];
    }

    /**
     * ดึงประวัติการทำแบบสอบถามของ patient
     */
    public function getByPatient(int $patientId): array
    {
        return $this->where('patient_id', $patientId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    public function getLatest(string $hospcode, string $pid): ?array
    {
        return $this->where('hospcode', $hospcode)
                    ->where('pid', $pid)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }
    public function getHlbyall(string $hospcode = ''): array
    {
        if(empty($hospcode)){
            $SQL = "SELECT avg(score_access) as score_access,avg(score_understand) as score_understand,
            avg(score_apply) as score_apply,avg(score_eval) as score_eval  
            FROM hl_survey";
            return $this->db->query($SQL)->getResultArray();
        } else {
            $SQL = "SELECT avg(score_access) as score_access,avg(score_understand) as score_understand,
            avg(score_apply) as score_apply,avg(score_eval) as score_eval  
            FROM hl_survey WHERE hospcode = '".$hospcode."'";
            return $this->db->query($SQL)->getResultArray();
        }
    }

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


}
