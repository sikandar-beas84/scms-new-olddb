<style>
form.dropzone.dz-clickable.primary-dropzone,
.filepond {
    background: rgb(1 126 250 / 10%);
    border: 1px solid rgb(1 126 250 / 20%);
    border-radius: 0.4rem;
}

.gImage {
    width: fit-content;
    margin-top: 11px;
    margin-bottom: 10px;
    s: ;
}

input,
select {
    flex: 1;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="text"] {
    flex: 1;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-control {
    height: 50px;
    font-size: 14px;
    box-shadow: none;
    border: 1px solid #e0ecf5;
    background-clip: initial;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    background-color: var(--bs-form-control-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid var(--bs-border-color);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.375rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

h3 {
    line-height: 30px;
    font-size: 24px;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    color: #05264e;
    font-weight: 700;
    text-transform: capitalize;
}

input.form-control {
    border: 1px solid #b5b5b5;
}

select.form-control {
    border: 1px solid #b5b5b5;
}

span.notti_coun.style-2 {
    background: #0563c2;
}

.notti_coun {
    position: absolute;
    right: 10px;
    width: 18px;
    height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #333333;
    border-radius: 50%;
    font-size: 13px;
    font-weight: 600 !important;
    color: #ffffff;
}

a.filepond--credits {
    display: none;
}

br {
    display: none;
}

label {
    text-transform: capitalize;
}

button.btn-close {
    top: auto !important;
}

.gImage .btn-close {

    margin-top: 0px;
    margin-right: -17px;
    background-color: #fff;
    color: #fff !important;

}
form#mainForm select {
    height: 48px !important;
}
textarea {
    border: 1px solid #c3c3c3 !important;
}
span.subHeding {
    display: block;
    font-size: 18px;
    color: #6e6e6e;
    margin-top: 6px;
}
#mainForm hr {
    margin-bottom: 20px;
    margin-top: 13px !important;
}
.crud_from_group {
    margin-bottom: 16px;
}
div#paymentModalBody .nav-tabs {
    background: #243448 !important;
}
.dt-buttons.btn-group.flex-wrap.btn-group-sm {
    margin-top: 14px;
}
</style>

<!-- File Upload -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/normalize.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/skeleton.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/pe-icon-7-stroke.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/drop_uploader.css">


<?php
    $field_data_type = $this->db->field_data($table_name);
    $query = $this->db->query("SHOW KEYS FROM $table_name WHERE Key_name = 'PRIMARY'");
    if ($query->num_rows() > 0) {
        $primary_key = $query->row()->Column_name;
    }
    if (!empty($data)) {
        $dataArray = (array)$data[0];
        $primaryValue = $dataArray[$primary_key];
    } else {
        $primaryValue = 0;
    }
            
?>

