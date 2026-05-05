<?php
namespace App\Models\Api;
use CodeIgniter\Model;

class StudentFeeStructureApiModel extends Model
{
    protected $table      = 'student_fee_structure';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [ 
        'student_code',
        'form_no',
        'month_id',
        'fine',
        'admission_fee',
        'development_fee',
        'exam_fee',
        'festival_celebration_fee',
        'games_sports_fee',
        'audio_visual_lab_fee',
        'library_fee',
        'electricity_maintenance_fee',
        'computer_fee',
        'session_charges',
        'security_deposite',
        'tuition_fee',
        'bus_services',
        'bus_fee_fine',
        'payment_amount',
        'academic_payment_amt',
        'bus_payment_amt',
        'total_stationary_fee',
        'ad_payment_status',
        'bus_payment_status',
        'payment_due_date',
        'created_date',
        'bus_payment_date',
        'ad_payment_mode',
        'bus_payment_mode',
        'cheque_number',
        'pos_bank_name',
        'pos_reference_number',
        'transaction_no',
        'payee_name',
        't_user_id',
        'added_by',
        'bus_cheque_number',
        'bus_pos_bank_name',
        'bus_pos_reference_number',
        'bus_payee_name',
        'bus_t_user_id',
        'bus_added_by',
        'cons_admission_fee',
        'cons_development_fee',
        'cons_exam_fee',
        'cons_festival_celebration_fee',
        'cons_games_sports_fee',
        'cons_audio_visual_lab_fee',
        'cons_library_fee',
        'cons_electricity_maintenance_fee',
        'cons_computer_fee',
        'cons_session_charges',
        'cons_security_deposite',
        'cons_tuition_fee',
        'cons_bus_services',
        'remarks',
        'adv_bal_used',
        'session_year_id',
        'allow_bus_report',
        'allow_payment_report',
    ];


}