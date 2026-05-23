<?php

namespace App\Models;

use CodeIgniter\Model;

class ncdModel extends Model
{
    protected $db; 
    protected $table = 'personncd';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'hospcode',
        'pid',
        'date_dx',
        'chronic',
        'hosp_dx',
        'hosp_rx',
        'date_disch',
        'typedisch',
        'd_update',
        'cid'
    ];
    
    public $timestamps = false;
    public function getNCDByCid($cid)
    {
        return $this->where('cid', $cid)->first();
    }
    public function BulkInsert($data)
    {
        return $this->insertBatch($data);
    }
    public function getNCDAll($hcode)
    {
        return $this->where('hospcode',$hcode)->get()->getResultArray();
    }
    public function deleteNCD($id)
    {
        return $this->delete($id);
    }
}