<form method="POST" action="counties/save" id="mainForm" enctype="multipart/form-data" >
    <!-- Submit Form -->
    <input type="hidden" name="primary_key" value="<?= $primaryValue; ?>">
    <div class="col-lg-12 col-md-12 row">
        <?php foreach ($fields as $field): 
            
            $field_type = $field_data_type[array_search($field, $fields)]->type;
            if (!empty($data)) {
                
                $nameValue = $dataArray[$field];
            } else {
                $nameValue = '';
            }
            ?>
            <?php 
            if($section){
                if (array_key_exists($field, $section)) {
                    echo '<hr class="mt-4">';
                    echo '<h2>'.$section[$field].'</h2>';
                    echo '';
                    if(!empty($section[$field])){
                    echo '<hr id="hr_'.$field.'">';
                    }
                    
                }
            }
            ?>
            <div class="<?= in_array($field, array_keys($size)) ? 'col-lg-' . $size[$field] . ' col-md-' . $size[$field] : (in_array($field, $hidden) ? 'd-none' : 'col-lg-6 col-md-6') ?> crud_from_group from_group_<?=$field;?> " id="from_group_<?=$field;?>">
        <!-- <div class="  <?= in_array($field, $size) ?  'col-lg-12 col-md-12' : 'col-lg-6 col-md-6' ?>   <?= in_array($field, $hidden)?  'd-none' : '' ?>"> -->
            <?php
            $labelField = preg_replace('/([a-z])([A-Z])/', '$1 $2', $field);
            $labelField = str_replace('_', ' ', $field);

            if (in_array($field, $hidden)) {
                echo form_hidden($field, $field);
            }  
            elseif (array_key_exists($field, $fieldType)) {
                echo '<label for="' . $field . '">' . $labelField . ':</label>';
                $inputType = isset($fieldType[$field]) ? $fieldType[$field] : 'text';
            
                if ($inputType == 'tel') {
                    // For telephone input, restrict input to numeric values only
                    echo '<input type="' . $inputType . '" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g, \'\');" />';
                } 
                elseif ($inputType == 'password') {
                    echo '<input type="password" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '"  />';
                }
                elseif ($inputType == 'int') {
                    echo '<input type="text" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g, \'\');" />';
                }
                elseif ($inputType == 'text') {
                    // For text input, restrict input to alphabetic characters only
                    echo '<input type="' . $inputType . '" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g, \'\');"  title="Only alphabetic characters are allowed" />';
                } else {
                    echo '<input type="' . $inputType . '" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '" />';
                }
            }
            elseif (array_key_exists($field, $dynamic_fields)) {
                        $dynamic_field = $dynamic_fields[$field]['field'] ?? [];
                        $minLimit = $dynamic_field['min_limit'] ?? 1;
                        $maxLimit = $dynamic_field['max_limit'] ?? 6;
                        ?>
                        <label for="<?= $field; ?>"><?= $labelField; ?>:</label>
                        <div id="<?= $field; ?>_container" class="dynamic-field-container">
                            <?php if ($nameValue): $nameValue = json_decode($nameValue); ?>
                                <?php for ($i = 0; $i < count($nameValue); $i++): ?>
                                    <div class="dynamic-field-group">
                                        <input type="text" name="<?= $field; ?>[]" class="form-control crud-suhrid" value="<?= htmlspecialchars($nameValue[$i] ?? '', ENT_QUOTES); ?>" />
                                        <?php if($i == 0){ ?>
                                            <button type="button" class="btn btn-primary add-field crud-suhrid-btn" onclick="addField('<?= $field; ?>', <?= $maxLimit; ?>)">+</button>
                                        <?php } ?>                                    
                                    </div>
                                <?php endfor; ?>
                            <?php else: ?>
                                <?php for ($i = 1; $i <= $minLimit; $i++): ?>
                                    <div class="dynamic-field-group">
                                        <input type="text" name="<?= $field; ?>[]" class="form-control crud-suhrid" value="" />
                                        <?php if($i == 1){ ?>
                                            <button type="button" class="btn btn-primary add-field crud-suhrid-btn" onclick="addField('<?= $field; ?>', <?= $maxLimit; ?>)">+</button>
                                        <?php } ?>
                                        <!-- <button type="button" class="btn btn-danger remove-field" onclick="removeField(this, '<?= $field; ?>', <?= $maxLimit; ?>)">-</button> -->
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                        <script>
                            function addField(fieldName, maxLimit) {
                                var fieldContainer = document.getElementById(fieldName + '_container');
                                var fieldGroup = document.createElement('div');
                                fieldGroup.className = 'dynamic-field-group';

                                var inputField = document.createElement('input');
                                inputField.type = 'text';
                                inputField.name = fieldName + '[]';
                                inputField.className = 'form-control';

                                var removeButton = document.createElement('button');
                                removeButton.type = 'button';
                                removeButton.className = 'btn btn-danger remove-field';
                                removeButton.innerText = '-';
                                removeButton.onclick = function() {
                                    removeField(this, fieldName, maxLimit);
                                };

                                fieldGroup.appendChild(inputField);
                                fieldGroup.appendChild(removeButton);
                                fieldContainer.appendChild(fieldGroup);

                                // Check if the number of fields exceeds max limit
                                if (fieldContainer.children.length >= maxLimit) {
                                    document.querySelector('.add-field').disabled = true;
                                }
                            }

                            function removeField(button, fieldName, maxLimit) {
                                var fieldContainer = button.parentNode.parentNode;
                                button.parentNode.remove();

                                // Enable the add button if the number of fields is below the max limit
                                if (fieldContainer.children.length < maxLimit) {
                                    document.querySelector('.add-field').disabled = false;
                                }
                            }
                            </script>

                <?php
            }       
            elseif (in_array($field, $textEditor)) {
                echo '<label for="' . $field . '">' . $labelField . ':</label>';
                // For fields in the $textEditor array, initialize CKEditor
                if (array_key_exists($field, $unsetTextEditor)){
                   $coll = $unsetTextEditor[$field];
                    }
                echo '<textarea  name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" coll="'.$coll.'">'.$nameValue.'</textarea>';
                if (!array_key_exists($field, $unsetTextEditor)){
                echo '<script>CKEDITOR.replace("' . $field . '");</script>';
                }
            } elseif (array_key_exists($field, $file)) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                if (isset($file[$field]['fieldType']) && $file[$field]['fieldType'] === 'multi') {
                    // Allow multiple file selection
                    echo '<input type="file" name="' . $field . '[]" class="form-control inputFile " id="' . $field . '" multiple>';
                    ?>

                    <div class="form-group col-md-12 row">
                        <?php 
                        if(!empty($nameValue)):
                            $gallery = jd($nameValue);
                            // $nameValue = $gallery;
                            // pr($gallery); exit;
                            // if(!empty($gallery)):
                            // foreach($gallery as $key=>$value):
                                foreach($gallery as $nameValue):
                        ?>
                        <div class="gImage">
                        <button type="button" onclick="deleteImage('<?= $field; ?>', <?= $dataArray['id']; ?>,0,'multy', this)"
                        class="btn-close deleteBtn crud-suhrid-btn" aria-label="Close">X</button>
                            <a href="<?=$file[$field]['path'] . $nameValue; ?>" data-lightbox="example-set">
                                <img src="<?=$file[$field]['path'] . $nameValue; ?>" alt="" srcset="" width="80" height="80"
                                    class="shadow-lg rounded">


                            </a>
                            
                        </div>
                        <?php endforeach;// endif;
                        else: ?>
                        <div class="gImage">


                            <img src="<?=$file[$field]['errorPath']; ?>" alt="" srcset="" width="80" height="80"
                                class="shadow-lg rounded errorImg">

                            </a>

                        </div>
                        <?php     endif; ?>
                    </div>
            <?php } else {
                    // pr($file[$field]);
                    // Allow single file selection
                    echo '<input type="file" name="' . $field . '" class="form-control inputFile" id="' . $field . '">';
                    ?>
            <div class="form-group col-md-12 row">
                <?php 
                                if(!empty($nameValue)):
                                    $gallery = jd($nameValue);
                                    $nameValue = $gallery[0];
                                    // pr($gallery); exit;
                                    // if(!empty($gallery)):
                                    // foreach($gallery as $key=>$value):
                                ?>
                <div class="gImage">
                    <button type="button" onclick="deleteImage('<?= $field; ?>',<?= $dataArray['id']; ?>,0,'single', this)"
                        class="btn-close deleteBtn crud-suhrid-btn" aria-label="Close">X</button>
                    <a href="<?=$file[$field]['path'] . $nameValue; ?>" data-lightbox="example-set">
                        <img src="<?=$file[$field]['path'] . $nameValue; ?>" alt="" srcset="" width="80" height="80"
                            class="shadow-lg rounded">


                    </a>
                </div>
                <?php //////endforeach; endif;
                else: ?>
                <div class="gImage">


                    <img src="<?=$file[$field]['errorPath']; ?>" alt="" srcset="" width="80" height="80"
                        class="shadow-lg rounded errorImg">

                    </a>

                </div>
                <?php     endif; ?>
            </div>


            <?php
                }
            } elseif (array_key_exists($field, $select)) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<select name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '">';
                echo '<option value="" disabled selected>Select ' . $labelField . '</option>';
                foreach ($select[$field] as $optionValue => $optionLabel) {
                    $selected = !empty($nameValue) && ($nameValue == $optionValue) ? 'selected' : '';
                    echo '<option value="' . $optionValue . '" ' . $selected . '>' . $optionLabel . '</option>';
                }

                echo '</select>';
            } elseif (strpos($field_type, 'int') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="number" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '">';
            } elseif (strpos($field_type, 'varchar') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="text" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '">';
            }
            elseif (strpos($field_type, 'date') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="date" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '">';
            }
            else {
                // Handle other data types as needed
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                $inputType = isset($fieldType[$field]) ? $fieldType[$field] : 'text';
                echo '<input type="'.$inputType.'" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '">';
            }

            echo '<br>';
           
            ?>
        </div>
        
        <?php endforeach; ?>
            <div class="customModal" id="paymentModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content p-1" id="modalContent">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                            <div class="modal-header mb-3">
                                <h4 class="modal-title">Payment</h4>
                                <button type="button" class="close" id="paymentcloseModalBtn" aria-label="Close" onclick="closeModal('paymentModal');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-5" id="paymentModalBody">
                                <input type="hidden" id="payment_type" name="payment_type" value="">
                                <p><b>Admission From Charge: ₹</b> <?=$admissionFromCharge; ?></p>
                                
                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="false">Cash</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="qr-tab" data-toggle="tab" href="#qr" role="tab" aria-controls="qr" aria-selected="false">QR</a>
                                    </li>
                                    <!--<li class="nav-item">-->
                                    <!--    <a class="nav-link" id="online-tab" data-toggle="tab" href="#online" role="tab" aria-controls="online" aria-selected="false">Online</a>-->
                                    <!--</li>-->
                                </ul>
        
                                <!-- Tab Content -->
                                <div class="tab-content mt-3" id="paymentTabContent">
                                    <!-- Cash Tab -->
                                    <div class="tab-pane fade show " id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                        <p>Payment will be made by cash.</p>
                                        <!-- Additional fields for cash payment can go here if needed -->
                                    </div>
        
                                    <!-- QR Tab -->
                                    <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                                        <div class="form-group">
                                            <label for="utrNumber">UTR Number:</label>
                                            <input type="text" id="utrNumber" class="form-control" name="utr_number" placeholder="Enter UTR Number">
                                        </div>
                                    </div>
        
                                    <!-- Online Tab -->
                                    <!--<div class="tab-pane fade" id="online" role="tabpanel" aria-labelledby="online-tab">-->
                                    <!--    <p>Proceed with online payment.</p>-->
                                    <!--    <button type="button" class="btn btn-success" onclick="initiateEazyPayPayment()">Pay with EazyPay</button>-->
                                    <!--</div>-->
                                </div>
                            </div>
                            <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-danger actionCloseButton" data-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-primary paymentSubitButton"   style="display: none;">Submit</button>
                            </div>
                    </div>
                </div>
            </div>


        <div class="col-md-12">
            <button type="button" class="w-100 btn-success crud-suhrid-btn pay-btn" onclick="holdModal('paymentModal');" >Pay</button>
            <button type="submit" class="w-100 btn-success crud-suhrid-btn submit-btn" >Submit</button>
        </div>
        <?php if($action == '1'): ?>
            <div class="col-md-12">
                <button type="button" id="printBtn" class="w-100 btn-success crud-suhrid-print-btn">Print Application Form</button>
            </div>
        <?php endif; ?>
        
    </div>
