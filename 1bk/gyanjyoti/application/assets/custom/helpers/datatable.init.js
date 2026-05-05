/*
Author: Suhrid Sarkar || suhrid.developer@gmail.com
File: Datatables Js File
*/

$(document).ready(function () {
    $('#datatable').DataTable();

    // Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    $(".dataTables_length select").addClass('form-select form-select-sm');
});



function ajaxDataTable(tabId, num_of_row, ajaxUrl, callback = '', formData = '') {
    // if ($.fn.dataTable.isDataTable('#' + tabId)) {
    //     destroyDataTable(tabId)
    // }

    var table = $('#' + tabId).DataTable();

    if (table) {
        table.destroy();
    }

    if (formData == '') {
        var formData = {
            [$("#csrf_token_name").val()]: $("#csrf_token_hash").val()
        }
    } else {
        formData[[$('#csrf_token_name').val()]] = $('#csrf_token_hash').val();
    }

    var table = $("#" + tabId).DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copyHtml5",
                text: '<i class="fa fa-copy"></i> Copy',
                titleAttr: "Copy",
            },
            {
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                titleAttr: "Excel",
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                titleAttr: "Pdf",
                orientation: "landscape",
                pageSize: "A4",
            },
            // {
            //     extend: "colvis",
            //     text: '<i class="fa fa-caret-square-down"></i> Column visibility',
            //     titleAttr: "Column visibility",
            // },  //Comment by Suhrid Sarkar || suhrid.developer@gmail.com on June 08, 2023
        ],
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
                $('.page_loader').show();
            },
            complete: function (response) {
                if(response.responseJSON.csrf){
                $("#csrf_token_name").val(response.responseJSON.csrf.csrfName);
                $("#csrf_token_hash").val(response.responseJSON.csrf.csrfHash);
                }
                // $("body").removeClass("loading");
                // makeallEnabled();
                $('.page_loader').hide();
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
        // initComplete: function () {
        //     this.api()
        //         .columns()
        //         .every(function () {
        //             let column = this;
        //             let title = column.footer().textContent;
        
        //             // Define an array of column titles you want to skip
        //             let columnsToSkip = ["Action"]; // Add the titles to skip here
        
        //             // Check if the current column title is in the skip list
        //             if (!columnsToSkip.includes(title)) {
        //                 // Create input element
        //                 let input = document.createElement('input');
        //                 input.placeholder = title;
        //                 column.footer().replaceChildren(input);
        //                 input.className = title.replace(/\s+/g, '');
        
        //                 // Event listener for user input
        //                 input.addEventListener('keyup', () => {
        //                     if (column.search() !== input.value) {
        //                         column.search(input.value).draw();
        //                     }
        //                 });
        //             }
        //         });
        // }
        // Comment By Suhrid On 08-31-2024
        // initComplete: function () {
        //     this.api()
        //         .columns()
        //         .every(function () {
        //             let column = this;
        //             let table = this;
        //             var title = column.footer().textContent;
                    
        //             let columnsToSkip = ["Action"]; 
        //             // console.log(column);
        //             if (!columnsToSkip.includes(title)) {
        //                 if (title !== 'clear' && title !== 'Clear Filter') {
        //                     let container = document.createElement('div');
        //                     let input = document.createElement('input');
        //                     input.placeholder = title;
        //                     input.className = title.replace(/\s+/g, '') +' filter-input-field';
        //                     input.style.width = '100%';
        //                     // if (title === "Posted On" || title === "Date") {
        //                     //     input.type = "date"; // Set the input type to date
        //                     // }
        
        //                     input.addEventListener('keyup', () => {
        //                         if (column.search() !== input.value) {
        //                             column.search(input.value).draw();
        //                         }
        //                     });
        //                     container.appendChild(input);
                
        //                     column.footer().replaceChildren(container);
        //                 } else {
        //                     let clearButton = document.createElement('button');
        //                     clearButton.textContent = 'Clear Filter';
        //                     clearButton.className = 'clear-filter-button buttonBg';
        //                     clearButton.style.width = '100%';
        //                     clearButton.addEventListener('click', () => {
        //                         $(".filter-input-field").val("");
        //                         column.search('').draw();
        //                         refreshDataTable();
        //                     });
                
        //                     column.footer().replaceChildren(clearButton);
        //                 }
        //             }
        //         });
        // }
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    let column = this;
                    let footer = column.footer();
        
                    // Check if footer element exists
                    if (footer) {
                        let title = footer.textContent.trim(); // Use trim() to clean up any extra whitespace
                        
                        let columnsToSkip = ["Action"];
                        
                        if (!columnsToSkip.includes(title)) {
                            if (title !== 'clear' && title !== 'Clear Filter') {
                                let container = document.createElement('div');
                                let input = document.createElement('input');
                                input.placeholder = title;
                                input.className = title.replace(/\s+/g, '') + ' filter-input-field';
                                input.style.width = '100%';
        
                                input.addEventListener('keyup', () => {
                                    if (column.search() !== input.value) {
                                        column.search(input.value).draw();
                                    }
                                });
                                container.appendChild(input);
        
                                footer.replaceChildren(container);
                            } else {
                                let clearButton = document.createElement('button');
                                clearButton.textContent = 'Clear Filter';
                                clearButton.className = 'clear-filter-button buttonBg';
                                clearButton.style.width = '100%';
                                clearButton.addEventListener('click', () => {
                                    $(".filter-input-field").val("");
                                    column.search('').draw();
                                    refreshDataTable();
                                });
        
                                footer.replaceChildren(clearButton);
                            }
                        }
                    } else {
                        console.warn('Footer element not found for column:', column.index());
                    }
                });
        }
        
        
        
    });
    

    $(".dataTables_length select").addClass('form-select form-select-sm');
}

function destroyDataTable(tabId) {
    $('#' + tabId).DataTable().destroy();
}
