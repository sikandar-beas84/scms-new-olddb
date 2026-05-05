<div class="row" id="print">
    <?php foreach($student_list as $v){ 
         $student = $this->Student_model->get_students_full_details($v->id);
         $total_working_days = $this->Student_model->total_working_days($v->id);
         $total_present_days = $this->Student_model->total_present_days($v->id);
         $grades = $this->Generalmodel->getDataWhere('grades', ['session_year_id'=>get_session('session'), 'student_code'=> $student->student_code]);
        // pr($student);
        $classSelect = $student->c_id;
        // pr($classSelect);
        ?>

    <div class="col-md-12" style="margin-bottom: 29px;">
        <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" width="100%">
    </div>
    <div class="col-sm-12">

        <div class="">
            <div id="marks_list_new">
                <div class="col-lg-12 col-md-12 col-sm-12 row" style="background: #fff; padding-top: 11px;">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <p style="color: #061776;"><b>Name: </b><?=$student->student_name; ?></p>
                        <p style="color: #061776;"><b>Student id: </b><?=$student->student_code; ?></p>
                        <p style="color: #061776;"><b>Roll Number: </b><?=$student->roll; ?></p>
                        <p style="color: #061776;"><b>Class: </b><?=$student->class_name; ?></p>
                        <p style="color: #061776;"><b>Section: </b><?=$student->section; ?></p>
                        <p style="color: #061776;"><b>Session: </b><?=$student->start_year; ?>-<?=$student->end_year; ?></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 imgDiv"
                        style="text-align: center; margin-bottom: 12px;">
                        <?php if($student->student_photo){ ?>
                            <img src="<?=base_url();?>assets/uploads/student/<?=$student->student_photo; ?>"
                            class="stdimg" style="max-height: 172px;">
                        <?php }else{ ?>
                        <!--    <img src="<?=base_url();?>assets/noImage.jpg"-->
                        <!--class="stdimg" style="max-height: 172px;">-->
                        <?php } ?>

                    </div>
                </div>
                <div class="col-sm-12 no-padding-left no-padding-right">
                    <div class="col-sm-12 no-padding-left no-padding-right"></div>
                    <!--<table id="simple-table"-->
                    <!--    class="table text-center table-bordered table-hover">-->
                    <!--    <thead>-->

                    <!--        <tr>-->
                    <!--            <th>-->
                    <!--                <center>Total Working Days</center>-->
                    <!--            </th>-->
                    <!--            <th>-->
                    <!--                <center>Present Days</center>-->
                    <!--            </th>-->


                    <!--        </tr>-->
                    <!--    </thead>-->
                    <!--    <tbody>-->

                    <!--        <tr>-->
                    <!--            <td><?=$total_working_days;?></td>-->
                    <!--            <td><?=$total_present_days;?></td>-->


                    <!--        </tr>-->
                    <!--    </tbody>-->
                    <!--</table>-->
                </div>
                <div class="col-sm-12 no-padding-left no-padding-right">
                    <table id="simple-table"
                        class="table text-center table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th colspan="8">
                                    <center>
                                        <h3 class="m-0">Half Yearly Examination (2024-25)</h3>
                                    </center>
                                </th>
                            </tr>
                            <?php if($classSelect == 14 || $classSelect == 15){ ?>
                                <tr>
                                    <th><center>Scholastic Subject &amp; Other Subject</center></th>
                                    <th><center>Marks</center></th>
                                    <!-- <th><center>Total</center></th> -->
                                    <th><center>Grade</center></th>
                                </tr>
                            <?php }else{ ?>
                                <tr>
                                    <th><center>Scholastic Subject &amp; Other Subject</center></th>
                                    <th><center>PT I (5)</center></th>
                                    <th><center>M.A (5)</center></th>
                                    <th><center>P.F (5)</center></th>
                                    <th><center>S.E (5)</center></th>
                                    <th><center>H.E (80)</center></th>
                                    <th><center>Total</center></th>
                                    <th><center>Grade</center></th>
                                </tr>
                               
                            <?php } ?>
                        </thead>

                        <tbody>
                                <?php foreach($grades as $g){ 
                                    // Calculate the total with rounded values where needed
                                    $total = round(((int)$g->pt1 / 4)) + round((int)$g->ma) + round((int)$g->pf) + round((int)$g->se) + round((int)$g->he);

                                    // Determine the grade based on the total
                                    // if ($total >= 91) {
                                    //     $grade = 'A1';
                                    // } elseif ($total >= 81) {
                                    //     $grade = 'A2';
                                    // } elseif ($total >= 71) {
                                    //     $grade = 'B1';
                                    // } elseif ($total >= 61) {
                                    //     $grade = 'B2';
                                    // } elseif ($total >= 51) {
                                    //     $grade = 'C1';
                                    // } elseif ($total >= 41) {
                                    //     $grade = 'C2';
                                    // } elseif ($total >= 33) {
                                    //     $grade = 'D';
                                    // } else {
                                    //     $grade = 'E';
                                    // }
                                    
                                    //  // Custom grading for specific subjects
                                    //  $ma = '';
                                    // if (in_array(strtoupper($g->subject), ['COMPUTER', 'ART EDUCATION', 'LANGUAGE 3','GENERAL KNOWLEDGE','PHYSICAL EDUCATION'])) {
                                    //     if ($total >= 40) {
                                    //         $grade = 'A';
                                    //     } elseif ($total >= 30) {
                                    //         $grade = 'B';
                                    //     } elseif ($total >= 1) {
                                    //         $grade = 'C';
                                    //     } else {
                                    //         $grade = 'NA';
                                    //     }
                                    //     $ma = '(50)';
                                    // }
                                ?>
                                    <?php if($classSelect == 14 || $classSelect == 15){ ?>
                                        <tr>
                                            <?php if($g->he != 'NA'){ ?>
                                            <td><?= strtoupper($g->subject) ?? 'NA'; ?><?=$ma?></td>
                                            <td><?= ($g->he ?? 0) ? round($g->he) : 'NA'; ?></td>
                                            <td><?= $g->grade; ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td><?= $g->subject ? strtoupper($g->subject) : 'NA'; ?><?=$ma?></td>
                                            <td><?= ($g->pt1 ?? 0) ? round($g->pt1 / 4) : 'NA'; ?></td>
                                            <td><?= ($g->ma ?? 0) ? round($g->ma) : 'NA'; ?></td>
                                            <td><?= ($g->pf ?? 0) ? round($g->pf) : 'NA'; ?></td>
                                            <td><?= ($g->se ?? 0) ? round($g->se) : 'NA'; ?></td>
                                            <td><?= ($g->he ?? 0) ? round($g->he) : 'NA'; ?></td>
                                            <td><?= ($total ?? 0) ? round($total) : 'NA'; ?></td>
                                            <td><?= $g->grade; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>

                    </table>
                </div>
                <div style="width:100%;clear:both">
                    <p>Grading scale for Scholastic Areas-1(Main Subjects): (Maximum marks-100)
                        : 91-100: A1; 81-90: A2; 71-80: B1; 61-70: B2, 51-60: C1; 41-50: C2;
                        33-40: D; 32 &amp; below: E </p>
                    <p>Grading scale for Co Scholastic Areas-1: (Maximum marks-50)
                        : 40-50: A; 30-39: B; 1-29: C; </p>
                  
                </div>
                <div id="marks_list">
                    


                    
                </div>
                <div class="col-md-12"><img
                        src="<?=base_url(); ?>assets/uploads/RESULT.jpg"
                        width=""></div>
            </div>
        </div>
        <!-- <table style="width: 100%;">
            <tbody>
                <tr>
                    <td align="center">
                        <button type="button" id="inv_items" class="btn btn-success"><i
                                class="ace-icon glyphicon glyphicon-print"></i>&nbsp; print now</button>
                    </td>
                </tr>
            </tbody>
        </table> -->




    </div><!-- /.page-content -->
    <?php } ?>
</div>