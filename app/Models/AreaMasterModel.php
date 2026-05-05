<?php
namespace App\Models;
use CodeIgniter\Model;

class AreaMasterModel extends Model
{
    protected $table      = 'area_master';
    protected $primaryKey = 'area_id'; // or whatever your PK is

    protected $allowedFields = [
        'area_name', 
        'create_date', 
        'status', 
    ];

}