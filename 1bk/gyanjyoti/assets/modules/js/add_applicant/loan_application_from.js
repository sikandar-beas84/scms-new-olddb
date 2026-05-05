$(document).ready(function() {
        
    addCoApplicantTab(); //Added by Ankit Adhikary on May 30, 2023 for multiple co applicant

    //Submit the modal form
    $("#modalLoanFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL+'save_loan_application', this, function (data) {
            // closeModal(modalId); // calling function to close Modal
            successMsg('Data save success');
            history.back();
        });
    }));

    // Photo preview
    $("#photo").change(function() {
        previewImage(this, "#photo-preview");
    });

    // ID Card preview
    $("#id-card").change(function() {
        previewImage(this, "#id-card-preview");
    });
});

//Added by Ankit Adhikary on May 30, 2023 for multiple co applicant
function addCoApplicantTab(){
    var count = $('.nav-item-co-applicant').length;
    if(count >= 5){
        errorMsg('Cannot add more than 5 Co Applicant.');
    } else{
        //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 04, 2023
        var product = gProduct;
        var product_type = gProduct_type;
        if(product_type == 11){
            product_type = 'L';
        } else if(product_type == 13){
            product_type = 'D';
        }
        ajaxPostRequest(
            pageURL + 'add_co_applicant_tab', 
            {
                'count':count,
                'product': product,             //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 04, 2023
                'product_type': product_type    //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 04, 2023
            }, 
            function (data){
                $('#pills-tab-sub').append(data.tab);
                $('#co_applicant_tab_body').append(data.tab_body);
        });
        tabArr.push(count+1);
        $('#tab_arr').val(tabArr);
    }
}


//ankit 03-06-2323 remove tabs
function closeTab(tabId = 0){
    $('#pills-home_sub_sub_group_'+tabId).remove();
    $('#tab_remove_btn_'+tabId).parent().parent().remove();

    $('.sub_nav_link').removeClass('active');
    $('#pills-home-tab_sub_sub_group_'+(tabId-1)).addClass('active');
    $('.sub_tab_pane').removeClass('active show');
    $('#pills-home_sub_sub_group_'+(tabId-1)).addClass('active show');
    var index = tabArr.indexOf(tabId);
    
    tabArr.splice(index, tabId);
    $('#tab_arr').val(tabArr);
    var activeTabCount = 0;
    $('.nav-item-co-applicant').each(function(index, value){
        activeTabCount++;
    });
    for(var i=tabId; i<=activeTabCount; i++){
        var tab_html = 'Co Applicant '+i+
                        '<span id="tab_remove_btn_'+i+'" class="remove" onclick="closeTab('+i+')"><i class="fa fa-close"></i></span>';
        $('#pills-home-tab_sub_sub_group_'+(i)).html(tab_html);
    }
}

// Function to preview the selected image
function previewImage(input, previewElement, id) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
      var reader = new FileReader();

      reader.onload = function(e) {

        // Check the file type
        if (file.type === 'application/pdf') {
            // Display a PDF preview
            $("#"+previewElement+"-preview").html('<embed src="' + e.target.result + '" width="100%" height="200px" type="application/pdf" />');
        } else if (file.type.includes('image/')) {
            // Display an image preview
            $("#"+previewElement+"-preview").html('<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 100%; height: 128px !important;">');
        } else if (file.type.includes('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
            // Display a DOCX preview
            $("#"+previewElement+"-preview").html('<div class="alert alert-warning">DOCX file cannot be previewed.</div>');
        } else {
            // File type not supported
            $("#"+previewElement+"-preview").html('<div class="alert alert-danger">File type not supported.</div>');
        }
      }

      reader.readAsDataURL(input.files[0]);
    }
}


//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 29, 2023
function addGoldTableField(){
    var count = $('.goldTableTbody').length;
    ajaxPostRequest(pageURL + 'add_gold_table_field', {'count': count}, function (data) {
        $('#gold_details_table tbody').append(data.html);

        $('#total_market_value').attr('readonly', false);       //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
        $('#item_name_'+count).select2();                       //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
        $('#no_of_item_'+count).val(0);                         //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
        $('#gross_weight_'+count).val(0);                       //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
        $('#net_weight_'+count).val(0);                         //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 29, 2023
function deleteTableBody(count){
    $('#goldTableTbody_'+count).remove();
    calculateTotalItems();                  //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
    calculateTotalGrossWeight();            //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
    calculateTotalNetWeight();              //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
    calculateTotalMarketValue();            //Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 29, 2023
function calculateMarketValue(count, gross_weight, market_rate){
    $('#market_value_'+count).val(gross_weight * market_rate);
    $('#market_value_'+count).attr('readonly', true);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 30, 2023
function calculateLendingValue(count, lending_rate, net_weight){
    $('#lending_value_'+count).val(lending_rate * net_weight);
    $('#lending_value_'+count).attr('readonly', true);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
function calculateTotalItems(){
    var count = $('.goldTableTbody').length;
    var total = 0;
    for(var i=0; i<count; i++){
        total = total + parseInt($('#no_of_item_'+i).val());
    }
    $('#total_no_of_items').val(total);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
function calculateTotalGrossWeight(){
    var count = $('.goldTableTbody').length;
    var total = 0;
    for(var i=0; i<count; i++){
        total = total + parseInt($('#gross_weight_'+i).val());
    }
    $('#total_gross_weight').val(total);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
function calculateTotalNetWeight(){
    var count = $('.goldTableTbody').length;
    var total = 0;
    for(var i=0; i<count; i++){
        total = total + parseInt($('#net_weight_'+i).val());
    }
    $('#total_net_weight').val(total);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 31, 2023
function calculateTotalMarketValue(){
    var total = parseInt($('#market_rate2').val()) * parseInt($('#total_gross_weight').val());
    $('#total_market_value').val(total);
    $('#total_market_value').attr('readonly', true);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 01, 2023
function calculateTotalLendingValue(){
    var total = parseInt($('#total_net_weight').val()) * parseInt($('#lending_rate2').val());
    $('#total_lending_value').val(total);
    $('#total_lending_value').attr('readonly', true);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 01, 2023
function calculateApprisalValue(){
    var total = parseInt($('#market_rate2').val()) * parseInt($('#total_net_weight').val());
    $('#apprisal_value').val(total);
    $('#apprisal_value').attr('readonly', true);
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 01, 2023
function calculateTotalSanctionAmount(){
    $('#total_sanction_amount').val($('#lending_rate2').val());
    $('#total_sanction_amount').attr('readonly', true);
}


//Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 08, 2023
//for added row in dynamic table
function addDynamicTableRow(tableName = '', panel_id = 0){
    var count = $('.' + tableName + '_tbody').length;
    ajaxPostRequest(pageURL + 'add_dynamic_table_row', {'count': count, 'table_name': tableName, 'panel_id': panel_id}, function (data){
        $('#' + tableName +' tbody').append(data.html);
    });
}