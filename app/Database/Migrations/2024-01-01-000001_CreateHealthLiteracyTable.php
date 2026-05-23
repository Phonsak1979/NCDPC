<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHealthLiteracyTable extends Migration
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
            // ข้อมูลผู้ตอบ (เชื่อมกับ patient ถ้ามี)
            'patient_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            // คำตอบแต่ละข้อ (1=ยากมาก, 2=ยาก, 3=ง่าย, 4=ง่ายมาก)
            'q1'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q2'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q3'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q4'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q5'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q6'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q7'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q8'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q9'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q10' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q11' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'q12' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            // คะแนนรวมแต่ละมิติ (คำนวณอัตโนมัติ)
            'score_access'     => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'comment' => 'การเข้าถึง q1+q2+q3'],
            'score_understand' => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'comment' => 'ความเข้าใจ q4+q5+q6'],
            'score_apply'      => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'comment' => 'การนำไปใช้ q7+q8+q9'],
            'score_eval'       => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'comment' => 'การประเมิน q10+q11+q12'],
            'score_total'      => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'comment' => 'คะแนนรวม 12-48'],
            'level' => [
                'type'       => 'ENUM',
                'constraint' => ['low', 'medium', 'high'],
                'default'    => 'low',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('patient_id');
        $this->forge->addKey('created_at');
        $this->forge->createTable('health_literacy_survey', true);
    }

    public function down()
    {
        $this->forge->dropTable('health_literacy_survey', true);
    }
}
