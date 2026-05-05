<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentTransactionModel extends Model
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

    public function updateStudentTransDetail($code, $data)
    {
        if( !isset($code) || empty($code) ) {
            return false;
        }
        
        $session_year_id = session()->get('session_year_id');

        return $this->db->table('student_transaction')
            ->where('student_code', $code)
            ->where('session_year_id', $session_year_id)
            ->update($data);
    }

    public function get_student_trans_details($scode){
        if( !isset($code) || empty($code) ) {
            return [];
        }

        $session_year_id = session()->get('session_year_id');

        $builder = $this->db->table('student_transaction');

        $builder->select('*');
        $builder->where('student_code', $scode);
        $builder->where('session_year_id', $sessionYearId);

        $query = $builder->get();
        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);
        return $query->getRowArray(); // return as array
    }

}