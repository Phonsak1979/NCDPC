<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $table            = 'home';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospcode','hid','village','tambon','ampur','changwat','latitude','longitude','nfamily','d_update'];

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

    public function getLatlng($cid)
    {
        $SQL = "SELECT h.latitude,h.longitude,p.idcard FROM ltc_home h 
        INNER JOIN ltc_person p ON h.hospcode = p.hospcode AND h.hid = p.hid WHERE h.cid ='".$cid."'";
        return $this->QUERY($SQL)->get()->getResultArray();
    }
    public function getHomeByVillage($hcode)
    {
        return $this->SELECT("CONCAT(changwat,ampur,tambon,village) as villcode,count(hid) as chid")
                    ->where('hospcode',$hcode)
                    ->groupBy('villcode')
                    ->get()->getResultArray();
    }
    public function getHomeByhid($hcode,$hid)
    {
        return $this->where('hospcode',$hcode)->where('hid',$hid)->first();
    }
    public function BulkInsert($data)
    {
        return $this->insertBatch($data);
    }
    public function addEntry($data) {
        $this->db
                ->table($this->table)
                    ->insert($data);
        return $this->db->insertID();
    }

    public function updateEntry($where, $data) {
        return $this->db
                ->table($this->table)
                    ->where($where)
                    ->set($data)
                    ->update();
    }

    public function deleteEntry($where) {
        return $this->db
                ->table($this->table)
                    ->where($where)
                    ->delete();
    }
}
