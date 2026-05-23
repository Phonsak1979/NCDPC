<?php

namespace App\Models;

use CodeIgniter\Model;

class SeleHtModel extends Model
{
    protected $table            = 'selected_riskht';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','sex','birth','hid','vhid','discharge',
    'typearea','date_screen','sbp','dbp','result','sbp2','dbp2','result2','inprojeted','risktype'];

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

    public function getRisk_ht_to_selected($id)
    {
        $sourceBuilder = $this->db->table('riskht');
        $query = $sourceBuilder->getWhere(['id' => $id]); 
        $rows = $query->getResultArray();
        if($rows){
            $destinationBuilder = $this->db->table($this->table);
            return $destinationBuilder->insertBatch($rows); 
        }

    }
    public function getCaseinProj($hcode= Null)
    {
        if(!empty($hcode)){
            return $this->db->table($this->table)
                        ->select('selected_riskht.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.sex,village.villname,tumbon.tumbon')
                        ->join('person','selected_riskht.hospcode=person.hospcode and selected_riskht.pid=person.pid','inner') 
                        ->join('village','selected_riskht.vhid = village.villcode','inner') 
                        ->join('tumbon','left(selected_riskht.vhid,6) = tumbon.tumid','inner') 
                        ->where('selected_riskht.hospcode',$hcode)
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db->table($this->table)
                        ->select('selected_riskht.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.sex,village.villname,tumbon.tumbon')
                        ->join('person','selected_riskht.hospcode=person.hospcode and selected_riskht.pid=person.pid','inner') 
                        ->join('village','selected_riskht.vhid = village.villcode','inner') 
                        ->join('tumbon','left(selected_riskht.vhid,6) = tumbon.tumid','inner') 
                        ->get()
                        ->getResultArray();
        }    
    }
    public function updateData($id,$data)
    {
        return $this->db
                    ->table($this->table)
                    ->where('id',$id)
                    ->set($data)
                    ->update();

    }
    public function delete_selected($id)
    {
        return $this->db
                    ->table($this->table)
                    ->where('id',$id)
                    ->delete();
    }

    public function getRiskByOrgan_chart($hcode = null)
    {
        if(!empty($hcode)){
            return $this->db
                        ->table($this->table)
                        ->select('vhid,village.villname,count(id) as countID')
                        ->join('village','selected_riskht.vhid=village.villcode')
                        ->where('hospcode',$hcode)
                        ->groupBy('vhid,village.villname')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                        ->select('hospcode,office.hname as villname,count(id) as countID')
                        ->join('office','selected_riskht.hospcode=office.hcode')
                        ->groupBy('hospcode,villname')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        }
    }
}
