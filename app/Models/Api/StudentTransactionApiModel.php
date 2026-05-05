<?php
namespace App\Models\Api;
use CodeIgniter\Model;

class StudentTransactionApiModel extends Model
{
    protected $table      = 'student_transaction';
    protected $primaryKey = 'st_id'; // or whatever your PK is

    protected $allowedFields = [ 
        'student_code',
        'due_amount',
        'advanced_amount',
        'ad_payment_status',
        'session_year_id',
        'created_date'
    ];


}