<?php

namespace App\Models;

use CodeIgniter\Model;

class DmckdModel extends Model
{
    protected $table            = 'dmckd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','hid','vhid','discharge','group_diag','group_date','group_hos_dx','min_date_dx'
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

    public function getDmCkdByhcode($hcode = null)
    {
        $builder1 = $this->db->table($this->table);
        
        if ($hcode) {
            $builder1->select('vhid as hospcode,count(id) as countid');
            $builder1->where('hospcode', $hcode);
            $builder1->groupBy('vhid');
        } else {
            $builder1->select('hospcode,count(id) as countid');
            $builder1->groupBy('hospcode');
        }
        return $builder1->get()->getResultArray();
    }
    public function getDmCkdData($hcode = null)
    {
        if($hcode){
            return $this->db->table($this->table)->where('hospcode', $hcode)->get()->getResultArray();
        } else {
            return $this->db->table($this->table)->get()->getResultArray();
        }
    }
}
