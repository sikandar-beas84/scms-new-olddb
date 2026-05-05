$(document).ready(function (){
    $('#entityType').select2();
    $('#accountType').select2();
    $('#bankCode').select2();
    $('#referance_id_div').hide();
    $('#referance_form_table_div').hide();
    $("#referance_form_div").show();

    if(pageType == 'S'){
        loadBankUploadKey(customer_id);
        loadBankUploadTable(customer_id);
    }

    $('#uploadBankApi').on('submit', function (e){
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'verify', this, function (data){
            if(data.status == 'success'){
                successMsg(data.message);
                loadBankUploadKey(customer_id);
            }
        });
    });

    $('#downloadBankApi').on('submit', function (e){
        e.preventDefault();
        ajaxFromSubmit(pageURL + 'download_bank', this, function (data){
            if(data.fetch == '1'){
                successMsg(data.message);
                $("#referance_form_div").hide();
                $("#referance_form_table_div").show();
                $("#referance_form_table_div").html(data.html);

                //Datatable
                staticDataTable("bankStatementTable");
            } else{
                errorMsg(data.message);
            }
        });
    });
});

function displaySanction(accountType = '', Gcount = undefined){
    if(Gcount == undefined){
        if(accountType == 'CC' || accountType == 'OD'){
            $('#sanctionLimit').attr('readonly', false);
            $('#monthly_drawing_div').show();
            $('#monthlyDrawingTable').find('.month, .year').select2();
        } else{
            $('#sanctionLimit').attr('readonly', true);
            $('#monthly_drawing_div').hide();
            $('#monthlyDrawingTable').find('.month, .year').select2();
        }
    } else{
        if(accountType == 'CC' || accountType == 'OD'){
            $('#sanctionLimit_'+Gcount).attr('readonly', false);
            $('#monthly_drawing_div_'+Gcount).show();
            $('#monthlyDrawingTable_'+Gcount).find('.month, .year').select2();
        } else{
            $('#sanctionLimit_'+Gcount).attr('readonly', true);
            $('#monthly_drawing_div_'+Gcount).hide();
            $('#monthlyDrawingTable_'+Gcount).find('.month, .year').select2();
        }
    }
    
}

function addMonthlyDrowing(Gcount = undefined){
    var GGcount, count;
    if(Gcount == undefined){
        GGcount = 'undefined';
        count = $('.monthlyDrawingTbody').length;
    } else{
        GGcount = Gcount;
        count = $('.monthlyDrawingTbody_'+Gcount).length;
    }
    ajaxPostRequest(pageURL + 'add_monthly_drawing', {'count': count, 'g_count': GGcount}, function (data){
        if(Gcount == undefined){
            $('#monthlyDrawingTable tbody').append(data.html);
            $('#monthlyDrawingTable').find('.month, .year').select2();
        } else{
            $('#monthlyDrawingTable_'+Gcount+' tbody').append(data.html);
            $('#monthlyDrawingTable_'+Gcount).find('.month, .year').select2();
        }
    });
}

function uploadFile(count = undefined){
    var formData = new FormData();
    var fileInput;
    if(count == undefined){
        fileInput = $("#file")[0];
    } else{
        fileInput = $("#file_"+count)[0];
    }
    var file = fileInput.files[0];
    formData.append('file', file);
    formData.append([$('#csrf_token_name').val()], $('#csrf_token_hash').val());

    $.ajax({
        url: baseUrl + pageURL + 'upload_file',
        type: "POST",
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('.page_loader').show();
        },
        success: function(data) {
            if (data.csrf) {
                csrf = data.csrf;
            } else {
                csrf = data;
            }
            updateCsrf(csrf, function() {
                if (data.status == "fail" || data.status == "0") {
                    errCallBk(data);
                    $('.page_loader').hide();
                }
                else if(data.status == "2"){
                    //Confirm Message
                    $('.page_loader').hide();
                    window[data.confirm.callbackfunction](data.confirm);
                } else {
                    $('.page_loader').hide();
                    if(data.status == 'warning'){       //CR by Suhrid Sarkar || suhrid.developer@gmail.com on June 26, 2023
                        swalWarnMsg('', data.message, 'warning', 'Ok');
                    } else{
                        if(count == undefined){
                            addFileTableBody(data.file_name, data.file_type, data.file_url);
                        } else{
                            addFileTableBody(data.file_name, data.file_type, data.file_url, count);
                        }
                    }
                }
            });
        },
        error: function(errResp) {
            console.log(errResp);
            //alert("Fail")
        }
    });
}

