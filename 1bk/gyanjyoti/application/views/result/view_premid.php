<style>
    .card {
        background: #fff;
        height: auto;
    }

    .card:hover {
        background: #fff;
        height: auto;
    }

    .card:before {
        background: none;
    }
    </style>
    <style>
    .stdimg {
        max-width: 132px !important;
        min-width: 132px !important;
        min-height: 165px !important;
        max-height: 165px !important;
    }

    /* Define a print stylesheet */
    @media print {
        body {
            margin: 0;
            padding: 0;
            /*page-break-before: always;*/
            /*page-break-after: avoid;*/
        }

        .printHide {
            display: none;

        }

        .col-sm-4,
        .col-sm-6,
        .col-sm-2,
        .col-md-4,
        .col-md-6,
        .col-md-2,
        .col-lg-4,
        .col-lg-6,
        .col-lg-2 {
            float: left;
        }

        .stdimg {
            max-width: 132px !important;
            min-width: 132px !important;
            min-height: 155px !important;
            max-height: 155px !important;
        }


        button#inv_items {
            display: none;
        }



    }

    @media screen and (max-width: 680px) {
        .col-lg-12.col-md-12.col-sm-12 {
            width: 100%;
        }

        .col-sm-12.no-padding-left.no-padding-right {
            overflow: auto;
        }

    }
    th {
            background: #b9b9b9 !important;
        }
        th {
    font-size: 13px !important;
}
td {
    text-align: center;
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
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php 
                // prx($_SESSION);
                if($this->session->userdata('user_type') != 'students'){ ?>
                    <form class="form-horizontal" role="form" action="javascript:;" id="getStudent">
        	                <div class="filter row mb-2 pb-4">
    	                        <div class="col-8  col-md-4 col-sm-4 col-lg-4">
                                    <label for="classFilter" class="text-light">Student Code</label>
                                    <input type="text" class="form-control student-mask-id" name="student_id" id="student_id"
    	                                required
    	                                value="<?= ($this->session->userdata('student_logged_in') == true ? $this->session->userdata('code'):'') ?>"
    	                                <?php if(isset($class_id) && $class_id != ''){ echo 'disabled'; }?>>
    	                            <?php if($this->session->userdata('student_logged_in') == true){ echo '<input type="hidden" name="student_id" value="'. $this->session->userdata('code') .'"/>'; }?>
    
    	                        </div>
    	                        <div class="col-4 col-md-2 col-sm-2 col-lg-2">
    	                            <button type="submit" class="btn btn-success mt-5 p-2 filterButton"
    	                                >Go</button>
    	                        </div>
                        </div>
                    </form>
                    <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Student Marksheet</h4>
                        

                    </div>

                    <div class="card-body" id="showResult">
                       
                    </div>
                </div>
                 <!--<?php if($this->session->userdata('user_type') != 'students'){ ?>-->
                       
                    
                 <!--<?php } ?>-->
            </div>
              <div class="print-btn">
                            <button class="bg-info text-light" onclick="window.print();">Print Certificate</button>
                        </div>
        </div>
    </div>
</div>

<!-- Add this at the bottom of your view file -->
<script>
    var baseUrl = '<?= base_url(); ?>';
$(document).ready(function () {
    // Handle class filter change
    $('#classFilter').change(function () {
        var selectedClass = $(this).val();
        if (selectedClass) {
            window.location.href = '<?= base_url("marksheet/index/") ?>' + selectedClass;
        }
    });

    <?php if ($this->session->userdata('user_type') == 'students') { ?>
        // Load grade card for students
        ajaxPostRequest(baseUrl + 'result/view_premid/loadGreadCard', { 
            classId: '', 
            studentId: <?= get_session('user_id'); ?> 
        }, function (data) {
           $("#showResult").html(data.html);
        });
    <?php } else { ?>
        // Load grade card for other users on filter button click
        $(".filterButton").click(function () {
            ajaxPostRequest(baseUrl + 'result/view_premid/loadGreadCard', { 
                classId: '', 
                studentId: $("#student_id").val() 
            }, function (data) {
                $("#showResult").html(data.html);
            });
        });
    <?php } ?>
});

function editGrade(id) {
    // Implement edit functionality
    window.location.href = '<?= base_url("marksheet/edit/") ?>' + id;
}

function deleteGrade(id) {
    if (confirm('Are you sure you want to delete this record?')) {
        window.location.href = '<?= base_url("marksheet/delete/") ?>' + id;
    }
}

</script>