<?php

namespace App\Models;

use CodeIgniter\Model;

class SeledmModel extends Model
{
    protected $table            = 'selected_riskdm';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','pid','birth','hid','vhid','sex','discharge','typearea',
        'date_screen','bstest','bslevel','result','bstest2','bslevel2','result2','inprojected','risktype','send'];

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

    public function getRisk_dm_to_selected($id)
    {
        $sourceBuilder = $this->db->table('riskdm');
        $query = $sourceBuilder->select('hospcode,pid,birth,hid,vhid,sex,discharge,typearea,date_screen,bstest,bslevel,result')
                    ->getWhere(['id' => $id]); 
        $rows = $query->getResultArray();
        if($rows){
            $destinationBuilder = $this->db->table($this->table);
            return $destinationBuilder->insertBatch($rows);
            //$destinationBuilder->where('id', $this->db->insertID())->update(['risktype' => 'dm', 'inprojected' => 1,'d_update' => date('Y-m-d H:i:s')]); 
        }
    }
    public function getRisk_ht_to_selected($id) 
    {
        $sourceBuilder = $this->db->table('riskht');
        $query = $sourceBuilder->select('hospcode,pid,birth,hid,vhid,sex,discharge,typearea,date_screen,sbp,dbp,result')
                    ->getWhere(['id' => $id]); 
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
                        ->select('selected_riskdm.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.sex,village.villname,tumbon.tumbon')
                        ->join('person','selected_riskdm.hospcode=person.hospcode and selected_riskdm.pid=person.pid','inner') 
                        ->join('village','selected_riskdm.vhid = village.villcode','inner') 
                        ->join('tumbon','left(selected_riskdm.vhid,6) = tumbon.tumid','inner') 
                        ->where('selected_riskdm.hospcode',$hcode)
                        ->where('selected_riskdm.inprojected','1')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db->table($this->table)
                        ->select('selected_riskdm.*,CONCAT(person.fname," ",person.lname) as pname,TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.sex,village.villname,tumbon.tumbon')
                        ->join('person','selected_riskdm.hospcode=person.hospcode and selected_riskdm.pid=person.pid','inner') 
                        ->join('village','selected_riskdm.vhid = village.villcode','inner') 
                        ->join('tumbon','left(selected_riskdm.vhid,6) = tumbon.tumid','inner') 
                        ->where('selected_riskdm.inprojected','1')
                        ->get()
                        ->getResultArray();
        }    
    }
    public function updateData($where,$data)
    {
        return $this->db
                    ->table($this->table)
                    ->where($where)
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
                        ->join('village','selected_riskdm.vhid=village.villcode')
                        ->where('hospcode',$hcode)
                        ->groupBy('vhid,village.villname')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->db
                        ->table($this->table)
                        ->select('hospcode,office.hname as villname,count(id) as countID')
                        ->join('office','selected_riskdm.hospcode=office.hcode')
                        ->groupBy('hospcode,villname')
                        ->orderBy('countID','DESC')
                        ->get()
                        ->getResultArray();
        }
    }
    public function get_risk_inproj_bf()
    {
        $builder1 = $this->db->table($this->table)->select('result,count(id) as countid')
                            ->groupBy('result');
    
        return $builder1->get()->getResultArray();
    }
    public function get_risk_inproj_af()
    {
        $builder1 = $this->db->table($this->table)->select('result2,count(id) as countid')
                            ->groupBy('result2');
    
        return $builder1->get()->getResultArray();
    }

    public function get_risk_per($hcode)
    {
        $builder1 = $this->db->table($this->table)->select('selected_riskdm.*,CONCAT(person.fname," ",person.lname) as pname,
                    TIMESTAMPDIFF(YEAR, person.birth, CURDATE()) AS age,person.sex,CONCAT(risktype,":",result) as result1,risktype')
                    ->join('person','person.hospcode=selected_riskdm.hospcode and person.pid=selected_riskdm.pid','inner')
                    ->where('selected_riskdm.hcoach', $hcode);
        return $builder1->get()->getResultArray();
    }
    public function get_result_by_hcode($hcode)
    {
        if(!empty($hcode)){
            $SQL = "SELECT hospcode,SUM(if(result2 <> '',1,0)) as results,
            SUM(if(hcoach <> '',1,0)) as hcoachs FROM selected_riskdm WHERE hospcode = '".$hcode."' GROUP BY hospcode";
        } else {        
         $SQL = "SELECT hospcode,SUM(if(result2 <> '',1,0)) as results,
         SUM(if(hcoach <> '',1,0)) as hcoachs FROM selected_riskdm GROUP BY hospcode";
        }
         return $this->db->query($SQL)->getResultArray();
    }
}
