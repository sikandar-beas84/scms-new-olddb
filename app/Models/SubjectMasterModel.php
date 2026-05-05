<?php
namespace App\Models;
use CodeIgniter\Model;

class SubjectMasterModel extends Model
{
    protected $table      = 'subject_master';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'subject_code', 
        'subject_name', 
        'created_at', 
        'updated_at', 
    ];

}

