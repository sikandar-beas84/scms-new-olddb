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
}
</style>

<!-- File Upload -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/normalize.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/skeleton.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/pe-icon-7-stroke.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/drop_uploader.css">
<!-- <script src="<?= base_url(); ?>assets/custom/helpers/imageUpload/jquery-3.2.1.js"></script> -->
<script src="<?= base_url(); ?>assets/custom/helpers/imageUpload/drop_uploader.js"></script>
<script src="https://cdn.ckeditor.com/4.17.0/standard/ckeditor.js"></script>

<script>
$(document).ready(function() {
    $('input[type=file]').drop_uploader({
        uploader_text: 'Drop files to upload, or',
        browse_text: 'Browse',
        only_one_error_text: 'Only one file allowed',
        not_allowed_error_text: 'File type is not allowed',
        big_file_before_error_text: 'Files, bigger than',
        big_file_after_error_text: 'is not allowed',
        allowed_before_error_text: 'Only',
        allowed_after_error_text: 'files allowed',
        browse_css_class: 'button button-primary',
        browse_css_selector: 'file_browse',
        uploader_icon: '<i class="bi bi-cloud-arrow-up"></i>',
        file_icon: '<i class="pe-7s-file"></i>',
        progress_color: '#4a90e2',
        time_show_errors: 5,
        layout: 'thumbnails',
        method: 'normal',
        url: 'ajax_upload.php',
        delete_url: 'ajax_delete.php',
    });
});
</script>
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
                    if(!empty($section[$field])){
                    echo '<hr>';
                    }

                }
            }
            ?>
            <div class="<?= in_array($field, array_keys($size)) ? 'col-lg-' . $size[$field] . ' col-md-' . $size[$field] : (in_array($field, $hidden) ? 'd-none' : 'col-lg-6 col-md-6') ?> from_group_<?=$field;?>" id="from_group_<?=$field;?>">
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
                    echo '<input type="' . $inputType . '" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g, \'\');" />';
                } 
                
                elseif ($inputType == 'int') {
                    echo '<input type="text" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g, \'\');" />';
                }
                elseif ($inputType == 'text') {
                    // For text input, restrict input to alphabetic characters only
                    echo '<input type="' . $inputType . '" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g, \'\');"  title="Only alphabetic characters are allowed" />';
                } else {
                    echo '<input type="' . $inputType . '" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '" />';
                }
            }
                      
            elseif (in_array($field, $textEditor)) {
                echo '<label for="' . $field . '">' . $labelField . ':</label>';
                // For fields in the $textEditor array, initialize CKEditor
                if (array_key_exists($field, $unsetTextEditor)){
                   $coll = $unsetTextEditor[$field];
                    }
                echo '<textarea  name="' . $field . '" class="form-control" id="' . $field . '" coll="'.$coll.'"></textarea>';
                if (!array_key_exists($field, $unsetTextEditor)){
                echo '<script>CKEDITOR.replace("' . $field . '");</script>';
                }
            } elseif (array_key_exists($field, $file)) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                if (isset($file[$field]['fieldType']) && $file[$field]['fieldType'] === 'multi') {
                    // Allow multiple file selection
                    echo '<input type="file" name="' . $field . '[]" class="form-control inputFile" id="' . $field . '" multiple>';
                    ?>


            <?php } else {
                    // pr($file[$field]);
                    // Allow single file selection
                    echo '<input type="file" name="' . $field . '" class="form-control inputFile" id="' . $field . '">';
                    ?>
            <div class="form-group col-md-12 row">
                <?php 
                                if(!empty($nameValue)):
                                    // $gallery = jd($property[0]->gallery);
                                    // pr($gallery); exit;
                                    // if(!empty($gallery)):
                                    // foreach($gallery as $key=>$value):
                                ?>
                <div class="gImage">
                    <a href="<?=$file[$field]['path'] . $nameValue; ?>" data-lightbox="example-set">
                        <img src="<?=$file[$field]['path'] . $nameValue; ?>" alt="" srcset="" width="80" height="80"
                            class="shadow-lg rounded">


                    </a>
                    <button type="button" onclick="deleteImage(<?= $dataArray['id']; ?>,0,'single', this)"
                        class="btn-close deleteBtn" aria-label="Close"></button>
                </div>
                <?php //////endforeach; endif;
                else: ?>
                <div class="gImage">


                    <img src="<?=$file[$field]['errorPath']; ?>" alt="" srcset="" width="80" height="80"
                        class="shadow-lg rounded">

                    </a>

                </div>
                <?php     endif; ?>
            </div>


            <?php
                }
            } elseif (array_key_exists($field, $select)) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<select name="' . $field . '" class="form-control" id="' . $field . '">';
                echo '<option value="" disabled selected>Select ' . $labelField . '</option>';
                foreach ($select[$field] as $optionValue => $optionLabel) {
                    $selected = !empty($nameValue) && ($nameValue == $optionValue) ? 'selected' : '';
                    echo '<option value="' . $optionValue . '" ' . $selected . '>' . $optionLabel . '</option>';
                }

                echo '</select>';
            } elseif (strpos($field_type, 'int') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="number" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '">';
            } elseif (strpos($field_type, 'varchar') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="text" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '">';
            }
            elseif (strpos($field_type, 'date') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="date" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '">';
            }
            else {
                // Handle other data types as needed
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                $inputType = isset($fieldType[$field]) ? $fieldType[$field] : 'text';
                echo '<input type="'.$inputType.'" name="' . $field . '" class="form-control" id="' . $field . '" value="' . $nameValue . '">';
            }

            echo '<br>';
           
            ?>
        </div>
        
        <?php endforeach; ?>
    </div>
</form>

<script>
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
    <?php if($action == '1'): ?>
    fieldDisabled(['file_browse']);
    displayNone(['drop_uploader', 'deleteBtn'], ['file_browse', '']);
    pointerNone(['file_browse', 'dropzone'], '');
    <?php endif; ?>
});


function deleteImage(id, index, action, e) {
    var fromData = {
        id: id,
        action: action
    };

    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                if (action == 'multy') {

                } else {

                    ajaxPostRequest(baseUrl + pageURL + 'deleteImage', fromData, function(data) {

                        if (data.status == 'success') {
                            swal(data.message, {
                                icon: "success",
                            });
                            ajaxDataTable(tableId, 10, baseUrl + pageURL + 'list');
                            var gImageElement = e.parentNode;
                            gImageElement.parentNode.removeChild(gImageElement);
                            // closeModal(modalId);
                        } else {
                            swal(data.message, {
                                icon: "error",
                            });
                        }
                    });
                }


            } else {
                swal("Your data is safe!");
            }
        })


}
$("#bpl").change(function() {
    $("#from_group_bpl_no").hide();
    if($('#bpl').val() == 'Yes'){
        $("#from_group_bpl_no").show();
    }
});

</script>

