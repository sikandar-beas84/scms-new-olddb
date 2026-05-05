/*******************
 * Ajax Form Submin With Validation
 * Added By Suhrid Sarkar
 * On 13-08-2023 12:48AM
 * IDE: VS Code
 *******************/
function AjaxFormSubmit(base_url='', url='', id='', formData='') {
    /*******************
     * Request
     * ***************
     * base_url = <?=base_url ?>
     * url = 'dashboard/updateProfile'
     * id = #editForm
     *******************/
      var isValid = true;
    //  if(id){
    //     var isValid = true;
    //     $('.error-message').remove();
    //     $('#' + id + ' input[type="text"], #' + id + '  input[type="email"], #' + id + '  textarea').each(function() {
    //         var value = $(this).val();
    //         var fieldName = $(this).attr('name');
    //         if (value.trim() === '') {
    //             $(this).after('<div class="error-message text-danger text-bold">This field is required.</div>');
    //             $(this).css("border", '1px solid red');
    //             isValid = false;
    //         } else {
    //             $(this).after('<div class="error-message text-success text-bold">Verified.</div>');
    //         }
    //     });
    //  }

    // Additional validation checks can be added here
    if (isValid) {
        formData[$('#csrf_token_name').val()] = $('#csrf_token_hash').val();
        
        // console.log(formData);
        // var formData = formData.serialize();
        // console.log(formData);
        $.ajax({
            type: 'POST', // or 'GET' depending on your server-side implementation
            url: base_url + url,
            data: formData,
            processData: false, // Important for file uploads
            contentType: false, // Important for file uploads
            dataType: 'json',
            beforeSend: function() {
                $('.page_loader').show();
            },
            success: function(response) {
                console.log(response);
            if (response.status == 'success') {
                
                if(response.message){
                    showToast(response.message, 'success');
                    if(id){
                        formReset(id);
                    }else{
                        formReset('');
                    }
                }else{
                    if(id){
                        formReset(id);
                    }else{
                        formReset('');
                    }
                    showToast("Form submitted successfully", 'success');
                }
                
            } else {
                if(response.message){
                    showToast("Oops!!, " + response.message, 'error');
                }else{
                    showToast("Error submitting form", 'error');
                }
            }
                // showToast("Form submitted successfully", 'success');
               $('.page_loader').hide(); 
            },
            error: function(error) {
                $('.page_loader').hide();
                showToast("Error submitting form", 'error');
            }
        });
    }
    // });
};
/*******************
 * Ajax Form Submin With Validation
 * Added By Suhrid Sarkar
 * On 13-08-2023 12:48AM
 * IDE: VS Code
 *******************/
function AjaxFormSubmitRedirect(base_url='', url='', id='', formData='',link="") {
    /*******************
     * Request
     * ***************
     * base_url = <?=base_url ?>
     * url = 'dashboard/updateProfile'
     * id = #editForm
     *******************/
      var isValid = true;
    //  if(id){
    //     var isValid = true;
    //     $('.error-message').remove();
    //     $('#' + id + ' input[type="text"], #' + id + '  input[type="email"], #' + id + '  textarea').each(function() {
    //         var value = $(this).val();
    //         var fieldName = $(this).attr('name');
    //         if (value.trim() === '') {
    //             $(this).after('<div class="error-message text-danger text-bold">This field is required.</div>');
    //             $(this).css("border", '1px solid red');
    //             isValid = false;
    //         } else {
    //             $(this).after('<div class="error-message text-success text-bold">Verified.</div>');
    //         }
    //     });
    //  }

    // Additional validation checks can be added here
    if (isValid) {
        // console.log(formData);
        // var formData = formData.serialize();
        // console.log(formData);
        formData[$('#csrf_token_name').val()] = $('#csrf_token_hash').val();
        // console.log($('#csrf_token_name').val());
        // console.log($('#csrf_token_hash').val());
        $.ajax({
            type: 'POST', // or 'GET' depending on your server-side implementation
            url: base_url + url,
            data: formData,
            // contentType: 'application/json',
            // processData: false, // Important for file uploads
            // contentType: false, // Important for file uploads
            dataType: 'json',
            beforeSend: function() {
                $('.page_loader').show();
            },
            success: function(response) {
                // console.log(response);
            if (response.status == 'success') {
                
                if(response.message){
                    showToast(response.message, 'success');
                    if(id){
                        formReset(id);
                    }else{
                        formReset('');
                    }
                }else{
                    if(id){
                        formReset(id);
                    }else{
                        formReset('');
                    }
                    showToast("Form submitted successfully", 'success');
                }
                
                if (link) {
                    // Redirect to a new URL
                    window.location.href = link; // Replace with your desired URL
                  }
                  $('#csrf_token_hash').val(response.csrf);
                  

            } else {
                if(response.message){
                    showToast("Oops!!, " + response.message, 'error');
                }else{
                    showToast("Error submitting form", 'error');
                }
                
            }
                // showToast("Form submitted successfully", 'success');
                $('.page_loader').hide();
                
            },
            error: function(jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                }else if (jqXHR.status == 403) {
                    msg = 'The action you have requested is not allowed..';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                showToast(msg, 'error');
                $('.page_loader').hide();
            }
            
        });
    }
    // });
};
/*******************
 * Ajax Post Function
 * Added By Suhrid Sarkar
 * On 14-08-2023 12:48AM
 * IDE: VS Code
 *******************/
