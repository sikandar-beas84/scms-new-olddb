<?php
namespace App\Models;
use CodeIgniter\Model;

class ClassWiseExamDatesModel extends Model
{
    protected $table      = 'class_wise_exam_dates';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'phase', 
        'session_year_id', 
        'exam_date', 
        'class_id', 
        'created_by', 
        'created_at', 
        'updated_by', 
        'updated_at', 
    ];
}