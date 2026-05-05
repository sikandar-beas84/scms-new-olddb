<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {

    public function getStoreData(){
        $this->db->select('*');
        $this->db->from('store');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $result = $query->result();
    }
    public function getItemData(){
        $this->db->select('*');
        $this->db->select('stationary_item.*,stationary_item.id as item_id,  store.name as store_name , store.id as sid');
        $this->db->from('stationary_item');
        // $this->db->join('group', 'group.id = stationary_item.group_id');
        $this->db->join('store', 'store.id = stationary_item.store');
        $this->db->order_by('stationary_item.id','desc');
        $query = $this->db->get();
        return $result = $query->result();
    }
    public function get_item_by_store($id){
        $this->db->select('*');
        $this->db->from('stationary_item');
        $this->db->where('store',$id);
        $this->db->order_by('item_name','asc');
        $query = $this->db->get();
        return $result = $query->result();
    }
    public function get_item_by_item_id($id){
        $this->db->select('*');
        $this->db->from('stationary_item');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $result = $query->result();
    }

    public function get_item_selling_price_by_item_id($id){
        $this->db->select('*');
        $this->db->from('purchase_entry');
        $this->db->where('item',$id);
        $query = $this->db->get();
        return $result = $query->result();
    }

    public function getStationaryData(){
		    
		   
		    
        $timestamp = time(); 
        $currentDate = gmdate('Y-m-d');
        
        $this->db->select('*');
        $this->db->select('stationary.*,stationary.id as edit_id,stationary.created_date as S_Date,class.*, section.*');
        $this->db->from('stationary');
        $this->db->join('students_details', 'stationary.student_code = students_details.student_code');
        $this->db->join('class', 'class.id = students_details.class');
        $this->db->join('section', 'section.id = students_details.class');
        // $this->db->join('stationary_item', 'stationary_item.id = stationary.item','left');
// 			$this->db->join('admin_users', 'admin_users.id = requisition.order_placed_to');
// 			$this->db->where('stationary.created_by', $this->session->userdata('user_id'));
        // $this->db->where('stationary.created_date', $currentDate );
        $this->db->order_by('stationary.id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $result = $query->result();
    }
        public function getslno(){
        $this->db->select('*');
        $this->db->from('sl_no');
        $query = $this->db->get();
        return $result = $query->result()[0]->sl_no;
    }

    public function get_admin_users(){
		// $ignore = array(0,3);
		$this->db->select('*');
		$this->db->from('staff');
		// $this->db->where_not_in('user_type', $ignore);
		$this->db->order_by('first_name', 'ASC');
		$result	= $this->db->get();
		return $result->result();
	}
    public function gepurchaseitems(){
        $this->db->select('*');
        $this->db->select('purchase_entry.*,purchase_entry.id as purchase_id, stationary_item.*');
        $this->db->from('purchase_entry');
        $this->db->join('stationary_item', 'stationary_item.id = purchase_entry.item');
        $this->db->order_by('purchase_entry.id','desc');
        $query = $this->db->get();
        return $result = $query->result();
    }
    public function get_stationary_by_id($id){
        $this->db->select('*');
        $this->db->from('stationary');
        $this->db->where('id',$id);
        $this->db->where('payment_status','Success');
        $query = $this->db->get();
        return $result = $query->row();
    }
    public function get_stationary_purchase_item_by_order_id($id){
        $this->db->select('*');
        $this->db->from('stationary_purchase_item');
        
        $this->db->where('order_id',$id);
        $query = $this->db->get();
        return $result = $query->result();
    }
    public function getNextAutoId() {
        // Query to get the next auto increment ID
        $query = $this->db->query("SHOW TABLE STATUS LIKE 'stationary'");
        $row = $query->row_array();
        return $row['Auto_increment'];
    }
    public function savestationary($data){ 
        $this->db->insert('stationary', $data); 
        return $this->db->insert_id();
    }
    public function updatestationary($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('stationary', $data);
    }
    public function update_item($data,$id){
        $this->db->where('id', $id);
        return $this->db->update('stationary_item', $data);			
    }
    public function savestationarypurchaseitem($data){ 
        $this->db->insert('stationary_purchase_item', $data); 
        return $this->db->insert_id();
    }
}