function AjaxPostRequest(base_url, url, formData, callbackurl = '') {
    /*******************
     * Request
     * ***************
     * base_url = <?=base_url ?>
     * url = 'dashboard/updateProfile'
     *******************/
    // console.log(formData);
    // formData.append([$('#csrf_token_name').val()], $('#csrf_token_hash').val());
    formData[$('#csrf_token_name').val()] = $('#csrf_token_hash').val();
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: base_url + url,
        data: formData,
        // processData: true, // Important for file uploads
        // contentType: true, // Important for file uploads
        beforeSend: function() {
            $('.page_loader').show();
        },
        dataType: 'json',
        success: function(response) {
            if (response.status == 'success') {
                showToast(response.message, 'success');
                if (callbackurl != '') {
                    window.location.href = base_url + callbackurl;
                }
            } else {
                showToast("Oops!!, " + response.message, 'error');
            }

            if (response.csrf) {
                csrf = response.csrf;
            } else {
                csrf = response;
            }
            updateCsrf(csrf, function() {
                if (response.status == "error" || response.status == "0") {
                    errCallBk(data);
                    $('.page_loader').hide();
                } else {
                    validation(); //Initialized Validation
                    $('.page_loader').hide();
                    callback(data);
                }
            });
            $('.page_loader').hide();
        },
        error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(error);
                console.log(status);
                $('.page_loader').hide();
            }
            // error: function(error) {
            //     showToast("Oops!!, Some error occurred", 'error');
            // }
    });
};
/*******************
 * Ajax Post Function
 * Added By Suhrid Sarkar
 * On 14-08-2023 12:48AM
 * IDE: VS Code
 *******************/
function AjaxPostRequestHTML(base_url, url, formData, id) {
    // Make the AJAX POST request
    // alert("ok");
    formData[$('#csrf_token_name').val()] = $('#csrf_token_hash').val();
    $.ajax({
        url: base_url + url,
        type: "POST",
        data: formData,
        traditional: true, // Serialize the data as traditional arrays
        dataType: 'json',
        beforeSend: function() {
            $('.page_loader').show();
        },
        success: function (response) {
           $("#"+id).html(response.html);
            if (response.csrf) {
                csrf = response.csrf;
            } else {
                // csrf = response;
                var csrf = {
                    csrfName: response.csrfName,
                    csrfHash: response.csrfHash
                };
            }
            // console.log(csrf);
            updateCsrf(csrf, function() {
                if (response.status == "error" || response.status == "0") {
                    errCallBk(data);
                    $('.page_loader').hide();
                } else {
                    validation(); //Initialized Validation
                    $('.page_loader').hide();
                    // callback(data);
                }
            });
            $('.page_loader').hide();
        },
        error: function (xhr, status, error) {
            // Call the error callback or handle errors
            console.error(error);
            $('.page_loader').hide();
            // if (typeof errorCallback === 'function') {
            //     errorCallback(xhr, status, error);
            // }
        }
    });
}



/*******************
 * Toast Alert
 * Added By Suhrid Sarkar
 * On 13-08-2023 12:48AM
 * IDE: VS Code
 *******************/


// .toast-container {
//   position: fixed;
//   top: 15%;
//   left: 50%;
//   transform: translate(-50%, -50%);
//   z-index: 1000;
// }
// .toast {
//     display: none;
//     color: #fff;
//     padding: 10px 20px;
//     border-radius: 5px;
//     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
//     display: flex;
//     align-items: center;
// }

// .toast-icon {
//     margin-right: 10px;
// }

// .toast-message {
//     font-size: 14px;
// }

// .gImage {
//     width: fit-content;
//     margin-top: 11px;
//     margin-bottom: 10px;s
// }
{
    /* <div id="toast-container" class="toast-container">
    <div class="toast" id="toast">
        <div class="toast-icon">
            <i class="fa fa-info-circle"></i>
        </div>
        <div class="toast-message" id="toast-message">This is a toast message.</div>
    </div>
    </div> */
}

