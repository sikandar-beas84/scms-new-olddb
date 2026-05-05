/*
Author: Suhrid Sarkar || suhrid.developer@gmail.com
File: Datatables Js File
*/

$(document).ready(function () {
    // $('#datatable').DataTable();

    //Buttons examples
    // var table = $('#datatable-buttons').DataTable({
    //     lengthChange: false,
    //     buttons: ['copy', 'excel', 'pdf', 'colvis']
    // });

    // table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    // $(".dataTables_length select").addClass('form-select form-select-sm');
});



function servSideDataTable(tabId, num_of_row, ajaxUrl, callback = '', formData = '') {
    if ($.fn.dataTable.isDataTable('#' + tabId)) {
        destroyDataTable(tabId)
    }

    // if (formData == '') {
    //     var formData = {
    //         [$("#csrf_token_name").val()]: $("#csrf_token_hash").val()
    //     }
    // } else {
    //     formData[[$('#csrf_token_name').val()]] = $('#csrf_token_hash').val();
    // }

    $("#" + tabId).DataTable({
        dom: "Bfrtip",
        // buttons: [
        //     {
        //         extend: "copyHtml5",
        //         text: '<i class="far fa-copy"></i> Copy',
        //         titleAttr: "Copy",
        //     },
        //     {
        //         extend: "excelHtml5",
        //         text: '<i class="far fa-file-excel"></i> Excel',
        //         titleAttr: "Excel",
        //     },
        //     {
        //         extend: "pdfHtml5",
        //         text: '<i class="far fa-file-pdf"></i> Pdf',
        //         titleAttr: "Pdf",
        //         orientation: "landscape",
        //         pageSize: "A4",
        //     },
        //     {
        //         extend: "colvis",
        //         text: '<i class="far fa-caret-square-down"></i> Column visibility',
        //         titleAttr: "Column visibility",
        //     },
        // ],
        processing: true,
        serverSide: false,
        pageLength: num_of_row,
        order: [],
        ajax: {
            data: formData,
            url: ajaxUrl,
            type: "POST",
            beforeSend: function () {
                // $("body").addClass("loading");
                // makeallDisabled();
                $('.global-loader').show();
            },
            complete: function (response) {
                // $("#csrf_token_name").val(response.responseJSON.csrf.csrfName);
                // $("#csrf_token_hash").val(response.responseJSON.csrf.csrfHash);
                // $("body").removeClass("loading");
                // makeallEnabled();
                $('.global-loader').hide();
            },
        },
        drawCallback: function () {
            if (callback != "") {
                callback();
            }
        },
        columnDefs: [
            {
                targets: [0],
                orderable: false,
            },
        ],
    });

    $(".dataTables_length select").addClass('form-select form-select-sm');
}

function destroyDataTable(tabId) {
    $('#' + tabId).DataTable().destroy();
}