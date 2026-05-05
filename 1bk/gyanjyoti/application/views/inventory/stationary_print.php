
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            height: 300px;
            margin-bottom: 20px;
        }
        .icon-bg {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        a {
            text-decoration: none;
        }

        @media print {
            /* Ensure Bootstrap is applied during printing */
            @import url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

            /* Ensure that the page uses the full width */
            .container {
                width: 100%;
                padding: 0;
            }

            /* Make sure the grid works in print */
            .row {
                display: block;
                width: 100%;
                padding: 0;
            }

            .col-12 {
                width: 100%;
                padding: 0;
            }

            /* Hide print button when printing */
            .btn {
                display: none;
            }

            /* Optional: Adjust the font sizes for better printing */
            h2 {
                font-size: 20px;
            }

            p, .content {
                font-size: 16px;
            }

            /* Optional: Adjust spacing for better print readability */
            body {
                margin: 0;
                padding: 10px;
            }
            div#cash-memo {
            margin: 0;
        }
        .cash-memo {
            margin: 0 !important;
        }
        }
        .page-content {
                justify-content: flex-start;
            }
            .cash-memo {
    background: #fff;
    margin: 0 !important;
}
    </style>
 <!-- Bootstrap CSS CDN -->
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0mTqjL1vcM5JSm9Wjc15+fXkRzjiAa9/4SOnjl92mye3sMMm" crossorigin="anonymous">
    
    <!-- Font Awesome for Print Button Icon -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- Print.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
    <div class="container-fluid py-4">
        <!-- Header -->


  
        <div id="filterData">

        <div class="main-content">
				<div class="main-content-inner">
					

					<div class="page-content">
						
						<!-- Surojit Bera -->
						<div class="col-sm-12" style="background: #eee;">
						<div class="filter-info mt-15" id="add_itens_block">
						      <style>
                                .cash-memo {
                                  max-width: 600px;
                                  margin: 50px auto;
                                  padding: 20px;
                                  border: 1px solid #dee2e6;
                                  border-radius: .25rem;
                                }
                                .cash-memo h2 {
                                  text-align: center;
                                  margin-bottom: 20px;
                                }
                                .cash-memo .row + .row {
                                  margin-top: 10px;
                                }
                                .cash-memo {
                                    background: #fff;
                                }
                                p, th, td {
                                    font-size: 11px;
                                }
                                @media print {
                                    p, th, td {
                                        font-size: 11px;
                                    }
                                }

                              </style>
                              <?php 
                                $student = $this->Student_model->get_students_full_details_by_code($list->student_code);
                                // $section = $this->Student_model->get_section_name_by_id($student->section_id);
                                $stationary_purchase_item = $this->Inventory_model->get_stationary_purchase_item_by_order_id($list->id);
                                // prx($student);
                               
                                // $section_name = $student[0]->section_name;
                                // print_r($stationary_purchase_item);
                                $total = $number = $list->amount;

                                function numberToWords($number) {
                                    $words = array(
                                        '0' => 'Zero', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four',
                                        '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                                        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen',
                                        '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                                        '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty',
                                        '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy',
                                        '80' => 'Eighty', '90' => 'Ninety'
                                    );
                        
                                    $units = array(
                                        '100' => 'Hundred', '1000' => 'Thousand', '100000' => 'Lakh', '10000000' => 'Crore'
                                    );
                        
                                    if ($number == 0) {
                                        return $words['0'];
                                    }
                        
                                    $result = '';
                                    if ($number >= 10000000) {
                                        $result .= numberToWords(floor($number / 10000000)) . ' ' . $units['10000000'] . ' ';
                                        $number %= 10000000;
                                    }
                                    if ($number >= 100000) {
                                        $result .= numberToWords(floor($number / 100000)) . ' ' . $units['100000'] . ' ';
                                        $number %= 100000;
                                    }
                                    if ($number >= 1000) {
                                        $result .= numberToWords(floor($number / 1000)) . ' ' . $units['1000'] . ' ';
                                        $number %= 1000;
                                    }
                                    if ($number >= 100) {
                                        $result .= numberToWords(floor($number / 100)) . ' ' . $units['100'] . ' ';
                                        $number %= 100;
                                    }
                                    if ($number >= 20) {
                                        $result .= $words[10 * floor($number / 10)];
                                        if ($number % 10) {
                                            $result .= '-' . $words[$number % 10];
                                        }
                                    } else if ($number > 0) {
                                        $result .= $words[$number];
                                    }
                        
                                    return $result;
                                }
                        
                                $total_in_words = numberToWords($total);
                              ?>
                            <div class="cash-memo" id="cash-memo" style="padding: 1px;">
                                <h2 style="font-size: 15px;margin: 0;padding: 0;">Cash Memo</h2>
                                <div class="row">
                                  <div class="col-sm-12">
                                    <p style="font-size: 9px;"><strong>Billing Number:</strong> <?=$list->billing_number; ?></p>
                                  </div>
                                  <div class="col-sm-12">
                                    <p style="font-size: 9px;"><strong>Student Id:</strong> <?=$list->student_code; ?></p>
                                  </div>
                                  <div class="col-sm-12">
                                    <p style="font-size: 9px;"><strong>Date Time:</strong> <?= date('Y-m-d', strtotime($list->created_date)); ?></p>
                                  </div>
                                </div>
                                <div class="row" style="margin: 0;">
                                  <div class="col-sm-12" style="padding: 0;">
                                    <p style="font-size: 9px;"><strong>Student Name: </strong> <?=$student->student_name; ?>, <?=$student->section_name; ?>, <?=$student->roll; ?></p>
                                    <!--<p><strong>Class:</strong> <?=$student->class_name; ?></p>-->
                                    <!--<p><strong>Section:</strong> <?=$section_name; ?></p>-->
                                    <!--<p><strong>Roll:</strong> <?=$student->roll_num; ?></p>-->
                                  </div>
                                </div>
                                <table class="table table-bordered mt-3">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th style="font-size: 9px;" scope="col">Item</th>
                                      <th style="font-size: 9px;" scope="col">Quantity</th>
                                      <th style="font-size: 9px;" scope="col">Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach($stationary_purchase_item as $v){ 
                                       $item = $this->Inventory_model->get_item_by_item_id($v->item);
                                      ?>
                                    <tr>
                                      <td style="font-size: 9px;">1. <?=$item[0]->item_name; ?></td>
                                      <td style="font-size: 9px;"><?=$v->quantity; ?></td>
                                      <td style="font-size: 9px;"><?=$v->amount; ?></td>
                                    </tr>
                                    <?php } ?>
                                    
                                  </tbody>
                                </table>
                                <div class="row">
                                  <div class="col-sm-12">
                                    <p style="font-size: 9px;"><strong>Grand Total:</strong> <?=$total; ?>/-</p>
                                  </div>
                                  <div class="col-sm-12">
                                    <p style="font-size: 9px;"><strong>Rupees in Word:</strong> <?=$total_in_words; ?></p>
                                  </div>
                                </div>
                                <div class="row mt-3" style="font-size: 9px;margin: 0;">
                                  <div class="col-sm-12" style="padding: 1px;">
                                    <p style="font-size: 9px;"><strong>Printed By: <?php echo $this->session->userdata('f_name').' '.$this->session->userdata('l_name'); ?></strong></p>
                                  </div>
                                  <?php $query = $this->db->get_where('staff', array('id' => $list->created_by)); 
                                  $collectedBy = $query->row()->first_name;
                                  ?>
                                  <div class="col-sm-12" style="padding: 1px;">
                                    <p style="font-size: 9px;"><strong>Collected By:</strong> <?=$collectedBy ?></p>
                                  </div>
                                </div>
                              </div>
                                <button id="printCashMemo" class="btn btn-primary mt-3">Print Cash Memo</button>
                                
                                <button class="btn btn-primary mt-3" onclick="history.go(-1);">Back </button>
						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

        
        
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>

    <script>
      $(document).ready(function() {
        $('#printCashMemo').on('click', function() {
            printJS({
            printable: 'cash-memo',  // id of the element to print
            type: 'html',
            targetStyles: ['*']
            });
        });
        });

        </script>
