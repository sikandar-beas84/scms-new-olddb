
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
    <div class="invoice-container">
        <header style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </header>

        <div class="student-details">
            <p><strong>Student Name:</strong> <?=$student[0]->student_name; ?></p>
            <p><strong>Class:</strong> <?=$class[0]->class_name; ?></p>
            <p><strong>Admission Number:</strong> <?=$student[0]->admission_form_no; ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Fee Description</th>
                    <th>Amount (INR)</th>
                </tr>
            </thead>
            <tbody id="fee-details">
                <tr>
                    <td>Session Charge</td>
                    <td id="session_fees"><?= $fees[0]->session_fees; ?></td>
                </tr>
                <tr>
                    <td>Admission Fees:</td>
                    <td id="academic_fees"><?= $fees[0]->academic_fees; ?></td>
                </tr>
                <tr>
                    <td>Tuition Fees:</td>
                    <td id="tuition_fees"><?= $fees[0]->tuition_fees; ?></td>
                </tr>
                <tr>
                    <td>Development Fees</td>
                    <td id="monthly_fees"><?= $fees[0]->monthly_fees; ?></td>
                </tr>
                <!--<tr>-->
                <!--    <td>Sports Fees</td>-->
                <!--    <td id="sports_fees"><?= $fees[0]->sports_fees; ?></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td>Library Fees</td>-->
                <!--    <td id="library_fees"><?= $fees[0]->library_fees; ?></td>-->
                <!--</tr>-->
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
                    <td><strong>Total</strong></td>
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
                <tr>
                    <td><strong>Payment Amount</strong></td>
                    <td id="total_fees">
                        <strong>
                            <?=$fees[0]->payment_amount_1st; ?>
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
            </tfoot>
        </table>
        <?php
        $collected_by = $this->Generalmodel->getDataWhere('staff',['id'=>$fees[0]->collected_by]);
        $print_by = $this->Generalmodel->getDataWhere('staff',['id'=>$this->session->userdata('user_id')]);
        ?>
        <p><strong>Collected By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ echo $collected_by[0]->first_name .' '.$collected_by[0]->last_name; } ?></p>
        <p><strong>Print By:</strong> <?php if(get_session('user_type') == 'super_admin'){ echo 'Super Admin';}else{ $print_by[0]->first_name .' '.$print_by[0]->last_name; } ?></p>
        <p><strong>Total Paid Amount (in Words):</strong> <?=convertNumberToWords($fees[0]->payment_amount_1st); ?></p>
        <p><b>Notice for fine:</b> After 15th of each month the late fine will be calculated Rs.50/- only for next 15 days. If any one fails those next 15 days then for another coming 15 days Rs.50/- will be calculated. So, 15+15+.... = Rs. 50+50+... </p>
        <footer style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterFooter.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </footer>
            <button type="button" id="print_btn" onclick="printInvoice()">Print Invoice</button>
        </div>

        <script>
function printInvoice() {
    // Hide the print button
    const printButton = document.getElementById('print_btn');
    printButton.style.display = 'none';

    // Get the invoice content
    const printContents = document.querySelector('.invoice-container').innerHTML;

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
