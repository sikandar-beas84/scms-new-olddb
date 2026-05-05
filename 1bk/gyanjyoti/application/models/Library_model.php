<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Library_model extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}
        public function get_student_details($class='',$student_id){
		    $session_year_id = get_session('session');
            $this->db->select('*');		
            $this->db->select('students_details.*,class.*,section.section as section_name,students_details.id as s_id,students_details.student_id as s_code');
            $this->db->from('students_details');
            $this->db->join('class', 'class.id = students_details.class','left');
            $this->db->join('section', 'section.id = students_details.section','left');
            $this->db->where('students_details.session_id',$session_year_id);
            if($class){
                $this->db->where('students_details.class', $class);
            }
            if($student_id){
            $this->db->where('students_details.student_code', $student_id);
            }
            $query = $this->db->get();
			return $result = $query->row();
		}
        public function get_book(){
			$this->db->select('book_name,access_no');
			$this->db->from('lib_stock');
			// $this->db->like('book_name', $qr , 'both');
			$this->db->where('number_book > 0');
			$this->db->order_by("id","desc");
			$query = $this->db->get();
			// echo $this->db->last_query(); die;
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

        public function get_book_search($qr){
			$this->db->select('book_name,access_no');
			$this->db->from('lib_stock');
			$this->db->like('book_name', $qr , 'both');
			$this->db->where('number_book > 0');
			$this->db->order_by("id","desc");
			$query = $this->db->get();
			// echo $this->db->last_query(); die;
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}
        public function get_book_details_by_name($name){			
			$new = explode('-',$name);
			$this->db->select('*');
			$this->db->from('lib_stock');
			$this->db->where('book_name',$new[0]);
			$this->db->where('access_no',$new[1]);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}
		}

        public function save_issue($data){
			$this->db->insert('lib_book_allot', $data);
		}
        public function get_book_for_student($id){
			$this->db->select('lib_book_allot.*,lib_stock.book_name as book_name');
			$this->db->from('lib_book_allot');
			$this->db->where('lib_book_allot.student_id',$id);
			$this->db->join('lib_stock','lib_stock.id = lib_book_allot.lib_stock_id');
			$this->db->order_by('lib_book_allot.id','desc');
			//$this->db->limit(10, 0);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return array();
			}
		}
		
		public function update_issued_items($id,$data){
			$this->db->where('id', $id);
			return $this->db->update('lib_book_allot',$data);
		}

        public function get_issue_details($id){
			$this->db->select('lib_book_allot.*');
			$this->db->from('lib_book_allot');
			$this->db->where('id',$id);			
			$query = $this->db->get();
			return $query->row();			
		}
        public function get_return_details($id){
			$this->db->select('lib_book_allot.*,lib_stock.book_name as book_name');
			$this->db->from('lib_book_allot');
			$this->db->where('lib_book_allot.id',$id);
			$this->db->join('lib_stock','lib_stock.id = lib_book_allot.lib_stock_id');
			$this->db->order_by('lib_book_allot.id','desc');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return array();
			}			
		}

		public function get_book_details($id){
			$this->db->select('*');
			$this->db->from('lib_stock');
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $result = $query->row();
		}

		public function get_teacher_details($id){
			$this->db->select('staff.*');
			$this->db->from('staff');
			$this->db->where('id',$id);
			$this->db->where('staff.role_type','staff');
			$query = $this->db->get();
			return $result = $query->row();
		}

		public function get_book_for_teacher($id){
			$this->db->select('lib_book_allot_teacher.*,lib_stock.book_name as book_name');
			$this->db->from('lib_book_allot_teacher');
			$this->db->where('lib_book_allot_teacher.teacher_id',$id);
			$this->db->join('lib_stock','lib_stock.id = lib_book_allot_teacher.lib_stock_id');
			$this->db->order_by('lib_book_allot_teacher.id','desc');
			//$this->db->limit(10, 0);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return array();
			}
		}

		public function save_issue_teacher($data){
			$this->db->insert('lib_book_allot_teacher', $data);
		}

		public function get_return_details_teacher($id){
			$this->db->select('lib_book_allot_teacher.*,lib_stock.book_name as book_name');
			$this->db->from('lib_book_allot_teacher');
			$this->db->where('lib_book_allot_teacher.id',$id);
			$this->db->join('lib_stock','lib_stock.id = lib_book_allot_teacher.lib_stock_id');
			$this->db->order_by('lib_book_allot_teacher.id','desc');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return array();
			}			
		}

		public function update_issued_items_teacher($id,$data){
			$this->db->where('id', $id);
			return $this->db->update('lib_book_allot_teacher',$data);
		}
		public function get_staff_details($id){
		    $session_year_id = get_session('session');
            $this->db->select('*');		
            $this->db->from('staff');
            // $this->db->where('staf.session_id',$session_year_id);
            
            $this->db->where('id', $student_id);
            $query = $this->db->get();
			return $result = $query->row();
		}
    }