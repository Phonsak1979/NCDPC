<?php

namespace App\Models;

use CodeIgniter\Model;

class ScreenDMModel extends Model
{
    protected $db;
    protected $DBGroup          = 'default'; 
    protected $table            = 'screened_dm';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','check_vhid','typearea','date_screen','bstest','bslevel','hosp_screen','hosp_input','risk','result'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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


    public function bulkInsert($data) {
        return $this->db
                ->table($this->table)
                ->insertBatch($data);
    }
    public function getperByhcodepid($where)
    {
        return $this->db
                    ->table($this->table)
                    ->where($where)
                    ->get()
                    ->getResultArray();
    }
    public function getPerScreenByHoscode($hospcode = null, $villcode = null)
    {
        if($hospcode != null && $villcode != null) {
             $SQL = "SELECT screened_dm.*, CONCAT(person.fname,' ',person.lname) as name,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age, person.typearea
                    FROM screened_dm
                    JOIN person ON person.hospcode = screened_dm.hospcode AND person.pid = screened_dm.pid
                    WHERE screened_dm.hospcode ='".$hospcode."' AND screened_dm.check_vhid = '".$villcode."' AND TIMESTAMPDIFF(YEAR, person.birth, CURDATE())> 34";
           
        } elseif($hospcode != null){
            $SQL = "SELECT screened_dm.*, CONCAT(person.fname,' ',person.lname) as name,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age, person.typearea
                    FROM screened_dm
                    JOIN person ON person.hospcode = screened_dm.hospcode AND person.pid = screened_dm.pid
                    WHERE screened_dm.hospcode ='".$hospcode."' AND TIMESTAMPDIFF(YEAR, person.birth, CURDATE())> 34";    
        } else {
            $SQL = "SELECT screened_dm.*, CONCAT(person.fname,' ',person.lname) as name,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age, person.typearea
                    FROM screened_dm
                    JOIN person ON person.hospcode = screened_dm.hospcode AND person.pid = screened_dm.pid
                    WHERE TIMESTAMPDIFF(YEAR, person.birth, CURDATE())> 34";
       }
       return $this->response->setJSON($this->db
                    ->query($SQL)
                    ->getResultArray());
    }
    public function getPernotScreenByHoscode($hospcode = null, $villcode = null)
    {
        if(!empty($hospcode)){
            $SQL = "SELECT CONCAT(person.fname,' ',person.lname) AS name,person.hospcode,person.pid,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.typearea
                    FROM person
                    LEFT JOIN screened_dm ON screened_dm.hospcode = person.hospcode AND screened_dm.pid = person.pid
                    WHERE person.hospcode = '".$hospcode."' AND TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) > 34
                    AND screened_dm.id IS NULL";
        } else {
         $SQL = "SELECT CONCAT(person.fname,' ',person.lname) AS name,person.hospcode,person.pid,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.typearea    
                    FROM person
                    LEFT JOIN screened_dm ON screened_dm.hospcode = person.hospcode AND screened_dm.pid = person.pid
                    WHERE TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) > 34
                    AND screened_dm.id IS NULL";
        }
        return $this->db
                    ->query($SQL)
                    ->getResultArray();
    }

}