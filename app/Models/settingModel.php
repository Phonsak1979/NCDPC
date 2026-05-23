<?php

namespace App\Models;

use CodeIgniter\Model;

class settingModel extends Model
{
    // Specify the table name
    protected $table = 'tb_setting';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Disable timestamps if the table doesn't have created_at and updated_at columns
    public $timestamps = false;

    // Specify fillable fields for mass assignment
    protected $allow = [ 'hoscode', 'offname', 'offtype', 'tumbon', 'ample', 'province', 'admin'
    ];

    public function getOffname()
    {
        $offname = $this->select('offname')->first();
        return $offname['offname'] ?? null;
    }
}