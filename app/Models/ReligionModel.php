<?php
namespace App\Models;
use CodeIgniter\Model;

class ReligionModel extends Model
{
    protected $table      = 'religion';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'name', 
    ];

}