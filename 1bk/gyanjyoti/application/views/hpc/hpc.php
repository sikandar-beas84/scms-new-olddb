<link rel="stylesheet" href="<?=base_url();?>assets/css/hpc.css" />
<style>
.table-header {
    height: 55px;
    padding-top: 9px;
}

@media screen and (max-width: 780px) {
    table {
        display: block;
        overflow: scroll;
    }

    .table-header {
        height: auto;
        padding-top: 9px;
        /* padding: 26px; */
        padding-right: 15px;

    }

    select#pick {
        width: 100%;
    }

    button#filter {
        margin-right: 15px;
        /* padding-right: 13px !important; */
        margin-top: 10px;
    }

    fieldset.feedbacktech .row {
        display: flex;
    }

    .table-header .row,
    .partA .row {
        display: block;
    }
}

.main-content {
    display: flex;
}
label.form-label {
    font-size: 12px;
}
</style>


<form id="hpcform" method="post" action="<?= base_url('Hpc/view/save') ?>">

    <!-- progressbar -->
    <ul id="progressbar">
        <li class="active" id="partA"><strong>PART-A(1)</strong></li>
        <li id="partA2" class=""><strong>PART-A(2)</strong></li>
        <li id="partB"><strong>DOMAIN 1</strong></li>
        <li id="teacherFed"><strong>TEACHER'S FEEDBACK</strong></li>
        <li id="domain2"><strong>DOMAIN 2</strong></li>
        <li id="teacherFed2"><strong>TEACHER'S FEEDBACK</strong></li>
        <li id="domain3"><strong>DOMAIN 3</strong></li>
        <li id="teacherFed3"><strong>TEACHER'S FEEDBACK</strong></li>
        <li id="domain4"><strong>DOMAIN 4</strong></li>
        <li id="teacherFed4"><strong>TEACHER'S FEEDBACK</strong></li>
        <li id="domain5"><strong>DOMAIN 5</strong></li>
        <li id="teacherFed5"><strong>TEACHER'S FEEDBACK</strong></li>
        <li id="domain51"><strong>DOMAIN 5.1</strong></li>
        <li id="teacherFed51"><strong>TEACHER'S FEEDBACK</strong></li>
        <li id="partC"><strong>PART C</strong></li>
    </ul>
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0"
            aria-valuemax="100" style="width: 25%;"></div>
    </div> <br> <!-- fieldsets -->
    <fieldset style="position: relative; opacity: 1;">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">PART-A(1):</h2>
                </div>

            </div>
            <div class="partA">




                <!--<span class="boldText">PART-A(1)</span>-->
                <div class="row">
                    <div class="col-md-12 border border-dark rounded row mt-3">
                        <div class="col-md-3">
                            <label for="schoolAddress" class="form-label d-flex">Name and Address of the School:</label>
                        </div>
                        <div class="col-md-5 pt-1">
                            <input type="text" name="school_address" class="form-control" id="schoolAddress"
                                aria-describedby="schoolAddressHelp" value="Gyanjyoti Public School" readonly>
                            <span class="required-message" style="display: none;">This field is required.</span>
                        </div>
                        <div class="col-md-1">
                            <label for="pinCode" class="form-label d-flex">Pin Code:</label>
                        </div>
                        <div class="col-md-3 pt-1">
                            <input type="text" name="pin_code" class="form-control" id="pinCode"
                                aria-describedby="pinCodeHelp" value="" readonly>
                            <span class="required-message" style="display: none;">This field is required.</span>
                        </div>
                        <div class="col-md-2">
                            <label for="udiseCode" class="form-label d-flex">UDISE Code:</label>
                        </div>
                        <div class="col-md-5 pt-1">
                            <input type="text" name="udise_code" class="form-control" id="udiseCode"
                                aria-describedby="udiseCodeHelp" value="" readonly>
                            <span class="required-message" style="display: none;">This field is required.</span>
                        </div>
                        <div class="col-md-2">
                            <label for="teacherCode" class="form-label d-flex">Teacher Code:</label>
                        </div>
                        <div class="col-md-3 pt-1">
                            <input type="text" name="teacher_code" class="form-control" id="teacherCode"
                                aria-describedby="teacherCodeHelp">
                            <span class="required-message" style="display: none;">This field is required.</span>
                        </div>
                        <div class="col-md-2">
                            <label for="apaarId" class="form-label d-flex">APAAR ID:</label>
                        </div>
                        <div class="col-md-5 pt-1">
                            <input type="text" name="apaar_id" class="form-control" id="apaarId"
                                aria-describedby="apaarIdHelp" value="NA" readonly>
                            <span class="required-message" style="display: none;">This field is required.</span>
                        </div>
                    </div>

                    <hr>
                    <div class="genHed">
                        <span class="boldText">GENERAL INFORMATION</span>
                        <h5>(To be filled by the teacher in consultation with caregiver/parent)</h5>
                    </div>
                    <?php
