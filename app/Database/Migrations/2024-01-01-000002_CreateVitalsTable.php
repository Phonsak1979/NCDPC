<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVitalsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'patient_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            // น้ำหนัก / ส่วนสูง / BMI
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'comment'    => 'กิโลกรัม',
            ],
            'height' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'comment'    => 'เซนติเมตร',
            ],
            'bmi' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
            ],
            'bmi_level' => [
                'type'       => 'ENUM',
                'constraint' => ['underweight', 'normal', 'overweight', 'obese1', 'obese2'],
            ],
            // ความดันโลหิต
            'bp_systolic' => [
                'type'       => 'SMALLINT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'มม.ปรอท (ตัวบน)',
            ],
            'bp_diastolic' => [
                'type'       => 'SMALLINT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'มม.ปรอท (ตัวล่าง)',
            ],
            'bp_level' => [
                'type'       => 'ENUM',
                'constraint' => ['normal', 'elevated', 'stage1', 'stage2', 'crisis'],
            ],
            // ระดับน้ำตาลในเลือด
            'blood_sugar' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'comment'    => 'มก./ดล.',
            ],
            'sugar_type' => [
                'type'       => 'ENUM',
                'constraint' => ['fasting', 'random', '2h_postprandial'],
                'comment'    => 'ประเภทการตรวจ',
            ],
            'sugar_level' => [
                'type'       => 'ENUM',
                'constraint' => ['normal', 'prediabetes', 'diabetes'],
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'recorded_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('patient_id');
        $this->forge->addKey('recorded_at');
        $this->forge->createTable('patient_vitals', true);
    }

    public function down()
    {
        $this->forge->dropTable('patient_vitals', true);
    }
}