function showToast(message, status) {
    console.log(11);
    // var toast = $('#toast');
    // var toastMessage = $('#toast-message');
        console.log('Show Toast Function Called');
        if (status === 'error') {
            toastr.error(message);
        } else {
            toastr.success(message);
        }
    
    // toastMessage.text(message);
    // toast.fadeIn(400, function() {
    //     setTimeout(function() {
    //         toast.fadeOut(400);
    //     }, 3333);
    // });
}


/*******************
 * Privecy Accept PopUp Alert
 * Added By Suhrid Sarkar
 * On 13-08-2023 12:48AM
 * IDE: VS Code
 *******************/

// .cookie-popup {
//     display: none;
//     position: fixed;
//     bottom: 97px;
//     left: 20px;
//     background-color: #f0f0f0;
//     padding: 10px;
//     border-radius: 8px;
//     box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
//     z-index: 9999;
//     width: 293px;
// }

// .cookie-popup p {
//     margin: 0;
// }

// .cookie-popup button {
//     margin-top: 5px;
//     background-color: #204792;
//     color: #fff;
//     border: none;
//     padding: 5px 15px;
//     border-radius: 4px;
//     cursor: pointer;
// }

// .cookie-popup .hed {
//     font-weight: 1000;
// }

{
    /* <div class="cookie-popup" id="cookiePopup">
    <p class="hed">WE CARE ABOUT YOUR PRIVACY.</p>
    <p> Your experience on this site will be improved by allowing cookies.</p>
    <button id="acceptCookiesBtn" class="btn-danger">Accept</button>
    </div> */
}
$(document).ready(function() {
    if (!getCookie("cookieConsent")) {
        $("#cookiePopup").fadeIn();
    }

    $("#acceptCookiesBtn").on("click", function() {
        setCookie("cookieConsent", true, 365);
        $("#cookiePopup").fadeOut();
    });

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
});


/*******************
 * Autocomplete Google Location
 * Added By Suhrid Sarkar
 * On 13-08-2023 01:41AM
 * IDE: VS Code
 *******************/

// google.maps.event.addDomListener(window, 'load', function() {
//     var places = new google.maps.places.Autocomplete(document.getElementById('google_address'));
//     google.maps.event.addListener(places, 'place_changed', function() {
//         var place = places.getPlace();
//         var address = place.formatted_address;
//         var latitude = place.geometry.location.lat();
//         var longitude = place.geometry.location.lng();
//         var mesg = "Address: " + address;
//         mesg += "\nLatitude: " + latitude;
//         mesg += "\nLongitude: " + longitude;
//         // alert(mesg);
//     });
// });
/*******************
 * Check if a specific value exists in an indexed array
 * Added By Suhrid Sarkar
 * On 15-08-2023 12:33AM
 * IDE: VS Code
 *******************/

function arrayChecks(array, searchValue) {
    if (array.indexOf(searchValue) !== -1) {
        return true;
    } else {
        return false;
    }
}
/*******************
 * Auto Form Validation by Form id
 * Added By Suhrid Sarkar
 * On 15-08-2023 12:41AM
 * IDE: VS Code
 *******************/

// function formValidationById(id = "", optionalField = []) {
//     var isValid = true;
//     $('.error-message').remove();
//     $('#' + id + ' input[type="text"], #' + id + ' input[type="email"], #' + id + ' textarea, #' + id + ' select').each(function() {
//         var value = $(this).val();
//         if (arrayChecks(optionalField, $(this).attr('name')) === false) {
//             if (value.trim() === '') {
//                 $(this).after('<div class="error-message text-danger text-bold">This field is required.</div>');
//                 $(this).css("border", '1px solid red');
//                 isValid = false;
//             } else {
//                 $(this).after('<div class="error-message text-success text-bold">Verified.</div>');
//                 $(this).css("border", '1px solid green');
//             }
//         } else {
//             // Handle the optional field logic here, if needed
//         }
//     });

