<?php
/* 
	Name: Login Model
	Author: Suhrid Sarkar || suhrid.developer@gmail.com
	Created ON: Febuary 13, 2023
*/
class LoginModel extends CI_Model {

    public function register_data($table_name, $data){
        return $this->db->insert($table_name, $data);
    }

    public function login_check_admin($data){
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['user_password']);
        $table_name = 'user_masters';
        $query = $this->db->get($table_name);
        return $query->row();
    }
    public function login_check_staff($data){
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['user_password']);
        
        $table_name = 'staff';
       
        $query = $this->db->get($table_name);
        return $query->row();
    }
    public function login_check_students($data){
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['user_password']);
        $table_name = 'students';
        $query = $this->db->get($table_name);
        return $query->row();
    }

    public function get_user_data($table_name, $email){
        $this->db->where('username', $email);
        $query = $this->db->get($table_name);
        return $query->row();
    }

    public function update_user_details($table_name, $data, $id){
        $this->db->where('email', $id);
        return $this->db->update($table_name, $data);
    }

    public function get_reset_user($table_name, $key){
        $this->db->where('key', $key);
        $query = $this->db->get($table_name);
        return $query->row();
    }
}
?>
