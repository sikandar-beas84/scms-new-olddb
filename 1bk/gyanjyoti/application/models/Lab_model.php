<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Lab_model extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}

        function get_last_requisition_no(){
            $this->db->select('id');       
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $result	= $this->db->get('lab_requisition');
            $result = $result->row()->id;	
            return $result;
        }

        public function get_requisition_by_num($id){
			$this->db->select('*');
			$this->db->from('lab_requisition');
			$this->db->join('labitem_master','labitem_master.id=lab_requisition.item','left');
			$this->db->where('lab_requisition.id',$id);
			$query = $this->db->get();
			return $result = $query->row();
		}
        public function getStock($item_id){			
			$this->db->select('qty');
			$this->db->from('lab_stock');
			$this->db->where('item',$item_id);
			$query = $this->db->get();
			return $result = $query->row()->qty;
			
		}
        public function updatelabReq($data,$bill_no){			
			$this->db->where('id', $bill_no);
			return $this->db->update('lab_requisition', $data);
		}
        		
		public function updatelabStock($data,$id){
            $this->db->where('item', $id);
            $query = $this->db->get('lab_stock');
        
            if ($query->num_rows() > 0) {
                // Record exists, so update it
                $this->db->where('item', $id);
                return $this->db->update('lab_stock', $data);
            } else {
                // Record does not exist, so insert it
                $data['item'] = $id; // Make sure the 'item' field is included in the data for the insert
                return $this->db->insert('lab_stock', $data);
            }
		}

        function get_all_list($table,$order_by='',$where=''){
            $session_year_id = $this->session->userdata('session_year_id');
            $this->db->select('*');	
            if($order_by!='')
            $this->db->order_by($order_by);
            if($where!='')
            $this->db->where($where);
            if($table =='particular_master')
            $this->db->where('particular_master.session_year_id', $session_year_id);
            if($table =='particular_requisition_master')
            $this->db->where('particular_requisition_master.session_year_id', $session_year_id);
            
            if($table =='particular_stock')
            $this->db->where('particular_stock.session_year_id', $session_year_id);
            
            //if($table =='parent_events_registration')
            //$this->db->where('parent_events_registration.session_year_id', $session_year_id);
            
            $result	= $this->db->get($table);
            $result	= $result->result(); 		
            return $result;
        }
        public function get_item_by_id($id){
			$this->db->select('*');
			$this->db->from('labitem_master');
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $result = $query->row();
		}
        public function get_stock_by_name($name){
			$this->db->select('*');
			$this->db->from('lab_stock');
			$this->db->where('name',$name);
			$query = $this->db->get();
			return $result = $query->row();
		}
        public function get_requisition_by_id($id){
			$this->db->select('*');
			$this->db->from('lab_requisition');
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $result = $query->row();
		}
        		
		public function updatelabStockUsage($data,$id){
			if($id!=''){
				$this->db->where('id', $id);
				return $this->db->update('lab_stock_usage', $data);
			}else{
				$this->db->insert('lab_stock_usage', $data);
				return $this->db->insert_id();
			}
						
		}
        		
		public function updatelabRequisition($data,$id){
			if($id!=''){
				$this->db->where('id', $id);
				return $this->db->update('lab_requisition', $data);
			}else{
				$this->db->insert('lab_requisition', $data);
				return $this->db->insert_id();
			}

		}
        public function get_usage_by_id($id){
			$this->db->select('*');
			$this->db->from('lab_stock_usage');
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $result = $query->row();
		}
    }