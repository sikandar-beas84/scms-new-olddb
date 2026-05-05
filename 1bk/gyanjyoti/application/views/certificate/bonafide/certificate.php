
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
            <p>This is to certify that <?=$student->student_name; ?> Son / Daughter of <?=$student->father_name; ?> an inhabitant of <?=$student->permanent_address; ?>, Mobile No <?=$student->father_mobile_no; ?>, reads in <?=$student->class_name; ?> Section <?=$student->section_name; ?> Roll <?=$student->roll; ?> of our school / institution in the year <?=$student->start_year; ?> -<?=$student->end_year; ?></p>

            <p>His / Her school admission date is <?= date('d-M-Y', strtotime($student->admission_date)); ?> Admission no <?=$student->student_id; ?></p>

            <p>According to the admission register his / her date of birth is <?= date('d-M-Y', strtotime($student->dob)); ?></p>


            <p>He / She bears a good moral character and his / her antecedents are also good.</p>
        </div>

        <div class="principal-signature">
            <?php if($student->student_photo){ ?>
                <img src="<?=base_url(); ?>assets/uploads/student/<?=$student->student_photo; ?>" alt="Student Photo">
            <?php }else{ ?>
                <img src="<?=base_url(); ?>assets/noImageProfile.png" alt="Student Photo">
            <?php } ?>
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

