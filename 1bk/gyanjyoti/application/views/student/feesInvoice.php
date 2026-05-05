
<style>
/* body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
} */

/* .invoice-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
} */

header {
    text-align: center;
    margin-bottom: 20px;
}

header h1 {
    margin: 0;
    font-size: 24px;
}

.school-details p {
    margin: 0;
    font-size: 14px;
}

.student-details p {
    margin: 5px 0;
    font-size: 16px;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.invoice-table th,
.invoice-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.invoice-table th {
    background-color: #243448 ;
}

.invoice-table tfoot td {
    font-size: 18px;
    font-weight: bold;
}

/* button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
} */

button:hover {
    background-color: #45a049;
}
button#paymentcloseModalBtn:hover {
    background: none;
}
button#paymentcloseModalBtn {
    text-align: end;
}
    </style>
    <div class="invoice-container invoice-container-one">
        <header style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </header>

        <div class="student-details">
            <?php if($fees[0]->month == 4){ ?>
            <p class="text-center"><strong>Admission Bill</strong> </p>
            <?php } ?>
            <p><strong>Transaction Id:</strong> <?=$fees[0]->transaction_id; ?></p>
            <p><strong>Session:</strong> <?=$session[0]->start_year; ?> - <?=$session[0]->end_year; ?></p>
            <p><strong>Student Name:</strong> <?=$student->student_name; ?></p>
            <p><strong>Class:</strong> <?=$student->class_name; ?></p>
            <p><strong>Section:</strong> <?=$student->section_name; ?></p>
            <p><strong>Roll:</strong> <?=$student->roll; ?></p>
            <p><strong>Student ID:</strong> <?=$student->student_code; ?></p>
            <!--<p><strong>Tuition Fees:</strong> ₹<?=number_format($fees[0]->tuition_fees, 2); ?></p>-->
            <!--<p><strong>Fine:</strong> ₹<?=number_format($fees[0]->fine, 2); ?></p>-->
            <!--<p><strong>Total Amount:</strong> ₹<?=number_format($fees[0]->total_amount, 2); ?></p>-->
            
            <p><strong>Payment Mode:</strong> <?php if($fees[0]->payment_type == 1){ echo 'Cash';}elseif($fees[0]->payment_type == 2){ echo 'QR';}else{echo 'Online Eazy Pay';} ?> </p>
            <p><strong>Date and Time:</strong> <?=date('d-m-Y H:i:s A', strtotime($fees[0]->payment_date)); ?></p>
            <p><strong>Month Paid For:</strong> <?=date('F', mktime(0, 0, 0, $fees[0]->month, 1)); ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Fee Description</th>
                    <th>Amount (INR)</th>
                </tr>
            </thead>
            <tbody id="fee-details">
                <!--<?php if($fees[0]->month == 4){ ?>-->
                <tr>
                    <td>Session Charge</td>
                    <td id="session_fees"><?= $fees[0]->session_fees; ?></td>
                </tr>
                <tr>
                    <td>Admission Fees</td>
                    <td id="academic_fees"><?= $fees[0]->academic_fees; ?></td>
                </tr>
                
                <!--<?php } ?>-->
                <tr>
                    <td>Tuition Fees</td>
                    <td id="tuition_fees"><?= $fees[0]->tuition_fees; ?></td>
                </tr>
                <tr>
                    <td>Development Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <!-- <?php if($fees[0]->month == 4){ ?>
                <tr>
                    <td>Monthly Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <tr>
                    <td>Sports Fees</td>
                    <td id="sports_fees"><?= $fees[0]->sports_fees; ?></td>
                </tr>
                <tr>
                    <td>Library Fees</td>
                    <td id="library_fees"><?= $fees[0]->library_fees; ?></td>
                </tr>
                <?php } ?>-->
                <tr>
                    <td>Misc.Fees</td>
                    <td id="other_curriculum_fees"><?= $fees[0]->other_curriculum_fees; ?></td>
                </tr>
                <tr>
                    <td>Fine</td>
                    <td id="fine"><?= $fees[0]->fine; ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?php
                                $total_fees = $fees[0]->session_fees 
                                            + $fees[0]->academic_fees 
                                            + $fees[0]->tuition_fees 
                                            + $fees[0]->monthly_fees 
                                            + $fees[0]->sports_fees 
                                            + $fees[0]->library_fees 
                                            + $fees[0]->other_curriculum_fees 
                                            + $fees[0]->fine 
                                            + $fees[0]->lab_fees;
                                echo $total_fees;
                            ?>
                        </strong>
                    </td>
                </tr>
                <?php if($fees[0]->month == 4){ ?>
                <tr>
                    <td><strong>Payment Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?php
                                
                                echo $fees[0]->payment_amount_1st ;
                            ?>
                        </strong>
                    </td>
                </tr>
                 <tr>
                    <td><strong>Remaining Balance</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?=$total_fees - ($fees[0]->payment_amount_1st); ?>
                        </strong>
                    </td>
                </tr>
                <?php } ?>
            </tfoot>
        </table>
        <?php
        $collected_by = $this->Generalmodel->getDataWhere('staff',['id'=>$fees[0]->collected_by]);
        $print_by = $this->Generalmodel->getDataWhere('staff',['id'=>$this->session->userdata('user_id')]);
        ?>
        <p><strong>Collected By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ echo $collected_by[0]->first_name .' '.$collected_by[0]->last_name; } ?></p>
        <p><strong>Print By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ $print_by[0]->first_name .' '.$print_by[0]->last_name; } ?></p>
