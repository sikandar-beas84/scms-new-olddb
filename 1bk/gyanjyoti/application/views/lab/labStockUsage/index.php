			<style>
			    @media screen and (max-width: 600px) {
                    .unitBtn {
                      margin-left: 12px;
                      margin-top: 8px;
                    }
                }
                label.form-label {
                    color: #fff;
                    font-size: 14px;
                }
                th {
                    font-size: 15px !important;
                }
			</style>
			<div class=" my-5">


                    <form class="row g-3" method="post" action="<?php echo base_url('lab/labStockUsage/index') ?>/<?php if(isset($labstockusage_ds)){ echo $labstockusage_ds->id; } ?>" name="labstockusage" id="labstockusage">
                <div class="filter row mb-2 pb-4">
                <?php if ($this->session->flashdata('success_msg')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('success_msg'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error_msg')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error_msg'); ?>
                    </div>
                <?php endif; ?>

	                <div class="filter row mb-2 pb-4">

                        <div class="col-md-6">
                            <label for="bill_no" class="form-label">Bill No</label>
                            <select class="form-select" name="bill_no" id="bill_no">
                                <option value="0">--select--</option>
                                <?php foreach($requisition_list as $requisition){ ?>                                                
                                    <option data-item="<?=$requisition->item?>" data-due="<?=$requisition->due_qty?>" value="<?= $requisition->id ?>" <?php if(isset($labstockusage_ds)  && $labstockusage_ds->bill_no==$requisition->id){ echo "selected"; } ?>><?=$requisition->requisition_num?> - <?=$requisition->name?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label">Item Name</label>
                            <select class="form-select" name="name" id="name" required style="pointer-events: none;">
                                <option value="0">--Select--</option>
                                <?php foreach($item_list as $item){ ?>
                                    <option value="<?=$item->id?>" <?php if(isset($labstockusage_ds)  && $item->name==$labstockusage_ds->name){ echo "selected"; } ?>><?=$item->name?></option>
                                <?php } ?>
                            </select>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="getUnit();">Get Unit</button>
                        </div>

                        <div class="col-md-6">
                            <label for="unit_of_measure" class="form-label">Unit of Measure</label>
                            <input type="text" id="unit_of_measure" name="unit_of_measure" class="form-control" value="<?php if(isset($labstockusage_ds)){ echo $labstockusage_ds->unit_of_measure; } ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="datepicker" class="form-label">From Date</label>
                            <input type="text" id="datepicker" autocomplete="off" name="stock_date" value="<?php if(isset($labstockusage_ds)){ echo $labstockusage_ds->stock_date; } ?>" class="form-control" placeholder="--/--/----">
                        </div>

                        <div class="col-md-6">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="text" id="to_date" autocomplete="off" name="to_date" value="<?php if(isset($labstockusage_ds)){ echo $labstockusage_ds->to_date; } ?>" class="form-control" placeholder="--/--/----">
                        </div>

                        <div class="col-md-6">
                            <label for="class" class="form-label">Select Class</label>
                            <select class="form-select" id="class" name="class">
                                <?php foreach($class_list as $item){ ?>                                                
                                    <option value="<?=$item->class_name?>" <?php if(isset($labstockusage_ds)  && $item->class_name==$labstockusage_ds->class){ echo "selected"; } ?>><?=$item->class_name?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="teacher" class="form-label">Teacher</label>
                            <select class="form-select" name="teacher" id="teacher">
                                <option value="">--Select User--</option>
                                <?php foreach($user_list as $key=>$v): ?>
                                    <option value="<?=$key;?>" <?php if(isset($labstockusage_ds)  && $key==$labstockusage_ds->teacher){ echo "selected"; } ?>><?=$v;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="project_name" class="form-label">Laboratory Name</label>
                            <input type="text" id="project_name" name="project_name" class="form-control" value="<?php if(isset($labstockusage_ds)){ echo $labstockusage_ds->project_name; } ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="due_qty" class="form-label">Available Quantity</label>
                            <input type="number" id="due_qty" value="" readonly class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="item_qty" class="form-label">Consumed Material Quantity</label>
                            <input type="number" name="item_qty" id="item_qty" value="<?php if(isset($labstockusage_ds)){ echo $labstockusage_ds->item_qty; } ?>" min="1" class="form-control">
                        </div>
<!-- 
                        <div class="col-md-6">
                            <label for="damage" class="form-label">Damage <i class="fa fa-info-circle" data-bs-toggle="tooltip" title="Check if item is Consumable or Damaged"></i></label>
                            <input type="checkbox" name="damage" id="damage" value="1">
                        </div> -->

                        <div class="col-12 mt-2">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit"></input>
                        </div>
                        </div>
                </div>
            </form>

    <!-- Stock Usage Table -->
    <div class="filter-info mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Name</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Class</th>
                        <th>Teacher</th>
                        <th>Laboratory Name</th>
                        <th>Consumed Material Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($labstockusage_list as $item) : ?>
                    <tr>
                        <td><?= $item->name ?></td>
                        <td><?= date('d-m-Y',strtotime($item->stock_date))?></td>
                        <td><?= date('d-m-Y',strtotime($item->to_date))?></td>
                        <td><?= $item->class ?></td>
                        <td><?= $item->teacher ?></td>
                        <td><?= $item->project_name ?></td>
                        <td><?= $item->item_qty ?></td>
                        <td>
                            <div class="action-buttons">
                                <a class="text-success" href="<?= base_url('lab/labStockUsage/index/'. $item->id) ?>">
                                     <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a class="text-danger" href="<?= base_url('lab/deletelabStockUsage/'. $item->id) ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


            
		</div><!-- /.main-content -->
</div><!-- /.main-container -->
		<!--[if !IE]> -->
		<script>			
			$('#unit').hide();
			$('#due_qty_group').hide();
			$('#name').change(function(){
				var item_id = $(this).find(':selected').val();				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('lab/labStockUsage/get_item_details'); ?>", 
					data:{item_id:item_id},
					dataType:"json",//return type expected as json
					success: function(data){
						
						$('#unit').show();
						$('#unit_of_measure').val(data.unit_of_measure);				   
					},
				});
			});	
		</script>
		<script>
        $(document).ready(function(){
            				$('#datepicker').datepicker({autoclose: true,todayHighlight: true,format: "dd-mm-yyyy"});				
            				$('#to_date').datepicker({autoclose: true,todayHighlight: true,format: "dd-mm-yyyy"});				
            $('#bill_no').change(function(){
                var selectedItem = $(this).find(':selected').data('item');
                var selectedDue = $(this).find(':selected').data('due');
            	$('#due_qty_group').show();
				$('#due_qty').val(selectedDue);
				$('#name').val(selectedItem);
                // $('#name option').each(function(){
                //     // If the value of the option matches the data-item value
                //     if($(this).val() == selectedItem){
                //         // Select this option
                //         $(this).prop('selected', true);
                //     }
                // });
            });
        });
        function getUnit(){
             var selectedDue = $("#bill_no").find(':selected').data('due');
            	$('#due_qty_group').show();
				$('#due_qty').val(selectedDue);
            	var item_id = $("#name").find(':selected').val();				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('lab/labStockUsage/get_item_details'); ?>", 
					data:{item_id:item_id},
					dataType:"json",//return type expected as json
					success: function(data){
						
						$('#unit').show();
						$('#unit_of_measure').val(data.unit_of_measure);				   
					},
				});
        }

</script>
	</body>
</html>			