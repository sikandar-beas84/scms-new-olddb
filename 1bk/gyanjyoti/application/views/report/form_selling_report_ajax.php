<!-- Stats Cards -->
<style>.card.listTableArea th, .card.listTableArea td {
    font-size: 13px;
}</style>
<div class="row g-4 mb-4">
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Applications</h6>
                                <h3 class="mb-0"><?=$count['total_applications']; ?></h3>
                            </div>
                            <div class="icon-bg bg-primary-subtle">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Approved</h6>
                                <h3 class="mb-0"><?=$count['approved_count']; ?></h3>
                            </div>
                            <div class="icon-bg bg-success-subtle">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Pending</h6>
                                <h3 class="mb-0"><?=$count['pending_count']; ?></h3>
                            </div>
                            <div class="icon-bg bg-warning-subtle">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Rejected</h6>
                                <h3 class="mb-0"><?=$count['rejected_count']; ?></h3>
                            </div>
                            <div class="icon-bg bg-danger-subtle">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Re Admission Students</h6>
                                <h3 class="mb-0"><?=$studentCount['re_admission_students']; ?></h3>
                            </div>
                            <div class="icon-bg bg-info-subtle">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card bg-secondary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Students</h6>
                                <h3 class="mb-0"><?=$studentCount['student']; ?></h3>
                            </div>
                            <div class="icon-bg bg-info-subtle">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card listTableArea" >
                    <div class="card-body">
                        
                        <table class="table" id="">
                            <thead class="bg-primary text-white table-dark">
                                <tr>
                                <th>#</th>
                                    <th>Admission Form No</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Fathers Name </th>
                                    <th>Fathers Phone </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_application as $k=>$v){ ?>
                                    <tr>
                                        <td><?=$k+1;?></td>
                                        <td><?=$v->admission_form_no;?></td>
                                        <td><?=$v->student_name;?></td>
                                        <td><?=$v->class_name;?></td>
                                        <td><?=$v->father_name;?></td>
                                        <td><?=$v->father_mobile_no;?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                          
                            </table>
                        </div>
                    </div>
                    
                    
                    
                </div>

                