<p><strong>Total Paid Amount (in Words):</strong> <?=convertNumberToWords($fees[0]->payment_amount_1st); ?></p>
<p>N.B: This is a system generated receipt, Stamp & Signature not require.</p>
        <footer style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterFooter.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </footer>
        <button type="button" id="print_btn" onclick="printInvoice('invoice-container-one')" style="margin-bottom: 10px;">Print Invoice</button>
        </div>

<?php if($fees[0]->payment_amount_2nd != 0 && $fees[0]->payment_amount_2nd != null ){  ?>
    <div class="invoice-container invoice-container-two">
        <header style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </header>

        <div class="student-details">
            <?php if($fees[0]->month == 4){ ?>
            <p class="text-center"><strong>Admission Bill</strong> </p>
            <?php } ?>
            <p><strong>Transaction Id:</strong> <?=$fees[0]->transaction_id_2nd; ?></p>
            <p><strong>Session:</strong> <?=$session[0]->start_year; ?> - <?=$session[0]->end_year; ?></p>
            <p><strong>Student Name:</strong> <?=$student->student_name; ?></p>
            <p><strong>Class:</strong> <?=$student->class_name; ?></p>
            <p><strong>Section:</strong> <?=$student->section_name; ?></p>
            <p><strong>Roll:</strong> <?=$student->roll; ?></p>
            <p><strong>Student ID:</strong> <?=$student->student_code; ?></p>
            <!--<p><strong>Tuition Fees:</strong> ₹<?=number_format($fees[0]->tuition_fees, 2); ?></p>-->
            <!--<p><strong>Fine:</strong> ₹<?=number_format($fees[0]->fine, 2); ?></p>-->
            <!--<p><strong>Total Amount:</strong> ₹<?=number_format($fees[0]->total_amount, 2); ?></p>-->
            
            <p><strong>Payment Mode:</strong> <?php if($fees[0]->payment_type_2nd == 1){ echo 'Cash';}elseif($fees[0]->payment_type_2nd == 2){ echo 'QR';}else{echo 'Online Eazy Pay';} ?> </p>
            <p><strong>Date and Time:</strong> <?=date('d-m-Y H:i:s A', strtotime($fees[0]->payment_date_2nd)); ?></p>
            <p><strong>Month Paid For:</strong> <?=date('F', mktime(0, 0, 0, $fees[0]->month, 1)); ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Fee Description</th>
                    <th>Amount (INR)</th>
                </tr>
            </thead>
            <tbody id="fee-details">
                <!--<?php if($fees[0]->month == 4){ ?>-->
                <tr>
                    <td>Session Charge</td>
                    <td id="session_fees"><?= $fees[0]->session_fees; ?></td>
                </tr>
                <tr>
                    <td>Admission Fees</td>
                    <td id="academic_fees"><?= $fees[0]->academic_fees; ?></td>
                </tr>
                <!--<?php } ?>-->
               <tr>
                    <td>Tuition Fees</td>
                    <td id="tuition_fees"><?= $fees[0]->tuition_fees; ?></td>
                </tr>
                <tr>
                    <td>Development Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <!-- <?php if($fees[0]->month == 4){ ?>
                <tr>
                    <td>Monthly Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <tr>
                    <td>Sports Fees</td>
                    <td id="sports_fees"><?= $fees[0]->sports_fees; ?></td>
                </tr>
                <tr>
                    <td>Library Fees</td>
                    <td id="library_fees"><?= $fees[0]->library_fees; ?></td>
                </tr>
                <?php } ?>-->
                <tr>
                    <td>Misc.Fees</td>
                    <td id="other_curriculum_fees"><?= $fees[0]->other_curriculum_fees; ?></td>
                </tr>
                <tr>
                    <td>Fine</td>
                    <td id="fine"><?= $fees[0]->fine; ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?php
                                $total_fees = $fees[0]->session_fees 
                                            + $fees[0]->academic_fees 
                                            + $fees[0]->tuition_fees 
                                            + $fees[0]->monthly_fees 
                                            + $fees[0]->sports_fees 
                                            + $fees[0]->library_fees 
                                            + $fees[0]->other_curriculum_fees 
                                            + $fees[0]->fine 
                                            + $fees[0]->lab_fees;
                                echo $total_fees;
                            ?>
                        </strong>
                    </td>
                </tr>
                <?php if($fees[0]->month == 4){ ?>
                <tr>
                    <td><strong>Payment Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?php
                                
                                echo $fees[0]->payment_amount_2nd ;
                            ?>
                        </strong>
                    </td>
                </tr>
                 <tr>
                    <td><strong>Remaining Balance</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?=$total_fees - ($fees[0]->payment_amount_2nd + $fees[0]->payment_amount_1st); ?>
                        </strong>
                    </td>
                </tr>
                <?php } ?>
            </tfoot>
        </table>
        <?php
        $collected_by = $this->Generalmodel->getDataWhere('staff',['id'=>$fees[0]->collected_by_2nd]);
        $print_by = $this->Generalmodel->getDataWhere('staff',['id'=>$this->session->userdata('user_id')]);
        ?>
        <p><strong>Collected By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ echo $collected_by[0]->first_name .' '.$collected_by[0]->last_name; } ?></p>
        <p><strong>Print By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ $print_by[0]->first_name .' '.$print_by[0]->last_name; } ?></p>
        <p><strong>Total Paid Amount (in Words):</strong> <?=convertNumberToWords($fees[0]->payment_amount_2nd); ?></p>
        <p>N.B: This is a system generated receipt, Stamp & Signature not require.</p>
        <footer style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterFooter.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </footer>
        <button type="button" id="print_btn" onclick="printInvoice('invoice-container-two')" style="margin-bottom: 10px;">Print Invoice</button>
        </div>
