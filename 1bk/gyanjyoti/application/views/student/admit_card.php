<!DOCTYPE html>
<html>
<head>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: flex-start;
        }
        .id-card {
            width: 48%;
            height: 500px;
            /* padding: 15px;*/
            /* border: 1px solid #ccc;*/
            font-family: Arial, sans-serif;
            /* background-image: url('<?php // echo base_url('assets/uploads/card/studentcard.jpg');?>');*/
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 15px;
            border-radius: 8px;
        }
        .id-head {
          margin-left: 49px;
          width: 92%;
          margin-top: -28px;
        }
        .photo-placeholder {
            width: 133px;
            height: 136px;
            margin: 14px auto;
            border: 1px solid #999;
            background: #fff;
            margin-top: 29px;
            margin-left: 102px;
            border-radius: 50%;
        }
        .photo-placeholder img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .student-details {
            margin: 10px 0;
        }
        .student-details p {
            padding: 0;
            margin: 0;
        }
        @media print {
            .card-container {
                page-break-inside: avoid;
            }
            .id-card {
                break-inside: avoid;
            }
        }
        .student-details {
          margin-left: 50px;
        }

        table#attendance-date th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        table#attendance-date th {
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <?php
        foreach($student_list as $student){
            $src = $student->student_photo ? base_url().'assets/uploads/student/'. jd($student->student_photo)[0] : base_url().'assets/noImageProfile.png';
            $section = $this->Generalmodel->getDataWhere('section', [
                'id' => $student->section,
            ]);
            $class = $this->Generalmodel->getDataWhere('class', [
                'id' => $student->class,
            ]);
           
        ?>
        <div class="id-card">
            

            <div class="BoxA border- padding mar-bot"> 
                <div class="row">
                    <div class="col-sm-12 txt-center">
                        <img src="<?= base_url() ?>/assets/uploads/LatterHead.png" width="100%"/>
                    </div>
                    
                </div>
            </div>
            <div class="BoxD border- padding mar-bot">
                <div class="row">
                    <div class="col-sm-9">
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <td><b>Class : <?=$class[0]->class_name;?></b></td>
                            </tr>
                            <tr>
                              <td><b>Section: </b> <?=$section[0]->section;?></td>
                            </tr>
                            <tr>
                              <td><b>Student Name: </b><?=$student->student_name;?></td>
                              </tr>
                            <tr>
                              <td><b>Student ID: </b><?=$student->student_code;?></td>
                            </tr>
                            <tr>
                              <td><b>Blood Group: </b><?=$student->blood_group;?></td>
                              </tr>
                            <tr>
                              <td><b>Exam: </b><?= $exam_type ?></td>
                            </tr>
                            <tr>
                              <td colspan="2" style="height: 90px;"><b>Address: </b><?=$student->permanent_address;?></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3 txt-center">
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <th scope="row txt-center"><img src="<?=$src; ?>" width="123px" height="165px" /></th>
                            </tr>
                            <tr>
                              <th scope="row txt-center"><img src="<?= base_url() ?>/assets/font-end/images/pp-sign.png" /></th>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>