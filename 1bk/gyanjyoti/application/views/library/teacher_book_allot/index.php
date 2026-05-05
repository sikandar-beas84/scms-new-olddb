	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" />
	<style>
        
.profile-info-row {
  display: flex
;
}
.profile-info-name, .profile-info-value {
  color: #fff !important;
  padding: 0;
  padding-top: 8px;
}

thead th {
    font-size: 14px !important;
    text-align: center;
}
a.add_button.btn.btn-xs.btn-primary {
    font-size: 13px;
}
    </style>
    <div class="main-content">
	    <div class="main-content-inner">

	        <div class="">

	            <!-- Surojit Bera -->
	            <div class="col-sm-12">
	                <div class="alert alert-block alert-success" id="success" style="display:none;">
	                    <i class="ace-icon fa fa-check green"></i>
	                    <span></span>
	                </div>
	                <div class="alert alert-block alert-danger" id="danger" style="display:none;">
	                    <i class="ace-icon fa fa-remove red"></i>
	                    <span></span>
	                </div>
                    <form class="form-horizontal" role="form" action="javascript:;" id="getTeacher">
	                <div class="filter row mb-2 pb-4">

	                        <div class="col-12  col-md-4 col-sm-4 col-lg-4">
	                            <label for="classFilter" class="text-light">Select Teacher </label>
	                            <select class="form-control bg-light" name="id" id="id" required>
                                <option value="">-- Select --</option>
                                <?php foreach($staff as $key=>$v): ?>
	                                <option value="<?=$key;?>"><?=$v;?></option>
	                                <?php endforeach; ?>
	                            </select>
                                
	                        </div>
	                       
	                        <div class="col-4 col-md-2 col-sm-2 col-lg-2">
	                            <button type="submit" class="btn btn-success mt-5 p-2 filterButton"
	                                >Go</button>
	                        </div>
                            <div class="filter-info mt-15" id="teacher_detail">
							
                            </div>
                        </div>
                    </form>
	            </div>

	            <div class="clearfix"></div>
                <div class="filter-info mt-15" id="issue_detail" style="display:none;">
	                <div id="field_wrapper">

	                </div>
	            </div>


	            <form class="form-horizontal" role="form" action="javascript:;" id="issueBook">
	                <input type="hidden" name="teacher_id_hidden" id="teacher_id_hidden" required>
	                <?php if($this->session->userdata('teacher_logged_in') != true){ ?>
	                <div class="filter-info mt-15">
	                    <div class="form-group pull-right">
	                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> </label>
	                        <div class="col-sm-9">
	                            <a href="javascript:void(0);" class="add_button btn btn-xs btn-primary" title="Add field">
	                                <i class="ace-icon fa fa-plus"></i> Add Book</a>
	                        </div>
	                    </div>

	                    <table id="simple-table1" class="table table-bordered table-hover">
	                        <thead class="bg-primary text-white">
	                            <tr>
	                                <th>Book Name</th>
	                                <th>Issue Date</th>
	                                <th>valid to</th>
	                                <th>Fine</th>
	                                <th></th>
	                            </tr>
	                        </thead>
	                        <tbody class="field_wrapper">
	                            <tr>
	                                <td>
	                                    <input type="text" class="form-control book" name="book[]" autocomplete="off"
	                                        id="book" placeholder="Search Book" required>
	                                    <input type="hidden" id="lib_stock_id" name="lib_stock_id[]">
	                                </td>
	                                <td>
	                                    <input type="text" name="issue_date[]" id="issue_date" autocomplete="off" required
	                                        class="form-control datepicker1" placeholder="mm/dd/YYYY"
	                                        value="<?= date("m-d-Y"); ?>">
	                                </td>
	                                <td>
	                                    <input type="text" name="valid_date[]" id="valid_date" autocomplete="off" required
	                                        class="form-control datepicker1" placeholder="mm/dd/YYYY"
	                                        value="<?= date("m-d-Y", strtotime($date." +". $library_book_allotment_duration ." day")); ?>">
	                                </td>
	                                <td>
	                                    Fine amount <b>Rs- <i class="fa fa-inr"></i> <?=$library_books_fine_per_day?> /
	                                        Day</b> after valid to date
	                                </td>
	                                <td align="center">
	                                    <a href="javascript:void(0);" class="remove_button" data-toggle="tooltip"
	                                        title="Remove"><button class="btn btn-xs btn-primary"><i
	                                                class="ace-icon fa fa-minus"></i></button></a>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>


	                </div>


	                <button class="btn btn-primary" type="submit">Save</button>
	                <?php } ?>
	            </form>

	        </div>
	    </div>
	</div><!-- /.main-content -->
	<!-- Modal -->
	<div class="modal fade" id="itemInvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	    aria-hidden="true">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="exampleModalLabel">teacher stationary item invoice</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
	                    onclick="closeModal('itemInvModal');">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	                <div class="row">
	                    <div class="col-xs-12">
	                        <div class="row">
	                            <div class="col-sm-10 col-sm-offset-1">
	                                <div class="widget-box transparent" id="item_data"></div>
	                            </div>
	                        </div>
	                    </div><!-- /.col -->
	                </div><!-- /.row -->
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal"
	                    onclick="closeModal('itemInvModal');">Close</button>
	                <button type="button" class="btn btn-primary" id="inv_items">Print</button>
	            </div>
	        </div>
	    </div>
	</div>


	<div class="customModal" id="InvModal">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content p-1" id="modalContent">
	            <div class="modal-header">
	                <h5 class="modal-title" id="">Calculated Fine</h5>
	                <button type="button" class="close" onclick="closeModal('InvModal');" data-dismiss="modal"
	                    aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	                <div class="row">
	                    <div class="col-xs-12">
	                        <form class="form-horizontal" role="form" id="cpay" autocomplete="off">
	                            <p class="pay_msg"></p>
	                            <div class="form-group">
	                                <label class="col-sm-4 control-label" for=""> Fine Amount </label>
	                                <div class="col-sm-12">
	                                    <input type="text" class="form-control fine" value="" disabled />
	                                    <input type="hidden" class="form-control fine" name="fine" value="" />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-sm-4 control-label" for=""> Bill No </label>
	                                <div class="col-sm-12">
	                                    <input type="text" class="form-control" name="bill_no" value="" />
	                                </div>
	                            </div>
	                            <input type="hidden" class="invoice_status" name="invoice_status" value="1" />
	                            <!--<input type="hidden" class="t_user_id" name="t_user_id" value="<?= $this->session->userdata('user_id')?>"/>
										<input type="hidden" class="added_by" name="added_by" value="<?= $this->session->userdata('f_name')?>"/>-->

	                        </form>
	                    </div><!-- /.col -->
	                </div><!-- /.row -->
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal"
	                    onclick="closeModal('InvModal');">Close</button>
	                <button type="button" class="btn btn-primary" id="fees_items">Save</button>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- Fine invoice Modal start-->

	<!-- Fine invoice Modal end -->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	    aria-hidden="true">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="exampleModalLabel">Lost Book Fine Collection</h5>
	                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button> -->
	            </div>
	            <div class="modal-body">
	                <div class="row">
	                    <div class="col-xs-12">
	                        <form class="form-horizontal" role="form" id="finePay" autocomplete="off">
	                            <p class="fine_pay_msg"></p>
	                            <div class="form-group">
	                                <label class="col-sm-4 control-label" for=""> Book Price </label>
	                                <div class="col-sm-12">
	                                    <input type="text" class="form-control" id="bookPrice" value="" disabled />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-sm-4 control-label" for="">Fine Amount</label>
	                                <div class="col-sm-12">
	                                    <input type="text" class="form-control fine" value="" disabled />
	                                    <input type="hidden" class="form-control fine" name="fine" value="" />
	                                </div>
	                            </div>

	                            <input type="hidden" class="id" value="" />
	                            <input type="hidden" class="invoice_status" name="invoice_status" value="1" />
	                            <input type="hidden" id="isLost" name="is_lost" value="1" />
	                            <input type="hidden" id="lostFine" name="lost_fine" value="" />
	                            <input type="hidden" name="return_date" value="<?= date('Y-m-d') ?>" />
	                            <input type="hidden" name="status" value="returned" />
	                        </form>
	                    </div><!-- /.col -->
	                </div><!-- /.row -->
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-primary" id="sub_cpay">Save</button>
	                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
	            </div>
	        </div>
	    </div>
	</div>


	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	</div><!-- /.main-container -->
	<div id="divLoading" style="display:none;"></div>
	<style>