<?php }  ?>

<?php if($fees[0]->payment_amount_3rd != 0){  ?>
    <div class="invoice-container invoice-container-three">
        <header style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </header>

        <div class="student-details">
            <?php if($fees[0]->month == 4){ ?>
            <p class="text-center"><strong>Admission Bill</strong> </p>
            <?php } ?>
            <p><strong>Transaction Id:</strong> <?=$fees[0]->transaction_id_3rd; ?></p>
            <p><strong>Session:</strong> <?=$session[0]->start_year; ?> - <?=$session[0]->end_year; ?></p>
            <p><strong>Student Name:</strong> <?=$student->student_name; ?></p>
            <p><strong>Class:</strong> <?=$student->class_name; ?></p>
            <p><strong>Section:</strong> <?=$student->section_name; ?></p>
            <p><strong>Roll:</strong> <?=$student->roll; ?></p>
            <p><strong>Student ID:</strong> <?=$student->student_code; ?></p>
            <!--<p><strong>Tuition Fees:</strong> ₹<?=number_format($fees[0]->tuition_fees, 2); ?></p>-->
            <!--<p><strong>Fine:</strong> ₹<?=number_format($fees[0]->fine, 2); ?></p>-->
            <!--<p><strong>Total Amount:</strong> ₹<?=number_format($fees[0]->total_amount, 2); ?></p>-->
            
            <p><strong>Payment Mode:</strong> <?php if($fees[0]->payment_type_3rd == 1){ echo 'Cash';}elseif($fees[0]->payment_type_3rd == 2){ echo 'QR';}else{echo 'Online Eazy Pay';} ?> </p>
            <p><strong>Date and Time:</strong> <?=date('d-m-Y H:i:s A', strtotime($fees[0]->payment_date_3rd)); ?></p>
            <p><strong>Month Paid For:</strong> <?=date('F', mktime(0, 0, 0, $fees[0]->month, 1)); ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Fee Description</th>
                    <th>Amount (INR)</th>
                </tr>
            </thead>
            <tbody id="fee-details">
                <!--<?php if($fees[0]->month == 4){ ?>-->
                <tr>
                    <td>Session Charge</td>
                    <td id="session_fees"><?= $fees[0]->session_fees; ?></td>
                </tr>
                <tr>
                    <td>Admission Fees</td>
                    <td id="academic_fees"><?= $fees[0]->academic_fees; ?></td>
                </tr>
                <!--<?php } ?>-->
                <tr>
                    <td>Tuition Fees</td>
                    <td id="tuition_fees"><?= $fees[0]->tuition_fees; ?></td>
                </tr>
                <tr>
                    <td>Development Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <!-- <?php if($fees[0]->month == 4){ ?>
                <tr>
                    <td>Monthly Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <tr>
                    <td>Sports Fees</td>
                    <td id="sports_fees"><?= $fees[0]->sports_fees; ?></td>
                </tr>
                <tr>
                    <td>Library Fees</td>
                    <td id="library_fees"><?= $fees[0]->library_fees; ?></td>
                </tr>
                <?php } ?>-->
                <tr>
                    <td>Misc.Fees</td>
                    <td id="other_curriculum_fees"><?= $fees[0]->other_curriculum_fees; ?></td>
                </tr>
                <tr>
                    <td>Fine</td>
                    <td id="fine"><?= $fees[0]->fine; ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?php
                                $total_fees = $fees[0]->session_fees 
                                            + $fees[0]->academic_fees 
                                            + $fees[0]->tuition_fees 
                                            + $fees[0]->monthly_fees 
                                            + $fees[0]->sports_fees 
                                            + $fees[0]->library_fees 
                                            + $fees[0]->other_curriculum_fees 
                                            + $fees[0]->fine 
                                            + $fees[0]->lab_fees;
                                echo $total_fees;
                            ?>
                        </strong>
                    </td>
                </tr>
                <?php if($fees[0]->month == 4){ ?>
                <tr>
                    <td><strong>Payment Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?php
                                
                                echo $fees[0]->payment_amount_3rd ;
                            ?>
                        </strong>
                    </td>
                </tr>
                 <tr>
                    <td><strong>Remaining Balance</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?=$total_fees - ($fees[0]->payment_amount_1st + $fees[0]->payment_amount_2nd + $fees[0]->payment_amount_3rd); ?>
                        </strong>
                    </td>
                </tr>
                <?php } ?>
            </tfoot>
        </table>
        <?php
        $collected_by = $this->Generalmodel->getDataWhere('staff',['id'=>$fees[0]->collected_by_3rd]);
        $print_by = $this->Generalmodel->getDataWhere('staff',['id'=>$this->session->userdata('user_id')]);
        ?>
        <p><strong>Collected By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ echo $collected_by[0]->first_name .' '.$collected_by[0]->last_name; } ?></p>
        <p><strong>Print By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ $print_by[0]->first_name .' '.$print_by[0]->last_name; } ?></p>
        <p><strong>Total Paid Amount (in Words):</strong> <?=convertNumberToWords($fees[0]->payment_amount_3rd); ?></p>
        <p>N.B: This is a system generated receipt, Stamp & Signature not require.</p>
        <footer style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterFooter.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </footer>
        <button type="button" id="print_btn" onclick="printInvoice('invoice-container-three')" style="margin-bottom: 10px;">Print Invoice</button>
        </div>