$student = $student; // Assuming $student is an array with the first element as an object
// pr($student);
?>
                    <input type="hidden" name="student_code" value="<?=$student->student_code; ?>">
                    <input type="hidden" name="class_id" value="<?= $this->input->post('class') ?>">
                    <div class="col-md-12 border border-dark rounded row mt-3">
                        <div class="col-md-8">
                            <!-- Student Name -->
                            <div class="mb-3 row">
                                <label for="studentName" class="col-md-2 col-form-label">Student Name:</label>
                                <div class="col-md-10">
                                    <input type="text" name="student_name" class="form-control" id="studentName"
                                        value="<?= htmlspecialchars($student->student_name ?: $hpc[0]->student_name); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Roll No -->
                            <div class="mb-3 row">
                                <label for="rollNo" class="col-md-2 col-form-label">Roll No:</label>
                                <div class="col-md-3">
                                    <input type="text" name="roll_no" class="form-control" id="rollNo"
                                        value="<?= htmlspecialchars($student->roll ?: $hpc[0]->roll_no); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Registration No -->
                            <div class="mb-3 row">
                                <label for="regNo" class="col-md-2 col-form-label">Registration No.:</label>
                                <div class="col-md-5">
                                    <input type="text" name="registration_no" class="form-control" id="regNo"
                                        value="<?= htmlspecialchars($student->student_code ?: $hpc[0]->registration_no); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Class -->
                            <div class="mb-3 row">
                                <label for="classOption" class="col-md-2 col-form-label">Class:</label>
                                <div class="col-md-10">
                                    <?php 
                // $classes = ['BV1', 'BV2', 'BV3', 'Grade 1', 'Grade 2'];
                 foreach($class as $key=>$v) { 
                    $checked = ($k == ($student->class ?: $hpc[0]->class_id)) ? 'checked' : ''; 
                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="" type="radio" name="class_option" id="class<?= $v ?>"
                                            value="<?= $k ?>" <?= $checked; ?>>
                                        <label class="form-check-label" for="class<?= $v ?>"><?= $v ?></label>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Section -->
                            <div class="mb-3 row">
                                <label for="section" class="col-md-2 col-form-label">Section:</label>
                                <div class="col-md-5">
                                    <input type="text" name="section" class="form-control" id="section"
                                        value="<?= htmlspecialchars($student->section_name ?: $hpc[0]->section); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-3 row">
                                <label for="dob" class="col-md-2 col-form-label">Date of Birth:</label>
                                <div class="col-md-3">
                                    <input type="date" name="dob" class="form-control" id="dob"
                                        value="<?= htmlspecialchars($student->d_o_b ?: $hpc[0]->dob); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3 row">
                                <label for="address" class="col-md-2 col-form-label">Address:</label>
                                <div class="col-md-5">
                                    <textarea name="address" class="form-control" id="address"
                                        rows="2"><?= htmlspecialchars($student->permanent_address ?: $hpc[0]->address); ?></textarea>
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3 row">
                                <label for="phone" class="col-md-1 col-form-label">Phone:</label>
                                <div class="col-md-4">
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        value="<?= htmlspecialchars($student->telephone_resi ?: $hpc[0]->phone); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <?php if($student->student_photo){ ?>
                                    <img  class="studentImg img-fluid" src="<?=base_url(); ?>assets/uploads/student/<?=jd($student->student_photo)[0]; ?>" alt="Student Photo">
                                <?php }else{ ?>
                                    <img class="studentImg img-fluid"  src="<?=base_url(); ?>assets/noImageProfile.png" alt="Student Photo">
                                <?php } ?>
                        </div>

                        <!-- Mother/Guardian Details -->
                        <div class="col-md-12 mt-3">
                            <!-- Mother Name -->
                            <div class="mb-3 row">
                                <label for="motherName" class="col-md-2 col-form-label">Mother/Guardian Name:</label>
                                <div class="col-md-10">
                                    <input type="text" name="mother_name" class="form-control" id="motherName"
                                        value="<?= htmlspecialchars($student->mother_name ?: $hpc[0]->mother_name); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Mother Education -->
                            <div class="mb-3 row">
                                <label for="motherEducation" class="col-md-2 col-form-label">Mother/Guardian
                                    Education:</label>
                                <div class="col-md-3">
                                    <input type="text" name="mother_education" class="form-control" id="motherEducation"
                                        value="<?= htmlspecialchars($student->mother_qualification ?: $hpc[0]->mother_education); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Mother Occupation -->
                            <div class="mb-3 row">
                                <label for="motherOccupation" class="col-md-3 col-form-label">Mother/Guardian
                                    Occupation:</label>
                                <div class="col-md-4">
                                    <input type="text" name="mother_occupation" class="form-control"
                                        id="motherOccupation"
                                        value="<?= htmlspecialchars($student->mother_occupation ?: $hpc[0]->mother_occupation); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Father/Guardian Details -->
                            <div class="mb-3 row">
                                <label for="fatherName" class="col-md-2 col-form-label">Father/Guardian Name:</label>
                                <div class="col-md-10">
                                    <input type="text" name="father_name" class="form-control" id="fatherName"
                                        value="<?= htmlspecialchars($student->father_name ?: $hpc[0]->father_name); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Father Education -->
                            <div class="mb-3 row">
                                <label for="fatherEducation" class="col-md-2 col-form-label">Father/Guardian
                                    Education:</label>
                                <div class="col-md-3">
                                    <input type="text" name="father_education" class="form-control" id="fatherEducation"
                                        value="<?= htmlspecialchars($student->father_qualification ?: $hpc[0]->father_education); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Father Occupation -->
                            <div class="mb-3 row">
                                <label for="fatherOccupation" class="col-md-3 col-form-label">Father/Guardian
                                    Occupation:</label>
                                <div class="col-md-4">
                                    <input type="text" name="father_occupation" class="form-control"
                                        id="fatherOccupation"
                                        value="<?= htmlspecialchars($student->father_occupation ?: $hpc[0]->father_occupation); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>

                            <!-- Siblings Count -->
                            <div class="mb-3 row">
                                <label for="siblingsCount" class="col-md-2 col-form-label">Number of Siblings:</label>
                                <div class="col-md-4">
                                    <input type="text" name="siblings_count" class="form-control" id="siblingsCount"
                                        value="<?= htmlspecialchars($student->siblings_count ?: $hpc[0]->siblings_count); ?>">
                                    <span class="required-message text-danger" style="display: none;">This field is
                                        required.</span>
                                </div>
                            </div>
                        </div>
                    </div>




                    <h3 class="boldText text-left">ATTENDANCE</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>MONTH</th>
                                <th>APR</th>
                                <th>MAY</th>
                                <th>JUNE</th>
                                <th>JUL</th>
                                <th>AUG</th>
                                <th>SEP</th>
                                <th>OCT</th>
                                <th>NOV</th>
                                <th>DEC</th>
                                <th>JAN</th>
                                <th>FEB</th>
                                <th>MAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="leftHed">No. of Working Days</td>
                                <?php
            foreach ($months as $key => $value) {
                echo "<td>{$value['workingDay']}</td>";
            }
            ?>
                            </tr>
                            <tr>
                                <td class="leftHed">No. of Days Attended</td>
                                <?php
            foreach ($months as $key => $value) {
                echo "<td>{$value['attendence']}</td>";
            }
            ?>
                            </tr>
                            <tr>
                                <td class="leftHed">% of Attendance</td>
                                <?php
            foreach ($months as $key => $value) {
                if ($value['workingDay'] > 0) {
                    $attendance_percentage = round(($value['attendence'] / $value['workingDay']) * 100, 2);
                    echo "<td>{$attendance_percentage}%</td>";
                } else {
                    echo "<td>0%</td>";
                }
            }
            ?>
                            </tr>
                            <tr>
                                <td class="leftHed">Reason for low attendance (if applicable)</td>
                                <td colspan="12">
                                    <textarea name="low_attendance_reason"
                                        style="width: 100%;"><?php echo htmlspecialchars($hpc[0]->low_attendance_reason); ?></textarea>
                                </td>
                            </tr>
                            <!-- Additional rows can be added here -->
                        </tbody>
                    </table>


                    <h3 class="boldText text-left">INTEREST (1 (the student) am interested in):</h3>
                    <div class="col-md-12 border border-dark rounded row mt-3">
                        <!-- Reading -->
                        <div class="col-md-2">
                            <label for="reading_interest" class="form-label d-flex">Reading:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_reading" id="reading_interest"
                                <?php echo (isset($hpc[0]->interest_reading) && $hpc[0]->interest_reading === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Music -->
                        <div class="col-md-4">
                            <label for="music_interest" class="form-label d-flex">Dancing, Singing, or Playing a musical
                                instrument:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_music" id="music_interest"
                                <?php echo (isset($hpc[0]->interest_music) && $hpc[0]->interest_music === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Sports -->
                        <div class="col-md-2">
                            <label for="sports_interest" class="form-label d-flex">Sport or Games:</label>
                        </div>
                        <div class="col-md-2 pt-1">
                            <input type="checkbox" name="interest_sports" id="sports_interest"
                                <?php echo (isset($hpc[0]->interest_sports) && $hpc[0]->interest_sports === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Writing -->
                        <div class="col-md-2">
                            <label for="writing_interest" class="form-label d-flex">Creative writing:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_writing" id="writing_interest"
                                <?php echo (isset($hpc[0]->interest_writing) && $hpc[0]->interest_writing === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Gardening -->
                        <div class="col-md-1">
                            <label for="gardening_interest" class="form-label d-flex">Gardening:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_gardening" id="gardening_interest"
                                <?php echo (isset($hpc[0]->interest_gardening) && $hpc[0]->interest_gardening === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Yoga -->
                        <div class="col-md-1">
                            <label for="yoga_interest" class="form-label d-flex">Yoga:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_yoga" id="yoga_interest"
                                <?php echo (isset($hpc[0]->interest_yoga) && $hpc[0]->interest_yoga === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Art -->
                        <div class="col-md-1">
                            <label for="art_interest" class="form-label d-flex">Art:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_art" id="art_interest"
                                <?php echo (isset($hpc[0]->interest_art) && $hpc[0]->interest_art === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Craft -->
                        <div class="col-md-1">
                            <label for="craft_interest" class="form-label d-flex">Craft:</label>
                        </div>
                        <div class="col-md-2 pt-1">
                            <input type="checkbox" name="interest_craft" id="craft_interest"
                                <?php echo (isset($hpc[0]->interest_craft) && $hpc[0]->interest_craft === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Cooking -->
                        <div class="col-md-1">
                            <label for="cooking_interest" class="form-label d-flex">Cooking:</label>
                        </div>
                        <div class="col-md-2 pt-1">
                            <input type="checkbox" name="interest_cooking" id="cooking_interest"
                                <?php echo (isset($hpc[0]->interest_cooking) && $hpc[0]->interest_cooking === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Regular Chores -->
                        <div class="col-md-5">
                            <label for="chores_interest" class="form-label d-flex">Regular chores at home with
                                significant others:</label>
                        </div>
                        <div class="col-md-1 pt-1">
                            <input type="checkbox" name="interest_chores" id="chores_interest"
                                <?php echo (isset($hpc[0]->interest_chores) && $hpc[0]->interest_chores === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Other -->
                        <div class="col-md-1">
                            <label for="other_interest" class="form-label d-flex">Other:</label>
                        </div>
                        <div class="col-md-2 pt-1">
                            <input type="checkbox" name="interest_other" id="other_interest"
                                <?php echo (isset($hpc[0]->interest_other) && $hpc[0]->interest_other === 'on') ? 'checked' : ''; ?>>
                        </div>

                        <!-- Specify Other Interests -->
                        <div class="col-md-2">
                            <label for="specify_interest" class="form-label d-flex">Please specify:</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <textarea name="interest_specify" id="specify_interest" rows="2" style="width:100%;">
                                        <?php echo isset($hpc[0]->interest_specify) ? htmlspecialchars($hpc[0]->interest_specify) : ''; ?>
                                    </textarea>
                        </div>
                    </div>

                </div>



            </div>
        </div> <input type="button" name="next" class="next action-button" value="Next">
    </fieldset>



    <!--/////////////////////////////////////////-->
    <fieldset style="display: none; opacity: 0; position: relative;">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">Part-A(2):</h2>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12 border border-dark rounded row mt-3">
                    <div class="col-md-1">
                        <label for="is_this" class="form-label d-flex">THIS IS</label>
                    </div>
                    <div class="col-md-5 pt-1">
                        <input type="text" name="this_is" class="form-control" id="is_this"
                            value="<?= isset($hpc[0]->this_is) ? $hpc[0]->this_is : '' ?>" aria-describedby="emailHelp">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                    <div class="col-md-1">
                        <label for="i_am" class="form-label d-flex">ME</label>
                    </div>
                    <div class="col-md-1 text-center">
                        <label for="i_am_years_old" class="form-label d-flex">I AM</label>
                    </div>
                    <div class="col-md-2 pt-1">
                        <input type="text" name="i_am_years_old" class="form-control" id="i_am_years_old"
                            value="<?= $age->y; ?>" aria-describedby="emailHelp">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                    <div class="col-md-2">
                        <label for="my_birthday" class="form-label d-flex">YEARS OLD.</label>
                    </div>
                    <div class="col-md-3">
                        <label for="birthday_date" class="form-label d-flex">My birthday is on:</label>
                    </div>
                    <div class="col-md-3 pt-1">
                        <input type="text" name="birthday_date" class="form-control" id="birthday_date"
                            value="<?= isset($hpc[0]->birthday_date) ? $hpc[0]->birthday_date : '' ?>"
                            aria-describedby="emailHelp">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>

                    <div class="col-md-1">
                        <label for="live_in" class="form-label d-flex">I live in</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="live_in" class="form-control" id="live_in"
                            value="<?= isset($hpc[0]->live_in) ? $hpc[0]->live_in : '' ?>" aria-describedby="emailHelp">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                    <div class="col-md-2">
                        <label for="my_family" class="form-label d-flex">This is my family:</label>
                    </div>
                    <div class="col-md-10 pt-1">
                        <textarea name="my_family" class="form-control" id="my_family"
                            aria-describedby="emailHelp"><?= isset($hpc[0]->my_family) ? $hpc[0]->my_family : '' ?></textarea>
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                    <div class="col-md-2 text-center">
                        <label for="want_to_be" class="form-label d-flex">I WANT TO BE A</label>
                    </div>
                    <div class="col-md-2 pt-1">
                        <input type="text" name="want_to_be" class="form-control" id="want_to_be"
                            value="<?= isset($hpc[0]->want_to_be) ? $hpc[0]->want_to_be : '' ?>"
                            aria-describedby="emailHelp">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                    <div class="col-md-2">
                        <label for="when_grow_up" class="form-label d-flex">WHEN I GROW UP.</label>
                    </div>
                    <div class="col-md-2 text-end">
                        <label for="friends" class="form-label d-flex">Our my friends</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <textarea name="friends" class="form-control" id="friends"
                            aria-describedby="emailHelp"><?= isset($hpc[0]->friends) ? $hpc[0]->friends : '' ?></textarea>
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                </div>

                <div class="col-md-12 border border-dark rounded row mt-3">
                    <h3 class="boldText text-left">My Favourite:</h3>

                    <div class="col-md-2 text-end">
                        <label for="favourite_colour" class="form-label d-flex">COLOUR</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="favourite_colour" class="form-control" id="favourite_colour"
                            value="<?= isset($hpc[0]->favourite_colour) ? $hpc[0]->favourite_colour : ''; ?>">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>

                    <div class="col-md-2 text-end">
                        <label for="favourite_flower" class="form-label d-flex">FLOWER</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="favourite_flower" class="form-control" id="favourite_flower"
                            value="<?= isset($hpc[0]->favourite_flower) ? $hpc[0]->favourite_flower : ''; ?>">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>

                    <div class="col-md-2 text-end">
                        <label for="favourite_food" class="form-label d-flex">FOOD</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="favourite_food" class="form-control" id="favourite_food"
                            value="<?= isset($hpc[0]->favourite_food) ? $hpc[0]->favourite_food : ''; ?>">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>

                    <div class="col-md-2 text-end">
                        <label for="favourite_sport" class="form-label d-flex">SPORT</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="favourite_sport" class="form-control" id="favourite_sport"
                            value="<?= isset($hpc[0]->favourite_sport) ? $hpc[0]->favourite_sport : ''; ?>">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>

                    <div class="col-md-2 text-end">
                        <label for="favourite_animal" class="form-label d-flex">ANIMAL</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="favourite_animal" class="form-control" id="favourite_animal"
                            value="<?= isset($hpc[0]->favourite_animal) ? $hpc[0]->favourite_animal : ''; ?>">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>

                    <div class="col-md-2 text-end">
                        <label for="favourite_subject" class="form-label d-flex">SUBJECT</label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <input type="text" name="favourite_subject" class="form-control" id="favourite_subject"
                            value="<?= isset($hpc[0]->favourite_subject) ? $hpc[0]->favourite_subject : ''; ?>">
                        <span class="required-message" style="display: none;">This field is required.</span>
                    </div>
                </div>

                <hr>
            </div>
        </div>

        <input type="button" name="next" class="next action-button" value="Next"> <input type="button" name="previous"
            class="previous action-button-previous" value="Previous">
    </fieldset>
    <!--For Domain 1 Start-->
    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">PART B:</h2>
                </div>

            </div>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">DOMAIN 1:</span> Physical development
                    </th>
                </tr>
                <tr>
                    <td class="text-start">
                        <h3>Curricular Goals:</h3>
                        <ul style="margin-left: 11px;">
                            <li style="list-style: disc;">Children develop habits that keep them healthy and safe.</li>
                            <li style="list-style: disc;">Children develop sharpness in sensorial perceptions.</li>
                            <li style="list-style: disc;">Children develop a fit and flexible body.</li>
                        </ul>
                    </td>
                    <td class="text-start">
                        <h3>Competency/Competencies</h3>
                        <textarea name="domain1_competencies" class="form-control" id="domain1_competencies"
                            aria-describedby="emailHelp">
                                            <?php echo htmlspecialchars($hpc[0]->domain1_competencies); ?>
                                        </textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ACTIVITY</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea name="domain1_activity" class="form-control" id="domain1_activity"
                            aria-describedby="emailHelp">
                                            <?php echo htmlspecialchars($hpc[0]->domain1_activity); ?>
                                        </textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ASSESSMENT QUESTIONS</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea name="domain1_assessment_questions" class="form-control"
                            id="domain1_assessment_questions" aria-describedby="emailHelp">
                                            <?php echo htmlspecialchars($hpc[0]->domain1_assessment_questions); ?>
                                        </textarea>
                    </td>
                </tr>
            </table>


            <table class="assessment">
                <tr>
                    <th colspan="4" class="text-center">ASSESSMENT RUBRIC*</th>
                </tr>
                <tr>
                    <th class="bgLightOreng"></th>
                    <th class="bgLightOreng">Stream</th>
                    <th class="bgLightOreng">Mountain</th>
                    <th class="bgLightOreng">Sky</th>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Awareness</td>
                    <td><input type="text" name="domain1_awareness_stream" class="form-control"
                            id="domain1_awareness_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_awareness_stream); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain1_awareness_mountain" class="form-control"
                            id="domain1_awareness_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_awareness_mountain); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain1_awareness_sky" class="form-control" id="domain1_awareness_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_awareness_sky); ?>"
                            aria-describedby="emailHelp"></td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Sensitivity</td>
                    <td><input type="text" name="domain1_sensitivity_stream" class="form-control"
                            id="domain1_sensitivity_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_sensitivity_stream); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain1_sensitivity_mountain" class="form-control"
                            id="domain1_sensitivity_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_sensitivity_mountain); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain1_sensitivity_sky" class="form-control"
                            id="domain1_sensitivity_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_sensitivity_sky); ?>"
                            aria-describedby="emailHelp"></td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Creativity</td>
                    <td><input type="text" name="domain1_creativity_stream" class="form-control"
                            id="domain1_creativity_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_creativity_stream); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain1_creativity_mountain" class="form-control"
                            id="domain1_creativity_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_creativity_mountain); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain1_creativity_sky" class="form-control"
                            id="domain1_creativity_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain1_creativity_sky); ?>"
                            aria-describedby="emailHelp"></td>
                </tr>
            </table>

            <p><b>*Note:</b> Circle the relevant performance level based on the individual student's performance for
                each ability for this activity.</p>
        </div>


        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>

    <fieldset class="feedbacktech">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">TEACHER'S FEEDBACK</h2>
                </div>

            </div> <br><br>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">TEACHER'S FEEDBACK:</span>
                    </th>
                </tr>
                <tr>
                    <td class="text-strat leftHed">
                        <b>NOTE:</b> For each ability, mark the appropriate level
                    </td>
                    <td class="text-strat leftHed">
                        <b>Observational Notes</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-strat">
                        <img src="<?=base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                    </td>
                    <td class="text-strat">
                        <textarea type="text" name="domain1_teacher_feedback_notes" class="form-control"
                            id="domain1_exampleInputEmail1"
                            aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->domain1_teacher_feedback_notes) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how you worked on this activity.</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 selfAssessment">
                                    Self Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>I liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_liked_work"
                                                    id="domain1_self_assessment_liked_yes" value="yes"
                                                    <?= $hpc[0]->domain1_self_assessment_liked_work === 'yes' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_liked_work"
                                                    id="domain1_self_assessment_liked_no" value="no"
                                                    <?= $hpc[0]->domain1_self_assessment_liked_work === 'no' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_liked_work"
                                                    id="domain1_liked_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain1_self_assessment_liked_work === 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>I found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_easy_work"
                                                    id="domain1_self_assessment_easy_yes" value="yes"
                                                    <?= $hpc[0]->domain1_self_assessment_easy_work === 'yes' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_easy_work"
                                                    id="domain1_easy_no" value="no"
                                                    <?= $hpc[0]->domain1_self_assessment_easy_work === 'no' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_easy_work"
                                                    id="domain1_easy_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain1_self_assessment_easy_work === 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain1_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, I needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_needed_help"
                                                    id="domain1_self_assessment_needed_classmate" value="classmate"
                                                    <?= $hpc[0]->domain1_self_assessment_needed_help === 'classmate' ? 'checked' : '' ?>>
                                                <label for="domain1_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_needed_help"
                                                    id="domain1_self_assessment_needed_teacher" value="teacher"
                                                    <?= $hpc[0]->domain1_self_assessment_needed_help === 'teacher' ? 'checked' : '' ?>>
                                                <label for="domain1_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_needed_help"
                                                    id="domain1_self_assessment_needed_books" value="books"
                                                    <?= $hpc[0]->domain1_self_assessment_needed_help === 'books' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_needed_help"
                                                    id="domain1_self_assessment_needed_computer" value="computer"
                                                    <?= $hpc[0]->domain1_self_assessment_needed_help === 'computer' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_self_assessment_needed_help"
                                                    id="domain1_self_assessment_needed_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain1_self_assessment_needed_help === 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain1_self_assessment_needed_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/8.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_self_assessment_needed_dont_know">Do not
                                                    know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how your friend worked on this activity.
                        </h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 peerAssessment">
                                    Peer Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>My friend liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_liked_work"
                                                    id="domain1_peer_assessment_liked_yes" value="yes"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_liked_work == 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_liked_work"
                                                    id="domain1_peer_assessment_liked_no" value="no"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_liked_work == 'no') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_liked_work"
                                                    id="domain1_peer_assessment_liked_dont_know" value="dont_know"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_liked_work == 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>My friend found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_easy_work"
                                                    id="domain1_peer_assessment_easy_yes" value="yes"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_easy_work == 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_easy_work"
                                                    id="domain1_peer_assessment_easy_no" value="no"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_easy_work == 'no') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_easy_work"
                                                    id="domain1_peer_assessment_easy_dont_know" value="dont_know"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_easy_work == 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, My friend needed....</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_needed_help"
                                                    id="domain1_peer_assessment_needed_classmate" value="classmate"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_needed_help == 'classmate') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_needed_help"
                                                    id="domain1_peer_assessment_needed_teacher" value="teacher"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_needed_help == 'teacher') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_needed_help"
                                                    id="domain1_peer_assessment_needed_books" value="books"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_needed_help == 'books') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_needed_help"
                                                    id="domain1_peer_assessment_needed_computer" value="computer"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_needed_help == 'computer') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <!-- Fifth option with radio button -->
                                        <div class="col-md-1">
                                            <div class="icon">
                                                <input type="radio" name="domain1_peer_assessment_needed_help"
                                                    id="domain1_peer_assessment_needed_none" value="none"
                                                    <?php echo ($hpc[0]->domain1_peer_assessment_needed_help == 'none') ? 'checked' : ''; ?>>
                                                <label for="domain1_peer_assessment_needed_none">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/8.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain1_peer_assessment_needed_none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


            </table>

            <table>
                <tr>
                    <td class="text-strat leftHed" style="width: 50%;">
                        Parents/Caregiver/Guardian's Observation
                    </td>
                    <td class="leftHed"></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <h5 class="text-start">Circle the relevant response.</h5>
                        <div class="col-md-12">
                            <div class="hed infoBg">
                                <h6>Learning Teaching resources at home</h6>
                            </div>
                            <div class="bod row">
                                <!-- First option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain1_needed_help" id="domain1_needed_classmate"
                                            value="classmate"
                                            <?php if ($hpc[0]->domain1_needed_help == 'classmate') echo 'checked'; ?>>
                                        <label for="domain1_needed_classmate">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/6.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain1_needed_classmate">books/magazine</label>
                                    </div>
                                </div>

                                <!-- Second option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain1_needed_help" id="domain1_needed_teacher"
                                            value="teacher"
                                            <?php if ($hpc[0]->domain1_needed_help == 'teacher') echo 'checked'; ?>>
                                        <label for="domain1_needed_teacher">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/9.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain1_needed_teacher">newspaper</label>
                                    </div>
                                </div>

                                <!-- Third option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain1_needed_help" id="domain1_needed_books"
                                            value="books"
                                            <?php if ($hpc[0]->domain1_needed_help == 'books') echo 'checked'; ?>>
                                        <label for="domain1_needed_books">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/10.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain1_needed_books">toys/games/sports</label>
                                    </div>
                                </div>

                                <!-- Fourth option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain1_needed_help" id="domain1_needed_computer"
                                            value="computer"
                                            <?php if ($hpc[0]->domain1_needed_help == 'computer') echo 'checked'; ?>>
                                        <label for="domain1_needed_computer">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/7.png" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain1_needed_computer">phone/computer</label>
                                    </div>
                                </div>

                                <!-- Fifth option with radio button -->
                                <div class="col-md-1">
                                    <div class="icon">
                                        <input type="radio" name="domain1_needed_help" id="domain1_needed_none"
                                            value="none"
                                            <?php if ($hpc[0]->domain1_needed_help == 'none') echo 'checked'; ?>>
                                        <label for="domain1_needed_none">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/12.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain1_needed_none">internet</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </div>
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <!--For Domain 1 END-->










    <!--For Domain 2 Start-->
    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">PART B:</h2>
                </div>

            </div>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">DOMAIN 2:</span> Socio-emotional development
                    </th>
                </tr>
                <tr>
                    <td class="text-strat">
                        <h3>Curricular Goals:</h3>
                        <ul style="margin-left: 11px;">
                            <li style="list-style: disc;">Children develop emotional intelligence, i.e., the ability to
                                understand and manage their own emotions, and respond positively to social norms.</li>
                            <li style="list-style: disc;">Children develop a positive attitude towards productive work
                                and service or 'Seva'.</li>
                            <li style="list-style: disc;">Children develop a positive regard for the natural environment
                                around them.</li>
                        </ul>
                    </td>
                    <td class="text-strat">
                        <h3>Competency/Competencies</h3>
                        <textarea type="text" name="domain2_competencies" class="form-control" id="domain2_competencies"
                            aria-describedby="emailHelp"><?php echo isset($hpc[0]->domain2_competencies) ? $hpc[0]->domain2_competencies : ''; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ACTIVITY</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain2_activity" class="form-control" id="domain2_activity"
                            aria-describedby="emailHelp"><?php echo isset($hpc[0]->domain2_activity) ? $hpc[0]->domain2_activity : ''; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ASSESSMENT QUESTIONS</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain2_assessment_questions" class="form-control"
                            id="domain2_assessment_questions"
                            aria-describedby="emailHelp"><?php echo isset($hpc[0]->domain2_assessment_questions) ? $hpc[0]->domain2_assessment_questions : ''; ?></textarea>
                    </td>
                </tr>
            </table>




            <table class="assessment">
                <tr>
                    <th colspan="4" class="text-center">ASSESSMENT RUBRIC*</th>
                </tr>
                <tr>
                    <th class="bgLightOreng"></th>
                    <th class="bgLightOreng">Stream</th>
                    <th class="bgLightOreng">Mountain</th>
                    <th class="bgLightOreng">Sky</th>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Awareness</td>
                    <td><input type="text" name="domain2_awareness_stream" class="form-control"
                            id="domain2_awareness_stream" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_awareness_stream) ? $hpc[0]->domain2_awareness_stream : '' ?>">
                    </td>
                    <td><input type="text" name="domain2_awareness_mountain" class="form-control"
                            id="domain2_awareness_mountain" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_awareness_mountain) ? $hpc[0]->domain2_awareness_mountain : '' ?>">
                    </td>
                    <td><input type="text" name="domain2_awareness_sky" class="form-control" id="domain2_awareness_sky"
                            aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_awareness_sky) ? $hpc[0]->domain2_awareness_sky : '' ?>">
                    </td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Sensitivity</td>
                    <td><input type="text" name="domain2_sensitivity_stream" class="form-control"
                            id="domain2_sensitivity_stream" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_sensitivity_stream) ? $hpc[0]->domain2_sensitivity_stream : '' ?>">
                    </td>
                    <td><input type="text" name="domain2_sensitivity_mountain" class="form-control"
                            id="domain2_sensitivity_mountain" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_sensitivity_mountain) ? $hpc[0]->domain2_sensitivity_mountain : '' ?>">
                    </td>
                    <td><input type="text" name="domain2_sensitivity_sky" class="form-control"
                            id="domain2_sensitivity_sky" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_sensitivity_sky) ? $hpc[0]->domain2_sensitivity_sky : '' ?>">
                    </td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Creativity</td>
                    <td><input type="text" name="domain2_creativity_stream" class="form-control"
                            id="domain2_creativity_stream" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_creativity_stream) ? $hpc[0]->domain2_creativity_stream : '' ?>">
                    </td>
                    <td><input type="text" name="domain2_creativity_mountain" class="form-control"
                            id="domain2_creativity_mountain" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_creativity_mountain) ? $hpc[0]->domain2_creativity_mountain : '' ?>">
                    </td>
                    <td><input type="text" name="domain2_creativity_sky" class="form-control"
                            id="domain2_creativity_sky" aria-describedby="emailHelp"
                            value="<?= isset($hpc[0]->domain2_creativity_sky) ? $hpc[0]->domain2_creativity_sky : '' ?>">
                    </td>
                </tr>
            </table>

            <p><b>*Note:</b> Circle the relevant performance level based on the individual student's performance for
                each ability for this activity.</p>


        </div>
        <!--<input type="button" name="next" class="next action-button" value="Submit"> -->
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <fieldset class="feedbacktech">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">TEACHER'S FEEDBACK<:< /h2>
                </div>

            </div> <br><br>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">TEACHER'S FEEDBACK:</span>
                    </th>
                </tr>
                <tr>
                    <td class="text-strat leftHed">
                        <b>NOTE:</b> For each ability, mark the appropriate level
                    </td>
                    <td class="text-strat leftHed">
                        <b>Observational Notes</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-strat">
                        <img src="<?=base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                    </td>
                    <td class="text-strat">
                        <textarea type="text" name="domain2_teacher_feedback_notes" class="form-control"
                            id="domain2_exampleInputEmail1"
                            aria-describedby="emailHelp"><?= isset($hpc[0]->domain2_teacher_feedback_notes) ? $hpc[0]->domain2_teacher_feedback_notes : ''; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how you worked on this activity.</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 selfAssessment">Self Assessment</div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed greenBg">
                                        <h6>I liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_liked_work"
                                                    id="domain2_self_assessment_liked_yes" value="yes"
                                                    <?= isset($hpc[0]->domain2_self_assessment_liked_work) && $hpc[0]->domain2_self_assessment_liked_work == 'yes' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_liked_work"
                                                    id="domain2_self_assessment_liked_no" value="no"
                                                    <?= isset($hpc[0]->domain2_self_assessment_liked_work) && $hpc[0]->domain2_self_assessment_liked_work == 'no' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_liked_work"
                                                    id="domain2_self_assessment_liked_dont_know" value="dont_know"
                                                    <?= isset($hpc[0]->domain2_self_assessment_liked_work) && $hpc[0]->domain2_self_assessment_liked_work == 'dont_know' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>I found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_easy_work"
                                                    id="domain2_self_assessment_easy_yes" value="yes"
                                                    <?= isset($hpc[0]->domain2_self_assessment_easy_work) && $hpc[0]->domain2_self_assessment_easy_work == 'yes' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_easy_work"
                                                    id="domain2_easy_no" value="no"
                                                    <?= isset($hpc[0]->domain2_self_assessment_easy_work) && $hpc[0]->domain2_self_assessment_easy_work == 'no' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_easy_work"
                                                    id="domain2_easy_dont_know" value="dont_know"
                                                    <?= isset($hpc[0]->domain2_self_assessment_easy_work) && $hpc[0]->domain2_self_assessment_easy_work == 'dont_know' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, I needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_needed_help"
                                                    id="domain2_self_assessment_needed_classmate" value="classmate"
                                                    <?= isset($hpc[0]->domain2_self_assessment_needed_help) && $hpc[0]->domain2_self_assessment_needed_help == 'classmate' ? 'checked' : ''; ?>>
                                                <label for="domain2_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_needed_help"
                                                    id="domain2_self_assessment_needed_teacher" value="teacher"
                                                    <?= isset($hpc[0]->domain2_self_assessment_needed_help) && $hpc[0]->domain2_self_assessment_needed_help == 'teacher' ? 'checked' : ''; ?>>
                                                <label for="domain2_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_needed_help"
                                                    id="domain2_self_assessment_needed_books" value="books"
                                                    <?= isset($hpc[0]->domain2_self_assessment_needed_help) && $hpc[0]->domain2_self_assessment_needed_help == 'books' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-2">
                                            <div class="icon">
                                                <input type="radio" name="domain2_self_assessment_needed_help"
                                                    id="domain2_self_assessment_needed_nothing" value="nothing"
                                                    <?= isset($hpc[0]->domain2_self_assessment_needed_help) && $hpc[0]->domain2_self_assessment_needed_help == 'nothing' ? 'checked' : ''; ?>>
                                                <label for="domain2_self_assessment_needed_nothing">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_self_assessment_needed_nothing">Nothing</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how your friend worked on this activity.
                        </h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Peer Assessment Title -->
                                <div class="col-md-2 peerAssessment">
                                    Peer Assessment
                                </div>

                                <!-- Question 1: My friend liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed greenBg">
                                        <h6>My friend liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_liked_work"
                                                    id="domain2_peer_assessment_liked_yes" value="yes"
                                                    <?= ($hpc[0]->domain2_peer_assessment_liked_work === 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_liked_yes">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_liked_work"
                                                    id="domain2_peer_assessment_liked_no" value="no"
                                                    <?= ($hpc[0]->domain2_peer_assessment_liked_work === 'no') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_liked_no">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_liked_work"
                                                    id="domain2_peer_assessment_liked_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain2_peer_assessment_liked_work === 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_liked_dont_know">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: My friend found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>My friend found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_easy_work"
                                                    id="domain2_peer_assessment_easy_yes" value="yes"
                                                    <?= ($hpc[0]->domain2_peer_assessment_easy_work === 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_easy_yes">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_easy_work"
                                                    id="domain2_peer_assessment_easy_no" value="no"
                                                    <?= ($hpc[0]->domain2_peer_assessment_easy_work === 'no') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_easy_no">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_easy_work"
                                                    id="domain2_peer_assessment_easy_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain2_peer_assessment_easy_work === 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_easy_dont_know">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, my friend needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, My friend needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_needed_help"
                                                    id="domain2_peer_assessment_needed_classmate" value="classmate"
                                                    <?= ($hpc[0]->domain2_peer_assessment_needed_help === 'classmate') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_needed_classmate">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_needed_help"
                                                    id="domain2_peer_assessment_needed_teacher" value="teacher"
                                                    <?= ($hpc[0]->domain2_peer_assessment_needed_help === 'teacher') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_needed_teacher">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_needed_help"
                                                    id="domain2_peer_assessment_needed_books" value="books"
                                                    <?= ($hpc[0]->domain2_peer_assessment_needed_help === 'books') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_needed_books">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_needed_help"
                                                    id="domain2_peer_assessment_needed_computer" value="computer"
                                                    <?= ($hpc[0]->domain2_peer_assessment_needed_help === 'computer') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_needed_computer">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="icon">
                                                <input type="radio" name="domain2_peer_assessment_needed_help"
                                                    id="domain2_peer_assessment_needed_none" value="none"
                                                    <?= ($hpc[0]->domain2_peer_assessment_needed_help === 'none') ? 'checked' : ''; ?>>
                                                <label for="domain2_peer_assessment_needed_none">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/8.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain2_peer_assessment_needed_none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


            </table>

            <table>
                <tr>
                    <td class="text-start leftHed" style="width: 50%;">
                        Parents/Caregiver/Guardian's Observation
                    </td>
                    <td class="leftHed"></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <h5 class="text-start">Circle the relevant response.</h5>
                        <div class="col-md-12">
                            <div class="hed infoBg">
                                <h6>Learning Teaching resources at home</h6>
                            </div>
                            <div class="bod row">
                                <!-- First option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain2_needed_help" id="domain2_needed_classmate"
                                            value="classmate"
                                            <?= isset($hpc[0]) && $hpc[0]->domain2_needed_help === 'classmate' ? 'checked' : ''; ?>>
                                        <label for="domain2_needed_classmate">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain2_needed_classmate">books/magazine</label>
                                    </div>
                                </div>

                                <!-- Second option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain2_needed_help" id="domain2_needed_teacher"
                                            value="teacher"
                                            <?= isset($hpc[0]) && $hpc[0]->domain2_needed_help === 'teacher' ? 'checked' : ''; ?>>
                                        <label for="domain2_needed_teacher">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/9.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain2_needed_teacher">newspaper</label>
                                    </div>
                                </div>

                                <!-- Third option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain2_needed_help" id="domain2_needed_books"
                                            value="books"
                                            <?= isset($hpc[0]) && $hpc[0]->domain2_needed_help === 'books' ? 'checked' : ''; ?>>
                                        <label for="domain2_needed_books">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/10.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain2_needed_books">toys/games/sports</label>
                                    </div>
                                </div>

                                <!-- Fourth option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain2_needed_help" id="domain2_needed_computer"
                                            value="computer"
                                            <?= isset($hpc[0]) && $hpc[0]->domain2_needed_help === 'computer' ? 'checked' : ''; ?>>
                                        <label for="domain2_needed_computer">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/7.png" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain2_needed_computer">phone/computer</label>
                                    </div>
                                </div>

                                <!-- Fifth option with radio button -->
                                <div class="col-md-1">
                                    <div class="icon">
                                        <input type="radio" name="domain2_needed_help" id="domain2_needed_none"
                                            value="none"
                                            <?= isset($hpc[0]) && $hpc[0]->domain2_needed_help === 'none' ? 'checked' : ''; ?>>
                                        <label for="domain2_needed_none">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/12.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain2_needed_none">internet</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </div>
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <!--For Domain 2 END-->
    <!--For Domain 3 Start-->
    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">PART B:</h2>
                </div>
                <!--<div class="col-5">-->
                <!--    <h2 class="steps">Step 3 - 4</h2>-->
                <!--</div>-->
            </div>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">DOMAIN 3:</span> Cognitive Development
                    </th>
                </tr>
                <tr>
                    <td class="text-strat">
                        <h3>Curricular Goals:</h3>
                        <ul style="margin-left: 11px;">
                            <li style="list-style: disc;">Children make sense of world around through observation and
                                logical thinking.</li>
                            <li style="list-style: disc;">Children develop mathematical understanding and abilities to
                                recognize the world through quantities, shapes, and measures.</li>
                        </ul>
                    </td>
                    <td class="text-strat">
                        <h3>Competency/Competencies</h3>
                        <textarea name="domain3_competencies" class="form-control" id="domain3_competencies"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain3_competencies); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ACTIVITY</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea name="domain3_activity" class="form-control" id="domain3_activity"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain3_activity); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ASSESSMENT QUESTIONS</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea name="domain3_assessment_questions" class="form-control"
                            id="domain3_assessment_questions"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain3_assessment_questions); ?></textarea>
                    </td>
                </tr>
            </table>

            <table class="assessment">
                <tr>
                    <th colspan="4" class="text-center">ASSESSMENT RUBRIC*</th>
                </tr>
                <tr>
                    <th class="bgLightOreng"></th>
                    <th class="bgLightOreng">Stream</th>
                    <th class="bgLightOreng">Mountain</th>
                    <th class="bgLightOreng">Sky</th>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Awareness</td>
                    <td><input type="text" name="domain3_awareness_stream" class="form-control"
                            id="domain3_awareness_stream" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_awareness_stream); ?>"></td>
                    <td><input type="text" name="domain3_awareness_mountain" class="form-control"
                            id="domain3_awareness_mountain" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_awareness_mountain); ?>"></td>
                    <td><input type="text" name="domain3_awareness_sky" class="form-control" id="domain3_awareness_sky"
                            aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_awareness_sky); ?>"></td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Sensitivity</td>
                    <td><input type="text" name="domain3_sensitivity_stream" class="form-control"
                            id="domain3_sensitivity_stream" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_sensitivity_stream); ?>"></td>
                    <td><input type="text" name="domain3_sensitivity_mountain" class="form-control"
                            id="domain3_sensitivity_mountain" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_sensitivity_mountain); ?>"></td>
                    <td><input type="text" name="domain3_sensitivity_sky" class="form-control"
                            id="domain3_sensitivity_sky" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_sensitivity_sky); ?>"></td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Creativity</td>
                    <td><input type="text" name="domain3_creativity_stream" class="form-control"
                            id="domain3_creativity_stream" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_creativity_stream); ?>"></td>
                    <td><input type="text" name="domain3_creativity_mountain" class="form-control"
                            id="domain3_creativity_mountain" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_creativity_mountain); ?>"></td>
                    <td><input type="text" name="domain3_creativity_sky" class="form-control"
                            id="domain3_creativity_sky" aria-describedby="emailHelp"
                            value="<?php echo htmlspecialchars($hpc[0]->domain3_creativity_sky); ?>"></td>
                </tr>
            </table>

            <p><b>*Note:</b> Circle the relevant performance level based on the individual student's performance for
                each ability for this activity.</p>


        </div>
        <!--<input type="button" name="next" class="next action-button" value="Submit"> -->
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <fieldset class="feedbacktech">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">TEACHER'S FEEDBACK<:< /h2>
                </div>

            </div> <br><br>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">TEACHER'S FEEDBACK:</span>
                    </th>
                </tr>
                <tr>
                    <td class="text-strat leftHed">
                        <b>NOTE:</b> For each ability, mark the appropriate level
                    </td>
                    <td class="text-strat leftHed">
                        <b>Observational Notes</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-strat">
                        <img src="<?=base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                    </td>
                    <td class="text-strat">
                        <textarea type="text" name="domain3_teacher_feedback_notes" class="form-control"
                            id="domain3_exampleInputEmail1"
                            aria-describedby="emailHelp"><?= $hpc[0]->domain3_teacher_feedback_notes; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how you worked on this activity.</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 selfAssessment">
                                    Self Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>I liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_liked_work"
                                                    id="domain3_self_assessment_liked_yes" value="yes"
                                                    <?= ($hpc[0]->domain3_self_assessment_liked_work == 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_liked_work"
                                                    id="domain3_self_assessment_liked_no" value="no"
                                                    <?= ($hpc[0]->domain3_self_assessment_liked_work == 'no') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_liked_work"
                                                    id="domain3_liked_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain3_self_assessment_liked_work == 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>I found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_easy_work"
                                                    id="domain3_self_assessment_easy_yes" value="yes"
                                                    <?= ($hpc[0]->domain3_self_assessment_easy_work == 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_easy_work"
                                                    id="domain3_easy_no" value="no"
                                                    <?= ($hpc[0]->domain3_self_assessment_easy_work == 'no') ? 'checked' : ''; ?>>
                                                <label for="domain3_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_easy_work"
                                                    id="domain3_easy_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain3_self_assessment_easy_work == 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain3_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, I needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_needed_help"
                                                    id="domain3_self_assessment_needed_classmate" value="classmate"
                                                    <?= ($hpc[0]->domain3_self_assessment_needed_help == 'classmate') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_needed_help"
                                                    id="domain3_self_assessment_needed_teacher" value="teacher"
                                                    <?= ($hpc[0]->domain3_self_assessment_needed_help == 'teacher') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_needed_help"
                                                    id="domain3_self_assessment_needed_books" value="books"
                                                    <?= ($hpc[0]->domain3_self_assessment_needed_help == 'books') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_needed_help"
                                                    id="domain3_self_assessment_needed_computer" value="computer"
                                                    <?= ($hpc[0]->domain3_self_assessment_needed_help == 'computer') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <!-- Fifth option with radio button -->
                                        <div class="col-md-2">
                                            <div class="icon">
                                                <input type="radio" name="domain3_self_assessment_needed_help"
                                                    id="domain3_self_assessment_needed_nothing" value="nothing"
                                                    <?= ($hpc[0]->domain3_self_assessment_needed_help == 'nothing') ? 'checked' : ''; ?>>
                                                <label for="domain3_self_assessment_needed_nothing">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/8.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_self_assessment_needed_nothing">Nothing</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how your friend worked on this activity.
                        </h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 peerAssessment">
                                    Peer Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>My friend liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_liked_work"
                                                    id="domain3_peer_assessment_liked_yes" value="yes"
                                                    <?= $hpc[0]->domain3_peer_assessment_liked_work == 'yes' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_liked_work"
                                                    id="domain3_peer_assessment_liked_no" value="no"
                                                    <?= $hpc[0]->domain3_peer_assessment_liked_work == 'no' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_liked_work"
                                                    id="domain3_peer_assessment_liked_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain3_peer_assessment_liked_work == 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>My friend found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_easy_work"
                                                    id="domain3_peer_assessment_easy_yes" value="yes"
                                                    <?= $hpc[0]->domain3_peer_assessment_easy_work == 'yes' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_easy_work"
                                                    id="domain3_peer_assessment_easy_no" value="no"
                                                    <?= $hpc[0]->domain3_peer_assessment_easy_work == 'no' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_easy_work"
                                                    id="domain3_peer_assessment_easy_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain3_peer_assessment_easy_work == 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, My friend needed....</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_needed_help"
                                                    id="domain3_peer_assessment_needed_classmate" value="classmate"
                                                    <?= $hpc[0]->domain3_peer_assessment_needed_help == 'classmate' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_needed_help"
                                                    id="domain3_peer_assessment_needed_teacher" value="teacher"
                                                    <?= $hpc[0]->domain3_peer_assessment_needed_help == 'teacher' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_needed_help"
                                                    id="domain3_peer_assessment_needed_books" value="books"
                                                    <?= $hpc[0]->domain3_peer_assessment_needed_help == 'books' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_needed_help"
                                                    id="domain3_peer_assessment_needed_computer" value="computer"
                                                    <?= $hpc[0]->domain3_peer_assessment_needed_help == 'computer' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <!-- Fifth option with radio button -->
                                        <div class="col-md-1">
                                            <div class="icon">
                                                <input type="radio" name="domain3_peer_assessment_needed_help"
                                                    id="domain3_peer_assessment_needed_no_help" value="no_help"
                                                    <?= $hpc[0]->domain3_peer_assessment_needed_help == 'no_help' ? 'checked' : '' ?>>
                                                <label for="domain3_peer_assessment_needed_no_help">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/8.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain3_peer_assessment_needed_no_help">No Help</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


            </table>

            <table>
                <tr>
                    <td class="text-start leftHed" style="width: 50%;">
                        Parents/Caregiver/Guardian's Observation
                    </td>
                    <td class="leftHed"></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <h5 class="text-start">Circle the relevant response.</h5>
                        <div class="col-md-12">
                            <div class="hed infoBg">
                                <h6>Learning Teaching resources at home</h6>
                            </div>
                            <div class="bod row">
                                <!-- First option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain3_needed_help" id="domain3_needed_classmate"
                                            value="classmate"
                                            <?php if($hpc[0]->domain3_needed_help == 'classmate') echo 'checked'; ?>>
                                        <label for="domain3_needed_classmate">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain3_needed_classmate">books/magazine</label>
                                    </div>
                                </div>

                                <!-- Second option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain3_needed_help" id="domain3_needed_teacher"
                                            value="teacher"
                                            <?php if($hpc[0]->domain3_needed_help == 'teacher') echo 'checked'; ?>>
                                        <label for="domain3_needed_teacher">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/9.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain3_needed_teacher">newspaper</label>
                                    </div>
                                </div>

                                <!-- Third option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain3_needed_help" id="domain3_needed_books"
                                            value="books"
                                            <?php if($hpc[0]->domain3_needed_help == 'books') echo 'checked'; ?>>
                                        <label for="domain3_needed_books">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/10.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain3_needed_books">toys/games/sports</label>
                                    </div>
                                </div>

                                <!-- Fourth option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain3_needed_help" id="domain3_needed_computer"
                                            value="computer"
                                            <?php if($hpc[0]->domain3_needed_help == 'computer') echo 'checked'; ?>>
                                        <label for="domain3_needed_computer">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/7.png" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain3_needed_computer">phone/computer</label>
                                    </div>
                                </div>

                                <!-- Fifth option with radio button -->
                                <div class="col-md-1">
                                    <div class="icon">
                                        <input type="radio" name="domain3_needed_help" id="domain3_needed_none"
                                            value="none"
                                            <?php if($hpc[0]->domain3_needed_help == 'none') echo 'checked'; ?>>
                                        <label for="domain3_needed_none">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/12.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain3_needed_none">internet</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </div>
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <!--For Domain 3 END-->
    <!--For Domain 4 Start-->
    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">DOMAIN 4:</h2>
                </div>

            </div>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">DOMAIN 4:</span> Language and literacy development
                    </th>
                </tr>
                <tr>
                    <td class="text-strat">
                        <h3>Curricular Goals:</h3>
                        <ul style="margin-left: 11px;">
                            <li style="list-style: disc;">Children develop effective communication skills for day-to-day
                                interactions in two languages.</li>
                            <li style="list-style: disc;">Children develop fluency in reading and writing in Language 1
                                (L1).</li>
                            <li style="list-style: disc;">Children begin to read and write in Language 2(L2).</li>
                        </ul>
                    </td>
                    <td class="text-strat">
                        <h3>Competency/Competencies</h3>
                        <textarea type="text" name="domain4_competencies" class="form-control" id="domain4_competencies"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain4_competencies); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ACTIVITY</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain4_activity" class="form-control" id="domain4_activity"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain4_activity); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ASSESSMENT QUESTIONS</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain4_assessment_questions" class="form-control"
                            id="domain4_assessment_questions"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain4_assessment_questions); ?></textarea>
                    </td>
                </tr>
            </table>


            <table class="assessment">
                <tr>
                    <th colspan="4" class="text-center">ASSESSMENT RUBRIC*</th>
                </tr>
                <tr>
                    <th class="bgLightOreng"></th>
                    <th class="bgLightOreng">Stream</th>
                    <th class="bgLightOreng">Mountain</th>
                    <th class="bgLightOreng">Sky</th>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Awareness</td>
                    <td><input type="text" name="domain4_awareness_stream" class="form-control"
                            id="domain4_awareness_stream"
                            value="<?= isset($hpc[0]->domain4_awareness_stream) ? $hpc[0]->domain4_awareness_stream : '' ?>">
                    </td>
                    <td><input type="text" name="domain4_awareness_mountain" class="form-control"
                            id="domain4_awareness_mountain"
                            value="<?= isset($hpc[0]->domain4_awareness_mountain) ? $hpc[0]->domain4_awareness_mountain : '' ?>">
                    </td>
                    <td><input type="text" name="domain4_awareness_sky" class="form-control" id="domain4_awareness_sky"
                            value="<?= isset($hpc[0]->domain4_awareness_sky) ? $hpc[0]->domain4_awareness_sky : '' ?>">
                    </td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Sensitivity</td>
                    <td><input type="text" name="domain4_sensitivity_stream" class="form-control"
                            id="domain4_sensitivity_stream"
                            value="<?= isset($hpc[0]->domain4_sensitivity_stream) ? $hpc[0]->domain4_sensitivity_stream : '' ?>">
                    </td>
                    <td><input type="text" name="domain4_sensitivity_mountain" class="form-control"
                            id="domain4_sensitivity_mountain"
                            value="<?= isset($hpc[0]->domain4_sensitivity_mountain) ? $hpc[0]->domain4_sensitivity_mountain : '' ?>">
                    </td>
                    <td><input type="text" name="domain4_sensitivity_sky" class="form-control"
                            id="domain4_sensitivity_sky"
                            value="<?= isset($hpc[0]->domain4_sensitivity_sky) ? $hpc[0]->domain4_sensitivity_sky : '' ?>">
                    </td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Creativity</td>
                    <td><input type="text" name="domain4_creativity_stream" class="form-control"
                            id="domain4_creativity_stream"
                            value="<?= isset($hpc[0]->domain4_creativity_stream) ? $hpc[0]->domain4_creativity_stream : '' ?>">
                    </td>
                    <td><input type="text" name="domain4_creativity_mountain" class="form-control"
                            id="domain4_creativity_mountain"
                            value="<?= isset($hpc[0]->domain4_creativity_mountain) ? $hpc[0]->domain4_creativity_mountain : '' ?>">
                    </td>
                    <td><input type="text" name="domain4_creativity_sky" class="form-control"
                            id="domain4_creativity_sky"
                            value="<?= isset($hpc[0]->domain4_creativity_sky) ? $hpc[0]->domain4_creativity_sky : '' ?>">
                    </td>
                </tr>
            </table>

            <p><b>*Note:</b> Circle the relevant performance level based on the individual student's performance for
                each ability for this activity.</p>


        </div>
        <!--<input type="button" name="next" class="next action-button" value="Submit"> -->
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <fieldset class="feedbacktech">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">TEACHER'S FEEDBACK<:< /h2>
                </div>

            </div> <br><br>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">TEACHER'S FEEDBACK:</span>
                    </th>
                </tr>
                <tr>
                    <td class="text-strat leftHed">
                        <b>NOTE:</b> For each ability, mark the appropriate level
                    </td>
                    <td class="text-strat leftHed">
                        <b>Observational Notes</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-strat">
                        <img src="<?= base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                    </td>
                    <td class="text-strat">
                        <textarea name="domain4_teacher_feedback_notes" class="form-control"
                            id="domain4_exampleInputEmail1"
                            aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->domain4_teacher_feedback_notes); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how you worked on this activity.</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2 selfAssessment">
                                    Self Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>I liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_liked_work"
                                                    id="domain4_self_assessment_liked_yes" value="yes"
                                                    <?= $hpc[0]->domain4_self_assessment_liked_work === 'yes' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_liked_yes">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_liked_work"
                                                    id="domain4_self_assessment_liked_no" value="no"
                                                    <?= $hpc[0]->domain4_self_assessment_liked_work === 'no' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_liked_no">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_liked_work"
                                                    id="domain4_liked_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain4_self_assessment_liked_work === 'dont_know' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_liked_dont_know">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>I found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_easy_work"
                                                    id="domain4_self_assessment_easy_yes" value="yes"
                                                    <?= $hpc[0]->domain4_self_assessment_easy_work === 'yes' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_easy_yes">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_easy_work"
                                                    id="domain4_easy_no" value="no"
                                                    <?= $hpc[0]->domain4_self_assessment_easy_work === 'no' ? 'checked' : ''; ?>>
                                                <label for="domain4_easy_no">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_easy_work"
                                                    id="domain4_easy_dont_know" value="dont_know"
                                                    <?= $hpc[0]->domain4_self_assessment_easy_work === 'dont_know' ? 'checked' : ''; ?>>
                                                <label for="domain4_easy_dont_know">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, I needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_needed_help"
                                                    id="domain4_self_assessment_needed_classmate" value="classmate"
                                                    <?= $hpc[0]->domain4_self_assessment_needed_help === 'classmate' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_needed_classmate">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_needed_help"
                                                    id="domain4_self_assessment_needed_teacher" value="teacher"
                                                    <?= $hpc[0]->domain4_self_assessment_needed_help === 'teacher' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_needed_teacher">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_needed_help"
                                                    id="domain4_self_assessment_needed_books" value="books"
                                                    <?= $hpc[0]->domain4_self_assessment_needed_help === 'books' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_needed_books">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_needed_help"
                                                    id="domain4_self_assessment_needed_computer" value="computer"
                                                    <?= $hpc[0]->domain4_self_assessment_needed_help === 'computer' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_needed_computer">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <!-- Fifth option with radio button -->
                                        <div class="col-md-1">
                                            <div class="icon">
                                                <input type="radio" name="domain4_self_assessment_needed_help"
                                                    id="domain4_self_assessment_needed_no_help" value="no_help"
                                                    <?= $hpc[0]->domain4_self_assessment_needed_help === 'no_help' ? 'checked' : ''; ?>>
                                                <label for="domain4_self_assessment_needed_no_help">
                                                    <img src="<?= base_url(); ?>assets/uploads/hpc/8.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_self_assessment_needed_no_help">No Help</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how your friend worked on this activity.
                        </h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 peerAssessment">
                                    Peer Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>My friend liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_liked_work"
                                                    id="domain4_peer_assessment_liked_yes" value="yes"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_liked_work) && $hpc[0]->domain1_peer_assessment_liked_work === 'yes' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_liked_work"
                                                    id="domain4_peer_assessment_liked_no" value="no"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_liked_work) && $hpc[0]->domain1_peer_assessment_liked_work === 'no' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_liked_work"
                                                    id="domain4_peer_assessment_liked_dont_know" value="dont_know"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_liked_work) && $hpc[0]->domain1_peer_assessment_liked_work === 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>My friend found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_easy_work"
                                                    id="domain4_peer_assessment_easy_yes" value="yes"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_easy_work) && $hpc[0]->domain1_peer_assessment_easy_work === 'yes' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_easy_work"
                                                    id="domain4_peer_assessment_easy_no" value="no"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_easy_work) && $hpc[0]->domain1_peer_assessment_easy_work === 'no' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_easy_work"
                                                    id="domain4_peer_assessment_easy_dont_know" value="dont_know"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_easy_work) && $hpc[0]->domain1_peer_assessment_easy_work === 'dont_know' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, My friend needed....</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_needed_help"
                                                    id="domain4_peer_assessment_needed_classmate" value="classmate"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_needed_help) && $hpc[0]->domain1_peer_assessment_needed_help === 'classmate' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_needed_help"
                                                    id="domain4_peer_assessment_needed_teacher" value="teacher"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_needed_help) && $hpc[0]->domain1_peer_assessment_needed_help === 'teacher' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_needed_help"
                                                    id="domain4_peer_assessment_needed_books" value="books"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_needed_help) && $hpc[0]->domain1_peer_assessment_needed_help === 'books' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain4_peer_assessment_needed_help"
                                                    id="domain4_peer_assessment_needed_computer" value="computer"
                                                    <?= isset($hpc[0]->domain1_peer_assessment_needed_help) && $hpc[0]->domain1_peer_assessment_needed_help === 'computer' ? 'checked' : '' ?>>
                                                <label for="domain4_peer_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain4_peer_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


            </table>

            <table>
                <tr>
                    <td class="text-start leftHed" style="width: 50%;">
                        Parents/Caregiver/Guardian's Observation
                    </td>
                    <td class="leftHed"></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <h5 class="text-start">Circle the relevant response.</h5>
                        <div class="col-md-12">
                            <div class="hed infoBg">
                                <h6>Learning Teaching resources at home</h6>
                            </div>
                            <div class="bod row">
                                <!-- First option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain4_needed_help" id="domain4_needed_classmate"
                                            value="classmate"
                                            <?= isset($hpc[0]->domain4_needed_help) && $hpc[0]->domain4_needed_help === 'classmate' ? 'checked' : ''; ?>>
                                        <label for="domain4_needed_classmate">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/6.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain4_needed_classmate">books/magazine</label>
                                    </div>
                                </div>

                                <!-- Second option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain4_needed_help" id="domain4_needed_teacher"
                                            value="teacher"
                                            <?= isset($hpc[0]->domain4_needed_help) && $hpc[0]->domain4_needed_help === 'teacher' ? 'checked' : ''; ?>>
                                        <label for="domain4_needed_teacher">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/9.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain4_needed_teacher">newspaper</label>
                                    </div>
                                </div>

                                <!-- Third option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain4_needed_help" id="domain4_needed_books"
                                            value="books"
                                            <?= isset($hpc[0]->domain4_needed_help) && $hpc[0]->domain4_needed_help === 'books' ? 'checked' : ''; ?>>
                                        <label for="domain4_needed_books">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/10.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain4_needed_books">toys/games/sports</label>
                                    </div>
                                </div>

                                <!-- Fourth option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain4_needed_help" id="domain4_needed_computer"
                                            value="computer"
                                            <?= isset($hpc[0]->domain4_needed_help) && $hpc[0]->domain4_needed_help === 'computer' ? 'checked' : ''; ?>>
                                        <label for="domain4_needed_computer">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/7.png" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain4_needed_computer">phone/computer</label>
                                    </div>
                                </div>

                                <!-- Fifth option with radio button -->
                                <div class="col-md-1">
                                    <div class="icon">
                                        <input type="radio" name="domain4_needed_help" id="domain4_needed_none"
                                            value="none"
                                            <?= isset($hpc[0]->domain4_needed_help) && $hpc[0]->domain4_needed_help === 'none' ? 'checked' : ''; ?>>
                                        <label for="domain4_needed_none">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/12.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain4_needed_none">internet</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </div>
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <!--DOMAIN 4 END -->
    <!--DOMAIN 5 Start -->


    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">DOMAIN 5:</h2>
                </div>

            </div>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">DOMAIN 5:</span> Aesthetic and Cultural Development
                    </th>
                </tr>
                <tr>
                    <td class="text-strat">
                        <h3>Curricular Goals:</h3>
                        <ul style="margin-left: 11px;">
                            <li style="list-style: disc;">Children develop abilities and sensibilities in visual and
                                performing arts and express their emotions through art in meaningful and joyful ways.
                            </li>
                        </ul>
                    </td>
                    <td class="text-strat">
                        <h3>Competency/Competencies</h3>
                        <textarea type="text" name="domain5_competencies" class="form-control" id="domain5_competencies"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain5_competencies); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ACTIVITY</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain5_activity" class="form-control" id="domain5_activity"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain5_activity); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ASSESSMENT QUESTIONS</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain5_assessment_questions" class="form-control"
                            id="domain5_assessment_questions"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain5_assessment_questions); ?></textarea>
                    </td>
                </tr>
            </table>


            <table class="assessment">
                <tr>
                    <th colspan="4" class="text-center">ASSESSMENT RUBRIC*</th>
                </tr>
                <tr>
                    <th class="bgLightOreng"></th>
                    <th class="bgLightOreng">Stream</th>
                    <th class="bgLightOreng">Mountain</th>
                    <th class="bgLightOreng">Sky</th>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Awareness</td>
                    <td><input type="text" name="domain5_awareness_stream" class="form-control"
                            id="domain5_awareness_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_awareness_stream); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain5_awareness_mountain" class="form-control"
                            id="domain5_awareness_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_awareness_mountain); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain5_awareness_sky" class="form-control" id="domain5_awareness_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_awareness_sky); ?>"
                            aria-describedby="emailHelp"></td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Sensitivity</td>
                    <td><input type="text" name="domain5_sensitivity_stream" class="form-control"
                            id="domain5_sensitivity_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_sensitivity_stream); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain5_sensitivity_mountain" class="form-control"
                            id="domain5_sensitivity_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_sensitivity_mountain); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain5_sensitivity_sky" class="form-control"
                            id="domain5_sensitivity_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_sensitivity_sky); ?>"
                            aria-describedby="emailHelp"></td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Creativity</td>
                    <td><input type="text" name="domain5_creativity_stream" class="form-control"
                            id="domain5_creativity_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_creativity_stream); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain5_creativity_mountain" class="form-control"
                            id="domain5_creativity_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_creativity_mountain); ?>"
                            aria-describedby="emailHelp"></td>
                    <td><input type="text" name="domain5_creativity_sky" class="form-control"
                            id="domain5_creativity_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_creativity_sky); ?>"
                            aria-describedby="emailHelp"></td>
                </tr>
            </table>
            <p><b>*Note:</b> Circle the relevant performance level based on the individual student's performance for
                each ability for this activity.</p>


        </div>
        <!--<input type="button" name="next" class="next action-button" value="Submit"> -->
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>
    <fieldset class="feedbacktech">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">TEACHER'S FEEDBACK<:< /h2>
                </div>

            </div> <br><br>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">TEACHER'S FEEDBACK:</span>
                    </th>
                </tr>
                <tr>
                    <td class="text-strat leftHed">
                        <b>NOTE:</b> For each ability, mark the appropriate level
                    </td>
                    <td class="text-strat leftHed">
                        <b>Observational Notes</b>
                    </td>
                </tr>
                <tr>
                    <td class="text-strat">
                        <img src="<?=base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                    </td>
                    <td class="text-strat">
                        <textarea type="text" name="domain5_teacher_feedback_notes" class="form-control"
                            id="domain5_exampleInputEmail1"
                            aria-describedby="emailHelp"><?= isset($hpc[0]->domain5_teacher_feedback_notes) ? htmlspecialchars($hpc[0]->domain5_teacher_feedback_notes) : ''; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how you worked on this activity.</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 selfAssessment">
                                    Self Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>I liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_liked_work"
                                                    id="domain5_self_assessment_liked_yes" value="yes"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_liked_work) && $hpc[0]->domain5_self_assessment_liked_work === 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain5_self_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_liked_work"
                                                    id="domain5_self_assessment_liked_no" value="no"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_liked_work) && $hpc[0]->domain5_self_assessment_liked_work === 'no') ? 'checked' : ''; ?>>
                                                <label for="domain5_self_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_liked_work"
                                                    id="domain5_liked_dont_know" value="dont_know"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_liked_work) && $hpc[0]->domain5_self_assessment_liked_work === 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain5_self_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>I found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_easy_work"
                                                    id="domain5_self_assessment_easy_yes" value="yes"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_easy_work) && $hpc[0]->domain5_self_assessment_easy_work === 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain5_self_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_easy_work"
                                                    id="domain5_easy_no" value="no"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_easy_work) && $hpc[0]->domain5_self_assessment_easy_work === 'no') ? 'checked' : ''; ?>>
                                                <label for="domain5_self_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_easy_work"
                                                    id="domain5_easy_dont_know" value="dont_know"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_easy_work) && $hpc[0]->domain5_self_assessment_easy_work === 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain5_self_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, I needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_needed_help"
                                                    id="domain5_self_assessment_needed_classmate" value="classmate"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_needed_help) && $hpc[0]->domain5_self_assessment_needed_help === 'classmate') ? 'checked' : ''; ?>>
                                                <label for="domain5_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_needed_help"
                                                    id="domain5_self_assessment_needed_teacher" value="teacher"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_needed_help) && $hpc[0]->domain5_self_assessment_needed_help === 'teacher') ? 'checked' : ''; ?>>
                                                <label for="domain5_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_needed_help"
                                                    id="domain5_self_assessment_needed_no_one" value="no_one"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_needed_help) && $hpc[0]->domain5_self_assessment_needed_help === 'no_one') ? 'checked' : ''; ?>>
                                                <label for="domain5_needed_no_one">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_needed_no_one">No one</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_needed_help"
                                                    id="domain5_self_assessment_needed_parent" value="parent"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_needed_help) && $hpc[0]->domain5_self_assessment_needed_help === 'parent') ? 'checked' : ''; ?>>
                                                <label for="domain5_needed_parent">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_needed_parent">Parent</label>
                                            </div>
                                        </div>

                                        <!-- Fifth option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_self_assessment_needed_help"
                                                    id="domain5_self_assessment_needed_someone_else"
                                                    value="someone_else"
                                                    <?= (isset($hpc[0]->domain5_self_assessment_needed_help) && $hpc[0]->domain5_self_assessment_needed_help === 'someone_else') ? 'checked' : ''; ?>>
                                                <label for="domain5_needed_someone_else">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/8.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_self_assessment_needed_someone_else">Someone
                                                    else</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how your friend worked on this activity.
                        </h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 peerAssessment">
                                    Peer Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>My friend liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_liked_work"
                                                    id="domain5_peer_assessment_liked_yes" value="yes"
                                                    <?php if($hpc[0]->domain1_peer_assessment_liked_work == 'yes') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_liked_work"
                                                    id="domain5_peer_assessment_liked_no" value="no"
                                                    <?php if($hpc[0]->domain1_peer_assessment_liked_work == 'no') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_liked_work"
                                                    id="domain5_peer_assessment_liked_dont_know" value="dont_know"
                                                    <?php if($hpc[0]->domain1_peer_assessment_liked_work == 'dont_know') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_liked_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>My friend found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_easy_work"
                                                    id="domain5_peer_assessment_easy_yes" value="yes"
                                                    <?php if($hpc[0]->domain1_peer_assessment_easy_work == 'yes') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_easy_work"
                                                    id="domain5_peer_assessment_easy_no" value="no"
                                                    <?php if($hpc[0]->domain1_peer_assessment_easy_work == 'no') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_easy_work"
                                                    id="domain5_peer_assessment_easy_dont_know" value="dont_know"
                                                    <?php if($hpc[0]->domain1_peer_assessment_easy_work == 'dont_know') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, My friend needed....</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_needed_help"
                                                    id="domain5_peer_assessment_needed_classmate" value="classmate"
                                                    <?php if($hpc[0]->domain1_peer_assessment_needed_help == 'classmate') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_needed_help"
                                                    id="domain5_peer_assessment_needed_teacher" value="teacher"
                                                    <?php if($hpc[0]->domain1_peer_assessment_needed_help == 'teacher') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_needed_help"
                                                    id="domain5_peer_assessment_needed_books" value="books"
                                                    <?php if($hpc[0]->domain1_peer_assessment_needed_help == 'books') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_needed_help"
                                                    id="domain5_peer_assessment_needed_computer" value="computer"
                                                    <?php if($hpc[0]->domain1_peer_assessment_needed_help == 'computer') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>

                                        <!-- Fifth option with radio button -->
                                        <div class="col-md-1">
                                            <div class="icon">
                                                <input type="radio" name="domain5_peer_assessment_needed_help"
                                                    id="domain5_peer_assessment_needed_none" value="none"
                                                    <?php if($hpc[0]->domain1_peer_assessment_needed_help == 'none') echo 'checked'; ?>>
                                                <label for="domain5_peer_assessment_needed_none">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/8.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_peer_assessment_needed_none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


            </table>

            <table>
                <tr>
                    <td class="text-start leftHed" style="width: 50%;">
                        Parents/Caregiver/Guardian's Observation
                    </td>
                    <td class="leftHed">
                    </td>
                </tr>
                <tr>
                    <td class="text-start">
                        <h5 class="text-start">Circle the relevant response.</h5>
                        <div class="col-md-12">
                            <div class="hed infoBg">
                                <h6>Learning Teaching resources at home</h6>
                            </div>
                            <div class="bod row">
                                <!-- First option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_needed_help" id="domain5_needed_classmate"
                                            value="classmate"
                                            <?= ($hpc[0]->domain5_needed_help == 'classmate') ? 'checked' : '' ?>>
                                        <label for="domain5_needed_classmate">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/6.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_needed_classmate">books/magazine</label>
                                    </div>
                                </div>

                                <!-- Second option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_needed_help" id="domain5_needed_teacher"
                                            value="teacher"
                                            <?= ($hpc[0]->domain5_needed_help == 'teacher') ? 'checked' : '' ?>>
                                        <label for="domain5_needed_teacher">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/9.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_needed_teacher">newspaper</label>
                                    </div>
                                </div>

                                <!-- Third option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_needed_help" id="domain5_needed_books"
                                            value="books"
                                            <?= ($hpc[0]->domain5_needed_help == 'books') ? 'checked' : '' ?>>
                                        <label for="domain5_needed_books">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/10.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_needed_books">toys/games/sports</label>
                                    </div>
                                </div>

                                <!-- Fourth option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_needed_help" id="domain5_needed_computer"
                                            value="computer"
                                            <?= ($hpc[0]->domain5_needed_help == 'computer') ? 'checked' : '' ?>>
                                        <label for="domain5_needed_computer">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/7.png" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_needed_computer">phone/computer</label>
                                    </div>
                                </div>

                                <!-- Fifth option with radio button -->
                                <div class="col-md-1">
                                    <div class="icon">
                                        <input type="radio" name="domain5_needed_help" id="domain5_needed_none"
                                            value="none"
                                            <?= ($hpc[0]->domain5_needed_help == 'none') ? 'checked' : '' ?>>
                                        <label for="domain5_needed_none">
                                            <img src="<?= base_url(); ?>assets/uploads/hpc/12.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_needed_none">internet</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </div>
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">
    </fieldset>

    <!--DOMAIN 5 END -->
    <!--DOMAIN 5.1 Start -->


    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">DOMAIN 5.1:</h2>
                </div>

            </div>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">DOMAIN 5.1:</span> Positive Learning Habits
                    </th>
                </tr>
                <tr>
                    <td class="text-strat">
                        <h3>Curricular Goals:</h3>
                        <ul style="margin-left: 11px;">
                            <li style="list-style: disc;">Children develop habits of learning that allow them to engage
                                actively in formal learning environments like a school classroom.</li>
                        </ul>
                    </td>
                    <td class="text-strat">
                        <h3>Competency/Competencies</h3>
                        <textarea type="text" name="domain5_1_competencies" class="form-control"
                            id="domain5_1_competencies"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain5_1_competencies); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ACTIVITY</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain5_1_activity" class="form-control" id="domain5_1_activity"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain5_1_activity); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">ASSESSMENT QUESTIONS</span>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <textarea type="text" name="domain5_1_assessment_questions" class="form-control"
                            id="domain5_1_assessment_questions"
                            aria-describedby="emailHelp"><?php echo htmlspecialchars($hpc[0]->domain5_1_assessment_questions); ?></textarea>
                    </td>
                </tr>
            </table>


            <table class="assessment">
                <tr>
                    <th colspan="4" class="text-center">ASSESSMENT RUBRIC*</th>
                </tr>
                <tr>
                    <th class="bgLightOreng"></th>
                    <th class="bgLightOreng">Stream</th>
                    <th class="bgLightOreng">Mountain</th>
                    <th class="bgLightOreng">Sky</th>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Awareness</td>
                    <td>
                        <input type="text" name="domain5_1_awareness_stream" class="form-control"
                            id="domain5_1_awareness_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_awareness_stream); ?>"
                            aria-describedby="emailHelp">
                    </td>
                    <td>
                        <input type="text" name="domain5_1_awareness_mountain" class="form-control"
                            id="domain5_1_awareness_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_awareness_mountain); ?>"
                            aria-describedby="emailHelp">
                    </td>
                    <td>
                        <input type="text" name="domain5_1_awareness_sky" class="form-control"
                            id="domain5_1_awareness_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_awareness_sky); ?>"
                            aria-describedby="emailHelp">
                    </td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Sensitivity</td>
                    <td>
                        <input type="text" name="domain5_1_sensitivity_stream" class="form-control"
                            id="domain5_1_sensitivity_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_sensitivity_stream); ?>"
                            aria-describedby="emailHelp">
                    </td>
                    <td>
                        <input type="text" name="domain5_1_sensitivity_mountain" class="form-control"
                            id="domain5_1_sensitivity_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_sensitivity_mountain); ?>"
                            aria-describedby="emailHelp">
                    </td>
                    <td>
                        <input type="text" name="domain5_1_sensitivity_sky" class="form-control"
                            id="domain5_1_sensitivity_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_sensitivity_sky); ?>"
                            aria-describedby="emailHelp">
                    </td>
                </tr>
                <tr class="icon-row">
                    <td class="leftHed">Creativity</td>
                    <td>
                        <input type="text" name="domain5_1_creativity_stream" class="form-control"
                            id="domain5_1_creativity_stream"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_creativity_stream); ?>"
                            aria-describedby="emailHelp">
                    </td>
                    <td>
                        <input type="text" name="domain5_1_creativity_mountain" class="form-control"
                            id="domain5_1_creativity_mountain"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_creativity_mountain); ?>"
                            aria-describedby="emailHelp">
                    </td>
                    <td>
                        <input type="text" name="domain5_1_creativity_sky" class="form-control"
                            id="domain5_1_creativity_sky"
                            value="<?php echo htmlspecialchars($hpc[0]->domain5_1_creativity_sky); ?>"
                            aria-describedby="emailHelp">
                    </td>
                </tr>
            </table>

            <p><b>*Note:</b> Circle the relevant performance level based on the individual student's performance for
                each ability for this activity.</p>


        </div>
        <!--<input type="button" name="next" class="next action-button" value="Submit"> -->
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">

    </fieldset>
    <fieldset class="feedbacktech">
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">TEACHER'S FEEDBACK<:< /h2>
                </div>

            </div> <br><br>
            <table>
                <tr>
                    <th colspan="2" class="text-center">
                        <span class="note text-center">TEACHER'S FEEDBACK:</span>
                    </th>
                </tr>
                <tr>
                    <td class="text-strat leftHed">
                        <b>NOTE:</b> For each ability, mark the appropriate level
                    </td>
                    <td class="text-strat leftHed">
                        <b>Observational Notes</b>
                    </td>
                </tr>

                <tr>
                    <td class="text-strat">
                        <img src="<?=base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                    </td>
                    <td class="text-strat">
                        <textarea type="text" name="domain5_1_teacher_feedback_notes" class="form-control"
                            id="domain5_1_exampleInputEmail1"
                            aria-describedby="emailHelp"><?= $hpc[0]->domain1_teacher_feedback_notes; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how you worked on this activity.</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 selfAssessment">
                                    Self Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>I liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_liked_work"
                                                    id="domain5_1_self_assessment_liked_yes" value="yes"
                                                    <?= ($hpc[0]->domain1_self_assessment_liked_work == 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_self_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_liked_work"
                                                    id="domain5_1_self_assessment_liked_no" value="no"
                                                    <?= ($hpc[0]->domain1_self_assessment_liked_work == 'no') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_self_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_liked_no">No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_liked_work"
                                                    id="domain5_1_liked_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain1_self_assessment_liked_work == 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_self_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_liked_dont_know">Do not
                                                    know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>I found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_easy_work"
                                                    id="domain5_1_self_assessment_easy_yes" value="yes"
                                                    <?= ($hpc[0]->domain1_self_assessment_easy_work == 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_self_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_easy_work"
                                                    id="domain5_1_easy_no" value="no"
                                                    <?= ($hpc[0]->domain1_self_assessment_easy_work == 'no') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_easy_no">No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_easy_work"
                                                    id="domain5_1_easy_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain1_self_assessment_easy_work == 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_easy_dont_know">Do not know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, I needed...</h6>
                                    </div>
                                    <div class="bod row">
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_needed_help"
                                                    id="domain5_1_self_assessment_needed_classmate" value="classmate"
                                                    <?= ($hpc[0]->domain1_self_assessment_needed_help == 'classmate') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label
                                                    for="domain5_1_self_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_needed_help"
                                                    id="domain5_1_self_assessment_needed_teacher" value="teacher"
                                                    <?= ($hpc[0]->domain1_self_assessment_needed_help == 'teacher') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_needed_help"
                                                    id="domain5_1_self_assessment_needed_books" value="books"
                                                    <?= ($hpc[0]->domain1_self_assessment_needed_help == 'books') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_self_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_needed_books">Books</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_self_assessment_needed_help"
                                                    id="domain5_1_self_assessment_needed_nothing" value="nothing"
                                                    <?= ($hpc[0]->domain1_self_assessment_needed_help == 'nothing') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_self_assessment_needed_nothing">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_self_assessment_needed_nothing">Nothing</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" class="text-center">
                        <h5 class="text-start">Circle the picture that shows how your friend worked on this activity.
                        </h5>
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Self Assessment Title -->
                                <div class="col-md-2 peerAssessment">
                                    Peer Assessment
                                </div>

                                <!-- Question 1: I liked doing this work -->
                                <div class="col-md-3">
                                    <div class="hed gereenBg">
                                        <h6>My friend liked doing this work.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_liked_work"
                                                    id="domain5_1_peer_assessment_liked_yes" value="yes"
                                                    <?= ($hpc[0]->domain1_peer_assessment_liked_work === 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_liked_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_liked_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_liked_work"
                                                    id="domain5_1_peer_assessment_liked_no" value="no"
                                                    <?= ($hpc[0]->domain1_peer_assessment_liked_work === 'no') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_liked_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_liked_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_liked_work"
                                                    id="domain5_1_peer_assessment_liked_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain1_peer_assessment_liked_work === 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_liked_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_liked_dont_know">Do not
                                                    know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: I found this work easy -->
                                <div class="col-md-3">
                                    <div class="hed pinkBg">
                                        <h6>My friend found this work easy.</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_easy_work"
                                                    id="domain5_1_peer_assessment_easy_yes" value="yes"
                                                    <?= ($hpc[0]->domain1_peer_assessment_easy_work === 'yes') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_easy_yes">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/1.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_easy_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-4 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_easy_work"
                                                    id="domain5_1_peer_assessment_easy_no" value="no"
                                                    <?= ($hpc[0]->domain1_peer_assessment_easy_work === 'no') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_easy_no">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/2.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_easy_no">No</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-4">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_easy_work"
                                                    id="domain5_1_peer_assessment_easy_dont_know" value="dont_know"
                                                    <?= ($hpc[0]->domain1_peer_assessment_easy_work === 'dont_know') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_easy_dont_know">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/3.webp"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_easy_dont_know">Do not
                                                    know</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: To do this work, I needed... -->
                                <div class="col-md-4">
                                    <div class="hed infoBg">
                                        <h6>To do this work, My friend needed....</h6>
                                    </div>
                                    <div class="bod row">
                                        <!-- First option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_needed_help"
                                                    id="domain5_1_peer_assessment_needed_classmate" value="classmate"
                                                    <?= ($hpc[0]->domain1_peer_assessment_needed_help === 'classmate') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_needed_classmate">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/4.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label
                                                    for="domain5_1_peer_assessment_needed_classmate">Classmate</label>
                                            </div>
                                        </div>

                                        <!-- Second option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_needed_help"
                                                    id="domain5_1_peer_assessment_needed_teacher" value="teacher"
                                                    <?= ($hpc[0]->domain1_peer_assessment_needed_help === 'teacher') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_needed_teacher">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/5.png"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_needed_teacher">Teacher</label>
                                            </div>
                                        </div>

                                        <!-- Third option with radio button -->
                                        <div class="col-md-2 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_needed_help"
                                                    id="domain5_1_peer_assessment_needed_books" value="books"
                                                    <?= ($hpc[0]->domain1_peer_assessment_needed_help === 'books') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_needed_books">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_needed_books">Books</label>
                                            </div>
                                        </div>

                                        <!-- Fourth option with radio button -->
                                        <div class="col-md-3 boderLeft">
                                            <div class="icon">
                                                <input type="radio" name="domain5_1_peer_assessment_needed_help"
                                                    id="domain5_1_peer_assessment_needed_computer" value="computer"
                                                    <?= ($hpc[0]->domain1_peer_assessment_needed_help === 'computer') ? 'checked' : ''; ?>>
                                                <label for="domain5_1_peer_assessment_needed_computer">
                                                    <img src="<?=base_url(); ?>assets/uploads/hpc/7.jpg"
                                                        class="iocnImg">
                                                </label>
                                            </div>
                                            <div class="iconText">
                                                <label for="domain5_1_peer_assessment_needed_computer">Computer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


            </table>

            <table>
                <tr>
                    <td class="text-start leftHed" style="width: 50%;">
                        Parents/Caregiver/Guardian's Observation
                    </td>
                    <td class="leftHed"></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <h5 class="text-start">Circle the relevant response.</h5>
                        <div class="col-md-12">
                            <div class="hed infoBg">
                                <h6>Learning Teaching resources at home</h6>
                            </div>
                            <div class="bod row">
                                <!-- First option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_1_needed_help" id="domain5_1_needed_classmate"
                                            value="classmate"
                                            <?= isset($hpc[0]->domain5_1_needed_help) && $hpc[0]->domain5_1_needed_help === 'classmate' ? 'checked' : '' ?>>
                                        <label for="domain5_1_needed_classmate">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/6.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_1_needed_classmate">books/magazine</label>
                                    </div>
                                </div>

                                <!-- Second option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_1_needed_help" id="domain5_1_needed_teacher"
                                            value="teacher"
                                            <?= isset($hpc[0]->domain5_1_needed_help) && $hpc[0]->domain5_1_needed_help === 'teacher' ? 'checked' : '' ?>>
                                        <label for="domain5_1_needed_teacher">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/9.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_1_needed_teacher">newspaper</label>
                                    </div>
                                </div>

                                <!-- Third option with radio button -->
                                <div class="col-md-2 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_1_needed_help" id="domain5_1_needed_books"
                                            value="books"
                                            <?= isset($hpc[0]->domain5_1_needed_help) && $hpc[0]->domain5_1_needed_help === 'books' ? 'checked' : '' ?>>
                                        <label for="domain5_1_needed_books">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/10.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_1_needed_books">toys/games/sports</label>
                                    </div>
                                </div>

                                <!-- Fourth option with radio button -->
                                <div class="col-md-3 boderLeft">
                                    <div class="icon">
                                        <input type="radio" name="domain5_1_needed_help" id="domain5_1_needed_computer"
                                            value="computer"
                                            <?= isset($hpc[0]->domain5_1_needed_help) && $hpc[0]->domain5_1_needed_help === 'computer' ? 'checked' : '' ?>>
                                        <label for="domain5_1_needed_computer">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/7.png" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_1_needed_computer">phone/computer</label>
                                    </div>
                                </div>

                                <!-- Fifth option with radio button -->
                                <div class="col-md-1">
                                    <div class="icon">
                                        <input type="radio" name="domain5_1_needed_help" id="domain5_1_needed_none"
                                            value="none"
                                            <?= isset($hpc[0]->domain5_1_needed_help) && $hpc[0]->domain5_1_needed_help === 'none' ? 'checked' : '' ?>>
                                        <label for="domain5_1_needed_none">
                                            <img src="<?=base_url(); ?>assets/uploads/hpc/12.jpg" class="iocnImg">
                                        </label>
                                    </div>
                                    <div class="iconText">
                                        <label for="domain5_1_needed_none">internet</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>


        </div>
        <input type="button" name="next" class="next action-button" value="Next">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">

    </fieldset>
    <fieldset>
        <div class="form-card">
            <div class="row">
                <div class="col-7">
                    <h2 class="fs-title">PART C</h2>
                    <h2 class="fs-title">SUMMARY FOR THE ACADEMIC YEAR</h2>
                    <h2>KEY PERFORMANCE DESCRIPTORS</h2>
                    <h6>(Qualitative inputs by teacher based on the student's ability)</h6>
                </div>
            </div>
            <div class="partC">
                <table>
                    <tr>
                        <td class="text-strat">
                            <h4>Awareness</h4>
                            <img src="<?= base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                        </td>
                        <td class="text-strat" rowspan="3">
                            <h6>Physical Development</h6>
                            <textarea name="physical_development" class="form-control" id="physical_development"
                                aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->physical_development) ?></textarea>

                            <h6>Socio-Emotional Development</h6>
                            <textarea name="socio_emotional_development" class="form-control"
                                id="socio_emotional_development"
                                aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->socio_emotional_development) ?></textarea>

                            <h6>Cognitive Development</h6>
                            <textarea name="cognitive_development" class="form-control" id="cognitive_development"
                                aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->cognitive_development) ?></textarea>

                            <h6>Language and Literacy Development</h6>
                            <textarea name="language_and_literac_development" class="form-control"
                                id="language_and_literac_developmentlanguage_and_literac_development"
                                aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->language_and_literac_development) ?></textarea>

                            <h6>Aesthetic and Cultural Development</h6>
                            <textarea name="aesthetic_and_cultural_development" class="form-control"
                                id="aesthetic_and_cultural_development"
                                aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->aesthetic_and_cultural_development) ?></textarea>

                            <h6>Positive Learning Habits</h6>
                            <textarea name="positive_learning_habits" class="form-control" id="positive_learning_habits"
                                aria-describedby="emailHelp"><?= htmlspecialchars($hpc[0]->positive_learning_habits) ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-strat">
                            <h4>Sensitivity</h4>
                            <img src="<?= base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-strat">
                            <h4>Creativity</h4>
                            <img src="<?= base_url(); ?>assets/uploads/hpc/sky.jpg" class="sky">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <input type="submit" name="next" class="next action-button submitBtn" value="Submit">
        <input type="button" name="previous" class="previous action-button-previous" value="Previous">

    </fieldset>

    <!--DOMAIN 5.1 END -->
