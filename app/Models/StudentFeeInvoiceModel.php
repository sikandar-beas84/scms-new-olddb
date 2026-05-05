<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentFeeInvoiceModel extends Model
{

    protected $table      = 'student_fee_invoice';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'form_no',
        'session_year_id',
        'admission_fee',
        'development_fee',
        'exam_fee',
        'festival_celebration_fee',
        'games_sports_fee',
        'audio_visual_lab_fee',
        'library_fee',
        'electricity_maintenance_fee',
        'computer_fee',
        'security_deposite',
        'tuition_fee',
        'stoppage_fee',
        'grand_total_fees',
        'payment_amount',
        'payment_cheque_number',
        'payment_pos_bank_name',
        'payment_pos_reference_number',
        'remarks',
        'stationary_items',
        'stationary_total',
        'tblc_items',
        'tblc_total',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'student_id'
    ];

}