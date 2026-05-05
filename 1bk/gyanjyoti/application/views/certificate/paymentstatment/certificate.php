
<style>
    .certificate {
        background-color: white;
        border: 2px solid #004080;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        text-align: center;
        position: relative;
    }
    .certificate::before,
    .certificate::after {
        content: '';
        position: absolute;
        border: 2px solid #004080;
        left: -10px;
        right: -10px;
        top: -10px;
        bottom: -10px;
        z-index: -1;
    }
    .certificate::after {
        transform: rotate(1deg);
    }
    .student-details {
        text-align: left;
        margin-bottom: 30px;
    }
    .principal-signature {
        margin-top: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: bold;
    }
    .principal-signature img {
            width: 155px;
            height: 164px;
            object-fit: cover;
            margin-right: 20px;
            border: 2px solid #004080;
            /* border-radius: 50%; */
        }
    .print-btn {
        margin-top: -18px;
        text-align: right;
    }
    .print-btn button {
        background-color: #004080;
        color: white;
        border: none;
        /* padding: 10px 20px; */
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }
    .print-btn button:hover {
        background-color: #003060;
    }
    @media print {
        /* #getStudent {
            visibility: hidden;
        } */
        /* .certificate, .certificate * {
            visibility: visible;
        }
        .certificate {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 auto;
        } */
        .print-btn, .filter, .page-header  {
            display: none;
        }
        .page-header.d-xl-flex.d-block {
            display: none !important;
        }
    }
</style>

<div class="container">
    <div class="certificate">
        <header style="max-width: 100%;">
            <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" style="max-width: 100%;">
        </header>
        <div class="student-details">
            <table class="table table-striped table-bordered" id="listTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <!-- <th>-->
                            <!--    <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">-->
                            <!--</th>-->
                            <th>Month</th>
                             <th>Admission Fees</th>
                            <th>Session Fees</th>
                            <th>Tuition Fees</th>
                            <th>Development Fees</th>
                            <th>Misc.Fees</th>
                            <th>Fine Amount</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Remaining Amount</th>
                            <th>Payment Date</th>
                            <!--<th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($fees as $v): ?>
                        <tr>
                            <!-- <td>-->
                            <!--    <?php if($v->payment_status == 'Y'): ?>    -->
                            <!--        <input type="checkbox" checked disabled>-->
                            <!--    <?php else: ?>    -->
                            <!--        <input type="checkbox" class="fee-checkbox" data-id="<?= $v->id ?>" onclick="togglePayOptions()">-->
                            <!--    <?php endif; ?>  -->
                            <!--</td> -->
                            <td>
                                <?php
                                    $dateObj = DateTime::createFromFormat('!m', $v->month);
                                    echo $dateObj->format('F');
                                ?>
                            </td>
                            <td><?= $v->academic_fees ?></td>
                            <td><?= $v->session_fees ?></td>
                            <td><?= $v->tuition_fees ?></td>
                            <td><?= $v->monthly_fees ?></td>
                            <td><?= $v->other_curriculum_fees ?></td>
                            <td><?= $v->fine ?></td>
                            <td><?= $v->session_fees + $v->academic_fees + $v->tuition_fees + $v->monthly_fees + $v->sports_fees + $v->library_fees + $v->lab_fees + $v->other_curriculum_fees + $v->fine ?></td>
                            <td><?= $v->payment_amount_1st + $v->payment_amount_2nd + $v->payment_amount_3rd ?></td>
                            <td><?= ($v->session_fees + $v->academic_fees + $v->tuition_fees + $v->monthly_fees + $v->sports_fees + $v->library_fees + $v->lab_fees + $v->other_curriculum_fees + $v->fine) - ($v->payment_amount_1st + $v->payment_amount_2nd + $v->payment_amount_3rd) ?></td>
                            <td><?= $v->payment_date ? date('d-M-Y h:i A', strtotime($v->payment_date)) : '_ _ _'; ?></td>
                            <!--<td>-->
                            <!--    <?php if($v->payment_status == 'Y'): ?>    -->
                            <!--        <a href="javascript:" class="btn btn-outline-success btn-xs" onclick="getInvoice(<?= $v->id ?>)"><i class="fas fa-file-invoice"></i><i class="fa fa-file-text-o " aria-hidden="true"></i></a>-->
                            <!--    <?php else: ?>    -->
                                    <!--<a href="javascript:" class="btn btn-outline-danger btn-xs" onclick="action(<?= $v->id ?>)"><i class="fa fa-credit-card " aria-hidden="true"></i></a>-->
                            <!--    <?php endif; ?>  -->
                            <!--</td>-->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>

        <div class="principal-signature">
            <!--  
                <?php if($student->student_photo){ ?>
                    <img src="<?=base_url(); ?>assets/uploads/student/<?=$student->student_photo; ?>" alt="Student Photo">
                <?php }else{ ?>
                    <img src="<?=base_url(); ?>assets/noImageProfile.png" alt="Student Photo">
                <?php } ?>
            -->
            <div>
                MR SAIKAT CHAKRAVORTY<br>
                [PRINCIPAL]
            </div>
        </div>

        <div class="print-btn">
            <button onclick="window.print();">Print Certificate</button>
        </div>
    </div>
</div>

