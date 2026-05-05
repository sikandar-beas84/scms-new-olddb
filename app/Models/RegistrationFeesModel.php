<?php
namespace App\Models;
use CodeIgniter\Model;

class RegistrationFeesModel extends Model
{
	protected $table      = 'registration_fees';
    protected $primaryKey = 'reg_fee_id'; // or whatever your PK is

    protected $allowedFields = [
        'form_no', 
        'payment_date', 
        'payment_type', 
        'payment_amount', 
        'pos_bank_name', 
        'pos_reference_number', 
        'payee_name', 
        'cheque_number', 
        'added_by', 
        't_user_id', 
        'payment_status', 
    ];

	public function add_reg_payment($data)
    {
        $builder = $this->db->table('registration_fees');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function getPaymentsWithStudentFromDate($startDate)
    {
        $builder = $this->db->table('registration_fees');
        $builder->select(' registration_fees.*, student_details.first_name, student_details.d_o_b, admin_users.first_name as added_by_first_name, admin_users.last_name as added_by_last_name'); // add needed columns

        $builder->join('student_details', 'student_details.form_no = registration_fees.form_no', 'left');
        $builder->join('admin_users', 'admin_users.id = registration_fees.t_user_id', 'left');

        // $builder->where('registration_fees.payment_date::date >=', $startDate);
        // $builder->where('DATE(registration_fees.payment_date) >=', $startDate, false);
        $builder->where("DATE(registration_fees.payment_date) = '{$startDate}'", null, false);
        $builder->where('student_details.status', 1);
        
        $builder->orderBy('registration_fees.payment_date', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getAcademicPaymentsByDate(
        $startDate,
        $endDate,
        $class_id,
        $user_id,
        $payment_mode,
        $payment_month,
        $student_code,
        $bus_user_id='',
        $date_filter_used=1
    ) {
        $builder = $this->db->table('student_fee_structure');

        /*$builder->select('
            student_fee_structure.*, 
            MONTHNAME(STR_TO_DATE(student_fee_structure.month_id, '%m')) AS month_name,
            student_details.first_name, 
            student_details.d_o_b, 
            admin_users.first_name AS added_by_first_name, 
            admin_users.last_name  AS added_by_last_name,
            class.class_name,

            tblc.item_ids    AS tblc_item_ids,
            tblc.item_qtys   AS tblc_item_qtys,
            tblc.item_price  AS tblc_item_price,
            tblc.price       AS tblc_price,

            st.item_ids      AS stationary_item_ids,
            st.item_qtys     AS stationary_item_qtys,
            st.item_price    AS stationary_item_price,
            st.price         AS stationary_price
        ');*/

        $builder->select(<<<SQL
            student_fee_structure.*, 

            CASE student_fee_structure.month_id
                WHEN 1 THEN 'January'
                WHEN 2 THEN 'February'
                WHEN 3 THEN 'March'
                WHEN 4 THEN 'April'
                WHEN 5 THEN 'May'
                WHEN 6 THEN 'June'
                WHEN 7 THEN 'July'
                WHEN 8 THEN 'August'
                WHEN 9 THEN 'September'
                WHEN 10 THEN 'October'
                WHEN 11 THEN 'November'
                WHEN 12 THEN 'December'
            END AS month_name,

            student_details.first_name, 
            student_details.d_o_b, 
            admin_users.first_name AS added_by_first_name, 
            admin_users.last_name  AS added_by_last_name,
            class.class_name,

            tblc.item_ids    AS tblc_item_ids,
            tblc.item_qtys   AS tblc_item_qtys,
            tblc.item_price  AS tblc_item_price,
            tblc.price       AS tblc_price,

            st.item_ids      AS stationary_item_ids,
            st.item_qtys     AS stationary_item_qtys,
            st.item_price    AS stationary_item_price,
            st.price         AS stationary_price
            SQL
        );
        /* ===== MAIN JOINS ===== */
        $builder->join(
            'student_details',
            'student_details.code = student_fee_structure.student_code',
            'left'
        );

        $builder->join(
            'class',
            "class.id = NULLIF(student_details.class_id, '')::integer",
            'left',
            false
        );

        $builder->join(
            'admin_users',
            'admin_users.id = student_fee_structure.t_user_id',
            'left'
        );

        /* ===== AGGREGATED TBLC ITEMS ===== */
        $builder->join(
            "(SELECT
                student_id,
                STRING_AGG(item_ids, ',')   AS item_ids,
                STRING_AGG(item_qtys, ',')  AS item_qtys,
                STRING_AGG(item_price, ',') AS item_price,
                SUM(price)                  AS price
              FROM student_tblc_items
              GROUP BY student_id
            ) tblc",
            'tblc.student_id = student_details.student_id',
            'left',
            false
        );

        /* ===== AGGREGATED STATIONARY ITEMS ===== */
        $builder->join(
            "(SELECT
                student_id,
                STRING_AGG(item_ids, ',')   AS item_ids,
                STRING_AGG(item_qtys, ',')  AS item_qtys,
                STRING_AGG(item_price, ',') AS item_price,
                SUM(price)                  AS price
              FROM student_stationary_items
              GROUP BY student_id
            ) st",
            'st.student_id = student_details.student_id',
            'left',
            false
        );

        /* ===== FILTERS ===== */
        // if (!empty($startDate) && !empty($endDate)) {
        //     $builder->where("DATE(student_fee_structure.created_date) >=", $startDate);
        //     $builder->where("DATE(student_fee_structure.created_date) <=", $endDate);
        // }

        if (!empty($startDate) && !empty($endDate)) {
            if( $date_filter_used == 0 ) {
                $builder->where('student_fee_structure.bus_payment_date >=', $startDate . ' 00:00:00');
                $builder->where('student_fee_structure.bus_payment_date <', date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 00:00:00');
            } else {
                $builder->where('student_fee_structure.created_date >=', $startDate . ' 00:00:00');
                $builder->where('student_fee_structure.created_date <', date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 00:00:00');
            }
        }

        if (!empty($class_id)) {
            $builder->where('student_details.class_id', $class_id);
        }

        if (!empty($user_id)) {
            $builder->where('student_fee_structure.t_user_id', $user_id);
        }

        if (!empty($bus_user_id)) {
            $builder->where('student_fee_structure.bus_t_user_id', $bus_user_id);
        }
        

        if (!empty($payment_mode)) {
            if ($date_filter_used == 0) {
                $builder->like('student_fee_structure.bus_payment_mode', $payment_mode);
            } else {
                $builder->like('student_fee_structure.ad_payment_mode', $payment_mode);
            }
        }

        if (!empty($payment_month)) {
            $builder->where('student_fee_structure.month_id', $payment_month);
        }

        if (!empty($student_code)) {
            $builder->where('student_fee_structure.student_code', $student_code);
        }

        $builder->where('student_details.session_year_id', session()->get('session_year_id'));
        $builder->where('student_fee_structure.session_year_id', session()->get('session_year_id'));
        

        // exclude invalid modes like "cash."
        // $builder->where("RIGHT(student_fee_structure.ad_payment_mode, 1) <>", '.', false);
        // $builder->where(
        //     "RIGHT(student_fee_structure.ad_payment_mode, 1) <> '.'",
        //     null,
        //     false
        // );

        // if( $date_filter_used == 0 ) {
        //     $builder->where("student_fee_structure.bus_payment_mode NOT LIKE '%.'", null, false);
        // }else {
        //     $builder->where("student_fee_structure.ad_payment_mode NOT LIKE '%.'", null, false);
        // }



        $builder->orderBy('student_fee_structure.created_date', 'ASC');

        $query = $builder->get();

        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);
        
        return $query->getResultArray();
    }

}