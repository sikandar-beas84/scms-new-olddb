<?php
namespace App\Models;
use CodeIgniter\Model;

class AdmissionExamScheduleModel extends Model
{
    protected $table      = 'admission_exam_schedule';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'class_id',
		'exam_date',
		'exam_time',
		'session_year_id',
		'status',
		'phase',
		'create_date',
		'created_by',
		'updated_by',
		'updated_at',
    ];

}