//     return isValid;
// }
function formValidationById(id = "", optionalField = []) {
    var isValid = true;
    var firstErrorField = null; // Variable to track the first field with an error
    $('.error-message').remove();
    
    $('#' + id + ' input[type="tel"], #' + id + ' input[type="text"], #' + id + ' input[type="email"], #' + id + ' textarea, #' + id + ' select, #' + id + ' input[type="number"], #' + id + ' input[type="password"], #' + id + ' input[name="confirmPassword"], #' + id + ' input[type="file"], #' + id + ' input[type="date"]').each(function() {
        var $this = $(this);
        var value = $this.val();
        
        // Ensure value is not null
        if (value === null) {
            value = '';
        }

        if (arrayChecks(optionalField, $this.attr('name')) === false) {
            if ($this.is('input[type="file"]')) {
                // Validate file input
                if ($this[0].files.length === 0) {
                    $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">Please select a file.</div>');
                    $this.css("border", '1px solid red');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $this;
                } else {
                    var file = $this[0].files[0];
                    var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Define allowed file types
                    if (!allowedTypes.includes(file.type)) {
                        $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">Invalid file type. Only JPEG, PNG, and PDF files are allowed.</div>');
                        $this.css("border", '1px solid red');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $this;
                    } else if (file.size > 5242880) { // Example: file size limit of 5MB
                        $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">File size exceeds 5MB.</div>');
                        $this.css("border", '1px solid red');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $this;
                    } else {
                        $this.after('<div class="error-message text-success text-bold valid-tooltip d-block text-light">File is valid.</div>');
                        $this.css("border", '1px solid green');
                    }
                }
            } else if ($this.is('input[type="date"]')) {
                // Validate date input
                if (value === '') {
                    $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">Please select a date.</div>');
                    $this.css("border", '1px solid red');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $this;
                } else {
                    var selectedDate = new Date(value);
                    $this.after('<div class="error-message text-success text-bold valid-tooltip d-block text-light">Date is valid.</div>');
                    $this.css("border", '1px solid green');
                }
            } else {
                if (value.trim() === '') {
                    $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">This field is required.</div>');
                    $this.css("border", '1px solid red');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $this;
                } else {
                    if ($this.is('input[type="password"]')) {
                        // Check password complexity or any other password validation logic
                        if (value.length < 8) {
                            $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">Password must be at least 8 characters long.</div>');
                            $this.css("border", '1px solid red');
                            isValid = false;
                            if (!firstErrorField) firstErrorField = $this;
                        } else {
                            $this.after('<div class="error-message text-success text-bold valid-tooltip d-block text-light">Verified.</div>');
                            $this.css("border", '1px solid green');
                        }
                    } else if ($this.is('input[name="confirmPassword"]')) {
                        // Check if the confirm password matches the original password
                        var passwordField = $('#' + id + ' input[type="password"]');
                        if (value !== passwordField.val()) {
                            $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">Passwords do not match.</div>');
                            $this.css("border", '1px solid red');
                            isValid = false;
                            if (!firstErrorField) firstErrorField = $this;
                        } else {
                            $this.after('<div class="error-message text-success text-bold valid-tooltip d-block text-light">Passwords match.</div>');
                            $this.css("border", '1px solid green');
                        }
                    }
                    else if ($this.is('input[name="bank_account_no"]')) {
                        if (value.length < 11 || value.length > 14) {
                            $this.after('<div class="error-message text-danger text-bold invalid-tooltip d-block text-light">Bank account number must be between 11 and 14 digits long.</div>');
                            $this.css("border", '1px solid red');
                            isValid = false;
                            if (!firstErrorField) firstErrorField = $this;
                        } else {
                            $this.after('<div class="error-message text-success text-bold valid-tooltip d-block text-light">Verified.</div>');
                            $this.css("border", '1px solid green');
                        }
                    }
                    else {
                        $this.after('<div class="error-message text-success text-bold valid-tooltip d-block text-light">Verified.</div>');
                        $this.css("border", '1px solid green');
                    }
                }
            }
        } else {
            // Handle the optional field logic here, if needed
        }
    });

    // Focus on the first field with an error
    if (firstErrorField) {
        firstErrorField.focus();
    }

    return isValid;
}




/*******************
 * Auto Form Validation
 * Added By Suhrid Sarkar
 * On 15-08-2023 12:41AM
 * IDE: VS Code
 *******************/

// function formValidation(optionalField = []) {
//     var isValid = true;
//     $('.error-message').remove();
//     $(' input[type="text"],  input[type="email"], textarea, select, input[type="radio"]:checked, input[type="checkbox"]:checked').each(function() {
//         var value = $(this).val();
//         if (arrayChecks(optionalField, $(this).attr('name')) == false) {
//             if (value.trim() === '' && $(this).attr('name')) {
//                 $(this).after('<div class="error-message text-danger text-bold">This field is required.</div>');
//                 $(this).css("border", '1px solid red');
//                 console.log($(this).attr('name')+': ' + isValid);
//                 isValid = false;
//             } else {
//                 $(this).after('<div class="error-message text-success text-bold">Verified.</div>');
//                 $(this).css("border", '1px solid green');
//             }
//         } else {
           
//         }
       
//     });
//     return isValid;
// }

