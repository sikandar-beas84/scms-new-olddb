<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .error-icon {
    color: #dc3545;
    font-size: 0rem;
    margin-bottom: 1rem;
    width: 48px;
}
        .error-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .error-details {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .retry-btn {
            background-color: #243448;
            border: none;
        }
        .retry-btn:hover {
            background-color: #1a2732;
        }
    </style>
</head>
<body class="bg-light">
    <div class="error-container">
        <header class="text-center mb-4">
            <img src="<?php echo base_url(); ?>assets/uploads/LatterHead.png" alt="Letter Head" class="img-fluid">
        </header>

        <div class="text-center">
            <svg class="error-icon" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="11" fill="none" stroke="currentColor" stroke-width="2"/>
                <line x1="8" y1="8" x2="16" y2="16" stroke="currentColor" stroke-width="2"/>
                <line x1="16" y1="8" x2="8" y2="16" stroke="currentColor" stroke-width="2"/>
            </svg>
            
            <h2 class="text-danger mb-4">Payment Failed</h2>
            
            <div class="error-details">
                <p class="mb-0">
                    Error Code: <?php echo $error_code ?? 'Unknown'; ?><br>
                    Error Message: <?php echo $error_message ?? 'An error occurred during payment processing.'; ?>
                </p>
            </div>

            <div class="mb-4">
                <h5>Possible reasons for failure:</h5>
                <ul class="text-start list-unstyled">
                    <li>• Insufficient funds in the account</li>
                    <li>• Transaction timed out</li>
                    <li>• Bank server error</li>
                    <li>• Invalid card details</li>
                </ul>
            </div>

            <div class="d-grid gap-2 col-md-6 mx-auto">
                <!--<a href="<?php echo base_url('payment/retry'); ?>" >-->
                <!--    Retry Payment-->
        <!--</a>-->
                <button class="btn btn-primary retry-btn btn-lg mb-2" onclick="window.print()">Print Invoice</button>

                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-secondary btn-lg">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <footer class="text-center mt-4">
            <img src="<?php echo base_url(); ?>assets/uploads/LatterFooter.png" alt="Letter Footer" class="img-fluid">
        </footer>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>