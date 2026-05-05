<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Success Message -->
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Error Message -->
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <!--<div class="card-header bg-light">-->
                    <!--    <div class="d-flex justify-content-between align-items-center">-->
                    <!--        <h5 class="mb-0">-->
                    <!--            <i class="fa fa-file-import me-2"></i>Import Student Grades-->
                    <!--        </h5>-->
                    <!--        <a href="<?=base_url(); ?>assets/uploads/grade_template.csv" class="btn btn-outline-primary btn-sm" >-->
                    <!--            <i class="fa fa-download me-1"></i> Download Template-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="card-body">
                        <div class="row">
                       
                            <div class="col-md-6">
                     
                                <div class="upload-container p-4 bg-light rounded-3 border">
                                    <?php echo form_open_multipart('result/index/upload', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                                    <div class="mb-4">
                                        <label for="resultType" class="form-label">Result Type</label>
                                        <select id="resultType" name="resultType" class="form-select" required>
                                            <option value="" selected disabled>Type</option>
                                            <option value="Annually">Annually</option>
                                            <option value="Premid">Premid</option>
                                            <!--<option value="Premid">Premid</option>-->
                                        </select>
                                        <div class="invalid-feedback">Please select a class.</div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="classSelect" class="form-label">Select Class</label>
                                        <select id="classSelect" name="classSelect" class="form-select" required>
                                            <option value="" selected disabled>Select Class</option>
                                            <?php foreach($class as $key=>$v): ?>
                                            <option value="<?=$key;?>"><?=$v;?></option>
                                            <?php endforeach; ?>
                                            <!-- Add more classes as needed -->
                                        </select>
                                        <div class="invalid-feedback">Please select a class.</div>
                                    </div>

                                    <div class="upload-area mb-4 text-center p-5 border-2 border-dashed rounded-3" 
                                         id="dropZone" 
                                         style="border-style: dashed; background: #f8f9fa;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                        <h6>Drag & Drop your CSV file here</h6>
                                        <p class="text-muted small mb-3">or</p>
                                        <div class="position-relative">
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="csvFile" 
                                                   name="csvFile" 
                                                   accept=".csv" 
                                                   required 
                                                   style="display: none;">
                                            <button type="button" 
                                                    class="btn btn-primary" 
                                                    onclick="document.getElementById('csvFile').click()">
                                                Browse File
                                            </button>
                                        </div>
                                        <div class="mt-3 text-muted small">
                                            <span class="selected-file-name"></span>
                                        </div>
                                    </div>

                                    <div class="file-requirements p-3 bg-white rounded shadow-sm">
                                        <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>File Requirements</h6>
                                        <ul class="list-unstyled text-muted small">
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>File format: CSV only</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Maximum size: 2MB</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Required columns: Roll Num, Class, Name, Student Code</li>
                                        </ul>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-100" id="uploadBtn" disabled>
                                            <i class="fas fa-upload me-2"></i>Upload Grades
                                        </button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="preview-container" id="previewContainer" style="display: none;">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-table me-2"></i>File Preview</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover table-striped" id="previewTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Roll No</th>
                                                            <th>Name</th>
                                                            <th>Class</th>
                                                            <th>Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="previewBody"></tbody>
                                                </table>
                                            </div>
                                            <div class="text-muted small mt-2">
                                                Showing preview of first 5 rows
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-dashed {
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.border-dashed:hover {
    border-color: #0d6efd;
    background: #f8f9fa;
}

.upload-area {
    transition: all 0.3s ease;
}

.upload-area.drag-over {
    background: #e9ecef;
    border-color: #0d6efd;
}

.file-requirements {
    background: #fff;
    border-radius: 0.25rem;
}

.preview-container {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.preview-container.show {
    opacity: 1;
}

.selected-file-name {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: inline-block;
}
table#previewTable {
    white-space: nowrap;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const csvFile = document.getElementById('csvFile');
    const uploadBtn = document.getElementById('uploadBtn');
    const previewContainer = document.getElementById('previewContainer');
    const fileNameDisplay = document.querySelector('.selected-file-name');

    // Drag and drop handlers
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('drag-over');
    }

    function unhighlight(e) {
        dropZone.classList.remove('drag-over');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        csvFile.files = files;
        handleFiles(files);
    }

    csvFile.addEventListener('change', function(e) {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        const file = files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;
            uploadBtn.disabled = false;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const csvData = e.target.result;
                displayPreview(csvData);
                previewContainer.style.display = 'block';
                setTimeout(() => {
                    previewContainer.classList.add('show');
                }, 50);
            };
            reader.readAsText(file);
        }
    }

    function displayPreview(csvData) {
        const rows = csvData.split('\n');
        const previewBody = document.getElementById('previewBody');
        previewBody.innerHTML = '';

        const maxPreviewRows = Math.min(5, rows.length);
        for(let i = 1; i < maxPreviewRows; i++) {
            const cells = rows[i].split(',');
            const tr = document.createElement('tr');
            
            cells.slice(0, 30).forEach(cell => {
                const td = document.createElement('td');
                td.textContent = cell.trim();
                tr.appendChild(td);
            });
            
            previewBody.appendChild(tr);
        }
    }
});

// function downloadTemplate() {
//     // Create sample CSV content
//     const csvContent = "Roll Num,Class,Name,Student Code,English PT1,English MA,English PF,English SE,English HE\n1,I Venus,John Doe,GPS001,15,5,5,5,75";
    
//     // Create blob and download
//     const blob = new Blob([csvContent], { type: 'text/csv' });
//     const url = window.URL.createObjectURL(blob);
//     const a = document.createElement('a');
//     a.href = url;
//     a.download = 'grade_template.csv';
//     document.body.appendChild(a);
//     a.click();
//     document.body.removeChild(a);
//     window.URL.revokeObjectURL(url);
// }
</script>