function formValidation(optionalField = []) {
    var isValid = true;
    $('.error-message').remove();
    $('input[type="text"], input[type="email"],input[type="number"], textarea, select, input[type="radio"]:checked, input[type="checkbox"]:checked, input[type="number"], input[type="password"]').each(function() {
        var value = $(this).val();
        if (arrayChecks(optionalField, $(this).attr('name')) == false) {
            if (value.trim() === '' && $(this).attr('name')) {
                $(this).after('<div class="error-message text-danger text-bold">This field is required.</div>');
                $(this).css("border", '1px solid red');
                console.log($(this).attr('name'));
                isValid = false;
            }  else if ($(this).is('input[type="password"]')) {
                // Password field validation logic
                if (value.length < 8) {
                    $(this).after('<div class="error-message text-danger text-bold">Password must be at least 8 characters long.</div>');
                    $(this).css("border", '1px solid red');
                    isValid = false;
                    console.log($(this).attr('name'));
                } else {
                    $(this).after('<div class="error-message text-success text-bold">Verified.</div>');
                    $(this).css("border", '1px solid green');
                }
            } else if ($(this).is('input[type="password"][name="confirmPassword"]')) {
                // Confirm password field validation logic
                var passwordField = $('input[type="password"][name="password"]');
                if (value !== passwordField.val()) {
                    $(this).after('<div class="error-message text-danger text-bold">Passwords do not match.</div>');
                    $(this).css("border", '1px solid red');
                    isValid = false;
                    console.log($(this).attr('name'));
                    
                } else {
                    $(this).after('<div class="error-message text-success text-bold">Passwords match.</div>');
                    $(this).css("border", '1px solid green');
                }
            }  else {
                $(this).after('<div class="error-message text-success text-bold">Verified.</div>');
                $(this).css("border", '1px solid green');
            }
        }
    });
    return isValid;
}

/*******************
 * Auto Form Field Disabled by Form id
 * Added By Suhrid Sarkar
 * On 24-08-2023 08:35AM
 * IDE: VS Code
 *******************/

function fieldDisabled(id, optionalField = []) {
    $('#' + id + ' input[type="text"],#' + id + ' input[type="number"], #' + id + '  input[type="email"], #' + id + '  textarea', +id + ' select,#' + id + 'input[type="radio"], #' + id + 'input[type="checkbox"]').each(function() {
        if (arrayChecks(optionalField, $(this).attr('name')) == false) {
            $(this).prop('disabled', true);
        }
    });
}
/*******************
 * Auto Form Field Disabled
 * Added By Suhrid Sarkar
 * On 24-08-2023 08:35AM
 * IDE: VS Code
 *******************/

function fieldDisabled(optionalField = []) {
    $(' input[type="text"],input[type="number"],  input[type="email"], textarea, select, input[type="radio"], input[type="checkbox"], input[type="date"] , input[type="text"]').each(function() {
        if (arrayChecks(optionalField, $(this).attr('name')) == false) {
            $(this).prop('disabled', true);
        }
    });
}
/*******************
 * Auto Form Pointer Events None By Class And ID
 * Added By Suhrid Sarkar
 * On 24-08-2023 08:45AM
 * IDE: VS Code
 *******************/

function pointerNone(pointerNoneClass = [], pointerNoneId = []) {
    if (pointerNoneClass.length > 0) {
        pointerNoneClass.forEach(function(className) {
            $('.' + className).css('pointer-events', 'none');
        });
    }
    if (pointerNoneId.length > 0) {
        pointerNoneId.forEach(function(idName) {
            $('#' + idName).css('pointer-events', 'none');
        });
    }
}
/*******************
 * Auto Display None By Class And ID
 * Added By Suhrid Sarkar
 * On 24-08-2023 08:45AM
 * IDE: VS Code
 *******************/

function displayNone(displayNoneClass = [], displayNoneId = []) {
    if (displayNoneClass.length > 0) {
        displayNoneClass.forEach(function(className) {
            $('.' + className).css('display', 'none');
        });
    }

    if (displayNoneId.length > 0) {
        displayNoneId.forEach(function(idName) {
            $('#' + idName).css('display', 'none');
        });
    }
}
/*******************
 * Get Form Data By Form Id
 * Added By Suhrid Sarkar
 * On 15-08-2023 01:00AM
 * IDE: VS Code
 *******************/
function getAllFormDataById(id) {
    var formData = {};
    // text
    $('#' + id + ' input[type="hidden"]').each(function() {
        formData[this.name] = $(this).val();
    });
    // text
    $('#' + id + ' input[type="text"]').each(function() {
        formData[this.name] = $(this).val();
    });
    // email
    $('#' + id + ' input[type="email"]').each(function() {
        formData[this.name] = $(this).val();
    });
    // Number
    $('#' + id + ' input[type="number"]').each(function() {
        formData[this.name] = $(this).val();
    });
    // select	
    $('#' + id + ' select').each(function() {
        formData[$(this).attr('name')] = $(this).val();
    });
    // radio
    $('#' + id + ' input[type="radio"]:checked').each(function() {
        formData[$(this).attr('name')] = $(this).val();
    });

    // Checkboxes
    $('#' + id + 'input:checkbox[type="checkbox"]:checked').each(function() {
        var checkboxName = $(this).attr('name');
        if (!formData[checkboxName]) {
            formData[checkboxName] = [];
        }
        // other_features.push($(this).val()); 
        formData[checkboxName].push($(this).val());
    });
    // textarea
    // $('#' + id + ' textarea').each(function() {
    //     if (!formData[$(this).attr('name')]) {
    //         formData[$(this).attr('name')] = [];
    //     }
    //     formData[$(this).attr('name')].push($(this).val());
    // });
    $('#' + id + ' textarea').each(function() {
        formData[this.name] = $(this).val();
    });
    // File inputs
    // File inputs
    // $('#' + id + ' input[type="file"]').each(function() {
    //     if (this.files && this.files.length > 0) {
    //         formData[this.name] = this.files[0];
    //     }
    // });
    // console.log(formData);
    return formData;
}
/*******************
 * Get Form Data 
 * Added By Suhrid Sarkar
 * On 15-08-2023 01:08AM
 * IDE: VS Code
 *******************/
