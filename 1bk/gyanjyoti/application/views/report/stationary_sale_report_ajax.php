<!-- Stats Cards -->
<style>.card.listTableArea th, .card.listTableArea td {
    font-size: 13px;
}</style>
<div class="row g-4 mb-4">
            <div class="col-md-4 col-lg-3">
                <div class="card stat-card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Payment Received</h6>
                                <h3 class="mb-0"><?=$total_payment_received ?? 0; ?></h3>
                            </div>
                            <div class="icon-bg bg-primary-subtle">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="card listTableArea" >
                    <div class="card-body">
                        
                        <table class="table w-100" id="listTableReport">
                            <thead class="bg-primary text-white table-dark">
                                <tr>
                                <th style="color: #fff !important;!i;!;">#</th>
                                    <th style="color: #fff !important;!i;!;">Student code</th>
                                    <th style="color: #fff !important;!i;!;">Name</th>
                                    <th style="color: #fff !important;!i;!;">Item</th>
                                    <th style="color: #fff !important;!i;!;">Price </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_stationary_sale as $k=>$v){ 
                                    $student = $this->Student_model->get_students_full_details_by_code($v->student_code);
                                    $stationary_purchase_item = $this->Generalmodel->getDataWhere('stationary_purchase_item',['order_id'=>$v->id]);
                                    
                                    ?>
                                    <tr>
                                        <td><?=$k+1;?></td>
                                        <td><?=$v->student_code;?></td>
                                        <td><?=$student->student_name;?></td>
                                        <td>
                                        <?php foreach($stationary_purchase_item as $sv){
                                            $item = $this->Inventory_model->get_item_by_item_id($sv->item);
                                                // prx($item);
                                            ?>    
                                        <li><?=$item[0]->item_name;?></li>
                                        <?php } ?>
                                        </td>
                                        <td><?=$v->amount;?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                          
                            </table>
                        </div>
                    </div>
                    
                    
                    
                </div>

                