</form>
<button type="button" name="printSpecificForm" onclick="printForm();" class="print action-button-print btn btn-info"
    value="Print">Print</button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
// Define the function in the global scope
function printForm() {
    // Get the content of the form using jQuery
    var printContent = $('#hpcform').html();

    // Open a new window
    var printWindow = window.open('', '_blank'); // Create a new blank window

    // Write content to the new window
    printWindow.document.open();
    printWindow.document.write(`
        <html>
            <head>
                <title>Print</title>

                <link rel="stylesheet" href="https://www.scmemorialschool.com/assets/admin/css/bootstrap.min.css" />
                <link rel="stylesheet" href="https://www.scmemorialschool.com/assets/css/hpc.css" />
                <style>
                    /* Optional: Add any additional styles needed for printing */
                    body {
                        margin: 0;
                        padding: 20px; /* Adjust as needed */
                    }
                    /* Add other print-specific styles here */
                        
                        table {
                            width: 100%;
                        }
                            .col-md-3 {
        width: 25%;
    }
        .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
        float: left;
    }
                   .col-md-1 {
        width: 8.333%;
    }
        .col-md-5 {
        width: 41.666%;
    }
        .col-md-4 {
        width: 33.333%;
    }
        .col-md-2 {
        width: 16.666%;
    }
        .col-md-8 {
        width: 66.666%;
    }
        .col-md-10 {
        width: 83.333%;
    }
    .btn-group-vertical>.btn-group:after, .btn-group-vertical>.btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .modal-header:after, .modal-header:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
    content: " ";
    display: table;
}
.col-md-10 {
        width: 83.333%;
    }
    .action-button, .action-button-previous { display: none; }
     th {
    background-color: orange;
    color: #fff;
}
                </style>
            </head>
            <body>
                ${printContent}
            </body>
        </html>
    `);
    printWindow.document.close();

    // Wait for the content to load before printing
    $(printWindow).on('load', function() {
        printWindow.focus(); // Focus on the new window to print
        printWindow.print(); // Print the new window content
        printWindow.close(); // Optional: close the window after printing
    });
}