function getAllFormData() {
    var formData = {};
    // text
    $('input[type="text"]').each(function() {
        formData[this.name] = $(this).val();
    });
    // Number
    $('input[type="number"]').each(function() {
        formData[this.name] = $(this).val();
    });
        // Number
    $('input[type="date"]').each(function() {
        formData[this.name] = $(this).val();
    });
    // select	
    $('select').each(function() {
        formData[$(this).attr('name')] = $(this).val();
    });
    // radio
    $('input[type="radio"]:checked').each(function() {
        formData[$(this).attr('name')] = $(this).val();
    });


    $('input:checkbox[type="checkbox"]:checked').each(function() {
        var checkboxName = $(this).attr('name');
        if (!formData[checkboxName]) {
            formData[checkboxName] = [];
        }
        // other_features.push($(this).val()); 
        formData[checkboxName].push($(this).val());
    });
    // textarea
    $('textarea').each(function() {
        if (!formData[$(this).attr('name')]) {
            formData[$(this).attr('name')] = [];
        }
        formData[$(this).attr('name')] = ($(this).val());
    });
    // File inputs
    $('input[type="file"]').each(function() {
        if (this.files && this.files.length > 0) {
            if(this.name != 'skip'){
                formData.append(this.name, this.files[0]);
            }
        }
    });
    // console.log(formData);
    return formData;
}



// $(document).ready(function() {
//     $('#datatable').DataTable();

//     // Buttons examples
//     var table = $('#datatable-buttons').DataTable({
//         lengthChange: false,
//         buttons: ['copy', 'excel', 'pdf', 'colvis']
//     });

//     table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
//     $(".dataTables_length select").addClass('form-select form-select-sm');
// });



// function ajaxDataList(tabId, num_of_row, ajaxUrl, callback = '', formData = '') {
//     alert("sd");
//     prx(num_of_row);
//     if ($.fn.dataTable.isDataTable('#' + tabId)) {
//         destroyDataTable(tabId)
//     }
//     $("#" + tabId).DataTable({
//         dom: "Bfrtip",
//         buttons: [{
//                 extend: "copyHtml5",
//                 text: '<i class="fa fa-copy"></i> Copy',
//                 titleAttr: "Copy",
//             },
//             {
//                 extend: "excelHtml5",
//                 text: '<i class="fa fa-file-excel-o"></i> Excel',
//                 titleAttr: "Excel",
//             },
//             {
//                 extend: "pdfHtml5",
//                 text: '<i class="fa fa-file-pdf-o"></i> Pdf',
//                 titleAttr: "Pdf",
//                 orientation: "landscape",
//                 pageSize: "A4",
//             },
//             // {
//             //     extend: "colvis",
//             //     text: '<i class="fa fa-caret-square-down"></i> Column visibility',
//             //     titleAttr: "Column visibility",
//             // },  
//         ],
//         processing: true,
//         serverSide: false,
//         pageLength: num_of_row,
//         order: [],
//         ajax: {
//             data: formData,
//             url: ajaxUrl,
//             type: "POST",
//             beforeSend: function() {
//                 $('#preloader').show();
//             },
//             complete: function(response) {
//                 $('#preloader').hide();
//             },
//         },
//         drawCallback: function() {
//             if (callback != "") {
//                 callback();
//             }
//         },
//         columnDefs: [{
//             targets: [0],
//             orderable: false,
//         }, ],
//     });

//     $(".dataTables_length select").addClass('form-select form-select-sm');

// }

// function destroyDataTable(tabId) {
//     $('#' + tabId).DataTable().destroy();
// }


// $(document).ready(function() {
//     // Call the function to initialize DataTable
//     ajaxDataList('dataTable', 10, 'your_server_side_script.php');
// });
/*******************
 * Data Table Using Ajax 
 * Added By Suhrid Sarkar
 * On 18-08-2023 02:35AM
 * IDE: VS Code
 *******************/
{
    /* <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> */
}

