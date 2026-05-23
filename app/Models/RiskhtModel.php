<?php

namespace App\Models;

use CodeIgniter\Model;

class RiskhtModel extends Model
{
    protected $table            = 'riskht';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'json';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','sex','birth','hid','vhid','discharge',
    'typearea','date_screen','sbp','dbp','result','inprojected'];

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
    public function updateData($id,$data)
    {
        return $this->db
                    ->table($this->table)
                    ->where('id',$id)
                    ->set($data)
                    ->update();

    }
    public function getperByhcodepid($where)
    {
        return $this->db
                    ->table($this->table)
                    ->where($where)
                    ->get()
                    ->getResultArray();
    }
    public function getRiskHtByhcode($hcode)
    {
        if(!empty($hcode)){
            return $this->db
                        ->table($this->table)
                        ->select('riskht.*,riskht.id as rid,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.typearea,village.villname,tumbon.tumbon')
                        ->join('person','riskht.hospcode=person.hospcode and riskht.pid=person.pid','inner') 
                        ->join('village','riskht.vhid = village.villcode','inner') 
                        ->join('tumbon','left(riskht.vhid,6) = tumbon.tumid','inner') 
                        ->where('riskht.hospcode',$hcode)
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                       ->select('riskht.*,riskht.id as rid,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.typearea,village.villname,tumbon.tumbon')
                        ->join('person','riskht.hospcode=person.hospcode and riskht.pid=person.pid','inner') 
                        ->join('village','riskht.vhid = village.villcode','inner') 
                        ->join('tumbon','left(riskht.vhid,6) = tumbon.tumid','inner') 
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
                        ->join('village','riskht.vhid=village.villcode')
                        ->where('hospcode',$hcode)
                        ->groupBy('vhid,village.villname')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                        ->select('hospcode,office.hname as villname,count(id) as countID')
                        ->join('office','riskht.hospcode=office.hcode')
                        ->groupBy('hospcode')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        }
    }
}
