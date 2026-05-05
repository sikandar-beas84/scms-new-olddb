<?php
namespace App\Models;
use CodeIgniter\Model;

class SubjectParameterModel extends Model
{
    protected $table      = 'subject_parameter';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'class_id', 
        'subject_id', 
        'parameter', 
        'marks', 
        'month_id',
    ];

}