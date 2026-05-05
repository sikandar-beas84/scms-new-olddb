<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_book_allot extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('LoginModel');
        $this->load->model('Common_model');
        $this->load->model('Student_model');
        $this->load->model('Library_model');

		date_default_timezone_set('Asia/Kolkata');
        if(empty($this->session->userdata('user_id'))){
            redirect(base_url('dashboard'));
        }

	}

	public function index(){
        
	
        $head['title'] = $data['page_title'] = 'Student Book Assign';
        $data['class'] = $this->Common_model->relational_dropdown(
            'class',
            'id',
            'class_name',
            ['status' => 'Y', 'is_delete !=' => 'Y'],
            ' - '
        );
        $data['book'] = $this->Library_model->get_book();
        $data['library_books_fine_per_day'] = $this->Generalmodel->get_configuration_by_key('library_books_fine_per_day');
        $data['library_book_allotment_duration'] = $this->Generalmodel->get_configuration_by_key('library_book_allotment_duration');
        // prx($book);
        $this->load->view('include/admin_head', $data);
		$this->load->view('include/side-bar');
        $this->load->view('include/admin_header');
        $this->load->view('include/breadcrumb');
		$this->load->view('library/student_book_allot/index');
        $this->load->view('include/admin_footer');
        $this->load->view('include/admin_end');
	}

    public function getStudent(){
		$this->form_validation->set_rules('class', 'Class', 'trim');
		$this->form_validation->set_rules('student_id', 'Student ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
				$data['msg'] = validation_errors();
				$data['status'] = 'Failure';
				echo json_encode($data); 
				die;				
		} else {
			$student_ds = $this->Library_model->get_student_details($this->input->post('class'),$this->input->post('student_id'));	
			// prx($student_ds);
            if(!empty($student_ds)){
				
				$html = '<div class="profile-user-info profile-user-info-striped">';
				$html .= '<div class="profile-info-row">
												<div class="profile-info-name"> Student Name </div>

												<div class="profile-info-value">
													<span class="editable editable-click" id="username">'.$student_ds->student_name .'</span>
												</div>
											</div>';
				$html .= '<div class="profile-info-row">
												<div class="profile-info-name"> Student ID </div>

												<div class="profile-info-value">
													<span class="editable editable-click" id="username">'.$student_ds->student_code .'</span>
												</div>
											</div>';
			    $html .= '<div class="profile-info-row">
												<div class="profile-info-name"> Class </div>

												<div class="profile-info-value">
													<span class="editable editable-click" id="username">'.$student_ds->class_name .'</span>
												</div>
											</div>';
				$html .= '<div class="profile-info-row">
												<div class="profile-info-name"> Section </div>

												<div class="profile-info-value">
													<span class="editable editable-click" id="username">'. $student_ds->section .'</span>
												</div>
											</div>';
				$html .= '<div class="profile-info-row">
												<div class="profile-info-name"> Student Roll No </div>

												<div class="profile-info-value">
													<span class="editable editable-click" id="username">'.$student_ds->roll .'</span>
												</div>
											</div>';
				$html .= "</div>";
				$data['data'] = $html;
				$data['student_id'] = $student_ds->student_code;
				$data['status'] = 'Success';
				echo json_encode($data); 
				die;	
			} else {
				$data['data'] = "<p class='text-danger'>No student found!</p>";
				$data['status'] = 'Failure';
				echo json_encode($data); 
				die;
			}			
		}	
	}

	
	public function getLibrary(){
		$details = $this->Library_model->get_book_search($_REQUEST['query']);
		if(!empty($details)){
			$array_js = array();
			foreach($details as $dt)
			$array_js[] = $dt->book_name . '-'. $dt->access_no;
		}else{			
			$array_js = array();
		}
		
		echo json_encode($array_js);
		die;
	}

    	
	public function issueBook()	{
		$this->form_validation->set_rules('book[]', 'Book', 'trim|required');
		$this->form_validation->set_rules('issue_date[]', 'Issue Date', 'trim|required');
		$this->form_validation->set_rules('valid_date[]', 'Valid Date', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			$data['msg'] = validation_errors();
			$data['status'] = 'Failure';
			echo json_encode($data); 
			die;				
		} else {
			for($i=0;$i<count($_POST['book']);$i++){
				$book_details = $this->Library_model->get_book_details_by_name($_POST['book'][$i]);
				
				$issue_data['student_id'] = $this->input->post('student_id_hidden');
				$issue_data['lib_stock_id'] = $book_details->id;
				$issue_data['issue_date'] = date('Y-m-d',strtotime(str_replace('/','-',$_POST['issue_date'][$i])));
				$issue_data['valid_date'] = date('Y-m-d',strtotime(str_replace('/','-',$_POST['valid_date'][$i])));
				$result = $this->Library_model->save_issue($issue_data);
				
				$this->db->set('number_book', ($book_details->numberBook-1)); 
				$this->db->where('id', $book_details->id); 
				$this->db->update('lib_stock');  					
			}
			
			
			$data['msg'] = "Book has been issued.";
			$data['status'] = 'Success';
			echo json_encode($data); 
			die;
		}
	}
	public function getIssueBook(){
		
		$issue_ds = $this->Library_model->get_book_for_student($this->input->post('student_id'));	
		$library_books_fine_per_day = $this->Generalmodel->get_configuration_by_key('library_books_fine_per_day');
				// prx($_SESSION);
		if(!empty($issue_ds)){
				$html = '';
				
				
				$html .= '<table class="table table-bordered table-hover" id="simple-table">
							<thead class="bg-primary text-white">
								<tr>';
				if($this->session->userdata('user_type') == 'admin'){
					$html .= '<th></th>';
				}					

				$html .= '		
							<th>Book Name</th>
							<th>Issue Date</th>
							<th>Return Date</th>
							<th>Expiry Date</th>
							<th>Fine</th>
							<th>Status</th>
							<th>Invoice Bill No</th>
							<th>Invoice Amount</th>
							<th>Action</th>
						</tr>
							</thead>
							<tbody>';

				foreach($issue_ds as $data1){

					$date_now = date("Y-m-d"); // this format is string comparable
					
					if ($date_now > $data1->valid_date) {
						$datetime1 =date_create($data1->valid_date);
						$datetime2 =date_create($date_now);
						$interval = date_diff($datetime1, $datetime2);
						$no_of_days = $interval->format("%R%a");
						$fine = number_format($no_of_days * $library_books_fine_per_day,2);
					}else{
						$fine = 0;
					}
					
					$html .= '<tr>';
					if($data1->status=='issued' && $fine>0 && $this->session->userdata('user_type') == 'admin')
					$html .= '<td><input name="check[]" class="selected" type="checkbox" id="'.$data1->id.'" value="'.$data1->id.'"/></td>';
					elseif($this->session->userdata('user_type') == 'admin')
					$html .= '<td><input name="check[]" class="selected" type="checkbox" value="'.$data1->id.'" disabled /></td>';
					$html .= '<td>'.$data1->book_name.'</td>';
					$html .= '<td>'.date('m-d-Y',strtotime($data1->issue_date)).'</td>';
					$html .= '<td>'. ($data1->return_date ? date('m-d-Y',strtotime($data1->return_date)) : '') .'</td>';
					$html .= '<td>'.date('m-d-Y',strtotime($data1->valid_date)).'</td>';
					
					if($data1->status=='issued')
					$html .= '<td>'.$fine.'</td>';
					else
					$html .= '<td><span class="btn btn-sm btn-primary h3">Returned</span></td>';
					
					//$html .= '<td>'.$fine.'</td>';
					$html .= '<td>'.$data1->status .'</td>';
					$html .= '<td>'.$data1->bill_no .'</td>';
					$html .= '<td>'.$data1->fine .'</td>';
					if($this->session->userdata('student_logged_in') != true){
					if($data1->status=='issued'){
						$html .= '<td style="width:150px">';
						if($fine>0 && $data1->invoice_status==1){
							$html .= '<span class="btn btn-sm btn-warning h3"  href="javascript:void(0);" onclick="return_item(\''.$data1->lib_stock_id.'\',\''.$data1->student_id.'\',\''.$data1->id.'\');">Return </span>';
						}else if($fine==0){
							$html .= '<span class="btn btn-sm btn-warning  h3"  href="javascript:void(0);" onclick="return_item(\''.$data1->lib_stock_id.'\',\''.$data1->student_id.'\',\''.$data1->id.'\');">Return </span>';
						}
						
						
						$html .= '<span class="btn btn-sm btn-danger  h3"  href="javascript:void(0);" onclick="lost_item(\''.$data1->lib_stock_id.'\',\''. round($fine || 0) .'\',\''.$data1->id.'\');"> Lost </span>';
						
						$html .= '</td>';
					}else{
						$html .= '<td>Returned</td>';
					}
					}else{
						if($data1->status=='issued')
						$html .= '<td><span class="btn btn-sm btn-warning">Alloted</span></td>';
						else
						$html .= '<td><span class="btn btn-sm btn-primary">Returned</span></td>';
					}
					$html .= "</tr>";
					
				}
				
				$html .='</tbody></table>';
				
				
				
				if($this->session->userdata('user_type') == 'admin'){
                    $html .= '<button type="button" class="btn btn-primary mb-15" data-toggle="modal" data-target="#InvModal" id="issue_id" onclick="holdModal(\'InvModal\');"> Collect Fine </button>';
				}
				
				// $html .="<script>
				// $('.table').DataTable({
				// 	dom: 'Blfrtip',
				// 	buttons: [
				// 		'csv', 'excel', 'pdf'
				// 	],
				// 	pageLength: 10,
				// 	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
				// });
				// </script>";
				
				$html .='<script>
					var selectedArr = [];
					$(".selected").on("click", function(e){
						var selectedId = parseInt(this.id);
						var isSelectedElemChecked = $("#"+selectedId).is(":checked");
						
						if(isSelectedElemChecked){								
							selectedArr.push(parseInt(this.id));
						}else{
							uncheckIndex = selectedArr.indexOf(selectedId);
							selectedArr.splice(uncheckIndex,1);
						}
						
						if(selectedArr.length > 0){
							$.ajax({
								url:"'. base_url().'library/student_book_allot/fine_amt_for_sel_mnth",									
								method: "post",					
								data: {ids : selectedArr},
								success: function(data){
									var data =  $.parseJSON( data );
									if(data){
										$(".fine").val(data.fine);
										
									} else {								
										alert("No Amount Found");
									}
									var selectedArr = [];
								}
							});					
						} else {								
							$(".fine").val("");								
						}
					
					});

					
					$("#issue_id").click(function() {							
						if(selectedArr.length > 0){
						} else {								
							$(".fine").val("");					
							alert("Please at least check one of the checkbox");
							return false;
						}
					});
				</script>';
				
				$data['data'] = $html;
				$data['status'] = 'Success';
				echo json_encode($data); 
				die;	
			
		}else{
				$data['data'] = "<tr style='text-align: center;'><td colspan='6'>Book has been not issued yet!</td></tr>";
				$data['status'] = 'Success';
				echo json_encode($data); 
				die;	
		}

	}

    public function ajax_lost_book_fine(){
		$fine = $this->input->post('fine');
		$lib_stock_id = $this->input->post('lib_stock_id');
		$book = $this->Generalmodel->getDataWhere('lib_stock', ['id'=>$lib_stock_id]);
		$bookPrice = $book[0]->price;			
		$increasedPrice = ($bookPrice*15)/100;
		$extraCharge = 30;
		//Book Price + 15% increased of the book price + Rs. 30 + Fine Amount
		$sumOfFines = $bookPrice+$increasedPrice+$extraCharge+$fine;
		
		$data['bookPrice']	= $bookPrice;
		$data['fine']		= round($sumOfFines);		
		$data['lostFine']	= $bookPrice+$increasedPrice+$extraCharge;
			
		echo json_encode($data);
	}

    public function add_lost_book_payment(){
		$id = $this->input->post('id');
		$formData = $this->input->post('value');
		foreach ($formData as $data) {
			$updata[$data['name']] =  $data['value'];			
		}
		
		$result = $this->Library_model->update_issued_items($id,$updata);	

		echo $result;
	}
    public function fine_amt_for_sel_mnth(){
		$ids = [];
		$data = [];
		$fine = 0;
		$ids = $this->input->post('ids');
		
		$student_code = $this->input->post('student_code');		
		$date_now = date("Y-m-d");
		$library_books_fine_per_day = $this->Generalmodel->get_configuration_by_key('library_books_fine_per_day');
		$ids = array_unique($ids);
		
		foreach($ids as $id){
			$issue_details = $this->Library_model->get_issue_details($id);			
			if ($date_now > $issue_details->valid_date) {
				$datetime1 = date_create($issue_details->valid_date);
				$datetime2 = date_create($date_now);
				$interval = date_diff($datetime1, $datetime2);
				$no_of_days = $interval->format("%R%a");				
			}
			
			if($no_of_days > 0 ){
				$fine += $no_of_days*$library_books_fine_per_day;
			}
		}
		
		$data['fine']	= $fine;
		echo json_encode($data);
	}
	public function update_issued_items(){
		$selId = [];
		$formData = [];
		$updata = [];
		$selId = $this->input->post('selId');
		
		$result = 0;
		$formData = $this->input->post('value');
		foreach ($formData as $data) {
			$updata[$data['name']] =  $data['value'];			
		}
		
		foreach($selId as $id){
			$result = $this->Library_model->update_issued_items($id,$updata);			
		}
		
		echo $result;
		
	}

    public function returnItem(){
		// $lib_stock_id = $_POST['lib_stock_id'];
		$student_id = $_POST['student_id'];
		$issue_ds = $this->Library_model->get_return_details($this->input->post('id'));	
		// pr($issue_ds);
		$library_books_fine_per_day = $this->Generalmodel->get_configuration_by_key('library_books_fine_per_day');
		$date_now = date("Y-m-d");				
		if ($date_now > $issue_ds->valid_date) {
			$datetime1 =date_create($issue_ds->valid_date);
			$datetime2 =date_create($date_now);
			$interval = date_diff($datetime1, $datetime2);
			$no_of_days = $interval->format("%R%a");
			$fine = number_format($no_of_days * $library_books_fine_per_day,2);		
			
			$student_ds = $this->Library_model->get_student_details('',$student_id);
			
			$data['html'] = '<div class="widget-header widget-header-large">
					<h3 class="widget-title grey lighter">
						<i class="ace-icon fa fa-leaf green"></i>
						Library item Invoice
					</h3>
					<div class="widget-toolbar no-border invoice-info">
						<span class="invoice-info-label">Invoice:</span>
						<span class="red">#'.$student_id.'/'.$issue_ds->id.'</span>
						<br>
						<span class="invoice-info-label">Date:</span>
						<span class="blue">'.date('d-m-Y').'</span>
					</div>
					<div class="widget-toolbar hidden-480">
						<a href="#">
							<i class="ace-icon fa fa-print"></i>
						</a>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main padding-24">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
										<b>Student Information</b>
									</div>
								</div>
								<div>
									<ul class="list-unstyled spaced">
										<li>
											<i class="ace-icon fa fa-caret-right blue"></i> <b>Name : </b>'.$student_ds->student_name.' 
										</li>
										<li>
											<i class="ace-icon fa fa-caret-right blue"></i><b>Student Code : </b>'.$student_ds->student_code.'
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="space"></div>
						<div>
							<table class="table table-striped table-bordered">
								<thead class="bg-primary text-white">
									<tr>
										<th class="center">#</th>
										<th  align="center">Item Name</th>
										<th  align="center">Fine for days</th>
										<th  align="center">Price</th>
									</tr>
								</thead>
								<tbody><tr>
										<td class="center">1</td>
										<td align="center">'.$issue_ds->book_name.'</td>	
										<td align="center">'.$no_of_days.'</td>
										<td align="center">'.$fine.'</td>
									</tr>
									
								</tbody>
							</table>
						</div>
						<div class="hr hr8 hr-double hr-dotted"></div>
						<div class="row">
							<div class="col-sm-5 pull-right">
								<h4 class="pull-right">
									Total amount :
									<span class="red">'.$fine.'</span>
								</h4>
							</div>
						</div>
					</div>
				</div>';
			
			$data['fine'] = $fine;
		}else{
			$data['html'] = '';
			$data['fine'] = '0';
		}
		
		
		//$this->db->set('invoice_status', 1);
		$this->db->set('status', 'returned');
		$this->db->set('fine', $data['fine']); 
		$this->db->set('return_date', date('Y-m-d')); 
		$this->db->where('id', $this->input->post('id')); 
		$this->db->update('lib_book_allot'); 
		
		$book_details = $this->Library_model->get_book_details($issue_ds->lib_stock_id);
		$this->db->set('number_book', ($book_details->number_book+1)); 
		$this->db->where('id', $book_details->id); 
		$this->db->update('lib_stock');  
		
		$data['msg'] = "Book has been returned. Stock Updated!";
		$data['status'] = 'Success';
		echo json_encode($data); 
		die;
		
	}
}
?>
