$(document).ready(function () {
    servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');

    //Submit the modal form
    $("#modalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'save', this, function (data) {
            closeModal(modalId); // calling function to close Modal
            successMsg('Data save success');
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        });
    }));

    //Submit property modal
    //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 17, 2023
    $("#propertyModalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'field_property_save', this, function (data) {
            closeModal(coApplicantPropertyModalId); // calling function to close Modal
            successMsg(data.message);
            // servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        });
    }));

    //Submit auto field modal
    //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 23, 2023
    $("#autofieldModalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'autofield_change', this, function (data) {
            closeModal(autofetchFieldModal); // calling function to close Modal
            successMsg(data.message);
            loadFieldProperty(data.field_id);
        });
    }));
});

function openModal(id = 0, type = 0) {
    ajaxPostRequest(pageURL + 'load_modal', { 'id': id }, function (data) {
        // console.log(data);
        $('#' + modalId + '_body').html(data.html);
        $('#' + modalId + '_title').text('Add Loan Input Master');
        $(".save-btn").show();

        $('#master_or_value_div').hide();
        $('#loan_input_panel').select2();
        $('#co_aplicant_field_type').select2();
        $('#value_table_div').hide();
        $('#master_div').hide();

        holdModal(modalId);

        if (type == 1) {
            $("#" + modalId + "_body .form-control, #" + modalId + "_body input").attr('disabled', true);
            $(".save-btn").hide();
            $("#" + modalId + "_title").text('View Loan Input Master');

            if (data.field_type == 'select') {
                $('#master_or_value_div').show();
                getSelectList(data.field_type, data.master_or_value);
                masterOrValueSelect(data.master_or_value, data.master, id, type);
                // $('#table_add_action').hide();
            }
        } else if (type == 2) {
            $("#" + modalId + "_title").text('Edit Loan Input Master');
            $("#" + modalId + "_body .form-control, #" + modalId + "_body input").attr('disabled', false);

            if (data.field_type == 'select') {
                $('#master_or_value_div').show();
                getSelectList(data.field_type, data.master_or_value);
                masterOrValueSelect(data.master_or_value, data.master, id, type);
                // $('#table_add_action').show();
            }
        }
    });
}

function getSelectList(id, viewValue = '') {
    if (id == 'select') {
        ajaxPostRequest(pageURL + 'load_selectdata', { 'id': id, 'view_value': viewValue }, function (data) {
            $('#master_or_value_div').show();
            $('#master_or_value').html(data.html);
            $('#master_or_value').select2();			//Added by Suhrid Sarkar || suhrid.developer@gmail.com on April 12, 2023
        });
    } else {
        $('#master_or_value_div').hide();
        $('#master_or_value').html('');
    }
}

function masterOrValueSelect(value, master_id = '', id = 0, type = 0) {
    var serviceCount = 0;
    $('.value_table_body_tr').each(function (index, value) {
        serviceCount++;
    });
    ajaxPostRequest(pageURL + 'master_or_value_select', { 'value': value, 'count': serviceCount, 'master_id': master_id, 'id': id }, function (data) {
        console.log(type);
        if (data.value == 'M') {
            $('#master_div').show();
            $('#master').html(data.html);
            $('#master').select2();
            $('#value_table_div').hide();
            $('#value_table tbody').html('');
        } else {
            $('#master_div').hide();
            $('#master').html('');
            $('#value_table_div').show();
            $('#value_table tbody').html(data.html);
            if (type == 1) {
                $("#" + modalId + "_body .form-control").attr('disabled', true);
                $('.delBtn').attr('onclick', '');
                $('#table_add_action').children().attr('onclick', '');
            } else if (type == 2) {
                $("#" + modalId + "_body .form-control").attr('disabled', false);
                $('.delBtn').attr('onclick', 'this.parentNode.remove()');
                $('#table_add_action').children().attr('onclick', 'addValueTableRow()');
            }
        }
    });
}

