<?php

namespace App\Models;

use CodeIgniter\Model;

class VitalsModel extends Model
{
    protected $table      = 'patient_vitals';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'hospcode', 'pid',
        'weight', 'height', 'bmi', 'bmi_level',
        'bp_systolic', 'bp_diastolic', 'bp_level',
        'blood_sugar', 'sugar_type', 'sugar_level',
        'note', 'recorded_at', 'hcoachname',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'weight'       => 'required|decimal|greater_than[0]|less_than[300]',
        'height'       => 'required|decimal|greater_than[0]|less_than[300]',
        'bp_systolic'  => 'required|integer|greater_than[0]|less_than[300]',
        'bp_diastolic' => 'required|integer|greater_than[0]|less_than[200]',
        'blood_sugar'  => 'required|decimal|greater_than[0]|less_than[1000]',
        'sugar_type'   => 'required|in_list[fasting,random,2h_postprandial]',
        'hcoachname'   => 'required|string|max_length[100]',
    ];

    protected $validationMessages = [
        'weight'       => ['required' => 'กรุณากรอกน้ำหนัก'],
        'height'       => ['required' => 'กรุณากรอกส่วนสูง'],
        'bp_systolic'  => ['required' => 'กรุณากรอกความดันตัวบน'],
        'bp_diastolic' => ['required' => 'กรุณากรอกความดันตัวล่าง'],
        'blood_sugar'  => ['required' => 'กรุณากรอกระดับน้ำตาล'],
        'sugar_type'   => ['required' => 'กรุณาเลือกประเภทการตรวจน้ำตาล'],
        'hcoachname'   => ['required' => 'กรุณากรอกชื่อโค้ช'],
    ];

    // ─── คำนวณ BMI ───────────────────────────────────────────────
    public function calcBmi(float $weight, float $height): array
    {
        $heightM = $height / 100;
        $bmi     = round($weight / ($heightM * $heightM), 1);

        if ($bmi < 18.5)       $level = 'underweight';
        elseif ($bmi < 23.0)   $level = 'normal';
        elseif ($bmi < 25.0)   $level = 'overweight';
        elseif ($bmi < 30.0)   $level = 'obese1';
        else                   $level = 'obese2';

        return ['bmi' => $bmi, 'bmi_level' => $level];
    }

    // ─── ประเมินความดันโลหิต ────────────────────────────────────
    public function calcBpLevel(int $systolic, int $diastolic): string
    {
        if ($systolic >= 180 || $diastolic >= 120)  return 'crisis';
        if ($systolic >= 140 || $diastolic >= 90)   return 'stage2';
        if ($systolic >= 130 || $diastolic >= 80)   return 'stage1';
        if ($systolic >= 120 && $diastolic < 80)    return 'elevated';
        return 'normal';
    }

    // ─── ประเมินระดับน้ำตาล ────────────────────────────────────
    public function calcSugarLevel(float $sugar, string $type): string
    {
        return match ($type) {
            'fasting' => match (true) {
                $sugar >= 126           => 'diabetes',
                $sugar >= 100           => 'prediabetes',
                default                 => 'normal',
            },
            '2h_postprandial' => match (true) {
                $sugar >= 200           => 'diabetes',
                $sugar >= 140           => 'prediabetes',
                default                 => 'normal',
            },
            'noncheck' => 'noncheck',
            'random' => match (true) {
                $sugar >= 50            => 'normal',
                default                 => 'diabetes',
            },
            default => match (true) {           // random
                $sugar >= 200           => 'diabetes',
                default                 => 'normal',
            },
        };
    }

    // ─── ดึงข้อมูลล่าสุดของ patient ────────────────────────────
    public function getLatest(string $hospcode, string $pid): ?array
    {
        return $this->where('hospcode', $hospcode)
                    ->where('pid', $pid)
                    ->orderBy('recorded_at', 'DESC')
                    ->first();
    }

    // ─── ดึงประวัติ ─────────────────────────────────────────────
    public function getHistory(string $hospcode, string $pid, int $limit = 10): array
    {
        return $this->where('hospcode', $hospcode)
                    ->where('pid', $pid)
                    ->orderBy('recorded_at', 'DESC')
                    ->findAll($limit);
    }
}
