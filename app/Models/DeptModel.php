<?php
namespace App\Models;
use CodeIgniter\Model;

class DeptModel extends Model
{
    protected $table      = 'dept';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'name', 
    ];

}

