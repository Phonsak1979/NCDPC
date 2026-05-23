<?php

namespace App\Models;

use CodeIgniter\Model;

class NewDMModel extends Model
{
    protected $table            = 'newdm';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','mix_dx',
    	'type_dx','date_dx','hosp_dx','ld_hba1c','rs_hba1c','ih_hba1c','ld_fpg1','rs_fpg1','ih_fpg1','ld_fpg2','rs_fpg2','ih_fpg2',
        'ld_retina','rs_retina','ih_retina','ld_foot','rs_foot','ih_foot','min_date_dx_dm','year_dx'
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
    public function getNewDmByhcode($hcode = null)
    {
        if(!empty($hcode))
            {
                return $this->db
                            ->QUERY('SELECT newdm.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,
                            person.typearea,person.sex,village.villname,tumbon.tumbon,TIMESTAMPDIFF(YEAR, newdm.date_dx, CURDATE()) AS d_dx FROM newdm 
                            INNER join person ON newdm.hospcode=person.hospcode and newdm.pid=person.pid  
                            inner join village ON newdm.vhid = village.villcode  
                            inner join tumbon ON  left(newdm.vhid,6) = tumbon.tumid WHERE newdm.hospcode ="'.$hcode.'"')
                            ->getResultArray(); 
            } else {
                return $this->db
                             ->QUERY('SELECT newdm.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,
                            person.typearea,person.sex,village.villname,tumbon.tumbon,TIMESTAMPDIFF(YEAR, newdm.date_dx, CURDATE()) AS d_dx FROM newdm 
                            INNER join person ON newdm.hospcode=person.hospcode and newdm.pid=person.pid  
                            inner join village ON newdm.vhid = village.villcode  
                            inner join tumbon ON  left(newdm.vhid,6) = tumbon.tumid')
                            ->getResultArray(); 
            }
    }

    public function getNewcaseByhcode($hcode = null)
    {
        if(!empty($hcode))
            {
                $builder1 = $this->db->table($this->table);
                $builder1->select('vhid as hospcode, count(pid) as countpid,"dm" as type');
                $builder1->where('hospcode', $hcode);
                $builder1->groupBy('vhid, type');
                $builder2 = $this->db->table('newht');
                $builder2->select('vhid as hospcode, count(pid) as countpid,"ht" as type');
                $builder2->where('hospcode', $hcode);
                $builder2->groupBy('vhid, type');
                $builder3 = $this->db->table('newdmht');
                $builder3->select('vhid as hospcode, count(pid) as countpid,"dmht" as type');
                $builder3->where('hospcode', $hcode);
                $builder3->groupBy('vhid, type');                
            } else {
                $builder1 = $this->db->table($this->table);
                $builder1->select('hospcode, count(pid) as countpid,"dm" as type');
                $builder1->groupBy('hospcode, type');
                $builder2 = $this->db->table('newht');
                $builder2->select('hospcode, count(pid) as countpid,"ht" as type');
                $builder2->groupBy('hospcode, type');
                $builder3 = $this->db->table('newdmht');
                $builder3->select('hospcode, count(pid) as countpid,"dmht" as type');
                $builder3->groupBy('hospcode, type');
            }

            return $builder1->unionAll($builder2)->unionAll($builder3)->get()->getResultArray();
    }
}