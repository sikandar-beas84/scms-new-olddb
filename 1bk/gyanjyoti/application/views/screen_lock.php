
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Screen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
	<!--Favicon -->
	<link rel="icon" href="<?= base_url() ?>assets/img/favicon.ico" type="image/x-icon" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .lock-screen-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .lock-screen-card {
            max-width: 360px;
            margin: auto;
            padding: 40px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .lock-screen-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .lock-screen-card .logo img {
            max-width: 100%;
        }

        .lock-screen-card .form-group {
            margin-bottom: 25px;
        }

        .lock-screen-card .form-group:last-child {
            margin-bottom: 0;
        }

        .lock-screen-card .form-group label {
            font-weight: bold;
        }

        .lock-screen-card .form-group input {
            height: 40px;
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .lock-screen-card .form-group input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .lock-screen-card .form-group input[type="submit"]:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="lock-screen-wrapper">
        <div class="lock-screen-card">
            <div class="logo">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo">
				<h3 class="text-center mb-4">Screen Locked</h3>
            <p class="text-center text-muted">Please enter your password to unlock the screen.</p>
            </div>
            <!-- Defining CSRF Token in JS Format -->
            <input type="hidden" name="csrf_token_name" id="csrf_token_name" value="<?= $this->security->get_csrf_token_name() ?>">
            <input type="hidden" name="csrf_token_hash" id="csrf_token_hash" value="<?= $this->security->get_csrf_hash() ?>">
            <form id="screenLockForm">
               
                <div class="form-group">
                    <!-- <label for="password">Password</label> -->
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <!-- <input type="submit" value="Unlock" class="btn btn-primary btn-block"> -->
                    <button type="submit" class="btn btn-primary btn-block">Unlock</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/feather.min.js"></script>
    <!-- INTERNAL Sweet-Alert js-->
    <script src="<?= base_url(); ?>assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="<?= base_url(); ?>assets/plugins/sweetalert/sweetalerts.min.js"></script>
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
    <script type="text/javascript">
        var baseUrl = '<?=base_url(); ?>';
        $(document).ready(function (){
            $('#screenLockForm').on('submit', function(e){
                // debugger;
                e.preventDefault();
                ajaxFromSubmit('login/update_screen_lock',this, function(data){
                    if(data.status == 'success'){
                        window.location.href = '<?= base_url() ?>dashboard';
                    }
                });
            });
            
        });
    </script>
</body>
</html>
