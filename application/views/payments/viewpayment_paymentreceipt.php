<?php
foreach($payments as $row) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row->companyname; ?> Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            
            margin: 0;
            padding: 0;
            /*max-width: 600px;*/
            margin: 0 auto;
            color: #333;
        }
        .container {
            background-image: url(<?php echo $asset_url."newpayments/".$row->letterhead; ?>);
            /*background-position: center;*/
            background-repeat: no-repeat;
            background-size: cover;
            height: 1380px !important;
            width: 989px !important;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .company-name {
            margin-bottom: 10px;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .due-date {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .invoice-number {
            font-size: 12px;
            margin-bottom: 15px;
        }
        .payment-button {
            background-color: #0a6621;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .payment-methods {
            display: flex;
            justify-content: center;
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
        }
        .payment-methods img {
            margin: 0 10px;
        }
        .letter {
            padding: 0 20px;
            line-height: 1.5;
            font-size: 14px;
        }
        .greeting {
            margin-bottom: 15px;
            font-size: 10px;
        }
        .paragraphs p {
            margin-bottom: 15px;
            font-size: 10px;
        }
        .signature {
            margin: 25px 0;
            font-size: 10px;
        }
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 10px;
        }
        .table tr {
            
        }
        .table td {
            padding: 0px 4px;
        }
        .table tr:last-child {
            font-weight: bold;
        }
        .table .amount-column {
            text-align: right;
        }
        .review-pay {
            background-color: #0a6621;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }
        .blue-link {
            color: #0066cc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php
    $subtotal = 0;
    foreach($payments_details as $row1) {
        $amount = $row1->unit_price * $row1->quantity;
        $subtotal += $amount;
    }
    $subtotal = $subtotal;
?>
                
    <button id="print" style="margin-top: 30px; margin-bottom: 30px; margin-left: 30px; width: 100px; height: 30px;">Print</button>
    <div class="container">
    <div style="padding-top: <?php if($row->letterhead == 'PSCTemplate-A4.jpg') { echo '300px'; } elseif($row->letterhead == 'SMICTemplateA4.jpg') { echo '150px'; } ?>;"></div>
    <!--<img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->letterhead; ?>" width="100%">-->
    <div class="header" style="margin-top: -30px;">
        <div class="logo"><img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->companylogo; ?>" width="100px"></div>
        <div class="company-name"><?php echo $row->companyname; ?></div>
        <div class="amount"><?php echo 'AUD ' . number_format($row->totalprice, 2); ?></div>
        <div class="due-date">
            <?php 
                $date = $row->duedate;
                $formatted = date("d M Y", strtotime($date));
                echo $formatted;
            ?>
        </div>
        <div class="invoice-number">Invoice # <?php echo $row->invoicenumber; ?></div>
    </div>

    <div class="payment-methods">
        <img src="<?php echo $asset_url; ?>images/visa.jpg" alt="Visa" width="50px" height="30px" />
        <img src="<?php echo $asset_url; ?>images/mastercard.jpg" alt="Mastercard" width="50px" height="30px" />
        <img src="<?php echo $asset_url; ?>images/applepay.png" alt="Apple Pay" width="60px" height="30px" />
        <img src="<?php echo $asset_url; ?>images/googlepay.png" alt="Google Pay" width="60px" height="30px" />
        <img src="<?php echo $asset_url; ?>images/paypal.jpg" alt="PayPal" width="50px" height="30px" />
    </div>
    
    <div class="letter" style="z-index: 2222; position: relative;">
        <div class="greeting">Dear <?php echo $row->payorname; ?>,</div>
        
        <div class="paragraphs">
            <p>We wish to emphasize the importance of settling your outstanding tuition fee. Your Overdue Invoice <?php echo $row->invoicenumber; ?> for an amount of <?php echo 'AUD ' . number_format($row->totalprice, 2); ?> has been overdue since <?php 
                $date = $row->duedate;
                $formatted = date("d M Y", strtotime($date));
                echo $formatted;
            ?>.</p>
            
            <p>Failure to settle your tuition fee may result in serious consequences, including the potential cancellation of your enrollment at <?php echo $row->companyname; ?>. To avoid this situation, we kindly request that you make your overdue payment, which includes a <?php 
                $penalty = 0;
                $penalty = ($row->penaltypercent * $subtotal) / 100;
                echo 'AUD ' . number_format($penalty, 2);
            ?> late fee, by the end of this week.</p>
            
            <p>If you have already processed the payment, we kindly ask you to send us a screenshot of the transaction for proper allocation. If you have not yet made the payment, we urge you to do so without delay. Please ensure that when making the payment, you include your Student ID and Full Name to facilitate processing and avoid incurring additional late payment fees.</p>
            
            <!--<p>To view your bill and make a payment, please access our online portal via the link: <span class="blue-link">https://abm.me/bill/ebmc-msmdlh9-9oys5a-pq58d3n</span>, or <span class="blue-link">Click/Tap here</span>.</p>-->
            
            <p>Bank Details:<br>
            Bank Name: <?php echo $row->bankname; ?><br>
            Account name: <?php echo $row->companyname; ?><br>
            Branch number (BSB): <?php echo $row->branchnumber; ?><br>
            Account Number: <?php echo $row->bankaccountnumber; ?><br>
            SWIFT code: <?php echo $row->bankidentifiercode; ?></p>
            
            <p>Should you require any further clarification or require assistance regarding this matter, please contact <?php echo $row->companyname; ?>'s accounts manager at <?php echo $row->contactdetails; ?>. We are here to assist you.</p>
            
            <p>Your cooperation in promptly resolving this matter is greatly appreciated. We look forward to receiving confirmation of your payment for this outstanding tuition fee.</p>
        </div>
        
        <div class="signature">
            Best regards,<br>
            <b><?php echo $row->companyname; ?> Finance</b>
        </div>
        
        <table class="table">
        
            <tr>
                <td><b>Description</b></td>
                <td class="amount-column"><b>Amount</b></td>
            </tr>
        <?php
        foreach($payments_details as $row1) {
        ?>
            <tr>
                <td><?php echo $row1->description; ?></td>
                <td class="amount-column">
                    <?php
                        $amount = 0;
                        $amount = $row1->unit_price * $row1->quantity;
                        echo 'AUD ' . number_format($amount, 2);
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
            <tr>
                <td>Late Fee/Tuition refundable/ Dip and above</td>
                <td class="amount-column">
                    <?php
                        echo 'AUD ' . number_format($penalty, 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td class="amount-column">
                    <?php
                        echo 'AUD ' . number_format($subtotal, 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td>GST <?php echo $row->taxpercent; ?>%</td>
                <td class="amount-column">
                    <?php
                    $gst = 0;
                    $gst = ($row->taxpercent * $subtotal) / 100;
                    echo 'AUD ' . number_format($gst, 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td>Discount <?php echo $row->discountpercent; ?>%</td>
                <td class="amount-column">
                    <?php
                        $discount = 0;
                        $discount = ($row->discountpercent * $subtotal) / 100;
                        echo '- AUD ' . number_format($discount, 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td>Amount Due</td>
                <td class="amount-column">
                    <?php
                    echo 'AUD ' . number_format($subtotal+$gst+$penalty-$discount, 2);
                    ?>
                </td>
            </tr>
        
        </table>
    </div>
    <!--<img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->footer; ?>" width="100%" style="margin-top: -135px;z-index: 0; position: relative; bottom: 0;">-->
    </div>
</body>
</html>
<script>
    init();
    
    function printDiv() {
        var printContents = document.getElementsByClassName("container")[0].outerHTML;
        var originalContents = document.body.innerHTML;
         
        document.body.innerHTML = printContents;
        // document.getElementById("print").style.display = "none";
        window.print();
        // document.getElementById("print").style.display = "block";
        document.body.innerHTML = originalContents;
        init();
    }
    
    function init() {
        document.getElementById("print").onclick = function() {
            printDiv();
        }
    }
</script>
<?php
}
?>