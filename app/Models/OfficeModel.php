<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $table            = 'office';
    protected $primaryKey       = 'hcode';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'hcode','orgcode', 'hname', 'htype','hdepart', 'tmb_code', 'amp_code', 'chw_code', 'd_update'
    ];
    protected $useTimestamps = false;
    public function getOfficeAll()
    {
        return $this->findAll();
    }
    public function getHospname($hcode)
    {
        $office = $this->find($hcode);
        foreach($office as $key => $value){
            $officename = $value->hname;
        }
        return $officename ? $officename : null;
    }
    public function getOrgname($orgcode)
    {
        $office = $this->find($orgcode);
        return $office ? $office->hname : null;
    }
    public function deleteBatch($hcode)
    {
        if($hcode){
            return $this->db->table($this->table)
                            ->where('hcode',$hcode)
                            ->delete();
        }
        return false;
    }
     public function bulkInsert($data) {
        return $this->db
                ->table($this->table)
                ->insertBatch($data);
    }
    
}