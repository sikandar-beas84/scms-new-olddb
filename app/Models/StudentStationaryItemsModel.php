<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentStationaryItemsModel extends Model
{
    protected $table      = 'student_stationary_items';
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

    public function dailyStationarySalesReport($class='',$from_date='',$to_date='',$payment_mode='',$t_user_id='',$lang='',$pos_bank_name='')
    {
        $session = session();

        $session_year_id = $session->get('session_year_id');

        $builder = $this->db->table('student_stationary_items');

        // $builder->select('student_stationary_items.*, student_personal_details.lkg_onw_sec_lang, student_details.section_id, student_details.roll_num, student_personal_details.second_language, student_details.first_name, class.class_name, section.section_name, admin_users.first_name, admin_users.last_name, CONCAT(admin_users.first_name,' ',admin_users.last_name) as admin_full_name');

        $builder->select("student_stationary_items.*, 
            student_personal_details.lkg_onw_sec_lang, 
            student_details.section_id, 
            student_details.roll_num, 
            student_personal_details.second_language, 
            student_details.first_name, 
            class.class_name, 
            section.section_name, 
            admin_users.first_name, 
            admin_users.last_name, 
            CONCAT(admin_users.first_name, ' ', admin_users.last_name) AS admin_full_name, 
            (
                SELECT STRING_AGG(i.item_name, ', ')
                FROM item_master i
                WHERE i.id::text = ANY(string_to_array(REPLACE(student_stationary_items.item_ids, ' ', ''), ','))
            ) AS item_names
        ", false);

        $builder->join('student_details','student_details.code = student_stationary_items.class_code AND student_details.session_year_id = student_stationary_items.session_year_id','left');
        $builder->join('student_personal_details','student_personal_details.student_id = student_details.student_id','left');

        $builder->join('class', 'class.id = student_stationary_items.class_id', 'left');
        $builder->join('admin_users', 'admin_users.id = student_stationary_items.t_user_id', 'left');
        $builder->join('section', 'section.id = NULLIF(student_details.section_id, \'\')::integer', 'left');
        
        if($class != ''){
            $builder->where('student_stationary_items.class_id', $class);
            $builder->where('student_details.class_id', $class);
        }

        if($from_date != ''){
            $builder->where('student_stationary_items.payment_date >=', date('Y-m-d', strtotime($from_date)));
        }

        if($to_date != ''){
            $builder->where('student_stationary_items.payment_date <=', date('Y-m-d', strtotime($to_date)));
        }

        if($payment_mode != ''){
            $builder->where('student_stationary_items.payment_mode', $payment_mode);
        }

        if($t_user_id != ''){
            $builder->where('student_stationary_items.t_user_id', $t_user_id);
        }

        if($lang != ''){
            $builder->where('student_personal_details.lkg_onw_sec_lang', $lang);
        }

        if($pos_bank_name != ''){
            $builder->where('student_stationary_items.pos_bank_name', $pos_bank_name);
        }

        $builder->where('student_stationary_items.payment_status', 1);
        $builder->where('student_stationary_items.session_year_id', $session_year_id);
        $builder->where('student_details.session_year_id', $session_year_id);

        $query = $builder->get();
        // ✅ Print last query
        // echo $this->db->getLastQuery();
        // die();
        return $query->getResultArray(); // CI4 standard
    }
}