<?php namespace App\Models;

use CodeIgniter\Model;

class riskfallModel extends Model
{
    protected $db;
    protected $DBGroup = 'default'; 
    protected $table = 'riskfall';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'ltc_id', 'sex', 'seen', 'balance','drug', 'his', 'home','sumall','d_update'];

    public function addEntry($data) {
        $this->db
                ->table($this->table)
                    ->insert($data);
        return $this->db->insertID();
    }

    public function updateEntry($where, $data) {
        return $this->db
                ->table($this->table)
                    ->where($where)
                    ->set($data)
                    ->update();
    }

    public function deleteEntry($where) {
        return $this->db
                ->table($this->table)
                    ->where($where)
                    ->delete();
    }

    public function getEntry($where) {
        return $this->db
                ->table($this->table)
                    ->where($where)
                    ->get()
                    ->getRow();

    }

    public function getEntryList($where = 0) {
        if($where) {
            return $this->db
                    ->table($this->table)
                ->where($where)
                ->get()
                ->getResultArray();
        } else {
            return $this->db
                    ->table($this->table)
                ->get()
                ->getResultArray();
        }
    }

    public function getNumRows($where) {
        return $this->db
                ->table($this->table)
                    ->where($where)
                    ->get()
                    ->getNumRows();
    }
    public function getLtcname($id)
    {
        $cgname = $this->QUERY("SELECT person.pername FROM ltc INNER JOIN person ON ltc.idcard = person.idcard 
                              WHERE ltc.id ='".$id."'")->getResultArray();
        if(!empty($cgname)){
            foreach($cgname as $value){
                return $value['pername'];
            }
        } else {
            return "ไม่พบบุคคลนี้";    
        }
    }
}