$(document).ready(function() {
    // servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
    $('#Customer_id').select2();
    $('#product_type').select2();
    $('#product').select2();
});

function getDataList(Customer_id = 0){
    servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list/'+Customer_id);
}

$(document).ready(function() {
    backFunction();     //CR by Suhrid Sarkar || suhrid.developer@gmail.com on June 21, 2023
    // servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
    
    //Submit the modal form
    $("#modalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL+'save', this, function (data) {
            closeModal(modalId); // calling function to close Modal
            successMsg('Data save success');
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        });
    }));
});

function openModal(id = 0, type = 0){
    ajaxPostRequest(pageURL+'load_modal',{'id': id}, function(data) {
        $('#'+modalId+'_body').html(data.html);
        $('#'+modalId+'_title').text('Add Applicant');
        $(".save-btn").show();
        $("#modelFooter").show();
        $('#applicant_type').select2();
        holdModal(modalId);
        $("#type_applicant").attr("style", 'display:block ');
        if(type == 1){
            $("#"+modalId+"_body .form-control").attr('disabled', 'disabled');
            $("#"+modalId+"_body #account_type").attr('disabled', 'disabled');
            $("#"+modalId+"_body #product_type").attr('disabled', 'disabled');
            $("#"+modalId+"_body #product").attr('disabled', 'disabled');
            $("#"+modalId+"_body .form-check-input").attr('disabled', 'disabled');
            $(".save-btn").hide();
            $("#"+modalId+"_title").text('View Applicant');
            $("#type_applicant").attr("style", 'display:none ');
            $(".show_for_new").show();
        } else if(type == 2){
            $("#"+modalId+"_title").text('Edit Applicant');
            $("#type_applicant").attr("style", 'display:none ');
            $(".show_for_new").show();
        }
        
    });
}

//05-06-23 MDFY by Ankit Adhikary
//Cr by Suhrid Sarkar || suhrid.developer@gmail.com on July 03, 2023
function checkNewExisting(newOrExisting = ''){
    if(newOrExisting != ''){
        if(newOrExisting == "existing"){
            $("#check_aadhar_number_div").show();
            $("#existing_aadharverify").show();
            $("#show_for_new").html("");        //Cr by Suhrid Sarkar || suhrid.developer@gmail.com on July 03, 2023
        } else{
            $("#check_aadhar_number_div").hide();
            $("#existing_aadharverify").hide();
            var product_type = $('#product_type').val();
            if(product_type == 11){
                product_type = 'L';
            } else if(product_type == 13){
                product_type = 'D';
            }
            //Cr by Suhrid Sarkar || suhrid.developer@gmail.com on July 03, 2023
            ajaxPostRequest(pageURL + 'check_new_existing', {'product': $('#product').val(), 'product_type': product_type}, function (data) {
                $("#show_for_new").html(data.html);
            });
        }
        
    } else{
        warnMsg('Please select NEW or Existing customer first!');
    }
}

function getProductDataList(id){
    ajaxPostRequest(pageURL+'load_product',{'id': id}, function(data) {
        $('#productfield').html(data.html);
    });
}

function deleteField(id = ''){
    warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function () {
        ajaxPostRequest(pageURL+'delete', {
            "id": id
        }, function (data) {
            successMsg('Item Deleted.'); // Success Message
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list'); //Refresh Datatable
        });
    });       
}

function get_load_verify_from(id, action, co_applicent = ''){
    ajaxPostRequest(pageURL+'load_verify_from',{'id': id, 'action': action, 'co_applicent': co_applicent}, function(data) {
        $("#addbtn").hide();
        $('#chengeData').html(data.html);
        $('#backBtn').show();
        //  closeModal(modalId)
    });
}


//Added by Suhrid Sarkar || suhrid.developer@gmail.com on June 21, 2023
//For navigation
function backFunction(){
    ajaxPostRequest(pageURL + 'get_datatable_body', {}, function (data) {
        $('#chengeData').html(data.html);
        servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        $('#backBtn').hide();
        $("#addbtn").show();
    });
}


