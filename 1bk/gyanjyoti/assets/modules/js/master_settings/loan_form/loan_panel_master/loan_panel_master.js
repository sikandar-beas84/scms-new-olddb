var pageURL = 'master_settings/loan_panel_master/';
var modalId = 'loan_panel_master_modal';
var tableName = 'loan_panel_master_table';
var dynamicTableModalId = 'dynamic_table_modal';        //Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 07, 2023
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
});

function openModal(id = 0, type = 0) {
    ajaxPostRequest(pageURL + 'load_modal', { 'id': id }, function (data) {
        $('#' + modalId + '_body').html(data.html);
        $('#' + modalId + '_title').text('Add Loan Panel');
        $(".save-btn").show();
        holdModal(modalId);
        $('#tab_id').select2();

        if (type == 1) {
            $("#" + modalId + "_body .form-control, #" + modalId + "_body .form-check-input").attr('disabled', 'disabled');         //Cr by Suhrid Sarkar || suhrid.developer@gmail.com on September 07, 2023
            $(".save-btn").hide();
            $("#" + modalId + "_title").text('View Loan Panel');
        } else if (type == 2) {
            $("#" + modalId + "_title").text('Edit Loan Panel');
        }
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