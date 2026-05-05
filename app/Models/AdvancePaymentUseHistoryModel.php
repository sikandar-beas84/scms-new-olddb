<?php
namespace App\Models;
use CodeIgniter\Model;

class AdvancePaymentUseHistoryModel extends Model
{
    protected $table      = 'advance_payment_use_history';
    protected $primaryKey = 'aph_id'; // or whatever your PK is

    protected $allowedFields = [ 
        'applied_date',
        's_code',
        'amount',
        'payment_mode',
        'cheque_number',
        'pos_bank_name',
        'pos_reference_number',
        'payee_name',
        't_user_id',
        'added_by'
    ];

    /**
     * Get payment history by student code
     * @param string $s_code
     * @return array
     */
    public function getByStudentCode(string $s_code)
    {
        return $this->where('s_code', $s_code)
            ->orderBy('applied_date', 'DESC')
            ->findAll();
    }

}