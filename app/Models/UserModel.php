<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    /**
     * ชื่อตารางในฐานข้อมูล
     */
    protected $db;
    protected $DBGroup = 'default'; 

    protected $table            = 'ltc_users';

    /**
     * Primary Key ของตาราง
     */
    protected $primaryKey       = 'id';

    /**
     * กำหนดให้ใช้ Auto Increment
     */
    protected $useAutoIncrement = true;

    /**
     * กำหนดประเภทข้อมูลที่จะ return (object หรือ array)
     */
    protected $returnType       = 'object'; // หรือ 'array'

    /**
     * กำหนดว่าให้ใช้ Soft Deletes หรือไม่ (ตารางนี้ไม่มี deleted_at)
     */
    protected $useSoftDeletes = false;

    /**
     * รายชื่อคอลัมน์ที่อนุญาตให้ "Mass Assignment"
     * (อนุญาตให้ insert/update ผ่าน $model->save($data))
     *
     * **สำคัญ:** เราเพิ่ม 'password' เข้าไปชั่วคราว
     * เพื่อให้ Callback (hashPassword) ทำงานได้
     */
    protected $allowedFields    = [
        'id',
        'hcode',
        'email',
        'fname',
        'username',
        'password_hash',
        'permis',
        'password', // Field เสมือนสำหรับรับรหัสผ่าน (จะถูกลบออกโดย Callback)
        'created_at'
    ];

    // --- Timestamps ---
    /**
     * กำหนดว่าให้ Model จัดการ timestamps (created_at, updated_at) อัตโนมัติหรือไม่
     * เราตั้งเป็น false เพราะ:
     * 1. ตารางของคุณมี 'created_at' ที่มี DEFAULT curdate() (Database จัดการเอง)
     * 2. ตารางของคุณไม่มี 'updated_at'
     */
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at'; // ไม่จำเป็นต้องกำหนด ถ้า useTimestamps = false
    // protected $updatedField  = ''; // ไม่จำเป็นต้องกำหนด

    // --- Callbacks ---
    /**
     * กำหนด Callbacks ที่จะทำงานก่อนการ Insert หรือ Update
     * เราใช้สำหรับ Hash รหัสผ่าน
     */
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * ฟังก์ชัน Callback สำหรับ Hash รหัสผ่าน
     *
     * ฟังก์ชันนี้จะมองหา key 'password' ใน $data ที่ส่งเข้ามา
     * ถ้าเจอ, มันจะ hash ค่านั้น แล้วเก็บลงใน 'password_hash'
     * และลบ key 'password' (ที่เป็น plaintext) ทิ้งไป
     */
    protected function hashPassword(array $data)
    {
        // ตรวจสอบว่ามี key 'password' ส่งมาใน $data['data'] หรือไม่
        if (! isset($data['data']['password'])) {
            return $data; // ไม่มีรหัสผ่านให้ hash, ส่งข้อมูลเดิมกลับไป
        }

        // Hash รหัสผ่าน
        $hashedPassword = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        // กำหนดค่า 'password_hash'
        $data['data']['password_hash'] = $hashedPassword;

        // ลบ key 'password' ที่เป็น plaintext ทิ้ง
        // เพื่อไม่ให้มันพยายาม insert ลง DB (เพราะไม่มีคอลัมน์ชื่อ password)
        unset($data['data']['password']);

        return $data;
    }

    // --- (ทางเลือก) Validation ---
    /**
     * กฎการตรวจสอบความถูกต้องของข้อมูล (แนะนำให้ใส่)
     */
    protected $validationRules = [
        // {id} ใช้สำหรับบอก CI ว่าให้ข้ามการเช็ค unique ของ id ปัจจุบัน (ตอน update)
        'email'    => 'required|valid_email|is_unique[ltc_users.email,id,{id}]',
        'username' => 'required|min_length[3]|is_unique[ltc_users.username,id,{id}]',
        'password' => 'required|min_length[6]', // ตรวจสอบ 'password' (plaintext)
    ];

    /**
     * ข้อความแสดงข้อผิดพลาด (ปรับแต่งเองได้)
     */
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'ขออภัย, อีเมลนี้ถูกใช้งานแล้ว',
        ],
        'username' => [
            'is_unique' => 'ขออภัย, ชื่อผู้ใช้งานนี้ถูกใช้งานแล้ว',
        ],
    ];
    protected $skipValidation       = false;

    public function addUser($data)
    {
        $this->db
              ->table($this->table)
                ->insert($data);
        return $this->db->insertID();
    }   
    public function updateUser($id, $data)
    {
        return $this->db
                    ->table($this->table)
                    ->where('id', $id)
                    ->set($data)
                    ->update();
    }
}