// function ajaxDataList(tabId, num_of_row, baseUrl, ajaxUrl, callback = '', formData = '') {
//     // if ($.fn.dataTable.isDataTable('#' + tabId)) {
//     //     table = $('#' + tabId).DataTable();
//     // } else {
//     //     table = $('#' + tabId).DataTable();
//     //     table = $('#' + tabId).DataTable({
//     //         paging: false
//     //     });
//     // }
//     // var dataTable = jQuery('#' + tabId).DataTable();
//     // alert(dataTable);
//     // if (dataTable instanceof $.fn.dataTable.Api) {
//     //     dataTable.destroy();
//     // }
//     new DataTable('#' + tabId, {
//         ajax: baseUrl + ajaxUrl
//     });
//     // // if ($.fn.dataTable.isDataTable('#' + tabId)) {
//     // //     destroyDataTable(tabId);
//     // // }

//     // $('#' + tabId).DataTable({
//     //     dom: "Bfrtip",
//     //     buttons: [{
//     //             extend: "copyHtml5",
//     //             text: '<i class="fa fa-copy"></i> Copy',
//     //             titleAttr: "Copy",
//     //         },
//     //         {
//     //             extend: "excelHtml5",
//     //             text: '<i class="fa fa-file-excel-o"></i> Excel',
//     //             titleAttr: "Excel",
//     //         },
//     //         {
//     //             extend: "pdfHtml5",
//     //             text: '<i class="fa fa-file-pdf-o"></i> Pdf',
//     //             titleAttr: "Pdf",
//     //             orientation: "landscape",
//     //             pageSize: "A4",
//     //         },
//     //     ],
//     //     processing: true,
//     //     serverSide: true, // Change to true for server-side processing
//     //     pageLength: num_of_row,
//     //     order: [],
//     //     // $('#dataTable').DataTable({
//     //     "ajax": ajaxUrl, // Path to your JSON data source
//     //     "columns": [] // No need to specify columns here
//     //         // });
//     //         // ajax: {
//     //         //     data: formData,
//     //         //     url: ajaxUrl,
//     //         //     type: "POST",
//     //         //     beforeSend: function() {
//     //         //         $('#preloader').show();
//     //         //     },
//     //         //     complete: function(response) {
//     //         //         $('#preloader').hide();
//     //         //     },
//     //         // },
//     //         // drawCallback: function() {
//     //         //     if (callback !== "") {
//     //         //         callback();
//     //         //     }
//     //         // },
//     //         // columnDefs: [{
//     //         //     targets: [0],
//     //         //     orderable: false,
//     //         // }, ],
//     // });

//     // $(".dataTables_length select").addClass('form-select form-select-sm');
// }

// function destroyDataTable(tabId) {
//     $('#' + tabId).DataTable().destroy();
// }

/*******************
 * Data Table Using Ajax 
 * Added By Suhrid Sarkar
 * On 18-08-2023 02:58AM
 * IDE: VS Code
 *******************/
function deleteField(baseUrl, pageURL, id, tableName = '', callbackurl = '') {
    Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var returnData = AjaxPostRequest(baseUrl, pageURL, { 'id': id });
                // console.log(returnData);
                // Swal.fire(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                // console.log(callbackurl);
                // console.log(tableName);
                if (callbackurl && tableName) {
                    ajaxDataList(tableName, 10, baseUrl, callbackurl);
                }
                // console.log(returnData);
                return true;
            }
        })
        // warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function () {
        //     AjaxPostRequest(baseUrl, pageURL + 'delete_property',{'id': id});
        //     ajaxPostRequest(pageURL+'delete', {
        //         "id": id
        //     }, function (data) {
        //         successMsg('Item Deleted.'); // Success Message
        //         servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list'); //Refresh Datatable
        //     });
        // });       
}
/*******************
 * Data Table Using Ajax 
 * Added By Suhrid Sarkar
 * On 18-08-2023 02:58AM
 * IDE: VS Code
 *******************/
function formReset(id =''){
 if(id){
     $("#"+id)[0].reset();
 }else{
     $("#resetButton").click(function () {
        // Reset all input fields and <select> elements within the form
        $("input, select").each(function () {
            // For input fields
            if ($(this).is("input")) {
                $(this).val(""); // Reset the value of the input field
            }
            
            // For <select> elements
            if ($(this).is("select")) {
                $(this).val(""); // Reset the selected option
            }
        });

        // If you also want to reset checkboxes and radios, clear their "checked" state
        $("input[type='checkbox']").prop("checked", false);
        $("input[type='radio']").prop("checked", false);
    }); 
 }

}
/*******************
 * Data Table Using Ajax 
 * Added By Suhrid Sarkar
 * On 18-08-2023 02:58AM
 * IDE: VS Code
 * *
 * *
 * *
 * 
 * ***********/

