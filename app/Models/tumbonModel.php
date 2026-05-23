<?php namespace App\Models;

use CodeIgniter\Model;

class tumbonModel extends Model
{
    protected $db;
    protected $DBGroup = 'default'; 
    protected $table = 'tumbon';
    protected $primaryKey = 'tumid';
    protected $allowedFields = ['tumid', 'tumbon', 'tumbon_eng', 'ampid', 'provid', 'pop',
    ];
    
    public function getTumbonname($tumid)
    {
        $tumb = $this->select('tumbon')->WHERE('tumid',$tumid)->get();
        if(!empty($tumb)){
            foreach($tumb->getResult() as $value){
                return $value->tumbon;
            }
        } else {
            return "ไม่พบตำบล";    
        }
    }
    public function getTumAll()
    {
        $tumb = $this->select('tumid,tumbon')->findAll();
        return $tumb;
    }
}
