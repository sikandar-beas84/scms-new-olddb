
	<!-- This For CRUD -->
	<script src="<?= base_url(); ?>assets/custom/helpers/helperNew.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="<?= base_url(); ?>assets/custom/helpers/helpers.js"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->
	<script src="<?= base_url(); ?>assets/custom/helpers/imageUpload/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/normalize.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/skeleton.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/imageUpload/drop_uploader.css">
    <script src="<?= base_url(); ?>assets/custom/helpers/imageUpload/drop_uploader.js"></script>
    
	<!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/custom/helpers/crud.css"> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-HeyBYvJ6m/bhEBssY99sAQVjXQ/sqAbjp6+ptSOQ2W8Z5IF5J3/3mpo7FadLtrG+" crossorigin="anonymous"> -->
	<!-- End For CRUD --> 
     <!-- File Upload -->
<style>
    .gImage img {
    margin-top: -4px;
    }
</style>

<?php
if($dynamic_fields){}else{$dynamic_fields = [];}
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
                
                elseif ($inputType == 'int') {
                    echo '<input type="text" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g, \'\');" />';
                }
                elseif ($inputType == 'password') {
                    echo '<input type="password" name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '" value="' . $nameValue . '"  />';
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
                    echo '<input type="file" name="' . $field . '[]" class="form-control inputFile" id="' . $field . '" multiple>';
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
                            <a href="<?=$file[$field]['path'] . $nameValue; ?>" data-lightbox="example-set">
                                <img src="<?=$file[$field]['path'] . $nameValue; ?>" alt="" srcset="" width="80" height="80"
                                    class="shadow-lg rounded">


                            </a>
                            <!-- <button type="button" onclick="deleteImage(<?= $dataArray['id']; ?>,0,'single', this)"
                                class="btn-close deleteBtn crud-suhrid-btn" aria-label="Close"></button> -->
                        </div>
                        <?php endforeach;// endif;
                        else: ?>
                        <div class="gImage">


                            <img src="<?=$file[$field]['errorPath']; ?>" alt="" srcset="" width="80" height="80"
                                class="shadow-lg rounded">

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
                    <a href="<?=$file[$field]['path'] . $nameValue; ?>" data-lightbox="example-set">
                        <img src="<?=$file[$field]['path'] . $nameValue; ?>" alt="" srcset="" width="80" height="80"
                            class="shadow-lg rounded">


                    </a>
                    <!-- <button type="button" onclick="deleteImage(<?= $dataArray['id']; ?>,0,'single', this)"
                        class="btn-close deleteBtn crud-suhrid-btn" aria-label="Close"></button> -->
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
                echo '<select name="' . $field . '" class="form-control crud-suhrid" id="' . $field . '">';
                echo '<option value="" disabled selected>Select ' . $labelField . '</option>';
                foreach ($select[$field] as $optionValue => $optionLabel) {
                    $selected = !empty($nameValue) && ($nameValue == $optionValue) ? 'selected' : '';
                    echo '<option value="' . $optionValue . '" ' . $selected . '>' . $optionLabel . '</option>';
                }

                echo '</select>';
            } elseif (strpos($field_type, 'int') !== false) {
                echo '<label for="' . $field . '">' . $labelField. ':</label>';
                echo '<input type="number" name="' . $field . '" class="form-control crud-suhrid" min="0" id="' . $field . '" value="' . $nameValue . '" oninput="this.value=this.value.replace(/[^0-9]/g, \'\');">';
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
        <!-- <div class="col-md-12">
            <button type="submit" class="w-100 btn-success crud-suhrid-btn" >Submit</button>
        </div> -->
    </div>

<script>

</script>

<script>
$(document).ready(function() {
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

$('#store').change(function() {
        var store = $(this).val();
        // alert("Df");
        $('#item').empty();

        if (store) {
            ajaxPostRequest(baseUrl + 'inventory/purchase_entry/get_item_by_store', { store: store }, function(data) {
                $.each(data, function(key, val) {
                    $('#item').append($('<option>').val(key).text(val));
                });
            });
        }
    });
    $('#quantity').change(function() {
        calculateTotal();    
    });
    $('#price').change(function() {
        calculateTotal();
    });
    function calculateTotal(){
        var quantity = $('#quantity').val();
        var price = $('#price').val();
        $('#total_amount').val( quantity * price);
    }
</script>