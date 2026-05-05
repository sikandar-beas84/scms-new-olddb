var pageURL = 'master_settings/loan_panel_master/';
var tableName = 'dynamic_table';
var modalId = 'dynamic_table_modal';        //Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 07, 2023
var coApplicantPropertyModalId = 'co_applicant_property_modal';

$(document).ready(function () {
    servSideDataTable(tableName, 10, baseUrl + pageURL + 'dynamic_table_data_list/' + panel_id);

    //Submit the modal form
    $("#modalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'dynamic_table_save', this, function (data) {
            closeModal(modalId); // calling function to close Modal
            successMsg('Data save success');
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'dynamic_table_data_list/'  + data.panel_id);
        });
    }));

    //Submit property modal
    //Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 08, 2023
    $("#propertyModalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'field_property_save', this, function (data) {
            closeModal(coApplicantPropertyModalId); // calling function to close Modal
            successMsg(data.message);
            // servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        });
    }));
});

function openModal(id = 0, type = 0, panel_id = 0) {
    ajaxPostRequest(pageURL + 'load_modal', { 'id': id, 'panel_id': panel_id }, function (data) {
        $('#' + modalId + '_body').html(data.html);
        $('#' + modalId + '_title').text('Add Loan Panel');
        $(".save-btn").show();
        holdModal(modalId);
        $('#field_type').select2();

        if (type == 1) {
            $("#" + modalId + "_body .form-control, #" + modalId + "_body .form-check-input").attr('disabled', 'disabled');         //Cr by Suhrid Sarkar || suhrid.developer@gmail.com on September 07, 2023
            $(".save-btn").hide();
            $("#" + modalId + "_title").text('View Loan Panel');
        } else if (type == 2) {
            $("#" + modalId + "_title").text('Edit Loan Panel');
        }
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

function fetchTable(panel_id = 0){
    ajaxPostRequest(pageURL + 'fetch_table', {'panel_id': panel_id}, function (data) {
        $('#' + modalId + '_body').html(data.html);
        $('#' + modalId + '_title').text(data.table_name);
        $(".save-btn").hide();
        holdModal(modalId);
    });
}

function deleteField(id = '') {
    warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function () {
        ajaxPostRequest(pageURL + 'delete', {
            "id": id
        }, function (data) {
            successMsg('Item Deleted.'); // Success Message
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'dynamic_table_data_list/' + panel_id); //Refresh Datatable
        });
    });
}