<?php }  ?>
        <script>
function printInvoice(classid) {
    // Hide the print button
    const printButton = document.getElementById('print_btn');
    printButton.style.display = 'none';

    // Get the invoice content
    const printContents = document.querySelector('.'+classid).innerHTML;

    // Open a new window
    const printWindow = window.open('', '', 'height=600,width=800', 'noopener,noreferrer');

    // Write the content to the new window
    printWindow.document.write('<html><head><title>Print Invoice</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body{ font-family: Arial, sans-serif; }');
    printWindow.document.write('.invoice-container { padding: 20px; border-radius: 8px; width: 100%; }');
    printWindow.document.write('header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('header h1 { margin: 0; font-size: 24px; }');
    printWindow.document.write('.school-details p, .student-details p { margin: 0; font-size: 14px; }');
    printWindow.document.write('.invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }');
    printWindow.document.write('.invoice-table th, .invoice-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('.invoice-table th { background-color: #f2f2f2; }');
    printWindow.document.write('.invoice-table tfoot td { font-size: 18px; font-weight: bold; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');

    // Wait for the new window to fully load the content before printing
    printWindow.document.close();

    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        
        // Show the button again after the print dialog is closed
        printWindow.onafterprint = function() {
            printButton.style.display = 'block';
            printWindow.close();
        };
        
        // Show the button again if the print dialog is cancelled
        printWindow.onabort = function() {
            printButton.style.display = 'block';
            printWindow.close();
        };
        printButton.style.display = 'block';
    };
}
</script>