function addFileTableBody(fileName = '', fileType = '', fileURL = '', Gcount = undefined){
    
    var GGcount, count;
    if(Gcount == undefined){
        GGcount = 'undefined';
        count = $('.fileTbody').length;
    } else{
        GGcount = Gcount;
        count = $('.fileTbody_'+Gcount).length;
    }
    ajaxPostRequest(pageURL + 'add_file_table_body', {'file_name': fileName, 'file_type': fileType, 'file_url': fileURL, 'count': count, 'g_count': GGcount}, function (data){
        if(Gcount == undefined){
            $('#file_table tbody').append(data.html);
            $('#file').val('');
        } else{
            $('#file_table_'+Gcount+' tbody').append(data.html);
            $('#file_'+Gcount).val('');
        }
    });
}

function loadBankUploadKey(customerId = 0){
    ajaxPostRequest(pageURL+'load_bank_upload_key', {'customer_id': customerId}, function (data){
        if(data.details != null && pageType == 'S'){
            $('#bank_upload_form_div').hide();
            $('#referance_id_div').show();
            $('#referance_id').text(JSON.parse(data.details.response_details).data.referenceId);
            $('#referance_id').after('&emsp;<i class="fa fa-check" id="check_btn" style="display: none;"></i><a href="javascript:void(0)" id="copy_btn" onclick="copyContent(\''+JSON.parse(data.details.response_details).data.referenceId+'\')"><i class="fa fa-clone"></i></a>');
        }
    });
}

function copyContent(content = ''){
    if (navigator.clipboard) {
        navigator.clipboard.writeText(content)
            .then(function () {
                // Clipboard write succeeded
                // You can add your success handling code here
            })
            .catch(function (err) {
                console.error('Unable to write to clipboard: ', err);
            });
    } else {
        console.error('Clipboard API not available in this browser.');
    }
    $('#check_btn').show();
    $('#copy_btn').hide();
}

function loadBankUploadTable(customerId = 0){
    ajaxPostRequest(pageURL + 'load_bank_upload_table', {'customer_id': customerId}, function (data){
        if(data.details != null && pageType == 'S'){
            $('#referance_form_table_div').show();
            $('#referance_form_table_div').html(data.html);
            $('#referance_form_div').hide();
        }
    });
}


//Multiple Bank
function addMultipleBank(){
    var count = $('.multiple_bank_body').length;
    ajaxPostRequest(pageURL + 'add_multiple_bank', {'count': count}, function (data){
        $('#multi_bank_div').append(data.html);

        $('.accountType').select2();
        $('.bankCode').select2();
    });
}

function changeBureauForm(){
    if($('input[name="bureau_info"]:checked').val() == 'retail'){
        $('#retail_div').show();
        $('#proprietorship_div').hide();
    } else if($('input[name="bureau_info"]:checked').val() == 'proprietorship'){
        $('#retail_div').hide();
        $('#proprietorship_div').show();
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on November 01, 2023
//For check bank statement
function checkBankStatement(customerId = 0){
    if(customerId != 0){
        ajaxPostRequest(pageURL + 'check_bank_statement', {'customer_id': customerId}, function (data){
            if(data.fetch == "1"){
                $("#referance_form_div").hide();
                $("#referance_form_table_div").show();
                $("#referance_form_table_div").html(data.html);

                //Datatable
                staticDataTable("bankStatementTable");
            } else{
                $("#referance_form_div").show();
                $("#referance_form_table_div").hide();
            }
            
        });
    } else{
        errorMsg("Please select a customer first");
    }
}