</form>

<script>
$(document).ready(function() {
    $('#printBtn').on('click', function() {
        // Hide the print button
        $(this).hide();

        var printContents = document.querySelector('.page-body').innerHTML;
        var printWindow = window.open('', '_blank', 'height=500,width=800');

        printWindow.document.write('<html><head><title>Print</title>');
        
        // Include Bootstrap and custom stylesheets
        printWindow.document.write('<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />');
        printWindow.document.write('<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />');
        
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();

        // Show the print button again after printing
        $(this).show();
    });
});

// var inputElements = document.getElementsByClassName('filepond');

// // Configuration for the first input element
// var config = {
//     allowReorder: true,
//     maxFileSize: '4MB',
//     maxFiles: 10
// };


// var ponds = [];
// for (let i = 0; i < inputElements.length; i++) {
//     var pond = FilePond.create(inputElements[i], config);
//     ponds.push(pond);
// }
</script>

<script>

</script>

<script>
$(document).ready(function() {
    $("#from_group_bpl_no").hide();
    $(".pay-btn").show();
    $(".submit-btn").hide();
    <?php if($action == '3' || $action == '2'): ?>
     displayNone(['errorImg']);
    // fieldDisabled(['student_code']);
    // $(".pay-btn").hide();
    // $(".submit-btn").show();
    <?php endif; ?>
    <?php if($action == '2'): ?>
    $("#student_code").attr("readonly", true);
        $(".pay-btn").hide();
    $(".submit-btn").show();
    <?php endif; ?>
    <?php if($action == '1'): ?>
    fieldDisabled(['crud-suhrid','mainForm .form-control']);
   $(".crud-suhrid").attr("readonly", true);

    displayNone(['drop_uploader', 'deleteBtn','crud-suhrid-btn','add-field','remove-field',], ['file_browse', '']);
    pointerNone(['file_browse', 'dropzone','crud-suhrid'], ['father_mobile_no']);
     $(".pay-btn").show();
    $(".submit-btn").hide();
    <?php endif; ?>
});