function updateCsrf(data, callback = '') {
    $('#csrf_token_name').val(data.csrfName);
    $('#csrf_token_hash').val(data.csrfHash);
    $('input[name="cronusgen_csrf_name"]').val(data.csrfHash);
    if (callback != '') {
        callback();
    }
}


// function dropZoneSetUp(id, url, acceptedFiles='image/png, image/jpeg', maxFilesize = 5, maxFiles = 5){
//      // Initialize Dropzone for the Document Upload Form
//      var dropzone = new Dropzone(`#${id}`,{
//         url: url, // Replace with your document upload URL
//         autoProcessQueue: true,
//         maxFilesize: maxFilesize,
//         maxFiles: maxFiles,
//         acceptedFiles: acceptedFiles,
//         addRemoveLinks: true,
//         // Customize additional options if needed
//     });
// }


    // $(document).ready(function(){
    //     $('input[type=file]').drop_uploader({
    //         uploader_text: 'Drop files to upload, or',
    //         browse_text: 'Browse',
    //         only_one_error_text: 'Only one file allowed',
    //         not_allowed_error_text: 'File type is not allowed',
    //         big_file_before_error_text: 'Files, bigger than',
    //         big_file_after_error_text: 'is not allowed',
    //         allowed_before_error_text: 'Only',
    //         allowed_after_error_text: 'files allowed',
    //         browse_css_class: 'button button-primary',
    //         browse_css_selector: 'file_browse',
    //         uploader_icon: '<i class="fa fa-cloud-upload"></i>',
    //         file_icon: '<i class="pe-7s-file"></i>',
    //         progress_color: '#4a90e2',
    //         time_show_errors: 5,
    //         layout: 'thumbnails',
    //         method: 'normal',
    //         url: 'ajax_upload.php',
    //         delete_url: 'ajax_delete.php',
    //     });
    // });

function ajaxDataList(tabId, num_of_row, baseUrl, ajaxUrl, callback = '', formData = '') {
    new DataTable('#' + tabId, {
        ajax: baseUrl + ajaxUrl
    });
}

    
// function ajaxDataList(tabId, num_of_row, baseUrl, ajaxUrl, callback = '', formData = '') {
//     // if ($.fn.dataTable.isDataTable('#' + tabId)) {
//     //     table = $('#' + tabId).DataTable();
//     // } else {
//     //     table = $('#' + tabId).DataTable();
//     //     table = $('#' + tabId).DataTable({
//     //         paging: false
//     //     });
//     // }
//     // var dataTable = jQuery('#' + tabId).DataTable();
//     // alert(dataTable);
//     // if (dataTable instanceof $.fn.dataTable.Api) {
//     //     dataTable.destroy();
//     // }
//     new DataTable('#' + tabId, {
//         ajax: baseUrl + ajaxUrl
//     });
//     // // if ($.fn.dataTable.isDataTable('#' + tabId)) {
//     // //     destroyDataTable(tabId);
//     // // }

//     // $('#' + tabId).DataTable({
//     //     dom: "Bfrtip",
//     //     buttons: [{
//     //             extend: "copyHtml5",
//     //             text: '<i class="fa fa-copy"></i> Copy',
//     //             titleAttr: "Copy",
//     //         },
//     //         {
//     //             extend: "excelHtml5",
//     //             text: '<i class="fa fa-file-excel-o"></i> Excel',
//     //             titleAttr: "Excel",
//     //         },
//     //         {
//     //             extend: "pdfHtml5",
//     //             text: '<i class="fa fa-file-pdf-o"></i> Pdf',
//     //             titleAttr: "Pdf",
//     //             orientation: "landscape",
//     //             pageSize: "A4",
//     //         },
//     //     ],
//     //     processing: true,
//     //     serverSide: true, // Change to true for server-side processing
//     //     pageLength: num_of_row,
//     //     order: [],
//     //     // $('#dataTable').DataTable({
//     //     "ajax": ajaxUrl, // Path to your JSON data source
//     //     "columns": [] // No need to specify columns here
//     //         // });
//     //         // ajax: {
//     //         //     data: formData,
//     //         //     url: ajaxUrl,
//     //         //     type: "POST",
//     //         //     beforeSend: function() {
//     //         //         $('#preloader').show();
//     //         //     },
//     //         //     complete: function(response) {
//     //         //         $('#preloader').hide();
//     //         //     },
//     //         // },
//     //         // drawCallback: function() {
//     //         //     if (callback !== "") {
//     //         //         callback();
//     //         //     }
//     //         // },
//     //         // columnDefs: [{
//     //         //     targets: [0],
//     //         //     orderable: false,
//     //         // }, ],
//     // });

//     // $(".dataTables_length select").addClass('form-select form-select-sm');
// }

// function destroyDataTable(tabId) {
//     $('#' + tabId).DataTable().destroy();
// }
