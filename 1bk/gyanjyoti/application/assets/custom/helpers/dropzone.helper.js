var baseUrl = $("#baseUrl").val();
var csrfName = $('#csrf_token_name').val();
var csrfHash = $('#csrf_token_hash').val();
var formData = {}; // Create an empty object

formData[csrfName] = csrfHash; // Add the CSRF token to the formData object

var dropzone = new Dropzone(`#documentDropzone`, {
    url: baseUrl + 'dashboard/propertyDocument', // Replace with your document upload URL
    autoProcessQueue: true,
    maxFilesize: 5,
    maxFiles: 5,
    acceptedFiles: '.pdf, .docx, .doc',
    addRemoveLinks: true,
    params: formData, // Spread the formData object into params
    // Customize additional options if needed
    success: function (file, data) {
        response = JSON.parse(data);
        // console.log(file);
        if (response.csrf) {
            csrf = response.csrf;
        } else {
            csrf = response;
        }
        console.log("AA"+csrfHash);
        csrfHash = response.csrfHash;
        console.log("EE"+csrfHash);
        updateCsrf(csrf, function() {
            alert("ok");
            if (response.status == "fail" || response.status == "0") {
                alert("oddk");
                // errCallBk(response);
                // $('.page_loader').hide();
            }
            else if(response.status == "2"){
                alert("sd");
                //Confirm Message
                // $('.page_loader').hide();
            } else {
                // $('.page_loader').hide();
                alert("sdd");
            }
        });
    },
    error: function (file, data) {
        console.log("444"+csrfHash);
    }
});