function addValueTableRow() {
    var serviceCount = 0;
    $('.value_table_body_tr').each(function (index, value) {
        serviceCount++;
    });
    ajaxPostRequest(pageURL + 'add_value_table_row', { 'count': serviceCount }, function (data) {
        $('#value_table tbody').append(data.html);
    });
}

function deleteField(id = '') {
    warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function () {
        ajaxPostRequest(pageURL + 'delete', {
            "id": id
        }, function (data) {
            successMsg('Item Deleted.'); // Success Message
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list'); //Refresh Datatable
        });
    });
}

function fetchForm() {
    ajaxPostRequest(pageURL + 'fetch_form', {}, function (data) {
        $('#' + coApplicantFormModalId + '_body').html(data.html);
        $('#' + coApplicantFormModalId + '_title').text('Loan Master Form');
        holdModal(coApplicantFormModalId);
    });
}
function getPanel(id) {
    ajaxPostRequest(pageURL + 'getPanel', { 'id': id }, function (data) {
        $('#panelField').html(data.html);
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 127, 2023
//For field property
var methodArr = [];
function loadFieldProperty(fieldId = 0){
    if(fieldId != 0){
        ajaxPostRequest(pageURL + 'load_field_property', {'field_id': fieldId}, function (data) {
            $('#' + coApplicantPropertyModalId + '_body').html(data.html);
            $('#' + coApplicantPropertyModalId + '_title').text('Field Property');
            $('.methods').select2();
            $('.save-btn').show();      //CR by Suhrid Sarkar || suhrid.developer@gmail.com on July 14, 2023
            holdModal(coApplicantPropertyModalId);
            // console.log(data);
            methodArr = [];
            $.each(data.method, function (index, value){
                methodArr.push(value.function_name);
            });
            // console.log(methodArr);
        });
    } else {
        errorMsg('Field id cannot be 0');
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 17, 2023
//For added field property methods
function addMethods(){
    var count = $('.addMethodCount').length;
    ajaxPostRequest(pageURL + 'add_method', {'count': count}, function (data) {
        $('#method_table tbody').append(data.html);
        $('.methods').select2();
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 17, 2023
//For checking the same method
function setMethodValue(selectedValue = ''){
    if(selectedValue.value != ''){
        if($.inArray(selectedValue.value, methodArr) >= 0){
            errorMsg('This method is already added');
            $(selectedValue).parent().parent().remove();
        } else{
            methodArr.push(selectedValue.value);
        }
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 17, 2023
//For remving the methods
function removeMethod(tdSelector, method = ''){
    if(method != ''){
        tdSelector.parentNode.remove();
        methodArr.pop(method);
    } else{
        errorMsg('Method cannot be null');
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 23, 2023
//For updating the auto fields
function autoFillChange(isAutofield = 'N', fieldID = 0){
    let message = '', isAutoFetch = '';
    if(isAutofield == 'Y'){
        message = 'You want to change as not autofield from API';
        isAutoFetch = 'N';
    } else{
        message = 'You want to change as autofield from API';
        isAutoFetch = 'Y';
    }
    warningMsg('Are You Sure', message, 'warning', 'Change it', function () {
        if(isAutofield == 'N'){
            ajaxPostRequest(pageURL + 'autofetch_name_modal', {
                "field_id": fieldID,
                "is_autofield": isAutoFetch
            }, function (data) {
    
                $('#' + autofetchFieldModal + '_body').html(data.html);
                $('#' + autofetchFieldModal + '_title').text('Field Property');
                $('#'+autofetchFieldModal).find('.save-btn').show();
                holdModal(autofetchFieldModal);
            });
        } else{

            ajaxPostRequest(pageURL + 'autofield_change', {
                "field_id": fieldID,
                "is_autofield": isAutoFetch,
                "field_name": ""
            }, function (data) {
                successMsg(data.message);
                loadFieldProperty(data.field_id);
            });
        }
        
    });
}