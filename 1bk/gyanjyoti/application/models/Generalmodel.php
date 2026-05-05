<?php

class Generalmodel extends CI_Model

{

	function __construct()

	{

		parent::__construct();

	}

	//=============== Select , Select by id , insert , update , delete ====================================================

	public function getData($table_name = '', $id = '', $fieldname = '', $order_field = '', $order = '', $action = '', $data = []) {

    if ($action == 'get') {

        $this->db->select('*');

        $this->db->from($table_name);



        if ($id != '' && $fieldname != '' && empty($data)) {

            $this->db->where($fieldname, $id);

        }



        if ($order_field != '' && $order != '') {

            $this->db->order_by($order_field, $order);

        }



        $query = $this->db->get();



        if ($query === false) {

            // Log the error and return an empty result

            log_message('error', 'Database query failed: ' . $this->db->last_query());

            return [];

        }



        $result = $query->result();

        return $result;

    }



    if ($action == 'insert') {

        foreach ($data as $key => $value) {

            if (is_array($value)) {

                $data[$key] = json_encode($value); // Found a nested array

            }

        }



        $return = $this->db->insert($table_name, $data);

        if ($return === false) {

            // Log the error

            log_message('error', 'Database insert failed: ' . $this->db->last_query());

            return false;

        }



        return $this->db->insert_id();

    }



    if ($action == 'update') {

        if (!empty($fieldname) && !empty($id)) {

            $this->db->where($fieldname, $id);

        }



        $return = $this->db->update($table_name, $data);

        if ($return === false) {

            // Log the error

            log_message('error', 'Database update failed: ' . $this->db->last_query());

        }



        return $return;

    }



    if ($action == 'delete') {

        $this->db->where($fieldname, $id);

        $return = $this->db->delete($table_name);

        

        if ($return === false) {

            // Log the error

            log_message('error', 'Database delete failed: ' . $this->db->last_query());

        }



        return $return;

    }



    return false; // In case of invalid action

}



	

	/*******************

	 * Model For indexed Get Data 

	 * Added By Suhrid Sarkar

	 * On 01-09-2023 11:30AM

	 * IDE: VS Code

	 *******************/

	public function getDataWhere($table_name='', $where = '',$order_field='',$order='',$limit = '')

	{

		$this->db->select('*');

		$this->db->from($table_name);

		$this->db->where($where);

		if(($order_field != '') && ($order != '')){

			$this->db->order_by($order_field, $order);

		}

		if(($limit != '')){

			$this->db->limit($limit);

		}

		

		$query = $this->db->get();

		$result = $query->result();



		// prx($this->db->last_query());

		return $result;

	}

	/*******************

	 * Model For indexed array to an associative array

	 * Added By Suhrid Sarkar

	 * On 14-08-2023 11:30AM

	 * IDE: VS Code

	 *******************/

	public function countRows($table, $value = '', $field = '',  $whereArray=array()) {

		if (!empty($value) && !empty($field)) {

			$this->db->where($field, $value);

		}

		// if (!empty($value2) && !empty($field2)) {

		// 	$this->db->where($field2, $value2);

		// }

		if (!empty($whereArray)) {

			$this->db->where($whereArray);

		}

		return $this->db->count_all_results($table);

	}

	/*******************

	 * Model For  Get Data Limit

	 * Added By Suhrid Sarkar

	 * On 01-09-2023 11:30AM

	 * IDE: VS Code

	 *******************/

	public function getDataByLimit($table,$value='',$field='', $whereArray=array(), $limit='', $offset='',$order_field='',$order='') {

		if(!empty($value) && !empty($field)):

			$this->db->where($field, $value);

		endif;

		// if(!empty($value2) && !empty($field2)):

		// 	$this->db->where($field2, $value2);

		// endif;

		if (!empty($whereArray)) {

			$this->db->where($whereArray);

		}

		if(($order_field != '') && ($order != '')){

			$this->db->order_by($order_field, $order);

		}

        $this->db->limit($limit, $offset);

        return $this->db->get($table)->result(); // Fetch properties from the database

    }

	/*******************

	 * Model For  Get Data  most common row

	 * Added By Suhrid Sarkar

	 * On 03-09-2023 04:55PM

	 * IDE: VS Code

	 *******************/

	public function getMostCommonRow($table,$whereArray=array(),$group_id='') {

		$this->db->select('*');

		$this->db->from($table);

		if (!empty($whereArray)) {

			$this->db->where($whereArray);

		}

		if (!empty($group_id)) {

			$this->db->group_by($group_id);

		}

		$this->db->order_by('COUNT(*)', 'DESC');

		// $this->db->limit(1);

        return $this->db->get()->result(); // Fetch properties from the database

    }

	public function customeQuery($sql){

		$query = $this->db->query($sql);

		return($query->num_rows() > 0) ? $query->result(): NULL;



	}



