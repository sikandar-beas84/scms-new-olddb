
<!-- Bootstrap4 js-->
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

<script src="<?= base_url(); ?>assets/js/feather.min.js"></script>

<!--INTERNAL Toastr js -->
<script src="<?= base_url() ?>assets/js/toastr.min.js"></script>

<!-- Custom JS Plugins -->
<script src="<?= base_url(); ?>assets/js/script.js"></script>
<script src="<?= base_url(); ?>assets/js/dynamicModal.js"></script>
<script src="<?= base_url(); ?>assets/js/ajaxRequest.js"></script>
<script src="<?= base_url(); ?>assets/js/commonValidation.js"></script>
<script src="<?= base_url(); ?>assets/js/datatable.init.js"></script>

<script src="<?= base_url(); ?>assets/js/alertify.js"></script>
<script src="<?= base_url(); ?>assets/js/alertify.min.js"></script>

<script src="<?= base_url(); ?>assets/js/message.js"></script>
<script src="<?= base_url(); ?>assets/js/init.js"></script>

<script>
	// var code;
	function createCaptcha() {
		//clear the contents of captcha div first 
		document.getElementById('captcha').innerHTML = "";
		var charsArray =
			"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
		var lengthOtp = 6;
		var captcha = [];
		for (var i = 0; i < lengthOtp; i++) {
			//below code will not allow Repetition of Characters
			var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
			if (captcha.indexOf(charsArray[index]) == -1)
				captcha.push(charsArray[index]);
			else i--;
		}
		var canv = document.createElement("canvas");
		canv.id = "captcha";
		canv.width = 100;
		canv.height = 50;
		var ctx = canv.getContext("2d");
		ctx.font = "25px Georgia";
		ctx.strokeText(captcha.join(""), 0, 30);
		//storing captcha so that can validate you can save it somewhere else according to your specific requirements
		code = captcha.join("");
		document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
	}
	function validateCaptcha() {
		// event.preventDefault();
		// debugger
		if (document.getElementById("cpatchaTextBox").value == code) {
			//alert("Valid Captcha")
			return 1;
		} else {
			//alert("Invalid Captcha. try Again");
			createCaptcha();
			return 0;
		}
	}

</script>

</body>

</html>
