<?php
$session = session();

$studentLoggedIn = $session->get('student_logged_in') ?? 0;
$sessionYearId   = $session->get('session_year_id');
$studentCode     = $session->get('code');
$finalPayAmt     = $session->get('finalPayAmt');
?>

<div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?= base_url('login') ?>">Home</a>
            </li>
            <li class="active">CCAvenue Payment Gateway</li>
        </ul>
    </div>

    <div class="page-content">
        <div class="page-header">
            <h1>Payment Details</h1>
        </div>

        <p class="red"><b>*Important Note : Additional Bank Charge may be applicable while Pay through CREDIT CARD, NET BANKING & WALLET.</b></p>
        <b class="red">**Do not close the browser or click back button after clicking "Proceed to pay".</b>
        <br><br>

        <div class="col-sm-12">

            <?php if ($studentLoggedIn == 1): ?>
                <form method="POST" name="customerData" action="<?= base_url('student/ccavenue_request') ?>">
            <?php else: ?>
                <form method="POST" name="customerData" action="<?= base_url('test/ccavenue_request') ?>">
                    <?php if (isset($form_no)): ?>
                        <input type="hidden" name="form_no" value="<?= esc($form_no) ?>">
                    <?php endif; ?>

                    <?php if (isset($first_name)): ?>
                        <input type="hidden" name="first_name" value="<?= esc($first_name) ?>">
                    <?php endif; ?>
            <?php endif; ?>

                <?php if (!empty($sessionYearId)): ?>
                    <input type="hidden" name="session_year_id" value="<?= esc($sessionYearId) ?>">
                <?php endif; ?>

                <?php if (!empty($studentCode)): ?>
                    <input type="hidden" name="student_code" value="<?= esc($studentCode) ?>">
                <?php endif; ?>

                <?php if (!empty($finalPayAmt)): ?>
                    <input type="hidden" name="finalPayAmt" value="<?= esc($finalPayAmt) ?>">
                <?php endif; ?>

                <table width="100%" border="1" align="center">
                    <tr>
                        <td colspan="2">Payment information:</td>
                    </tr>

                    <tr>
                        <td>Payment Option:</td>
                        <td>
                            <input class="payOption" type="radio" name="payment_option" value="OPTCRDC"> Credit Card
                            <input class="payOption" type="radio" name="payment_option" value="OPTDBCRD"> Debit Card <br>
                            <input class="payOption" type="radio" name="payment_option" value="OPTNBK"> Net Banking
                        </td>
                    </tr>

                    <!-- EMI section unchanged -->
                    <!-- keep your EMI HTML as-is -->

                    <tr>
                        <td>Mobile Number:</td>
                        <td>
                            <input type="text" name="mobile_number" placeholder="9770707070">
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="Proceed to pay" class="btn btn-primary">
                        </td>
                    </tr>
                </table>
            </form>

        </div>

        <h2 style="color:green;">
            *For more Payment options (i.e. PhonePe, Google Pay etc.) Click on Proceed to pay.
        </h2>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(function () {

        /* json object contains
            1) payOptType - Will contain payment options allocated to the merchant. Options may include Credit Card, Net Banking, Debit Card, Cash Cards or Mobile Payments.
            2) cardType - Will contain card type allocated to the merchant. Options may include Credit Card, Net Banking, Debit Card, Cash Cards or Mobile Payments.
            3) cardName - Will contain name of card. E.g. Visa, MasterCard, American Express or and bank name in case of Net banking.
            4) status - Will help in identifying the status of the payment mode. Options may include Active or Down.
            5) dataAcceptedAt - It tell data accept at CCAvenue or Service provider
            6)error -  This parameter will enable you to troubleshoot any configuration related issues. It will provide error description.
             "<?php // echo $session->get('finalPayAmt'); ?>";
        */
        var jsonData;
        var access_code = "AVCO86GH94AD42OCDA"; // shared by CCAVENUE
        var amount = 1;
        var currency = "INR";
        console.log( 'https://secure.ccavenue.com/transaction/transaction.do?command=getJsonData&access_code=' + access_code + '&currency=' + currency + '&amount=' + amount )
        $.ajax({
            url: 'https://secure.ccavenue.com/transaction/transaction.do?command=getJsonData&access_code=' + access_code + '&currency=' + currency + '&amount=' + amount,
            dataType: 'jsonp',
            jsonp: false,
            jsonpCallback: 'processData',
            success: function (data) {
                jsonData = data;
                // processData method for reference
                processData(data);
                // get Promotion details
                $.each(jsonData, function (index, value) {
                    if (value.Promotions != undefined && value.Promotions != null) {
                        var promotionsArray = $.parseJSON(value.Promotions);
                        $.each(promotionsArray, function () {
                            console.log(this['promoId'] + " " + this['promoCardName']);
                            var promotions = "<option value=" + this['promoId'] + ">"
                                + this['promoName'] + " - " + this['promoPayOptTypeDesc'] + "-" + this['promoCardName'] + " - " + currency + " " + this['discountValue'] + "  " + this['promoType'] + "</option>";
                            $("#promo_code").find("option:last").after(promotions);
                        });
                    }
                });
            },
            error: function (xhr, textStatus, errorThrown) {
                alert('An error occurred! ' + (errorThrown ? errorThrown : xhr.status));
                //console.log("Error occured");
            }
        });

        $(".payOption").click(function () {
            var paymentOption = "";
            var cardArray = "";
            var payThrough, emiPlanTr;
            var emiBanksArray, emiPlansArray;

            paymentOption = $(this).val();
            $("#card_type").val(paymentOption.replace("OPT", ""));
            $("#card_name").children().remove(); // remove old card names from old one
            $("#card_name").append("<option value=''>Select</option>");
            $("#emi_div").hide();

            //console.log(jsonData);
            $.each(jsonData, function (index, value) {
                //console.log(value);
                if (paymentOption != "OPTEMI") {
                    if (value.payOpt == paymentOption) {
                        cardArray = $.parseJSON(value[paymentOption]);
                        $.each(cardArray, function () {
                            $("#card_name").find("option:last").after("<option class='" + this['dataAcceptedAt'] + " " + this['status'] + "'  value='" + this['cardName'] + "'>" + this['cardName'] + "</option>");
                        });
                    }
                }

                if (paymentOption == "OPTEMI") {
                    if (value.payOpt == "OPTEMI") {
                        $("#emi_div").show();
                        $("#card_type").val("CRDC");
                        $("#data_accept").val("Y");
                        $("#emi_plan_id").val("");
                        $("#emi_tenure_id").val("");
                        $("span.emi_fees").hide();
                        $("#emi_banks").children().remove();
                        $("#emi_banks").append("<option value=''>Select your Bank</option>");
                        $("#emi_tbl").children().remove();

                        emiBanksArray = $.parseJSON(value.EmiBanks);
                        emiPlansArray = $.parseJSON(value.EmiPlans);
                        $.each(emiBanksArray, function () {
                            payThrough = "<option value='" + this['planId'] + "' class='" + this['BINs'] + "' id='" + this['subventionPaidBy'] + "' label='" + this['midProcesses'] + "'>" + this['gtwName'] + "</option>";
                            $("#emi_banks").append(payThrough);
                        });

                        emiPlanTr = "<tr><td>&nbsp;</td><td>EMI Plan</td><td>Monthly Installments</td><td>Total Cost</td></tr>";

                        $.each(emiPlansArray, function () {
                            emiPlanTr = emiPlanTr +
                                "<tr class='tenuremonth " + this['planId'] + "' id='" + this['tenureId'] + "' style='display: none'>" +
                                "<td> <input type='radio' name='emi_plan_radio' id='" + this['tenureMonths'] + "' value='" + this['tenureId'] + "' class='emi_plan_radio' > </td>" +
                                "<td>" + this['tenureMonths'] + "EMIs. <label class='merchant_subvention'>@ <label class='emi_processing_fee_percent'>" + this['processingFeePercent'] + "</label>&nbsp;%p.a</label>" +
                                "</td>" +
                                "<td>" + this['currency'] + "&nbsp;" + this['emiAmount'].toFixed(2) +
                                "</td>" +
                                "<td><label class='currency'>" + this['currency'] + "</label>&nbsp;" +
                                "<label class='emiTotal'>" + this['total'].toFixed(2) + "</label>" +
                                "<label class='emi_processing_fee_plan' style='display: none;'>" + this['emiProcessingFee'].toFixed(2) + "</label>" +
                                "<label class='planId' style='display: none;'>" + this['planId'] + "</label>" +
                                "</td>" +
                                "</tr>";
                        });
                        $("#emi_tbl").append(emiPlanTr);
                    }
                }
            });

        });


        $("#card_name").click(function () {
            if ($(this).find(":selected").hasClass("DOWN")) {
                alert("Selected option is currently unavailable. Select another payment option or try again later.");
            }
            if ($(this).find(":selected").hasClass("CCAvenue")) {
                $("#data_accept").val("Y");
            } else {
                $("#data_accept").val("N");
            }
        });

        // Emi section start
        $("#emi_banks_row").on("change", "#emi_banks", function () {
            if ($(this).val() != "") {
                var cardsProcess = "";
                $("#emi_tbl").show();
                cardsProcess = $("#emi_banks option:selected").attr("label").split("|");
                $("#card_name").children().remove();
                $("#card_name").append("<option value=''>Select</option>");
                $.each(cardsProcess, function (index, card) {
                    $("#card_name").find("option:last").after("<option class=CCAvenue value='" + card + "' >" + card + "</option>");
                });
                $("#emi_plan_id").val($(this).val());
                $(".tenuremonth").hide();
                $("." + $(this).val() + "").show();
                $("." + $(this).val()).find("input:radio[name=emi_plan_radio]").first().attr("checked", true);
                $("." + $(this).val()).find("input:radio[name=emi_plan_radio]").first().trigger("click");

                if ($("#emi_banks option:selected").attr("id") == "Customer") {
                    $("#processing_fee").show();
                } else {
                    $("#processing_fee").hide();
                }

            } else {
                $("#emi_plan_id").val("");
                $("#emi_tenure_id").val("");
                $("#emi_tbl").hide();
            }


            $("label.emi_processing_fee_percent").each(function () {
                if ($(this).text() == 0) {
                    $(this).closest("tr").find("label.merchant_subvention").hide();
                }
            });

        });

        $("#emi_tbl").on("click", ".emi_plan_radio", function () {
            var processingFee = "";
            $("#emi_tenure_id").val($(this).val());
            processingFee =
                "<span class='emi_fees' >" +
                "Processing Fee:" + $(this).closest('tr').find('label.currency').text() + "&nbsp;" +
                "<label id='processingFee'>" + $(this).closest('tr').find('label.emi_processing_fee_plan').text() +
                "</label><br/>" +
                "Processing fee will be charged only on the first EMI." +
                "</span>";
            $("#processing_fee").children().remove();
            $("#processing_fee").append(processingFee);

            // If processing fee is 0 then hiding emi_fee span
            if ($("#processingFee").text() == 0) {
                $(".emi_fees").hide();
            }

        });


        $("#card_number").focusout(function () {
            /*
             emi_banks(select box) option class attribute contains two fields either allcards or bin no supported by that emi
            */
            if ($('input[name="payment_option"]:checked').val() == "OPTEMI") {
                if (!($("#emi_banks option:selected").hasClass("allcards"))) {
                    if (!$('#emi_banks option:selected').hasClass($(this).val().substring(0, 6))) {
                        alert("Selected EMI is not available for entered credit card.");
                    }
                }
            }

        });


        // Emi section end


        // below code for reference

        function processData(data) {
            var paymentOptions = [];
            var creditCards = [];
            var debitCards = [];
            var netBanks = [];
            var cashCards = [];
            var mobilePayments = [];
            $.each(data, function () {
                // this.error shows if any error
                console.log(this.error);
                paymentOptions.push(this.payOpt);
                switch (this.payOpt) {
                    case 'OPTCRDC':
                        var jsonData = this.OPTCRDC;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function () {
                            creditCards.push(this['cardName']);
                        });
                        break;
                    case 'OPTDBCRD':
                        var jsonData = this.OPTDBCRD;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function () {
                            debitCards.push(this['cardName']);
                        });
                        break;
                    case 'OPTNBK':
                        var jsonData = this.OPTNBK;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function () {
                            netBanks.push(this['cardName']);
                        });
                        break;

                    case 'OPTCASHC':
                        var jsonData = this.OPTCASHC;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function () {
                            cashCards.push(this['cardName']);
                        });
                        break;

                    case 'OPTMOBP':
                        var jsonData = this.OPTMOBP;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function () {
                            mobilePayments.push(this['cardName']);
                        });
                }

            });
        }
    });
</script>	