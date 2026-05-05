<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentAcademicHistoryModel extends Model
{
    protected $table      = 'student_academic_history';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'student_id',
		'student_code',
		'last_ac_certificate',
		'last_ac_exam_passed',
		'last_ac_year',
		'last_ac_board',
		'last_ac_school_name',
		'last_ac_roll_no',
		'last_ac_max_mark',
		'last_ac_marks',
		'last_school_detail',
		'transfer_certificate',
		'marksheet',
		'last_year_marksheet',
		'tc_required',
		'pre_school_tc_date',
		'migration_required',
		'migration_date',
    ];

}