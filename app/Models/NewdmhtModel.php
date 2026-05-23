<?php

namespace App\Models;

use CodeIgniter\Model;

class NewdmhtModel extends Model
{
    protected $table            = 'newdmht';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','mix_dx',
    	'type_dx','date_dx','hosp_dx','ld_hba1c','rs_hba1c','ih_hba1c','ld_fpg1','rs_fpg1','ih_fpg1','ld_fpg2','rs_fpg2','ih_fpg2',
        'ld_retina','rs_retina','ih_retina','ld_foot','rs_foot','ih_foot','ld_bp1','ih_bp1','rs_bps1','rs_bpd1','ld_bp2','ih_bp2',	
    'rs_bps2','rs_bpd2','min_date_dx_dm','min_date_dx_ht','year_dx'];

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
    public function getNewDmHtByhcode($hcode = null)
    {
        if(!empty($hcode))
            {
                return $this->db
                            ->QUERY('SELECT newdmht.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,
                            person.typearea,person.sex,village.villname,tumbon.tumbon,TIMESTAMPDIFF(YEAR, newdmht.min_date_dx_dm, CURDATE()) AS d_dx FROM newdmht 
                            INNER join person ON newdmht.hospcode=person.hospcode and newdmht.pid=person.pid  
                            inner join village ON newdmht.vhid = village.villcode  
                            inner join tumbon ON  left(newdmht.vhid,6) = tumbon.tumid WHERE newdmht.hospcode ="'.$hcode.'"')
                            ->getResultArray(); 
            } else {
                return $this->db
                             ->QUERY('SELECT newdmht.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,
                            person.typearea,person.sex,village.villname,tumbon.tumbon,TIMESTAMPDIFF(YEAR, newdmht.min_date_dx_dm, CURDATE()) AS d_dx FROM newdmht 
                            INNER join person ON newdmht.hospcode=person.hospcode and newdmht.pid=person.pid  
                            inner join village ON newdmht.vhid = village.villcode  
                            inner join tumbon ON  left(newdmht.vhid,6) = tumbon.tumid')
                            ->getResultArray(); 
            }
    }
    public function getOldDmHtByHbA1C($hcode = null)
    {
         if(!empty($hcode))
            {
                return $this->db
                            ->QUERY('Select CASE WHEN rs_hba1c > 7.0 THEN "unControl" WHEN rs_hba1c <= 7.0 THEN "Good Control" ELSE "Null" END AS res_hba1c,
                                     count(id) as c_hba1c FROM newdmht WHERE hospcode="'.$hcode.'" GROUP BY res_hba1c')
                            ->getResultArray();
            } else {
                return $this->db
                            ->QUERY('Select CASE WHEN rs_hba1c > 7.0 THEN "unControl" WHEN rs_hba1c <= 7.0 THEN "Good Control" ELSE "Null" END AS res_hba1c,
                                     count(id) as c_hba1c FROM newdmht GROUP BY res_hba1c')
                            ->getResultArray();
            }
    }
    public function getOldDmHtByFpg1($hcode = null)
    {
            if(!empty($hcode))
            {
                return $this->db
                            ->QUERY('Select CASE WHEN rs_fpg1 <= 100 THEN "ปกติ" WHEN rs_fpg1 > 100 and rs_fpg1 <= 126 THEN "เสี่ยง" WHEN rs_fpg1 > 126 THEN "เสี่ยงสูง" ELSE "Null" END AS res_fpg1, 
                                     count(id) as c_fpg1 FROM newdmht WHERE hospcode="'.$hcode.'" GROUP BY res_fpg1')
                            ->getResultArray();
            } else {
                return $this->db
                            ->QUERY('Select CASE WHEN rs_fpg1 <= 100 THEN "ปกติ" WHEN rs_fpg1 > 100 and rs_fpg1 <= 126 THEN "เสี่ยง" WHEN rs_fpg1 > 126 THEN "เสี่ยงสูง" ELSE "Null" END AS res_fpg1, 
                                     count(id) as c_fpg1 FROM newdmht GROUP BY res_fpg1')
                            ->getResultArray();
            }
    }
    public function getOldDmHtByFpg2($hcode = null)
    {
            if(!empty($hcode))
            {
                return $this->db
                            ->QUERY('Select CASE WHEN rs_fpg2 <= 100 THEN "ปกติ" WHEN rs_fpg2 > 100 and rs_fpg2 <= 126 THEN "เสี่ยง" WHEN rs_fpg2 > 126 THEN "เสี่ยงสูง" ELSE "Null" END AS res_fpg2, 
                                     count(id) as c_fpg2 FROM newdmht WHERE hospcode="'.$hcode.'" GROUP BY res_fpg2')
                            ->getResultArray();
            } else {
                return $this->db
                            ->QUERY('Select CASE WHEN rs_fpg2 <= 100 THEN "ปกติ" WHEN rs_fpg2 > 100 and rs_fpg2 <= 126 THEN "เสี่ยง" WHEN rs_fpg2 > 126 THEN "เสี่ยงสูง" ELSE "Null" END AS res_fpg2, 
                                     count(id) as c_fpg2 FROM newdmht GROUP BY res_fpg2')
                            ->getResultArray();
            }
    }
}  