#divLoading {
    display: block;
    position: fixed;
    z-index: 100;
    background-image: url(<?php echo base_url('assets/img/load.gif') ?>);
    background-color: #fff;
    opacity: 0.9;
    background-repeat: no-repeat;
    background-position: center;
    left: 0;
    bottom: 0;
    right: 0;
    top: 0;
}

.error {
    color: red;
}

.profile-info-name {
    text-align: right;
    padding: 6px 10px 6px 4px;
    font-weight: 400;
    color: #667E99;
    background-color: transparent;
    width: 150px;
    vertical-align: middle;
}
	</style>


	<script src="<?php echo base_url();?>assets/admin/js/jquery.validate.min.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<!-- Include jQuery UI (Compatible with jQuery 3.6.0) -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.0/jQuery.print.min.js"></script>


    <script>
			//cash payment
			$('#fees_items').click(function () {
				var billNo = $('#cpay').find('[name="bill_no"]').val();
				var amt = $('.fine').val();
				
				if(amt > 0 && billNo){				
					var chkArray = [];
					$(".selected:checked").each(function() {
						chkArray.push($(this).val());
					});
					var r = confirm("Confirm?");
					if ( r == true ) {
						var dataString = $('#cpay').serializeArray();
						$.ajax({
							url:'<?= base_url() ?>library/teacher_book_allot/update_issued_items',
							method: 'post',					
							data: {selId : chkArray,value : dataString},				  
							success: function(data){								
								if(data){	
									$('.pay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Fine Collected.</p></div>');
									/* setTimeout(function(){										
										location.reload();			
									}, 1500); */
								} else {								
									$('.pay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Try after sometime<br></div>');
								}
							}
						}) 
					} else {				
						e.preventDefault();
					}
				} else {
					
					alert('Enter All Details');
					return false;
				}
			});	
		
		</script>
 
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
				$(document).ready(function(){
					$('.datepicker1').datepicker({ dateFormat: "dd-mm-yyyy" });
					var maxField = 10; //Input fields increment limitation
					var minField = 1; //Input fields increment limitation
					var addButton = $('.add_button'); //Add button selector
					var wrapper = $('.field_wrapper'); //Input field wrapper
					var fieldHTML = '<tr><td><input type="text" required class="form-control book" autocomplete="off"  name="book[]" id="book" placeholder="search book"><input type="hidden"  id="lib_stock_id" name="lib_stock_id[]"></td><td><input type="text" required name="issue_date[]" autocomplete="off" class="form-control datepicker" placeholder="dd/mm/YYYY" value="<?= date("d-m-Y") ?>"></td><td><input type="text" required name="valid_date[]" autocomplete="off" class="form-control datepicker" placeholder="dd/mm/YYYY" value="<?= date("d-m-Y", strtotime($date." +". $library_book_allotment_duration ." day")); ?>"></td><td>Fine amount <b>Rs- <i class="fa fa-inr"></i> <?=$library_books_fine_per_day?> / Day</b> after valid to date</td><td align="center"><a href="javascript:void(0);" class="remove_button" data-toggle="tooltip" title="Remove"><button class="btn btn-xs btn-primary"><i class="ace-icon fa fa-minus"></i></button></a></td></tr>';
					var x = 1; //Initial field counter is 1
					$(addButton).click(function(){
						if(x < maxField){ 
							x++; //Increment field counter
							$(wrapper).append(fieldHTML); //Add field html
							$('.datepicker').datepicker({ dateFormat: "dd-mm-yyyy" });
							$( ".book" ).autocomplete({
								source: function (request, response) {
								jQuery.get("<?php echo base_url('library/teacher_book_allot/getLibrary') ?>", {
									query: request.term
								}, function (data) {
									response(JSON.parse(data));			 
								});
							},
							minLength: 1
							
							});							
						}
					});
					$(wrapper).on('click', '.remove_button', function(e){
						e.preventDefault();
						if(x > minField){ 
							$(this).parent('td').parent('tr').remove(); //Remove field html
							x--; //Decrement field counter
							$('.datepicker').datepicker({ dateFormat: "dd-mm-yyyy" });
							$( ".book" ).autocomplete({
								source: function (request, response) {
								jQuery.get("<?php echo base_url('library/teacher_book_allot/getLibrary') ?>", {
									query: request.term
								}, function (data) {
									response(JSON.parse(data));			 
								});
							},
							minLength: 1
							
							});			
						}
					});
				});
			</script>
		<script type="text/javascript">
			jQuery(function($) {
				
			$("#getTeacher").validate({
				submitHandler: function(form) {
					$("#divLoading").show();
                    getTeacher();
                 }
			});
			$("#issueBook").validate({
				submitHandler: function(form) {
					$("#divLoading").show();
                    issueBook();
                 }
			});
			function getTeacher(){
				$.ajax({
				  method: "POST",
				  url: '<?php echo base_url('library/teacher_book_allot/getTeacher') ?>',
				  data: $("#getTeacher").serialize(),
				}).done(function( resp ) {
					var resp =  $.parseJSON( resp );
					   if(resp.status=='Success'){
						   $("#divLoading").hide();
						   $("#teacher_detail").html(resp.data);
						   $("#teacher_id_hidden").val(resp.id);
							  getTeacherIssueBook();
							  $('html, body').animate({
								scrollTop: $("#getTeacher").offset().top-300
							  });	
						  // dataTable.draw();
					   }else{
						   $("#divLoading").hide();
						   $("#teacher_detail").html(resp.data);
						   $("#teacher_id_hidden").val("");
						   $('html, body').animate({
								scrollTop: $("#getTeacher").offset().top-300
						   });	
					   } 
				});				
			}
			
			function getTeacherIssueBook(){
				$.ajax({
					method: "POST",
					url: '<?php echo base_url('library/teacher_book_allot/getTeacherIssueBook') ?>',
					data: {teacher_id:$("#teacher_id_hidden").val()},
					}).done(function( resp ) {
						var resp =  $.parseJSON( resp );
							if(resp.status=='Success'){
								$("#issue_detail").show();
								$("#field_wrapper").html(resp.data);
							}
					});
			}
			
			function issueBook(){
				if($("#tacher_id_hidden").val()==''){
					alert("Please select teacher first!");
					 $("#divLoading").hide();
					return false;
				}
					$.ajax({
					  method: "POST",
					  url: '<?php echo base_url('library/teacher_book_allot/issueBookTeacher') ?>',
					  data: $("#issueBook").serialize(),
					}).done(function( resp ) {
					
						var resp =  $.parseJSON( resp );
                        getTeacherIssueBook();
						   if(resp.status=='Success'){
							   $("#divLoading").hide();
							   $("#success span").html(resp.msg);
							   $("#teacher_detail").html(resp.data);
							   $("#submit").trigger('click');
							   $('#issueBook')[0].reset();
								  $("#success").show();
								  $('html, body').animate({
									scrollTop: $("#issueBook").offset().top-300
								  });	
							  // dataTable.draw();
                              
						   }else{
							   $("#divLoading").hide();
							  $("#danger span").html(resp.msg);
							   $(".captcha_image").html(resp.captcha);
							  $("#danger").show();
							  $('html, body').animate({
								scrollTop: $("#issueBook").offset().top-300
							  });	
						   } 
					});
				
				
			}
				// dataTable.draw();
			});
			/* var dataTable = $('#lib_stock').DataTable({
						"processing" : true,
						"serverSide" : true,
						"order" : [],
						"searching" : false,
						"ajax" : {
							url:"<?php echo base_url('library/libServer') ?>",
							type:"GET"
						},
						"pageLength": 10
					});
					 */
			// function EditBook(id){
			// 	$.ajax({
			// 		  method: "POST",
			// 		  url: '<?php echo base_url('library/editBook') ?>/'+id,
			// 		  data: {id:id},
			// 		}).done(function( resp ) {
						
			// 			var resp =  $.parseJSON( resp );
			// 			$("#lib_stock_id").val(resp.id);
			// 			$("#book_edition").val(resp.book_edition);
			// 			$("#billNo").val(resp.billNo);
			// 			$("#bookName").val(resp.bookName);
			// 			$("#bookAuthor").val(resp.bookAuthor);
			// 			$("#bookPublisher").val(resp.bookPublisher);
			// 			$("#entryDate").val(resp.entryDate);
			// 			$("#numberBook").val(resp.numberBook);
			// 			$('html, body').animate({
			// 				scrollTop: $("#addBook").offset().top-300
			// 			});	
			// 		});
			// }
			// function DeleteBook(id){
			// 	var r = confirm("Are you sure you want to delete this record?");
			// 	if (r == true) {
			// 		$.ajax({
			// 		  method: "POST",
			// 		  url: '<?php echo base_url('library/deleteBook') ?>/'+id,
			// 		  data: {id:id},
			// 		}).done(function( resp ) {
			// 			var resp =  $.parseJSON( resp );
			// 			$("#success span").html(resp.msg);
			// 					  $("#success").show();
			// 					  $('html, body').animate({
			// 						scrollTop: $("#addBook").offset().top-300
			// 					  });	
			// 				  dataTable.draw();
			// 		});
			// 	}
				
			// }
		</script>
		 <script>
			$(function() {			   
				$( ".book" ).autocomplete({
					source: function (request, response) {
					jQuery.get("<?php echo base_url('library/teacher_book_allot/getLibrary') ?>", {
						query: request.term
					}, function (data) {
						response(JSON.parse(data));			 
					});
				},
				minLength: 1
				
				});
				
			});
			
			$(document).ready(function() {
				$("#inv_items").click(function(){
					$("#item_data").print();
				});
			} );

			function return_item(lib_stock_id,student_id,id){
				var r = confirm("Are you sure you want to return this Book?");
				if (r == true) {
				$.ajax({
					url:"<?php echo base_url('library/teacher_book_allot/returnItem') ?>",
					method: "post",					
					data: {id:id,lib_stock_id:lib_stock_id, student_id: student_id},				  
					success: function(data){
						var json_obj = JSON.parse(data);
						 $("#success span").html(json_obj.msg); 
						 $("#success").show();
						if(json_obj.fine!="0")
						$("#itemInvModal").modal("show");					
					
						$("#item_data").html(json_obj.html);
						$("#submit").trigger('click');	
                        setTimeout(function() {
                            location.reload();
                        }, 2000);				
					}
				 });								
				}
			}
			
			
			
		function lost_item(lib_stock_id,fine,id){
			$.ajax({
				url:"<?=base_url()?>library/teacher_book_allot/ajax_lost_book_fine",
				method: "post",					
				data: {lib_stock_id : lib_stock_id, fine : fine},				  
				success: function(data){
					var data =  $.parseJSON( data );
					if(data){							
						$("#bookPrice").val(data.bookPrice);
						$("#lostFine").val(data.lostFine);
						$(".id").val(id);
						$(".fine").val(data.fine);	
                        // getTeacherIssueBook();					
					} else {								
						alert("No Amount Found");
					}
					
					$("#myModal").modal("show");
				}
			});								
		}
		
		//lost book fine payment
		$('#sub_cpay').click(function () {
			var r = confirm("Confirm?");
			if ( r == true ) {
				var dataString = $('#finePay').serializeArray();
				var id = $('.id').val();
				$.ajax({
					url:'<?= base_url() ?>library/teacher_book_allot/add_lost_book_payment',
					method: 'post',					
					data: {value : dataString, id : id},				  
					success: function(data){
						if(data){
							$('.fine_pay_msg').html('<div class="alert alert-block alert-success"><button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>Success</strong>Your Transaction is Successfull . </p></div>');
							setTimeout(function(){
								location.reload();
							}, 4000);
							
						} else {								
							$('.fine_pay_msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i> Failed! </strong>Their is an error for this transaction<br></div>');
						}
					}
				}) 
			} else {				
				e.preventDefault();
			}
		});	
  </script>
	</body>

	</html>