	public function subscriptionReport(){

		// $this->db->select("DATE_FORMAT(active_date, '%Y-%m') AS month, subscription, COUNT(*) AS active_subscriptions_count");

		// $this->db->from("active_subscription");

		// $this->db->where("active_date >= DATE_SUB(CURRENT_DATE, INTERVAL 10 MONTH)");

		// $this->db->group_by("month, subscription");

		// $this->db->order_by("month DESC, active_subscriptions_count DESC");

		// $query = $this->db->get();

		// $result = $query->result();



		// $this->db->select('YEAR(active_date) AS year, MONTH(active_date) AS month, subscription_type, COUNT(*) AS active_subscriptions');

        // $this->db->from('active_subscription');

        // $this->db->where('active_date >= DATE_SUB(CURDATE(), INTERVAL 10 MONTH)', NULL, FALSE);

        // $this->db->group_by('year, month, subscription_type');

        // $this->db->order_by('year DESC, month DESC, subscription_type');



        // $query = $this->db->get();

        // return $query->result();



		$this->db->select("DATE_FORMAT(active_date, '%Y-%m') AS month, 

                            COUNT(*) AS total_subscriptions,

                            SUM(CASE WHEN subscription_type = 'Monthly' THEN 1 ELSE 0 END) AS monthly_subscriptions,

                            SUM(CASE WHEN subscription_type = 'Quarterly' THEN 1 ELSE 0 END) AS quarterly_subscriptions,

                            SUM(CASE WHEN subscription_type = 'Yearly' THEN 1 ELSE 0 END) AS yearly_subscriptions");

        $this->db->from("active_subscription");

        $this->db->where("active_date >= DATE_SUB(CURRENT_DATE, INTERVAL 10 MONTH)");

        $this->db->group_by("DATE_FORMAT(active_date, '%Y-%m')");

        $this->db->order_by("month", "DESC");



        $query = $this->db->get();

        return $query->result();

	}

	/*******************

	 * Model For  Update Data Multy Where

	 * Added By Suhrid Sarkar

	 * On 01-12-2023 01:55AM

	 * IDE: VS Code

	 *******************/



	public function updateData($table_name, $where='', $data){

		if(!empty($where)){

			$this->db->where($where);



		}

		$return = $this->db->update($table_name, $data);

		return $return;

	}



  // Fetch attendance data from the database

  public function get_attendance($month, $year) {

	// Fetch attendance data based on month and year

	$this->db->select('roll_no, name, attendance_data');

	$this->db->where('month', $month);

	$this->db->where('year', $year);

	$query = $this->db->get('attendance');

	

	$result = $query->result_array();

	

	// Format data

	$attendance = [];

	foreach ($result as $row) {

		$attendance[] = [

			'roll_no' => $row['roll_no'],

			'name' => $row['name'],

			'attendance' => json_decode($row['attendance_data'], true) // Assuming this field contains JSON data

		];

	}



	return $attendance;

}



// Mark attendance in the database

public function mark_attendance($roll_no, $day, $month, $year, $status) {

	// Fetch the current attendance record

	$this->db->select('attendance_data');

	$this->db->where('roll_no', $roll_no);

	$this->db->where('month', $month);

	$this->db->where('year', $year);

	$query = $this->db->get('attendance');



	// Check if attendance record exists

	if ($query->num_rows() > 0) {

		$attendance_data = json_decode($query->row()->attendance_data, true); // Decode existing data

		

		// Update the specific day's status

		$attendance_data[$day] = $status;



		// Update the attendance record with modified data

		$this->db->where('roll_no', $roll_no);

		$this->db->where('month', $month);

		$this->db->where('year', $year);

		$this->db->update('attendance', [

			'attendance_data' => json_encode($attendance_data) // Encode back to JSON

		]);

	} else {

		// Optionally handle the case where no record exists

		// You might want to insert a new record if needed

		$new_attendance_data = [$day => $status];

		$this->db->insert('attendance', [

			'roll_no' => $roll_no,

			'month' => $month,

			'year' => $year,

			'attendance_data' => json_encode($new_attendance_data)

		]);

	}

}



public function get_current_session()

{

    $this->db->select('*');

    $this->db->from('session');

    $this->db->where('CURDATE() BETWEEN start_date AND end_date', null, false); // Disable query escaping for raw SQL

    $query = $this->db->get();

    

    return $query->result_array(); // Fetch all results as an array

}



public function get_student_payment_details($session_year, $month, $payment_status) {

	$this->db->select('*');

	$this->db->from('student_payment_details');

	$this->db->where('session_year', $session_year);

	$this->db->where('month', $month);

	$this->db->where('payment_status', $payment_status);



	$query = $this->db->get();

	return $query->result(); // Returns the result as an array

}

public function update_student_fine($id, $fine_amount)

{

    $this->db->set('fine',$fine_amount, FALSE); // Update the fine

    $this->db->where('id', $id);

    $this->db->update('student_payment_details');

}

public function get_configuration_by_key($key){

	$this->db->select('configuration_value');

	$this->db->from('configuration');			

	$this->db->where('configuration_key',$key);			

	$query = $this->db->get();	

	return $query->row()->configuration_value;

}

public function get_due_dates($session_year, $month) {

    $this->db->select('*');

    $this->db->from('month_wise_due_date');

    $this->db->where('session_year', $session_year);

    $this->db->where('month', $month);

    $this->db->where('is_delete', 'N');

    $query = $this->db->get();



    return $query->row(); // Returns the result as an array

    // return $query->result(); // Returns the result as an object

}

}