$(document).ready(function() {
    var current_fs, next_fs, previous_fs; // fieldsets
    var opacity;
    var current = 1; // Start from the first step
    var steps = $("fieldset").length; // Total number of steps
    setProgressBar(current); // Set initial progress bar

    $(".next").click(function() {
        current_fs = $(this).parent(); // Get the current fieldset
        next_fs = $(this).parent().next(); // Get the next fieldset

        // Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        // Show the next fieldset
        next_fs.show();
        // Hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now; // Calculate opacity
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                }); // Hide current
                next_fs.css({
                    'opacity': opacity
                }); // Set opacity for next
            },
            duration: 500
        });
        setProgressBar(++current); // Update progress
    });

    $(".previous").click(function() {
        current_fs = $(this).parent(); // Get the current fieldset
        previous_fs = $(this).parent().prev(); // Get the previous fieldset

        // Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        // Show the previous fieldset
        previous_fs.show();
        // Hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                opacity = 1 - now; // Calculate opacity
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                }); // Hide current
                previous_fs.css({
                    'opacity': opacity
                }); // Set opacity for previous
            },
            duration: 500
        });
        setProgressBar(--current); // Update progress
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep; // Calculate percent
        percent = percent.toFixed(); // Round percent
        $(".progress-bar").css("width", percent + "%"); // Update progress bar width
    }

    $(".submit").click(function() {
        return false; // Prevent form submission for now
    });
});
<?php if($this->session->userdata('user_type') == 3){ ?>
$(document).ready(function() {
    $('input, textarea').attr('readonly', true); // Set readonly
    $('input, textarea').attr('disabled', true); // Set disabled
    $('.action-button, .action-button-previous').removeAttr('readonly');
    $('.action-button, .action-button-previous').removeAttr('disabled');
    $('.submitBtn').css('display', 'none');
});
<?php } ?>
</script>