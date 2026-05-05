<?php
namespace App\Models;
use CodeIgniter\Model;

class DesignationModel extends Model
{
    protected $table      = 'designation';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'name', 
        'status', 
    ];

}

