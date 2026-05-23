<?php

namespace App\Models;

use CodeIgniter\Model;

class RiskdmModel extends Model
{
    protected $table            = 'riskdm';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'json';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'hospcode','pid','birth','hid','vhid','sex','discharge','typearea',
        'date_screen','bstest','bslevel','result','inprojected'
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
    public function updateData($id,$data)
    {
        return $this->db
                    ->table($this->table)
                    ->where('id',$id)
                    ->set($data)
                    ->update();

    }
    public function getRiskDmByhcode($hcode)
    {
        if(!empty($hcode)){
            return $this->db
                        ->table($this->table)
                        ->select('riskdm.*,riskdm.id as rid,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.sex,person.typearea,village.villname,tumbon.tumbon')
                        ->join('person','riskdm.hospcode=person.hospcode and riskdm.pid=person.pid','inner') 
                        ->join('village','riskdm.vhid = village.villcode','inner') 
                        ->join('tumbon','left(riskdm.vhid,6) = tumbon.tumid','inner') 
                        ->where('riskdm.hospcode',$hcode)
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                        ->select('riskdm.*,riskdm.id as rid,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age
                        ,person.sex,person.typearea,village.villname,tumbon.tumbon')
                        ->join('person','riskdm.hospcode=person.hospcode and riskdm.pid=person.pid','inner') 
                        ->join('village','riskdm.vhid = village.villcode','inner') 
                        ->join('tumbon','left(riskdm.vhid,6) = tumbon.tumid','inner') 
                        ->get()  
                        ->getResultArray();
        }
    }
    public function getRiskByOrgan_chart($hcode = null)
    {
        if(!empty($hcode)){
            return $this->db
                        ->table($this->table)
                        ->select('vhid,village.villname,count(id) as countID')
                        ->join('village','riskdm.vhid=village.villcode')
                        ->where('hospcode',$hcode)
                        ->groupBy('vhid,village.villname')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                        ->select('hospcode,office.hname as villname,count(id) as countID')
                        ->join('office','riskdm.hospcode=office.hcode')
                        ->groupBy('hospcode')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        }
    }
    public function getRiskAll($hcode)
    {
        if(!Empty($hcode)){
            return $this->db
                        ->table($this->table)
                        ->select('result,count(id) as countID')
                        ->where('hospcode',$hcode)
                        ->groupBy('result')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                        ->select('result,count(id) as countID')
                        ->groupBy('result')
                        ->get()
                        ->getResultArray();
        }
    }

}