function dataVerify(id,sub_tab_id,document_id, action, co_applicent){
    var field = $("#"+sub_tab_id+"_"+"field").val().split(",");
    var dob = new Date($("#pan_dob").val());
    var formattedDate = formatDate(dob);

    var body = {};
    var file = '';
    $.each(field, function(index, key) {
        
        if(key == 'dob'){
            if(sub_tab_id == 1){
                var dob = new Date($("#"+sub_tab_id+"_"+key).val());
                var formattedDate = formatDate(dob,'/');
            }else if(sub_tab_id == 3){
                var dob = new Date($("#"+sub_tab_id+"_"+key).val());
                var formattedDate = formatDate(dob,'-');
            }else{
                var formattedDate = $("#"+sub_tab_id+"_"+key).val();
            }
            body[key] = formattedDate;

        }else if (key == 'file'){
            // file = $("#"+sub_tab_id+"_"+key).files[0];
            var fileInput = $("#"+sub_tab_id+"_"+key)[0];
            file = fileInput.files[0];
        }else{
            body[key] = $("#"+sub_tab_id+"_"+key).val();
        }

    });

    var formData = new FormData();
    formData.append('id', id);
    formData.append('file', file);
    formData.append('document_id', document_id);
    formData.append('sub_tab_id', sub_tab_id);
    formData.append('body', JSON.stringify(body));
    formData.append('action', action);
    formData.append('co_applicent', co_applicent);

    // ajaxPostRequest(pageURL + 'apiVerify', {
    //     'id': id,
    //     'document_id': document_id,
    //     'sub_tab_id': sub_tab_id,
    //     'body': JSON.stringify(body),
    //     'action': action,
    //     'file': formData,
    //     'co_applicent': co_applicent
    // }, function(data) {
    //     if(data.status == 'warning'){       //CR by Suhrid Sarkar || suhrid.developer@gmail.com on June 26, 2023
    //         swalWarnMsg('', data.message, 'warning', 'Ok');
    //     } else{
    //         $(".inputField_"+sub_tab_id).attr('disabled', 'disabled');
    //         $(".verifyBtn_"+sub_tab_id).hide();
    //         $("#subTabBtn_"+sub_tab_id).show();
    //         $('#v-pills-pan').html(data.html);
    //         loadapidata(id, sub_tab_id, action, co_applicent);
    //     }
        
    // });

    formData.append([$('#csrf_token_name').val()], $('#csrf_token_hash').val());

    $.ajax({
        url: baseUrl + pageURL + 'apiVerify',
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
                        $(".inputField_"+sub_tab_id).attr('disabled', 'disabled');
                        $(".verifyBtn_"+sub_tab_id).hide();
                        $("#subTabBtn_"+sub_tab_id).show();
                        $('#v-pills-pan').html(data.html);
                        loadapidata(id, sub_tab_id, action, co_applicent);
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


function otp(id,sub_tab_id,document_id, action, co_applicent){
    var field = $("#"+sub_tab_id+"_"+"otp_field").val().split(",");
    var dob = new Date($("#pan_dob").val());
    var formattedDate = formatDate(dob);

    var body = {};

    $.each(field, function(index, key) {
        if(key == 'dob'){
            if(sub_tab_id == 25){
                var dob = new Date($("#"+sub_tab_id+"_"+key).val());
                var formattedDate = formatDate(dob,'/',1);
            }else if(sub_tab_id == 28){
                var dob = new Date($("#"+sub_tab_id+"_"+key).val());
                var formattedDate = formatDate(dob,'-',1);
            }else{
                var dob = ($("#"+sub_tab_id+"_"+key).val());
                var formattedDate = dob;
                
            }
            body[key] = formattedDate;

        }else{
            body[key] = $("#"+sub_tab_id+"_"+key).val();
        }

    });
    // console.log(JSON.stringify(body));


    ajaxPostRequest(pageURL + 'generate_otp', {
        'id': id,
        'document_id': document_id,
        'sub_tab_id': sub_tab_id,
        'body': JSON.stringify(body),
        'action': action,
        'co_applicent': co_applicent
    }, function(data) {
            // alert();
            if(data.status_code == 200){
            // if(true){
                successMsg("OTP sent to registered mobile number.");
                $(".api_input_body_"+sub_tab_id).removeClass("d-none");
                $(".verifyBtn_"+sub_tab_id).removeClass("d-none");
                // $(".otp_"+sub_tab_id).addClass("d-none");
                $(".notShowLavel"+sub_tab_id).addClass("d-none");
                $("#"+sub_tab_id+"_requestId").val(data.requestId);
            }else{
                errorMsg('Please try again.');
            }

    });

}

function loadapidata(id, sub_tab_id, action, co_applicent){
     ajaxPostRequest(pageURL + 'loadapiData', {
        'id': id,
        'sub_tab_id': sub_tab_id,
        'action': action,
        'co_applicent': co_applicent
    }, function(data1) {
        $('#showdata'+sub_tab_id).html(data1.html);
    });
// ajaxFromSubmit()
}

function formatDate(date,separator) {
    // Extract day, month, and year from the Date object
    var day = date.getDate();
    var month = date.getMonth() + 1; // Note: January is 0
    var year = date.getFullYear();

    // Pad day and month with leading zeros if necessary
    if (day < 10) {
        day = '0' + day;
    }
    if (month < 10) {
        month = '0' + month;
    }

    // Return the formatted date string
    return day + separator + month + separator + year;
}

//Added by Ankit Adhikary on May 30, 2023 for multiple co applicant
function addCoApplicantTab(){
    var count = $('.nav-item-co-applicant').length;
    if(count >= 5){
        errorMsg('Cannot add more than 5 Co Applicant.');
    } else{
        //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 04, 2023
        var product = $('#product_id').val();
        var product_type = $('#product_type').val();
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
    }
}

function get_load_application_from(id){
    ajaxPostRequest(pageURL+'load_loan_application_from',{'id': id}, function(data) {
        $('#'+loanModalId+'_body').html(data.html);
        $('#'+loanModalId+'_title').text('View Loan Application');
        $("#"+loanModalId+"_body .form-control").attr('disabled', 'disabled');
        $(".approved-btn").val('Approved');
        $(".rejected-btn").val('Rejected');
        $(".save-btn").hide();
        $("#modelFooter").hide();
        holdModal(loanModalId);
        // $("#addbtn").hide();
        // if($("#verify_statas").val() == 'N'){
        // }
        $(".approved-btn").show();
        // $('#chengeData').html(data.html);
    });
}

function approved(action){
    var id = $("#from_id").val();
    ajaxPostRequest(pageURL+'approved_loan',{'id': id, 'action': action}, function(data) {
        servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list'); //Refresh Datatable
        closeModal(loanModalId);
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on September 14, 2023
//For print the loan application
function printApplication(loan_id = 0){
    if(loan_id != 0){
        ajaxPostRequest(pageURL + 'print_application', {'loan_id': loan_id}, function (data){
            popup(data.html);
        });
    }else{
        warnMsg('Please select loan');
    }
}


//Added by Suhrid Sarkar || suhrid.developer@gmail.com on Octobor 11, 2023
var bankApiModal = 'bank_api_modal';
var bankApiURL = 'bank_api/bank_api/';
var mainBankModal = 'main_modal';

function load_bank_main_modal(customerId = 0){
    if(customerId == 0){
        warnMsg('Please select customer');
    } else{
        ajaxPostRequest(bankApiURL + 'load_bank_main_modal',{'customer_id': customerId}, function(data){
            $('#'+mainBankModal+'_body').html(data.html);
            $('#'+mainBankModal+'_title').text('Please choose a tool to proceed');
            holdModal(mainBankModal);
        });
    }
}

function load_bank_single_multi_modal(customerId = 0, type = ''){
    if(customerId == 0){
        warnMsg('Please select customer');
    } else{
        if(type == 'Bank'){
            ajaxPostRequest(bankApiURL + 'load_bank_single_multi_modal', {'customer_id': customerId}, function (data){
                closeModal(mainBankModal);
                $('#'+bankApiModal+'_body').html(data.html);
                $('#'+bankApiModal+'_title').text('Select Approach');
                $(".save-btn").show();
                $(".save-btn").text('Continue');
                $("#modelFooter").show();
                holdModal(bankApiModal);
            });
        } else if(type == 'GSTR'){
            ajaxPostRequest(bankApiURL + 'load_gstr_modal', {'customer_id': customerId}, function (data){
                closeModal(mainBankModal);
                $('#'+bankApiModal+'_body').html(data.html);
                $('#'+bankApiModal+'_title').text('Select Approach');
                $(".save-btn").show();
                $(".save-btn").text('Continue');
                $("#modelFooter").show();
                $('#analyze_gst_div').show();
                $('#basic_gst_div').hide();
                $('#basic_pan_div').hide();
                $('#pan_bank_upload_div').hide();
                holdModal(bankApiModal);
            });
        } else if(type == 'ITR'){
            ajaxPostRequest(bankApiURL + 'load_itr_modal', {'customer_id': customerId}, function (data){
                closeModal(mainBankModal);
                $('#'+bankApiModal+'_body').html(data.html);
                $('#'+bankApiModal+'_title').text('Select Approach');
                $(".save-btn").show();
                $(".save-btn").text('Continue');
                $("#modelFooter").show();
                $('#analysis_26as_div').hide();
                holdModal(bankApiModal);
            });
        } else if(type == 'company'){
            window.location.href = baseUrl + bankApiURL + 'company_search/' + customerId;
        }
        
    }
}

$(document).ready(function (e){
    // e.preventDefault();
    //Submit the modal form
    $("#modalFormBankAPI").on('submit', (function (e) {
        e.preventDefault();
        
        if($('#modalFormBankAPI').find('#type').val() == 'bank'){
            ajaxFromSubmit(bankApiURL+'go_bank_api', this, function (data) {
                if(data.type == 'S'){
                    window.location.href = baseUrl+bankApiURL+'single_verify/'+data.customer_id;
                } else if(data.type == 'M'){
                    window.location.href = baseUrl+bankApiURL+'multi_verify/'+data.customer_id;
                }
            });
        } else if($('#modalFormBankAPI').find('#type').val() == 'gstin'){
            
            if($('#modalFormBankAPI').find('#approach').val() == 'analysis_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'password_approach'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/Password';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'otp_approach'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/OTP';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'password_using_link'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/password_using_link';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'otp_using_link'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/otp_using_link';
            } 

            else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'basic_info_and_filing_status_by_company_name'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/basic_info_and_filing_status_by_company_name';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'basic_info_and_filing_status_by_gst'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/basic_info_and_filing_status_by_gst';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'filing_status_by_gst'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/filing_status_by_gst';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_gstr' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'gst_basic_info'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/gst_basic_info';
            }
            
            else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_by_pan' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'filing_status_by_pan'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/filing_status_by_pan';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_by_pan' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'gst_basic_info_by_pan'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/gst_basic_info_by_pan';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_by_pan' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'gst_info_by_pan'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/gst_info_by_pan';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'basic_info_by_pan' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'gst_list_by_pan'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/gst_list_by_pan';
            }
            
            else if($('#modalFormBankAPI').find('#approach').val() == 'pan_bulk_upload' && $('#modalFormBankAPI').find('input[name="sub_approach"]:checked').val() == 'pan_bulk_upload'){
                window.location.href = baseUrl + bankApiURL + 'analysis_gstr_password_approach/' + $('#modalFormBankAPI').find('#customer_id').val() + '/pan_bulk_upload';
            }
        } else if($('#modalFormBankAPI').find('#type').val() == 'itr'){
            if($('#modalFormBankAPI').find('#approach').val() == 'analysis_itr' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'ack_upload'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/acknowledgement_upload';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_itr' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'pdf_upload'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/pdf_upload';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_itr' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'username_password'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/username_and_password';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_itr' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'username_password_link'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/username_and_password_using_link';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_itr' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'username_password_with_validation'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/username_password_with_validation';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_itr' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'xml_json_upload'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/xml_json_upload';
            }

            else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_26as' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'pdf_upload'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/pdf_upload';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_26as' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'username_password'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/username_password';
            } else if($('#modalFormBankAPI').find('#approach').val() == 'analysis_26as' && $('#modalFormBankAPI').find('input[name="select_bank_type"]:checked').val() == 'username_password_with_validation'){
                window.location.href = baseUrl + bankApiURL + 'itr_upload/' + $('#modalFormBankAPI').find('#customer_id').val() + '/username_password_with_validation';
            }
        }
        
    }));
});

function goToDataAnalysis(customerId = 0){
    window.location.href = baseUrl + bankApiURL + 'data_analysis/'+customerId;
}

function goToBureauDataAnalysis(customerId = 0){
    window.location.href = baseUrl + bankApiURL + 'bureau_data_analysis/'+customerId;
}

function changeApproach(approach = ''){
    if(approach == 'analysis_gstr'){
        $('#analyze_gst_div').show();
        $('#basic_gst_div').hide();
        $('#basic_pan_div').hide();
        $('#pan_bank_upload_div').hide();
    } else if(approach == 'basic_info_gstr'){
        $('#analyze_gst_div').hide();
        $('#basic_gst_div').show();
        $('#basic_pan_div').hide();
        $('#pan_bank_upload_div').hide();
    } else if(approach == 'basic_info_by_pan'){
        $('#analyze_gst_div').hide();
        $('#basic_gst_div').hide();
        $('#basic_pan_div').show();
        $('#pan_bank_upload_div').hide();
    } else if(approach == 'pan_bulk_upload'){
        $('#analyze_gst_div').hide();
        $('#basic_gst_div').hide();
        $('#basic_pan_div').hide();
        $('#pan_bank_upload_div').show();
    } else if(approach == 'analysis_itr'){
        $('#analysis_itr_div').show();
        $('#analysis_26as_div').hide();
    } else if(approach == 'analysis_26as'){
        $('#analysis_itr_div').hide();
        $('#analysis_26as_div').show();
    }
}