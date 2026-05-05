<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Invoice</title>
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .student-details {
            margin: 20px 0;
        }
        .student-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #243448;
            color: white;
        }
        .invoice-table tfoot td {
            font-weight: bold;
            font-size: 18px;
        }
        .print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 12px;
            background-color: #243448;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #1a2732;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <header>
            <img src="<?php echo base_url(); ?>assets/uploads/LatterHead.png" alt="Letter Head" style="max-width: 100%;">
        </header>

        <div class="student-details">
            <p><strong>Transaction ID:</strong> <?php echo $response['unique_ref_number']; ?></p>
            <p><strong>Payment Date:</strong> <?php echo date('d M Y H:i', strtotime($response['transaction_date'])); ?></p>
            <p><strong>Payment Mode:</strong> <?php echo $response['payment_mode']; ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Fee Description</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mandatory_values = explode('|', $response['mandatory_fields']);
                $fees_data = [
                    'Session Fees' => $fees[0]->session_fees ?? 0,
                    'Academic Fees' => $fees[0]->academic_fees ?? 0,
                    'Tuition Fees' => $fees[0]->tuition_fees ?? 0,
                    'Monthly Fees' => $fees[0]->monthly_fees ?? 0,
                    'Sports Fees' => $fees[0]->sports_fees ?? 0,
                    'Library Fees' => $fees[0]->library_fees ?? 0,
                    'Other Curriculum Fees' => $fees[0]->other_curriculum_fees ?? 0,
                    'Fine' => $fees[0]->fine ?? 0
                ];

                foreach ($fees_data as $description => $amount) {
                    if ($amount > 0) {
                        echo "<tr><td>$description</td><td>₹" . number_format($amount, 2) . "</td></tr>";
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Amount Paid</strong></td>
                    <td><strong>₹<?php echo number_format($response['transaction_amount'], 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <p>For print receipt Please Logout and Login</p>
        <footer>
            <img src="<?php echo base_url(); ?>assets/uploads/LatterFooter.png" alt="Letter Footer" style="max-width: 100%;">
        </footer>
        
        <button class="print-btn" onclick="window.print()">Print Invoice</button>
         <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-secondary btn-lg">
                    Back to Dashboard
                </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-print when specifically requested
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === 'true') {
                window.print();
            }
        });
    </script>
</body>
</html>