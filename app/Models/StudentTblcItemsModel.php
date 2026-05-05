<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentTblcItemsModel extends Model
{
    protected $table      = 'student_tblc_items';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [ 
        'student_id',
        'class_id',
        'class_code',
        'item_ids',
        'item_qtys',
        'item_price',
        'price',
        'session_year_id',
        'add_date',
        'payment_status',
        'payment_date',
        'payment_mode',
        'cheque_number',
        'pos_bank_name',
        'pos_reference_number',
        't_user_id',
        'added_by',
        'remarks',
    ];

    /*function getAcademicTblcReportsOld($startDate, $endDate, $class_id, $user_id, $payment_mode, $payment_month, $student_code)
    {
        $builder = $this->db->table('student_tblc_items');

        $builder->select('
            student_tblc_items.*, 
            student_details.first_name, 
            student_details.d_o_b,
            admin_users.first_name as added_by_first_name, 
            admin_users.last_name as added_by_last_name,
            class.class_name,
            section.section_name,
            student_fee_structure.ad_payment_mode,
            student_fee_structure.remarks as sfs_remarks,
        ');

        $builder->join('student_details', 'student_details.code = student_tblc_items.class_code', 'left');
        
        $builder->join('section', 'section.id = NULLIF(student_details.section_id, \'\')::integer', 'left');
        $builder->join('class', 'class.id = student_tblc_items.class_id', 'left');
        $builder->join('student_fee_structure', 'student_fee_structure.student_code = student_tblc_items.class_code AND student_fee_structure.month_id = 4', 'left');
        $builder->join('admin_users', 'admin_users.id = student_fee_structure.t_user_id', 'left');

        if( !empty($startDate) && !empty($endDate) ) {
            $builder->where("DATE(student_tblc_items.add_date) >= '{$startDate}'", null, false);
            $builder->where("DATE(student_tblc_items.add_date) <= '{$endDate}'", null, false);
        }

        if( !empty($class_id)  ) {
            $builder->where("student_tblc_items.class_id", $class_id);
        }

        if( !empty($user_id)  ) {
            $builder->where("student_fee_structure.t_user_id", $user_id);
        }

        if( !empty($payment_mode)  ) {
            $builder->where("student_fee_structure.ad_payment_mode", $payment_mode);
        }

        if( !empty($student_code)  ) {
            $builder->where("student_tblc_items.class_code", $student_code);
        }

        // Exclude payment modes ending with a dot
        $builder->where("RIGHT(student_fee_structure.ad_payment_mode, 1) <> '.'", null, false);

        // $builder->where('student_details.status', 1);
        $builder->orderBy('student_tblc_items.add_date', 'ASC');

        $query = $builder->get();

        pr($this->db->getLastQuery());
        return $query->getResultArray();
    }*/

    function getAcademicTblcReports($startDate, $endDate, $class_id, $user_id, $payment_mode, $payment_month, $student_code)
    {
        $builder = $this->db->table('student_tblc_items');
        $builder->select('
            student_tblc_items.*, 
            student_details.first_name, 
            student_details.d_o_b,
            admin_users.first_name as added_by_first_name, 
            admin_users.last_name as added_by_last_name,
            class.class_name,
            section.section_name,
            student_fee_structure.ad_payment_mode,
            student_fee_structure.remarks as sfs_remarks,
            string_agg(tblc_master.item_name, \', \') AS tblc_item_names

        ');

        $builder->join('student_details', 'student_details.code = student_tblc_items.class_code', 'left');
        $builder->join('section', 'section.id = NULLIF(student_details.section_id, \'\')::integer', 'left');
        $builder->join('class', 'class.id = student_tblc_items.class_id', 'left');
        $builder->join('student_fee_structure', 
            "student_fee_structure.student_code = student_tblc_items.class_code 
             AND student_fee_structure.month_id = 4", 
            'left');
        $builder->join('admin_users', 'admin_users.id = student_fee_structure.t_user_id', 'left');

        $builder->join('tblc_master', "tblc_master.id = ANY (string_to_array(student_tblc_items.item_ids, ',')::int[])", 'left', false);



        if( !empty($startDate) && !empty($endDate) ) {
            $builder->where("DATE(student_tblc_items.add_date) >= '{$startDate}'", null, false);
            $builder->where("DATE(student_tblc_items.add_date) <= '{$endDate}'", null, false);
        }

        if( !empty($class_id)  ) {
            $builder->where("student_tblc_items.class_id", $class_id);
        }

        if( !empty($user_id)  ) {
            $builder->where("student_fee_structure.t_user_id", $user_id);
        }

        if( !empty($payment_mode)  ) {
            $builder->where("student_fee_structure.ad_payment_mode", $payment_mode);
        }

        if( !empty($student_code)  ) {
            $builder->where("student_tblc_items.class_code", $student_code);
        }

        // Fixed: Allow NULL values for LEFT JOIN
        $builder->groupStart();
        $builder->where("RIGHT(student_fee_structure.ad_payment_mode, 1) <> '.'", null, false);
        $builder->orWhere("student_fee_structure.ad_payment_mode IS NULL");
        $builder->groupEnd();

        $builder->orderBy('student_tblc_items.add_date', 'ASC');

        $builder->groupBy([
            'student_tblc_items.id',
            'student_details.first_name',
            'student_details.d_o_b',
            'admin_users.first_name',
            'admin_users.last_name',
            'class.class_name',
            'section.section_name',
            'student_fee_structure.ad_payment_mode',
            'student_fee_structure.remarks'
        ]);

        $query = $builder->get();

        // pr($this->db->getLastQuery());
        return $query->getResultArray();
    }
}