<?php
foreach($payments as $row) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acknowledgement Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /*max-width: 800px;*/
            /*margin: 0 auto;*/
            line-height: 1.6;
        }
        .container {
            padding: 20px;
            background-image: url(<?php echo $asset_url."newpayments/".$row->letterhead; ?>);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .header {
            text-align: right;
            margin-bottom: 30px;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .form-field {
            margin-bottom: 20px;
        }
        .underline {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 60%;
            height: 1.2em;
        }
        .amount-field .underline {
            min-width: 70%;
        }
        .payment-field {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .payment-field .parenthesis {
            white-space: nowrap;
        }
        .payment-field .underline:first-of-type {
            min-width: 150px;
        }
        .payment-field .underline:last-of-type {
            min-width: 60%;
        }
        .payment-details {
            margin-top: 30px;
            font-size: 12px;
        }
        .payment-details h3 {
            margin-bottom: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .payment-item {
            display: flex;
            margin-bottom: 10px;
        }
        .payment-label {
            width: 140px;
        }
        .payment-value {
            border-bottom: 1px solid #000;
            width: 250px;
        }
        .signature-section {
            margin-top: 40px;
            text-align: right;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 300px;
            height: 1.2em;
            margin-bottom: 5px;
            display: inline-block;
        }
        .signature-label {
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <button id="print" style="margin-top: 30px; margin-bottom: 30px; margin-left: 30px; width: 100px; height: 30px;">Print</button>
    <div class="container" style="height: 1400px !important;width: 989px !important;">
        
        <!--<img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->letterhead; ?>" width="100%">-->
        <br><br><br>
        <div style="padding-top: <?php if($row->letterhead == 'PSCTemplate-A4.jpg') { echo '200px'; } elseif($row->letterhead == 'SMICTemplateA4.jpg') { echo '70px'; } ?>;">
        <div class="header">
            <div class="form-field">
                Date: <b><?php echo $row->paymentdate; ?></b>
            </div>
        </div>
        
        <div class="title">ACKNOWLEDGEMENT RECEIPT</div>
        
        <div style="font-size: 16px;">This is to acknowledge receiving from <b><?php echo $row->companyname; ?></b> the amount of (in words): <b><?php echo $row->totalpriceinwords; ?></b> <span class="parenthesis">(AUD </span><b><?php echo number_format($row->totalprice, 2); ?></b><span class="parenthesis">)</span> as payment for <b><?php echo $row->description; ?></b></div>
        
        <div class="payment-details">
            <h3>Payment details:</h3>
            Cash Payment: _________________________<br>
            Bank & Check No.: ______________________<br>
            Check Date: ___________________________<br>
            <!--<div class="payment-item">-->
            <!--    <div class="payment-label"></div>-->
            <!--    <div class="payment-value"></div>-->
            <!--</div>-->
            <!--<div class="payment-item">-->
            <!--    <div class="payment-label"></div>-->
            <!--    <div class="payment-value"></div>-->
            <!--</div>-->
            <!--<div class="payment-item">-->
            <!--    <div class="payment-label">Check Date:</div>-->
            <!--    <div class="payment-value"></div>-->
            <!--</div>-->
        </div>
        
        <div class="signature-section">
            <div>Received By;</div>
            <b><?php echo $row->payorname; ?></b>
            <div class="signature-label">(Signature over Printed Name)</div>
        </div>
        </div>
        
        <!--<img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->footer; ?>" width="100%" style="margin-top: -110px;z-index: 0; position: relative; bottom: 0;">-->
    </div>
</body>
</html>
<script>
    init();
    
    function printDiv() {
        var printContents = document.getElementsByClassName("container")[0].outerHTML;
        var originalContents = document.body.innerHTML;
         
        document.body.innerHTML = printContents;
        window.print();
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