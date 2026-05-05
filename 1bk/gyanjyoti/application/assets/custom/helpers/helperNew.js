/**
 * From Submit Ajax Request 
 * By Suhrid Sarkar || suhrid.developer@gmail.com
 * @param {*} url 
 * @param {*} elem 
 * @param {*} callback 
 */$('.page_loader').hide();
 function ajaxFromSubmit(url, elem, callback, errCallBk = function(data) { errCllBkLogic(data); }) {
    var formData = new FormData(elem);
    formData.append([$('#csrf_token_name').val()], $('#csrf_token_hash').val());
    
    // Iterate through form elements to identify CKEditor fields
    $(elem).find('textarea').each(function() {
        var textareaId = $(this).attr('id');
        if (textareaId && CKEDITOR.instances[textareaId]) {
            // If CKEditor instance found, update the element and append its data to formData
            CKEDITOR.instances[textareaId].updateElement();
            formData.append(textareaId, CKEDITOR.instances[textareaId].getData());
        }
    });
    
    // console.log(formData);
    $.ajax({
        url: url,
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
            if(data.message){
                showToast(data.message, data.status);
            }
            if (data.csrf) {
                csrf = data.csrf;
            } else {
                csrf = {
                    csrfName: data.csrfName,
                    csrfHash: data.csrfHash
                };
            }
            // console.log("csrf");
            // console.log(csrf);
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
                    callback(data);
                }
            });
        },
        error: function(errResp) {
            console.log(errResp);
            //alert("Fail")
        }
    });
}

function ajaxPostRequest(url, formData, callback, errCallBk = function(data) { errCllBkLogic(data); }) {
    
    formData[[$('#csrf_token_name').val()]] = $('#csrf_token_hash').val();
    // console.log(formData);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        dataType: 'json',
        // contentType: 'application/json;',
        beforeSend: function() {
            $('.page_loader').show();
        },

        success: function(data) {
            // updateCsrfbyAjax();
            // console.log("df");
            // var data = JSON.parse(response);
            // console.log(data);
            if (data.csrf) {
                csrf = data.csrf;
            } else {
                // csrf = data;
                csrf = {
                    csrfName: data.csrfName,
                    csrfHash: data.csrfHash
                };
            }
            // callback(data);
            // console.log("csrf");
            // console.log(csrf);
			updateCsrf(csrf, function() {
                if (data.status == "error" || data.status == "0") {
                    errCallBk(data);
					$('.page_loader').hide();
                } else {
                    validation(); //Initialized Validation
                    $('.page_loader').hide();
                    callback(data);
                }
            });

        },
        
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log("AJAX Error: " );
            console.log(msg);
			$('.page_loader').hide();
        }
    });
}

function errCllBkLogic(data) {
    validation(); //Initialized Validation
    // $("body").removeClass("loading");
    // makeallEnabled();
    $('#global-loader').hide();
    showToast(data.message, data.status);
}

function updateCsrfbyAjax(){
    baseUrl = $("#baseUrl").val();
    // ajaxPostRequest(baseUrl +'page/updateCsrf',{}, function(data) {
    //     $('#csrf_token_name').val(data.csrfName);
    //     $('#csrf_token_hash').val(data.csrfHash);
    //     $('input[name="cronusgen_csrf_name"]').val(data.csrfHash);
    // });
    $.ajax({
        url: baseUrl +'page/updateCsrf',
        type: "POST",
        data: {},
        dataType: 'json',
        // contentType: 'application/json; charset=utf-8',
        beforeSend: function() {
            $('.page_loader').show();
        },

        success: function(data) {
            $('#csrf_token_name').val(data.csrfName);
            $('#csrf_token_hash').val(data.csrfHash);
            $('input[name="cronusgen_csrf_name"]').val(data.csrfHash);


        },
        
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            console.log("AJAX Error: " );
            console.log(msg);
			$('.page_loader').hide();
        }
    });
   

}


function holdModal(modalId,callback = '') {
	// $('#' + modalId).modal('show');
    $("#"+modalId).css("display", "block");
	if(callback != ''){
		callback();
	}
}  


function closeModal(modalId, callback = ''){
	// $('#' + modalId).modal('toggle');
	// $('#' + modalId).modal('toggle');
    $("#"+modalId).css("display", "none");
	if(callback != ''){
		callback();
	}
}

function showToast(message, status) {
    // console.log(22);
    if (status == 'error') {
        toastr.error(message);
    } else {
        toastr.success(message);
    }
    // var toast = $('#toast');
    // var toastMessage = $('#toast-message');
    // if (status == 'error') {
    //     $('#toast').css('background', 'red');
    // } else {
    //     $('#toast').css('background', 'green');
    // }
    // toastMessage.text(message);
    // toast.fadeIn(400, function() {
    //     setTimeout(function() {
    //         toast.fadeOut(400);
    //     }, 3333);
    // });
}