function deleteImage(field, id, index, action, e) {
    var formData = {
        field: field,
        id: id,
        index: index,
        action: action
    };

    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to delete the image
            ajaxPostRequest(baseUrl + 'student/admission/deleteImage', formData, function(data) {
                if (data.status == 'success') {
                    Swal.fire({
                        title: "Deleted!",
                        text: data.message,
                        icon: "success"
                    });

                    // Remove the image from the DOM
                    var gImageElement = e.closest('.gImage'); // Closest gImage container
                    if (gImageElement) {
                        gImageElement.parentNode.removeChild(gImageElement);
                    }
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error"
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: "Cancelled",
                text: "Your image is safe!",
                icon: "info"
            });
        }
    });
}


$("#bpl").change(function() {
    $("#from_group_bpl_no").hide();
    if($('#bpl').val() == 'Yes'){
        $("#from_group_bpl_no").show();
    }
});

</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <script>
    var baseUrl = '<?= base_url(); ?>';
    var pageURL = 'admission/save';
    var formId = 'mainForm';

    $('#class').change(function() {
        var class_id = $(this).val();
        $('#section').empty();

        if (class_id) {
            ajaxPostRequest(baseUrl + 'attendance/add_edit_attendance/get_sections_by_class_id', { classId: class_id }, function(data) {
                $('#section').append('<option value="" disabled="" selected="">Select section</option>');
                $.each(data, function(key, val) {
                    $('#section').append($('<option>').val(key).text(val));
                });
            });
        }
    });

    
    

    $(document).ready(function() {
        $("#" + formId).submit(function(event) {
            event.preventDefault();
            if($("#primary_key").val()  == 0){
                optionalField = ['utr_number'];
            }else{
            optionalField = [
                'utr_number',
                'student_photo',
                'father_photo',
                'mother_photo',
                'local_guardian_photo',
                'attachments[]',
                'status',
                'only_child',
                'bpl',
                'academic_status_assigned',
                'student_code',
                'tc_require',
                'migration_require',
                'student_subject_option',
                'present_address',
                // 'permanent_address',
                'bank_account_no',
                'student_aadhar',
                'father_aadhar_no',
                'email_id',
                'father_mobile_no',
                'father_whatsapp_no',
                // 'father_name',
                'father_occupation',
                'father_annual_income',
                // 'mother_name',
                'mother_mobile_no',
                'mother_whatsapp_no',
                'mother_aadhar_no',
                'mother_occupation',
                'mother_annual_income',
                'local_guardian_name',
                'local_guardian_mobile_no',
                'local_guardian_whatsapp_no',
                'local_guardian_aadhar_no',
                'local_guardian_occupation',
                'local_guardian_annual_income',
                'pen',
                'local_guardian_mobile_no',
                'local_guardian_mobile_no',
                'section',
                'religion',
                'category',
                'blood_group',
                'medical_condition',
                // 'student_name',
                'banglar_siksha_id',
                'pen',
                'section',
                'ifsc',
                'mother_language',
                'second_language',
                'third_language',
                'house',
                'nationality',
                'bpl',
                'bpl_no',
                'tc_require',
                'tc_submitted_date',
                'migration_require',
                'migration_submitted_date',
                'student_subject_option[]',
                'security_money',
                'security_money_return_details',
                

            ];
            }
            if (formValidationById(formId, optionalField)) {
            // alert("sds");
                ajaxFromSubmit(baseUrl+'student/admission/save', this, function(data) {
                    if (data.status == 'success') {
                        if(data.data == null){
                            mess = 'Your From has been update successfully';
                        }else{
                            mess = 'Your From has been saved successfully, From No. is '+data.data;
                        }
                        setTimeout(function() {
                            Swal.fire({
                                title: 'Success!',
                                text: mess,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to the desired URL
                                    window.location.replace(baseUrl + "student/admission/invoice?id="+data.data);
                                }
                            });
                        }, 2000); // 2000 milliseconds = 2 seconds
                    }

                });
            }
        });
        
    });

   $(document).ready(function () {
        // Automatically show the first tab when the page loads
        // $('#paymentTabs a:first').tab('show');

        // Function to manually change tabs
        function showTab(tabId) {
            var target = $(tabId);
            if (target.length) {
                var tab = $('#paymentTabs a[href="' + tabId + '"]');
                tab.tab('show');
            }
        }

        // Example: Show the QR tab on some action
        $('#qr-tab').click(function() {
            showTab('#qr');
            $(".paymentSubitButton").show();
            $("#payment_type").val(2);
        });
        $('#online-tab').click(function() {
            showTab('#online');
            $(".paymentSubitButton").hide();
            $("#payment_type").val(3);

        });
        $('#cash-tab').click(function() {
            showTab('#cash');
            $(".paymentSubitButton").show();
            $("#payment_type").val(1);

        });
    });

    </script>
