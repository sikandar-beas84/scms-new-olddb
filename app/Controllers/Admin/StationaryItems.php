<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\ItemMasterModel;
use App\Models\StudentFeeStructureModel;
use App\Models\StationaryItemCollectionModel;
use App\Models\StudentStationaryItemsModel;


class StationaryItems extends BaseController
{

	public function index()
	{
		$data['title'] = "Stationary Items";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $classModel = new ClassModel();
        $data['class_list'] = $classModel->orderBy('id', 'ASC')->findAll();

        echo view('admin/stationary-items/list', $data);  

        echo view('admin/common/footer', $data);	
	}

	function ajax_item_list()
	{
		$class_id = $this->request->getPost('class_id');
		$lang_name = $this->request->getPost('lang_name');

		$itemMasterModel = new ItemMasterModel();
		$item_list = $itemMasterModel->get_class_lang_items($class_id, $lang_name);

        return $this->response->setJSON(['item_list' => $item_list, 'class_id' => $class_id, 'lang_name' => $lang_name]);
	}

	function ajax_save_items()
	{
		try {
            // Read raw JSON input
            $json = $this->request->getJSON(true);

            if (!$json) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Invalid JSON data.'
                ]);
            }

            $class_id  = $json['class_id'] ?? null;
            $sec_lang  = $json['sec_lang'] ?? null;
            $items     = $json['items'] ?? [];
            $session_year_id = $this->session->get('session_year_id');

            // VALIDATION
			if (empty($class_id) || !is_numeric($class_id)) {
			    return $this->response->setJSON([
			        'status'  => 'error',
			        'message' => 'Class ID is required and must be numeric.',
			    ]);
			}

			if (empty($sec_lang)) {
			    return $this->response->setJSON([
			        'status'  => 'error',
			        'message' => 'Second language is required.',
			    ]);
			}

            // Basic validation
            if (!$class_id || !$sec_lang || empty($items)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Class, Language and Items are required.'
                ]);
            }

            $model = new ItemMasterModel();

            // Insert new items
            $insertData = [];
            foreach ($items as $row) {
                $insertData[] = [
                    'class_id'         => $class_id,
                    'sec_lang'         => $sec_lang,
                    'item_name'        => $row['item_name'],
                    'qty'              => $row['qty'],
                    'price'            => $row['price'],
                    'total'            => $row['total'],
                    'status' 		   =>	1,
                    'add_date' 		   =>	date('Y-m-d H:i:s'),
                    'session_year_id'  => $session_year_id,
                    'created_by'  	   => $this->session->get('user_id'),
                    'created_date'     => date('Y-m-d H:i:s'),
                ];
            }

            if (!empty($insertData)) {
                $model->insertBatch($insertData);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Items saved successfully.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
	}

	function ajax_delete_item()
	{
		$id = $this->request->getPost('id');

	    if (!$id) {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Invalid item ID'
	        ]);
	    }

	    $model = new ItemMasterModel();

	    $deleted = $model->delete($id);

	    if ($deleted) {
	        return $this->response->setJSON([
	            'status'  => 'success',
	            'message' => 'Item deleted successfully!'
	        ]);
	    } else {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Failed to delete the item'
	        ]);
	    }
	}

	function ajax_get_item_details()
	{
		$id = $this->request->getPost('id');

	    if (!$id) {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Invalid item ID'
	        ]);
	    }

	    $model = new ItemMasterModel();

	    $data = $model->where('id', $id)->first();

	    if ($data) {
	        return $this->response->setJSON([
	            'status' => 'success',
	            'data'   => $data
	        ]);
	    } else {
	        return $this->response->setJSON([
	            'status'  => 'error',
	            'message' => 'Record not found'
	        ]);
	    }
	}

	function ajax_update_stationary_item()
	{
		$data = $this->request->getPost();

		$id = $this->request->getPost('id');
		$item_name = $this->request->getPost('item_name');
		$qty = $this->request->getPost('qty');
		$price = $this->request->getPost('price');

		// VALIDATION
	    if (empty($item_name)) {
	        return $this->response->setJSON([
	            "status" => "error",
	            "message" => "Item Name is required"
	        ]);
	    }

	    if ($qty == "" || $qty <= 0) {
	        return $this->response->setJSON([
	            "status" => "error",
	            "message" => "Quantity must be greater than 0"
	        ]);
	    }

	    if ($price == "" || $price <= 0) {
	        return $this->response->setJSON([
	            "status" => "error",
	            "message" => "Price must be greater than 0"
	        ]);
	    }

		$total_price = $qty * $price;

		$model = new ItemMasterModel();

		$updateData = [
	        'item_name'     => $item_name,
	        'qty'           => $qty,
	        'price'         => $price,
	        'total'         => $total_price,
	        'updated_by'    => $this->session->get('user_id'),
	        'updated_date'  => date('Y-m-d H:i:s'),
	    ];

	    $model->update($id, $updateData);

	    return $this->response->setJSON([
	        "status" => "success",
	        "message" => "Item updated successfully!"
	    ]);
	}

	public function stationary_item_collection()
	{
		$data['title'] = "Stationary Collections";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/stationary-items/item-collection', $data);  

        echo view('admin/common/footer', $data);	
	}

	public function stationary_item_collection_student_list()
	{
		$student_code = $this->request->getPost('student_code');

	    if (!$student_code) {
	        return $this->response->setJSON([
	            'html' => '',
	        ]);
	    }
 
		$get_session_year_id = $this->session->get('session_year_id');
		$studentFeeStructureModel = new StudentFeeStructureModel();
		$stationaryItemCollectionModel = new StationaryItemCollectionModel();

        $student_list = $studentFeeStructureModel->get_student_statonary_item_collection_lists_for_ajax_call($student_code);

        $count=0;
        $html = '';

		if(!empty($student_list)){
			$html .='';
           
			foreach($student_list as $student){
				$stationaryCcollectedItemDetails = $stationaryItemCollectionModel->student_stationary_collected_item_details($student['code']);
				
				$html .='<tr>
				    <td> ' . ++$count .'</td>
					<td>'. $student['code'] .'</td>
					<td>'. $student['first_name'] .' '.$student['middle_name'] .' '.$student['surname'] .'</td>';
							
					if($student['ad_payment_status'] == true){
					    $html .= '<td>Admitted</td>';
					} else {
					    $html .= '<td>Not Admitted</td>';
					}
					
					$html .= '<td>'. $student['total_price'] .'</td>';
					
					$getCollectedDetails = "";
					if( isset($stationaryCcollectedItemDetails) && !empty($stationaryCcollectedItemDetails) ) {
					    $getCollectedDetails = '<span><strong>Given By:</strong> '.get_user_full_name_by_id($stationaryCcollectedItemDetails['given_by']).'</span><br/><span><strong>Given Date:</strong> '.date('j F, Y g.iA', strtotime($stationaryCcollectedItemDetails['given_date'])).'</span>';
					}
					$html .= '<td class="itemCollectedDetailsJs">'.$getCollectedDetails.'</td>';

					if($student['ad_payment_status'] == 1 && count($stationaryCcollectedItemDetails) <= 0){
                    	$html .='<td class="stationaryItemCollectionJs"><span class="col-sm-12"><label class="pull-right inline"><input name="allowTransport" class="ace ace-switch ace-switch-7 allowTransport" value="'. $student['code'] .'" type="checkbox" data-sessionYearId="'. $student['session_year_id'] .'" data-classid="'. $student['class_id'] .'" ><span class="lbl"></span></label></span></td>';
					} else {
					    $html .='<td>All Stationery Items Collected Successfully</td>';
					}
				
				$html .='</tr>';
            }	   
		} else {
			$html =' <tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr>';
		}
		return $this->response->setJSON(['html' => $html]);
	}

	public function assign_stationary_items()
	{
		$data['title'] = "Assign Stationary Items";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/stationary-items/assign-stationary-items', $data);  

        echo view('admin/common/footer', $data);
	}

	public function assign_stationary_item_collection_student_list()
	{
		$student_code = $this->request->getPost('student_code');

	    if (!$student_code) {
	        return $this->response->setJSON([
	            'html' => '',
	        ]);
	    }
 
		$get_session_year_id = $this->session->get('session_year_id');
		$studentFeeStructureModel = new StudentFeeStructureModel();
		$stationaryItemCollectionModel = new StationaryItemCollectionModel();
		$itemMasterModel = new ItemMasterModel();

        $student_list = $studentFeeStructureModel->get_student_statonary_item_collection_lists_for_ajax_call($student_code);

        $count=0;
        $html = '';
        
        // pr($student_list);

		if(!empty($student_list)){
			$html .='';
           
			foreach($student_list as $student){
				$getStationaryCollectedItemDetails = $itemMasterModel->getStudentItemsByStudentId($student['student_id']);

				// pr($getStationaryCollectedItemDetails);

				$html .='<tr>
				    <td> ' . ++$count .'</td>
					<td>'. $student['code'] .'</td>
					<td>'. $student['first_name'] .' '.$student['middle_name'] .' '.$student['surname'] .'</td>';
							
					if($student['ad_payment_status'] == true){
					    $html .= '<td>Admitted</td>';
					} else {
					    $html .= '<td>Not Admitted</td>';
					}
					
					$html .= '<td>'. $student['total_price'] .'</td>';

					if($student['ad_payment_status'] == 1 && empty($getStationaryCollectedItemDetails)){
                    	$html .='<td class="stationaryItemCollectionJs"><a href="'.base_url('admin/stationary-items/assign-student-stationary-items/'.$student['student_id']).'">Assign Stationery Items</a></td>';
					} else {
					    $html .='<td>Already Stationary Item Assigned to this Student 
					    <br />
					    <div style="display: flex; align-items: center; gap: 10px;">
					    <a title="Print Stationary Item Fee" class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="stationary_invoice_fee('.$student['student_id'].')">
                           <i class="bi bi-printer"></i></a>';
                        if( session()->get('user_id') == 9583 ):
                        	$checkedPaymentModeTextUpdated = '';
							if (isset($fee['payment_mode']) && str_ends_with($fee['payment_mode'], '.')) {
							    $checkedPaymentModeTextUpdated = 'checked';
							}

                        	$html .=' <div class="form-check-horizontal">
								<label class="form-check form-switch mb-2" style="transform: scale(1.2);">
									<input type="checkbox" class="change-fees-payment-mode form-check-input" data-stationary-payment-mode="'.$getStationaryCollectedItemDetails['payment_mode'].'" data-id="'.$getStationaryCollectedItemDetails['id'].'" '.$checkedPaymentModeTextUpdated.' title="Change Stationary Fees Payment Mode" />
								</label>
							</div>';
                        endif;

                        $html .='</div></td>';
					}
				
				$html .='</tr>';
            }	   
		} else {
			$html =' <tr><td colspan="6"><div class="alert alert-danger">No result found!</div></td></tr>';
		}
		return $this->response->setJSON(['html' => $html]);
	}

	public function assign_student_stationary_items($student_id)
	{
		$data['title'] = "Assign Student Stationary Items";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $student_code = !empty($student_id) ? student_code_by_id($student_id) : '';
        $class_id = !empty($student_code) ? class_id_by_student_code($student_code) : '';
        $lang_name = second_language_by_student_id($student_id);

        $itemMasterModel = new ItemMasterModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();

		$data['stationary_item_list'] = $itemMasterModel->get_class_lang_items($class_id, $lang_name);
		$data['student_name'] = !empty($student_code) ? student_name_by_code($student_code) : '';
		$data['student_stationary_items'] = $itemMasterModel->getStudentItemsByStudentId($student_id);
		$data['student_id'] = $student_id;
		$data['class_id'] = $class_id;
		$data['student_code'] = $student_code;

		$data['april_month_fees_details'] = $studentFeeStructureModel->get_student_april_month_fees_details($student_code);
        
        // pr($data);
        
        echo view('admin/stationary-items/assign-student-stationary-items', $data);  

        echo view('admin/common/footer', $data);
	}

	public function assign_stationary_item_to_student()
	{
		$stationary_items = $this->request->getPost('stationary_items') ?? [];
		$stationary_total = $this->request->getPost('stationary_total') ?? 0;
		$student_id = $this->request->getPost('student_id') ?? '';
		$class_id = $this->request->getPost('class_id') ?? '';
		$student_code = $this->request->getPost('student_code') ?? '';
		$student_name = $this->request->getPost('student_name') ?? '';
		
		$fees_id = $this->request->getPost('fees_id') ?? '';
		$ad_payment_mode = $this->request->getPost('ad_payment_mode') ?? '';
		$cheque_number = $this->request->getPost('cheque_number') ?? '';
		$pos_bank_name = $this->request->getPost('pos_bank_name') ?? '';
		$pos_reference_number = $this->request->getPost('pos_reference_number') ?? '';
		
		$session_id = session()->get('session_year_id');
		$t_user_id = session()->get('user_id');
        $added_by = session()->get('f_name');

        if ($student_code == '') {
	        return $this->response->setJSON([
	            'status' => false,
		        'message' => 'Student code not found.'
	        ]);
	    } 

	    if($student_id == '') {
	    	return $this->response->setJSON([
	            'status' => false,
		        'message' => 'Student details not found.'
	        ]);
	    } 

	   	if($fees_id == '') {
	    	return $this->response->setJSON([
	            'status' => false,
		        'message' => 'Student fees details not found.'
	        ]);
	    } 

	    if($class_id == '') {
	    	return $this->response->setJSON([
	            'status' => false,
		        'message' => 'Student class details not found.'
	        ]);
	    } 

	    if($ad_payment_mode == '') {
	    	return $this->response->setJSON([
	            'status' => false,
		        'message' => 'Student payment details not found.'
	        ]);
	    }

	    if (empty($stationary_items)) {
		    return $this->response->setJSON([
		        'status' => false,
		        'message' => 'No stationary items selected.'
		    ]);
		}

		// Insert Stationary Item
        $studentStationaryItemsModel = new StudentStationaryItemsModel();
        $studentFeeStructureModel = new StudentFeeStructureModel();
        $itemMasterModel = new ItemMasterModel();

        $get_student_stationary_items = $itemMasterModel->getStudentItemsByStudentId($student_id);
        if ($get_student_stationary_items) {
		    return $this->response->setJSON([
		        'status' => false,
		        'message' => 'Stationary items already assigned to this student.'
		    ]);
		}

        $stFeesUpdata = [
        	'total_stationary_fee' => $stationary_total,
        ];
        $result = $studentFeeStructureModel->update($fees_id, $stFeesUpdata);

        if( !empty($stationary_items) && $result ) {
            $item_names = array_column($stationary_items, 'item_name');
            $item_ids   = array_column($stationary_items, 'item_id');
            $item_qtys  = array_column($stationary_items, 'qty');
            $item_price = array_column($stationary_items, 'price');

            // Convert to comma-separated string
            $item_names_str = implode(',', $item_names);
            $item_ids_str   = implode(',', $item_ids);
            $item_qtys_str  = implode(',', $item_qtys);
            $item_price_str = implode(',', $item_price);

            $stationaryData = array(
                'student_id'=> $student_id,
                'class_id'  => $class_id, // class_id
                'class_code'=> $student_code, // code
                'item_ids' => $item_ids_str,                       
                'item_qtys'=> $item_qtys_str,                      
                'item_price'=> $item_price_str,
                'price'     => $stationary_total,
                'payment_status' => 1,
                'payment_date' => date('Y-m-d'),
                'session_year_id'=> $session_id,
                'add_date'  => date('Y-m-d H:i:s'),
                'payment_mode' => $ad_payment_mode,
                'cheque_number' => $cheque_number,
                'pos_bank_name' => $pos_bank_name,
                'pos_reference_number' => $pos_reference_number,
                't_user_id' => $t_user_id,
                'added_by' => $added_by,
                'remarks' => 'Only stationary items payment is being taken. Admission fees are not included in this payment.'
            );
            // echo "<pre>"; print_r($stationaryData);
            
            $stationaryResultId = $studentStationaryItemsModel->insert($stationaryData, true);

            if (!empty($stationaryResultId)) {
			    return $this->response->setJSON([
			        'status' => true,
			        'message' => 'Stationary items payment successfully saved.',
			        'insert_id' => $stationaryResultId,
			        'student_code' => $student_code
			    ]);
			} else {
				return $this->response->setJSON([
			        'status' => false,
			        'message' => 'Failed to save stationary items payment.'
			    ]);
			}
        } else {
			return $this->response->setJSON([
		        'status' => false,
		        'message' => 'Failed to save stationary items payment.'
		    ]);
		}
	}

	public function ajax_stationary_invoice()
	{
		$student_id = $this->request->getPost('student_id') ?? '';

		if( $student_id == '' ) {
			return $this->response->setJSON(['status' => false, 'html' => '']);
		}

		$itemMasterModel = new ItemMasterModel();

		$getStCollectedItemDetails = $itemMasterModel->getStudentItemsByStudentId($student_id);
		// print_r("getStCollectedItemDetails");
		// pr($getStCollectedItemDetails);

		$getItemIds = $getStCollectedItemDetails['item_ids'] ?? '';
		$getItemQty = $getStCollectedItemDetails['item_qtys'] ?? '';
		$getItemPrice = $getStCollectedItemDetails['item_price'] ?? '';
		$student_code = $getStCollectedItemDetails['class_code'] ?? '';
		$class_id = $getStCollectedItemDetails['class_id'] ?? '';
		$student_id = $getStCollectedItemDetails['student_id'] ?? '';

		$stationary_item_id_array = !empty($getItemIds) ? array_map('intval', explode(',', $getItemIds)) : [];
		$stationary_item_qty_array = !empty($getItemQty) ? array_map('intval', explode(',', $getItemQty)) : [];
		$stationary_item_price_array = !empty($getItemPrice) ? array_map('intval', explode(',', $getItemPrice)) : [];

		$barcode =  $student_code.'/'.$class_id.'/'.$student_id;
		$student_name = ($student_code != '') ? student_name_by_code($student_code) : '';
		$class_name = ($class_id != '') ? get_class_name_by_id($class_id) : '';
		$payment_date = $getStCollectedItemDetails['payment_date'] ?? '';
		$payment_amount = $getStCollectedItemDetails['price'] ?? '';
		$payment_mode = $getStCollectedItemDetails['payment_mode'] ?? '';

		$html = '<div style="font-size:12px !important;">
            <div style="width:100%;clear:both;min-height:70px;">
                <div style="width:15%;float:left;text-align:center">
                    <img width="50" src="'. base_url('public/img/Satish-Chandra-Memorial-School-Nadia-West-Bengal.png') .'">
                </div>
                <div style="width:45%;float:left;text-align:center">
                    <div style="width:100%;float:left;">
                        <span class="invoice-info-label">Bill No:</span>
                        <span class="red">' . $barcode .'</span>
                    </div>
                </div>
                <div style="width:40%;float:left;text-align:center">
                    <strong class="widget-title grey lighter">SATISH CHANDRA MEMORIAL SCHOOL<br>PUMLIA, CHOWRASTA, CHAKDAHA</strong>
                </div>
            </div>
            <div style="width:100%;clear:both;min-height:40px">
                <div style="width:35%;float:left;"><b>Name:</b> '. $student_name .'</div>
                <div style="width:35%;float:left;"><b>Student ID:</b> '. $student_code .'</div>
                <div style="width:35%;float:left;"><b>Class:</b> '. $class_name .'</div>
                <div style="width:35%;float:left;"><b>Payment Date:</b> '. $payment_date .'</div>
            </div>
        </div>

        <div class="">
            <div class="">';

                $html .='<div class="space"></div>
                <div class="row" style="margin-top:5px !important;">
                    <div class="col-sm-12" style="float:left">
                        <div>
                            <p>Stationary Items</p>
                            <table class="table table-striped table-bordered" style="font-size:11px;">
                                <thead>
                                    <tr>
                                        <th class="center">Sl No.</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $sti = 1;
                                foreach ($stationary_item_id_array as $key => $stitems) {
                                    $totalPrice = (int)$stationary_item_qty_array[$key] * (int)$stationary_item_price_array[$key];

                                    $html .= '<tr>
                                        <td style="padding:1px;" class="center">'.$sti.'</td>
                                        <td style="padding:1px;"><a>'.item_name_by_id($stitems).'</a></td>                                                                    
                                        <td style="padding:1px;"> '.$stationary_item_qty_array[$key].' </td>
                                        <td style="padding:1px;" align="right">'.number_format($stationary_item_price_array[$key],2).'</td>
                                        <td style="padding:1px;" align="right">'.number_format($totalPrice,2).'</td>
                                    </tr>';

                                    $sti++;
                                } 
                            $html .= '  </tbody>
                            </table>
                        </div>
                    
                        <p>Stationary. Items (in words): '. ucwords(convert_number_to_words($payment_amount)) .'</p>
                        <p>
                            <span>Stationary Items  : '.number_format($payment_amount,2).'</span><br>
                            <span style="text-align:left"><strong>Printed By: </strong>'.($this->session->get('dept_id') == 1 ? $this->session->get('f_name') : 'Cashier').'</span>
                            <span style="float:center"><strong>Collected By: </strong>'. $getStCollectedItemDetails['added_by'] .'</span>
                        </p>
                    </div>';

                $html .= '</div>

                <div class="row" style="margin-top:5px !important;">
                    <p class="pull-left">
                        Net Collected Amount (in words) :
                        <span class="red">'.ucwords(convert_number_to_words(($payment_amount),2)).' Only</span>
                    </p>
                    <p class="pull-right">
                        Net Collected Amount :
                        <span class="red"><strong>'.number_format(($payment_amount),2).'</strong></span>
                    </p>
                    <p class="pull-right">
                        Payment Mode :
                        <span class="red"><strong>'.$payment_mode.'</strong></span>
                    </p>
                </div>

                <div>
                    <p>For Downloading app please scan this QR</p>
                    <img src="'. base_url() .'public/img/QR.png" alt="QR Code" width="90" height="110"></br>
                    <p>This is a system generated receipt. Signature & Stamp not require</p>
                
                </div>';

            $html .='</div>
        </div>';

        return $this->response->setJSON(['status' => true, 'html' => $html]);
	}

	public function ajax_update_stationary_fees_payment_mode()
	{
		$fees_payment_id = $this->request->getPost('id');
        $payment_mode = $this->request->getPost('paymentMode');
        $isChecked = $this->request->getPost('isChecked');

        if (!$fees_payment_id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid ID'
            ]);
        }

        if (!$payment_mode) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid Payment Mode'
            ]);
        }

        $update_data['payment_mode'] = $payment_mode;

        $studentStationaryItemsModel = new StudentStationaryItemsModel();
        $update =  $studentStationaryItemsModel->where('id', $fees_payment_id)->set($update_data)->update();

        if ($update) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Payment mode updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update payment mode.'
            ]);
        }
	}
}