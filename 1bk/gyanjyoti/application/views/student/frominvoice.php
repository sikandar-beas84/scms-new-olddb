<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Invoice</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #243448;
            --secondary-color: #f8f9fa;
        }

        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }

        .invoice-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            max-width: 200px;
            height: auto;
        }

        .invoice-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        .school-details {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .student-details {
            background-color: var(--secondary-color);
            padding: 1.5rem;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        .fee-table {
            margin-bottom: 2rem;
        }

        .fee-table th {
            background-color: var(--primary-color);
            color: white;
        }

        .total-section {
            background-color: var(--secondary-color);
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        .signature-section {
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
            margin-top: 2rem;
        }

        .print-button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .print-button:hover {
            background-color: #1a2632;
            transform: translateY(-2px);
        }

        @media print {
            body {
                background-color: white;
            }
            .invoice-container {
                box-shadow: none;
                padding: 0;
            }
            .print-button {
                display: none;
            }
        }
        a {
    text-decoration: none;
}
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Logo Section -->
           <header style="max-width: 100%;">
            <!-- <h1>Gyanjyoti Public School</h1>
            <div class="school-details">
                <p>Address: Kalyani Expy, highway, Kanchrapara, Chendua P, West Bengal 743145</p>
                <p>Phone: +91 90731 12222</p>
            </div> -->
            <img src="<?=base_url(); ?>assets/uploads/LatterHead.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </header>

        <!-- Invoice Header -->
        <div class="invoice-header text-center">
            <h2 class="mb-0">Form Fill Up Invoice</h2>
        </div>



        <!-- Student Details -->
        <div class="student-details">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Transaction ID:</strong> <span id="transactionId"></span></p>
                    <p><strong>Form No:</strong> <span id="formNo"></span></p>
                    <p><strong>Student Name:</strong> <span id="studentName"></span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Mode:</strong> <span id="paymentMode"></span></p>
                    <p><strong>Date:</strong> <span id="paymentDate"></span></p>
                    <p><strong>Amount:</strong> ₹<span id="amount"></span></p>
                </div>
            </div>
        </div>

        <!-- Amount in Words -->
        <div class="total-section">
            <p class="mb-0"><strong>Amount in Words:</strong> <span id="amountInWords"></span></p>
        </div>

        <!-- Footer Note -->
        <div class="text-muted small">
            <p>N.B: This is a system generated receipt, Stamp & Signature not required.</p>
        </div>
<footer style="max-width: 100%;">

            <img src="<?=base_url(); ?>assets/uploads/LatterFooter.png" alt="LatterHead" srcset="" style="max-width: 100%;">
        </footer>
        <!-- Print Button -->
        <div class="text-center mt-4">
            <button class="print-button" id="printBtn">
                <i class="bi bi-printer"></i> Print Invoice
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to convert number to words
            function numberToWords(num) {
                const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
                const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

                if (num === 0) return 'Zero';

                function convertLessThanThousand(n) {
                    if (n === 0) return '';
                    
                    let result = '';
                    
                    if (n >= 100) {
                        result += ones[Math.floor(n / 100)] + ' Hundred ';
                        n %= 100;
                    }
                    
                    if (n >= 20) {
                        result += tens[Math.floor(n / 10)] + ' ';
                        n %= 10;
                    } else if (n >= 10) {
                        result += teens[n - 10] + ' ';
                        return result;
                    }
                    
                    if (n > 0) {
                        result += ones[n] + ' ';
                    }
                    
                    return result;
                }

                let result = '';
                
                if (num >= 100000) {
                    result += convertLessThanThousand(Math.floor(num / 100000)) + 'Lakh ';
                    num %= 100000;
                }
                
                if (num >= 1000) {
                    result += convertLessThanThousand(Math.floor(num / 1000)) + 'Thousand ';
                    num %= 1000;
                }
                
                result += convertLessThanThousand(num);
                
                return result.trim() + ' Rupees Only';
            }
            // Fill in sample data (replace with actual data)
            $('#transactionId').text('<?=$fromInvoice[0]['transaction_id'];?>');
            $('#formNo').text('<?=$fromInvoice[0]['admission_form_no'];?>');
            $('#studentName').text('<?=$fromInvoice[0]['student_name'];?>');
            $('#paymentMode').text('Online Payment');
            $('#paymentDate').text(new Date().toLocaleDateString());
            $('#amount').text('<?=$fromInvoice[0]['amount'];?>');
            $('#amountInWords').text(numberToWords(<?=$fromInvoice[0]['amount'];?>));

            // Print functionality
            $('#printBtn').click(function() {
                window.print();
            });
        });
    </script>
</body>
</html>