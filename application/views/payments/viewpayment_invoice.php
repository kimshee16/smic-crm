<?php
foreach($payments as $row) {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tax Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            padding: 20px;
            background-image: url(<?php echo $asset_url."newpayments/".$row->letterhead; ?>);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .logo {
            text-align: right;
            font-weight: bold;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
        }
        .invoice-details-left {
            width: 60%;
        }
        .invoice-details-right {
            width: 40%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            text-align: left;
        }
        td {
        }
        .total-row {
            font-weight: bold;
        }
        .payment-info {
            margin-top: 20px;
        }
        .due-date {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .payment-methods {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .payment-advice {
            margin-top: 50px;
            border-top: 1px dashed #999;
            padding-top: 20px;
        }
        .payment-advice-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <button id="print" style="margin-top: 30px; margin-bottom: 30px; margin-left: 30px; width: 100px; height: 30px;">Print</button>
    <div class="container" style="height: 1400px !important; width: 989px !important;">
    <!--<img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->letterhead; ?>" width="100%">-->
        <div style="padding-top: <?php if($row->letterhead == 'PSCTemplate-A4.jpg') { echo '280px'; } elseif($row->letterhead == 'SMICTemplateA4.jpg') { echo '150px'; } ?>;"></div>
        <div class="header">
            <div class="invoice-title">TAX INVOICE</div>
            <div class="logo">
                <div><img src="<?php echo $asset_url; ?>newpayments/<?php echo $row->companylogo; ?>" alt="SMIC" width="100px" /></div>
            </div>
        </div>

        <div class="invoice-details">
            <div class="invoice-details-left">
                <div><?php echo $row->payorname; ?></div>
                <br>
                <br>
                <br>
            </div>
            <div class="invoice-details-right" style="text-align: right;">
                <div><b>Invoice Date:</b> <?php
                    $date = $row->paymentdate; // or any date string
                    $formatted = date('d M Y', strtotime($date));
                    echo $formatted;
                ?></div>
                <div><b>Invoice Number:</b> <?php echo $row->invoicenumber; ?></div>
                <div><b>Company:</b> <?php echo $row->companyname; ?></div>
                <div><b>Address:</b> <?php echo $row->companyaddress; ?></div>
                <div><b>Reference:</b> <?php echo $row->reference; ?></div>
                <div>ABN: <?php echo $row->businessregistrationnumber; ?></div>
                <br><br>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>GST <?php echo $row->taxpercent; ?>%</th>
                    <th style="text-align: right;">Amount AUD</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                foreach($payments_details as $row1) {
                    $amount = 0;
                    $amount = $row1->unit_price * $row1->quantity;
                                
                    $baseAmount = $amount;
                    $gstRate = $row->taxpercent;
                                
                    $gstAmount = ($baseAmount * $gstRate) / 100;
                    $totalAmount = $baseAmount + $gstAmount;
                ?>
                    <tr>
                        <td><?php echo $row1->description; ?></td>
                        <td><?php echo $row1->quantity; ?></td>
                        <td><?php echo 'AUD ' . number_format($row1->unit_price, 2); ?></td>
                        <td><?php echo $gstAmount; ?></td>
                        <td class="amount-column" style="text-align: right;">
                            <?php
                                
                                echo 'AUD ' . number_format($totalAmount, 2);
                                
                                $subtotal += $totalAmount;
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr class="total-row">
                    <td colspan="4">TOTAL AUD</td>
                    <td style="text-align: right;"><?php echo 'AUD ' . number_format($subtotal, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="due-date">Due Date: 23 Dec 2024</div>

        <div class="payment-info">
            <div><?php echo $row->companyname; ?></div>
            <div>BSB: <?php echo $row->branchnumber; ?></div>
            <div>ACCOUNT: <?php echo $row->bankaccountnumber; ?></div>
            <div>SWIFT CODE: <?php echo $row->bankidentifiercode; ?></div>
            <div><?php echo $row->bankname; ?></div>
        </div>

        <div class="payment-methods">
            <img src="<?php echo $asset_url; ?>images/visa.jpg" alt="VISA" width="60px" />
            <img src="<?php echo $asset_url; ?>images/mastercard.jpg" alt="MasterCard" width="60px" />
            <img src="<?php echo $asset_url; ?>images/paypal.jpg" alt="PayPal" width="60px" />
            <div>View and pay online now</div>
        </div>

        <div class="payment-advice">
            <div class="payment-advice-title">PAYMENT ADVICE</div>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <div>To:</div>
                    <div><?php echo $row->companyname; ?></div>
                    <div><?php echo $row->companyaddress; ?></div>
                </div>
                <div>
                    <div>Customer: <?php echo $row->payorname; ?></div>
                    <div>Invoice Number: <?php echo $row->client_id; ?></div>
                    <div>Due Date: <?php
                        $date = $row->duedate; // or any date string
                        $formatted = date('d M Y', strtotime($date));
                        echo $formatted;
                    ?></div>
                    <div>Amount Enclosed: ______________</div>
                    <div><i>Enter the amount you are paying above</i></div>
                </div>
            </div>
            <div style="margin-top: 20px; font-size: 12px;">
                <div>ABN: <?php echo $row->businessregistrationnumber; ?>. Registered Office: N/A</div>
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