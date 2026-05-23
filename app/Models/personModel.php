<?php

namespace App\Models;

use CodeIgniter\Model;

class personModel extends Model
{
    protected $db; 
    protected $table = 'person';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'hospcode',
        'cid',
        'pid',
        'hid',
        'prename',
        'fname',
        'lname',
        'hn',
        'sex',
        'birth',
        'mstatus',
        'typearea',
        'adl',
        'tai',
        'riskfall',
        'd_update'
    ];
    
    public $timestamps = false;
    public function getPersonByCid($cid)
    {
        return $this->where('cid', $cid)->first();
    }
    public function BulkInsert($data)
    {
        return $this->insertBatch($data);
    }
    public function getPersonAll()
    {
        return $this->findAll();
    }
    public function deletePop($id)
    {
        return $this->delete($id);
    }
    public function updatePersonById($hospcode,$cid, $data)
    {
        return $this->where('hospcode', $hospcode)->andWhere('cid', $cid)->update($data);
    }
    public function getElderlyByHcode($hospcode)
    {
        return $this->select("id,hospcode,cid,CONCAT(fname,' ',lname) as fullname,hn,sex,DATEDIFF(CURRENT_DATE, birth) / 365 as age,mstatus,typearea,adl,tai,riskfall,d_update") 
         ->where("DATEDIFF(CURRENT_DATE, birth) / 365 >= 60")
         ->Where('hospcode', $hospcode)
         ->get()
         ->getResultArray();
    }
    public function getElderlyByCid($cid)
    {
        return $this->select("id,hospcode,cid,CONCAT(fname,' ',lname) as fullname,hn,sex,DATEDIFF(CURRENT_DATE, birth) / 365 as age,mstatus,typearea,adl,tai,riskfall,d_update") 
         ->where("DATEDIFF(CURRENT_DATE, birth) / 365 >= 60")
         ->Where('cid', $cid)
         ->get()
         ->getResultArray();
    }

    public function popByagegroup($hcode)
    {
        $SQL = "CASE 
            WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 0 AND 14 THEN '0-14 ปี'
            WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 15 AND 24 THEN '15-24 ปี'
            WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 25 AND 59 THEN '25-59 ปี'
            WHEN TIMESTAMPDIFF(YEAR, birth, CURDATE()) BETWEEN 60 AND 70 THEN '60-70 ปี'
            ELSE 'อายุ 70 ปีขึ้นไป' 
        END AS age_group,COUNT(*) AS pop_count";
        return $this->select($SQL)->where("hospcode",$hcode)->groupBy("age_group")
                ->orderBy("MIN(TIMESTAMPDIFF(YEAR, birth, CURDATE()))")
                ->get()
                ->getResultArray();
        
    }
    public function getPersonName($hoscode,$pid)
    {
        return $this->select("CONCAT(fname,' ',lname) as pname")
                    ->where('hospcode', $hoscode)
                    ->where('pid', $pid)
                    ->get()
                    ->getRow();
    }
    public function getPersonByHcodePid($hospcode,$pid)
    {
        return $this->where('hospcode', $hospcode)->where('pid', $pid)->get()->getRow();
    }
    public function getPerOver35year($hospcode = null)
    {
        $builder = $this->select("id,hospcode,pid,cid,CONCAT(fname,' ',lname) as fullname");
        if ($hospcode) {
            $builder->where('hospcode', $hospcode);
        }
        return $builder->where("TIMESTAMPDIFF(YEAR, birth, CURDATE()) > 34")
                       ->get()
                       ->getResultArray();
    }
}