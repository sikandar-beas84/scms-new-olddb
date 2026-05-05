/* 
function to generate sweet-alert Error messages by Suhrid Sarkar || suhrid.developer@gmail.com 22-09-2022 
	arguments: msg => accepts the error message array/string
	description: pop up the error message
	returns: Nothing
*/
function swalErrMsg(msg, callback = function() {}) {

    if ((typeof msg) == "object") {
        var nwArr = [];
        $.each(msg, function(i, val) {
            nwArr.push(val);
        });
        msg = nwArr;
    }

    if ((typeof msg) == "string") {
        msg = [msg];
    }

    if (msg.length > 0) {
        msgString = "<ul>";
        var lenChar = 0;
        $.each(msg, function(i, val) {
            if (val != '') {
                msgString += "<li>" + val + "</li>";
                lenChar++;
            }
        });
        msgString += "</ul>";
        msgString = "<h4>" + lenChar + " errors occured.</h4><br>" + msgString;

        Swal.fire({
            title: msgString,
            confirmButtonColor: '#5156be',
        });

        $(".swal2-modal").css({ "background": "#FA4848" }); //Optional changes the color of the sweetalert 
        $(".swal2-title").css("color", "#ffffff");
        $(".swal2-title h4").css("color", "#ffffff");
    } else {
        console.log('Array you sent was blank');
    }

    callback();
}


/* 
function to generate alertify success messages by Suhrid Sarkar || suhrid.developer@gmail.com 22-09-2022 
	arguments: msg => accepts the success message string
	description: pop up the Success message
	returns: Nothing
*/
function successMsg(msg, callback = function() {}) {
    //alertify.dismissAll();
    alertify.success(msg, {enableHtml: true});
    callback();
}

/* 
function to generate alertify Error messages by Suhrid Sarkar || suhrid.developer@gmail.com 22-09-2022
	arguments: msg => accepts the error message string
	description: pop up the Success message
	returns: Nothing
*/
function errorMsg(msg) {
    //alertify.dismissAll();
    alertify.error(msg, {enableHtml: true});     
}

function warnMsg(msg) {
    //alertify.dismissAll();
    alertify.warning(msg, {enableHtml: true});   
}


/**
 * ADDED BY Suhrid Sarkar || suhrid.developer@gmail.com
 * @param {*} title 
 * @param {*} msg 
 * @param {*} type 
 * @param {*} btn_text 
 * @param {*} callback 
 */
function warningMsg(title, msg, type, btn_text, callback = function() {}, cancelCallback = function() {}, cancel_text='Cancel') {
    Swal.fire({
        title: title,
        text: msg,
        icon: type,
        showCancelButton: true,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: btn_text,
        cancelButtonText: cancel_text,
        allowOutsideClick: false
    }).then(function (result) {
        if (result.isConfirmed) {
            callback();
        } else {
            if(cancelCallback!=''){
                cancelCallback();
            }else{
                return false;
            }
        }
    });
}