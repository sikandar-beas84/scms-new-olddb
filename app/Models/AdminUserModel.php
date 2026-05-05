<?php
namespace App\Models;
use CodeIgniter\Model;

class AdminUserModel extends Model
{

    protected $table      = 'admin_users';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'first_name', 
        'last_name', 
        'email', 
        'password', 
        'mobile', 
        'code',
        'dept_id',
        'session_id',
        'designation_id',
        'image',
        'address',
        'present_address',
        'pancard_number',
        'aadhar_number',
        'phone_no_other',
        'bank_name',
        'bank_acc_number',
        'bank_ifsc_number',
        'esic_number',
        'pf_number',
        'spouse_name',
        'joining_date',
        'subject_tought',
        'class_taken',
        'city',
        'state',
        'pincode',
        'country',
        'qualification',
        'extra_qualification',
        'experience',
        'date_of_birth',
        'gender',
        'oasis_id',
        'session_id',
        'useremaill',
        'status',
        'created_date',
        'is_student_password_set',

    ]; // update with your table columns

    public function get_all_users()
    {
        $builder = $this->db->table('admin_users');
        $builder->join('dept', 'dept.id = admin_users.dept_id', 'left');
        
        // Select the columns you want
        $builder->select('admin_users.*, dept.name as dept_name');

        $builder->whereNotIn('admin_users.dept_id', [0, 3]);

        $builder->orderBy('admin_users.created_date', 'DESC');
        
        // $builder->limit($limit, $offset);
        // Execute the query and get the results
        $query = $builder->get();

        $lastQuery = $this->db->getLastQuery();
        // printr($lastQuery); die();
        
        return $query->getResultArray();
    }

    public function chkStudent($code)
    {
        $builder = $this->db->table('admin_users');
        $builder->select('admin_users.*, dept.name as dept_name');
        $builder->join('dept', 'dept.id = admin_users.dept_id', 'left');
        $builder->where('admin_users.code', $code);

        return $builder->countAllResults();  // just count
    }

}

