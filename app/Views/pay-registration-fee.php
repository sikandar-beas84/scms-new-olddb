<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile & Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
        }

        .logo {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 10px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2.2rem;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .profile-payment-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .profile-payment-container {
                grid-template-columns: 1fr;
            }
        }

        /* Profile Header */
        .profile-header {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            grid-column: 1 / -1;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid white;
            margin-right: 25px;
            background: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #3498db;
        }

        .profile-info h2 {
            margin: 0 0 5px 0;
            font-size: 28px;
        }

        .student-id, .class-info {
            margin: 5px 0;
            opacity: 0.9;
        }

        .payment-status {
            margin-left: auto;
            text-align: center;
        }

        .status-badge {
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 16px;
            display: inline-block;
        }

        .status-badge.pending {
            background: #e74c3c;
            color: white;
        }

        .status-badge.paid {
            background: #2ecc71;
            color: white;
        }

        /* Profile Details */
        .profile-details {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            min-height: 400px;
        }

        .section-title {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
            font-size: 1.5rem;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .detail-card {
        	width: 100%;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #3498db;
            transition: transform 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 1.2rem;
        }

        .card-title i {
            margin-right: 10px;
            color: #3498db;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .label {
            font-weight: 600;
            color: #7f8c8d;
        }

        .value {
            color: #2c3e50;
            text-align: right;
        }

        /* Payment Section */
        .payment-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: fit-content;
        }

        .payment-summary h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 1.5rem;
            text-align: center;
        }

        .fee-breakdown {
            margin-bottom: 30px;
        }

        .fee-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .fee-item.total {
            font-weight: bold;
            font-size: 1.2rem;
            color: #2c3e50;
            border-bottom: none;
            border-top: 2px solid #e9ecef;
            margin-top: 10px;
            padding-top: 15px;
        }

        .payment-action {
            text-align: center;
            border-top: 1px solid #e9ecef;
            padding-top: 25px;
        }

        .pay-now-btn {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            border: none;
            padding: 18px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(46, 204, 113, 0.3);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pay-now-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
        }

        .pay-now-btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .payment-note {
            margin-top: 15px;
            color: #7f8c8d;
            font-size: 14px;
            text-align: center;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .payment-method {
            font-size: 1.8rem;
            color: #7f8c8d;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .payment-status {
                margin-left: 0;
                margin-top: 15px;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            body {
                padding: 10px;
            }
        }
		img.site-icon {
		  width: 100px;             /* adjust as needed */
		  height: 100px;            /* keep consistent size */
		  vertical-align: middle;  /* aligns nicely with text/icons */
		  object-fit: contain;     /* keeps aspect ratio */
		  margin-right: 6px;       /* spacing after logo */
		}
        /* Ensure proper scrolling */
        html, body {
            height: 100%;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="<?= base_url('/public/admin/assets/images/siteicon.png') ?>" alt="Site Logo" class="site-icon">
            </div>
            <h1>Pay Admisssion Registration Fee</h1>
            <p class="subtitle">Complete your admission process by making the payment</p>
        </header>

        <div class="profile-payment-container">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="profile-info">
                    <h2><?= $formData['first_name'] ?? '' ?></h2>
                    <p class="student-id">ADMISSION FORM NO : <?= $form_no ?? '' ?></p>
                    <p class="class-info">Class : <?= $formData['class_name'] ?? '' ?></p>
                </div>
                <div class="payment-status">
                    <span class="status-badge pending">Payment Pending</span>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="profile-details">
                <h3 class="section-title">Student Details</h3>
                
                <div class="details-grid">
                    <!-- Personal Information -->
                    <div class="detail-card">
                        <div class="card-title">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </div>
                        <div class="info-row">
                            <span class="label">Date of Birth:</span>
                            <span class="value"><?= date('d F Y', strtotime($formData['d_o_b'])); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Gender:</span>
                            <span class="value"><?= $formData['gender'] ?? '' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Aadhar No:</span>
                            <span class="value"><?= $formData['aadhaar_no'] ?? '' ?></span>
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <!-- <div class="detail-card">
                        <div class="card-title">
                            <i class="fas fa-users"></i>
                            Parent Information
                        </div>
                        <div class="info-row">
                            <span class="label">Father's Name:</span>
                            <span class="value">Robert Doe</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Father's Mobile:</span>
                            <span class="value">+91 9876543210</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Mother's Name:</span>
                            <span class="value">Sarah Doe</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Mother's Mobile:</span>
                            <span class="value">+91 9876543211</span>
                        </div>
                    </div> -->

                    <!-- Academic Information -->
                    <!-- <div class="detail-card">
                        <div class="card-title">
                            <i class="fas fa-graduation-cap"></i>
                            Academic Information
                        </div>
                        <div class="info-row">
                            <span class="label">Class:</span>
                            <span class="value">10 - Science</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Exam Date:</span>
                            <span class="value">15 December 2024</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Exam Time:</span>
                            <span class="value">10:00 AM</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Academic Year:</span>
                            <span class="value">2024-2025</span>
                        </div>
                    </div> -->

                    <!-- Contact Information -->
                    <!-- <div class="detail-card">
                        <div class="card-title">
                            <i class="fas fa-address-book"></i>
                            Contact Information
                        </div>
                        <div class="info-row">
                            <span class="label">Email:</span>
                            <span class="value">john.doe@example.com</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Telephone:</span>
                            <span class="value">+91 33 1234567</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Transport Stop:</span>
                            <span class="value">Central Station</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Emergency Contact:</span>
                            <span class="value">+91 9876543212</span>
                        </div>
                    </div> -->

                    <!-- Additional Information -->
                    <!-- <div class="detail-card">
                        <div class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Additional Information
                        </div>
                        <div class="info-row">
                            <span class="label">Blood Group:</span>
                            <span class="value">O+</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Allergies:</span>
                            <span class="value">None</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Previous School:</span>
                            <span class="value">St. Mary's High School</span>
                        </div>
                    </div> -->

                    <!-- Medical Information -->
                    <!-- <div class="detail-card">
                        <div class="card-title">
                            <i class="fas fa-heartbeat"></i>
                            Medical Information
                        </div>
                        <div class="info-row">
                            <span class="label">Doctor's Name:</span>
                            <span class="value">Dr. Sharma</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Doctor's Contact:</span>
                            <span class="value">+91 9876543213</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Medical Conditions:</span>
                            <span class="value">None</span>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Payment Section -->
            <div class="payment-section">
                <div class="payment-summary">
                    <h3>Payment Summary</h3>
                    <div class="fee-breakdown">
                        <div class="fee-item">
                            <span>Admisssion Registration Fee:</span>
                            <span>₹<?= $ad_reg_fee ?></span>
                        </div>
                        <!-- <div class="fee-item">
                            <span>Tuition Fee:</span>
                            <span>₹15,000</span>
                        </div>
                        <div class="fee-item">
                            <span>Transport Fee:</span>
                            <span>₹1,500</span>
                        </div>
                        <div class="fee-item">
                            <span>Activity Fee:</span>
                            <span>₹2,000</span>
                        </div>
                        <div class="fee-item">
                            <span>Library Fee:</span>
                            <span>₹500</span>
                        </div>
                        <div class="fee-item">
                            <span>Lab Fee:</span>
                            <span>₹1,000</span>
                        </div> -->
                        <div class="fee-item total">
                            <span>Total Amount:</span>
                            <span>₹<?= $ad_reg_fee ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="payment-action">
                    <button class="pay-now-btn" onclick="initiatePayment()">
                        <i class="fas fa-credit-card"></i>
                        Pay Now - ₹<?= $ad_reg_fee ?>
                    </button>
                    <p class="payment-note">Secure payment powered by Razorpay</p>
                    <div class="payment-methods">
                        <i class="fab fa-cc-visa payment-method"></i>
                        <i class="fab fa-cc-mastercard payment-method"></i>
                        <i class="fab fa-cc-amex payment-method"></i>
                        <i class="fab fa-cc-paypal payment-method"></i>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <p>© <?= date('Y') ?> Satish Chandra Memorial School. All rights reserved.</p>
            <p>Need help? Contact support at scmemorial@rediffmail.com</p>
        </footer>
    </div>

    <script>
        function initiatePayment() {
            // In a real application, this would integrate with a payment gateway
            alert("Redirecting to secure payment gateway...");
            
            // Simulate payment processing
            setTimeout(function() {
                document.querySelector('.status-badge').textContent = 'Payment Completed';
                document.querySelector('.status-badge').className = 'status-badge paid';
                document.querySelector('.pay-now-btn').innerHTML = '<i class="fas fa-check"></i> Payment Completed';
                document.querySelector('.pay-now-btn').style.background = 'linear-gradient(135deg, #95a5a6, #7f8c8d)';
                document.querySelector('.pay-now-btn').style.cursor = 'default';
                document.querySelector('.pay-now-btn').onclick = null;
                
                alert('Payment Successful! Your admission process is now complete.');
            }, 2000);
        }

        // Ensure the page is scrollable
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflowY = 'auto';
            document.documentElement.style.overflowY = 'auto';
        });
    </script>
</body>
</html>