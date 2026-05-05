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
            width: 320px;
            height: 500px;
            padding: 15px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            background-image: url('<?php echo base_url('assets/uploads/card/studentcard.jpg');?>');
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
            <div class="content-wrapper">
                 <div class="id-head">
                     <img src="<?php echo base_url('assets/uploads/card/idHed.png');?>" alt="Student Photo">
                </div>
                <div class="photo-placeholder">
                    <img src="<?=$src; ?>" alt="Student Photo">
                </div>
                
                <div class="student-details">
                    <p><strong>Student ID:</strong> <span><?=$student->student_code;?></span></p>
                    <p><strong>Name:</strong> <span><?=$student->student_name;?></span></p>
                    <p><strong>Class:</strong> <span><?=$class[0]->class_name;?></span></p>
                    <p><strong>Section:</strong> <span><?=$section[0]->section;?></span></p>
                    <p><strong>Blood Group:</strong> <span><?=$student->blood_group;?></span></p>
                    <p><strong>Address:</strong> <span><?=$student->permanent_address;?></span></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>