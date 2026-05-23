<?php

namespace App\Models;

use CodeIgniter\Model;

class NewHTModel extends Model
{
    protected $table            = 'newht';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','hid','vhid','discharge','typearea','source_tb',
    'mix_dx','type_dx','date_dx','hosp_dx','ld_bp1','ih_bp1','rs_bps1','rs_bpd1','ld_bp2','ih_bp2',	
    'rs_bps2','rs_bpd2','min_date_dx_ht','year_dx'
];

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
    public function getNewHtByhcode($hcode = null)
    {
        if(!empty($hcode))
            {
                return $this->db
                            ->QUERY('SELECT newht.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,
                            person.typearea,person.sex,village.villname,tumbon.tumbon,TIMESTAMPDIFF(YEAR, newht.date_dx, CURDATE()) AS d_dx FROM newht 
                            INNER join person ON newht.hospcode=person.hospcode and newht.pid=person.pid  
                            inner join village ON newht.vhid = village.villcode  
                            inner join tumbon ON  left(newht.vhid,6) = tumbon.tumid WHERE newht.hospcode ="'.$hcode.'"')
                            ->getResultArray(); 
            } else {
                return $this->db
                             ->QUERY('SELECT newht.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,
                            person.typearea,person.sex,village.villname,tumbon.tumbon,TIMESTAMPDIFF(YEAR, newht.date_dx, CURDATE()) AS d_dx FROM newht 
                            INNER join person ON newht.hospcode=person.hospcode and newht.pid=person.pid  
                            inner join village ON newht.vhid = village.villcode  
                            inner join tumbon ON  left(newht.vhid,6) = tumbon.tumid')
                            ->getResultArray(); 
            }
    }
}
