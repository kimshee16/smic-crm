<?php
foreach($payments as $row) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $row->companyname; ?> Commission Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #333;
    }
    h1 {
      text-align: center;
      color: #2a75f3;
      font-size: 50px;
      margin-bottom: 0;
    }
    .section {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .section div {
      width: 45%;
    }
    table {
      width: 100%;
      margin-bottom: 20px;
    }
    th, td {
      text-align: left;
    }
    .summary td {
      border: none;
    }
    .summary tr:last-child td {
      font-weight: bold;
    }
    .payment-note {
      margin-top: 20px;
      font-size: 14px;
    }
    .wrapper {
        background-image: url(<?php echo $asset_url."newpayments/".$row->letterhead; ?>);
        background-repeat: no-repeat;
        background-size: cover;
        height: 1400px !important;
        width: 989px !important;
        padding: 20px;
    }
    .tablewrapper {
        border: 1px solid black;
    }
  </style>
</head>
<body>
<button id="print" style="margin-top: 30px; margin-bottom: 30px; margin-left: 30px; width: 100px; height: 30px;">Print</button>
<div class="wrapper">
<div style="padding-top: <?php if($row->letterhead == 'PSCTemplate-A4.jpg') { echo '200px'; } elseif($row->letterhead == 'SMICTemplateA4.jpg') { echo '150px'; } ?>;"></div>
<h1>Commission Invoice</h1>
<hr><br><br><br><br>
<div class="section">
  <div>
    <small>FROM</small><br>
    <b><?php echo $row->companyname; ?></b><br>
    <?php echo $row->companyaddress; ?><br>
    <?php echo $row->contactdetails; ?><br>
  </div>
  <div style="text-align: right;">
    <small>TO</small><br>
    <b><?php echo $row->payorname; ?></b><br>
    <?php echo $row->address; ?><br>
  </div>
</div>

<div class="section">
  <div><strong>ISSUED ON</strong><br><?php 
                $date = $row->paymentdate;
                $formatted = date("d M Y", strtotime($date));
                echo $formatted;
            ?></div>
  <div style="text-align: right;"><strong>DUE DATE</strong><br><?php 
                $date = $row->duedate;
                $formatted = date("d M Y", strtotime($date));
                echo $formatted;
            ?></div>
</div>

<div class="tablewrapper">
<table>
  <thead>
    <tr>
      <th>ITEM NAME</th>
      <th>UNITS</th>
      <th>RATE</th>
      <th>TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $subtotal = 0;
    foreach($payments_details as $row1) {
    ?>
        <tr>
            <td><?php echo $row1->description; ?></td>
            <td><?php echo $row1->quantity; ?></td>
            <td><?php echo 'AUD ' . number_format($row1->unit_price, 2); ?></td>
            <td class="amount-column">
                <?php
                    $amount = 0;
                    $amount = $row1->unit_price * $row1->quantity;
                    echo 'AUD ' . number_format($amount, 2);
                    $subtotal += $amount;
                ?>
            </td>
        </tr>
    <?php
    }
    ?>
    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
    <tr>
        <td>Subtotal:</td>
        <td></td>
        <td></td>
        <td><?php echo 'AUD ' . number_format($subtotal, 2); ?></td>
      </tr>
      <tr>
        <td><?php echo $row->discountpercent; ?>% Discount:</td>
        <td></td>
        <td></td>
        <td>- 
        <?php 
        $discount = 0;
        $discount = ($subtotal * $row->discountpercent) / 100;
        echo 'AUD ' . number_format($discount, 2); 
        ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $row->taxpercent; ?>% Tax:</td>
        <td></td>
        <td></td>
        <td>
        <?php
        $gst = 0;
        $gst = ($subtotal * $row->taxpercent) / 100;
        echo 'AUD ' . number_format($gst, 2);
        ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $row->penaltypercent; ?>% Penalty:</td>
        <td></td>
        <td></td>
        <td>
        <?php
        $penalty = 0;
        $penalty = ($subtotal * $row->penaltypercent) / 100;
        echo 'AUD ' . number_format($penalty, 2);
        ?>
        </td>
      </tr>
      <tr>
        <td>Total Amount:</td>
        <td></td>
        <td></td>
        <td><b><?php
        $totalAmount = $subtotal + $gst + $penalty - $discount;
        echo 'AUD ' . number_format($totalAmount, 2);
        ?></b>
        </td>
      </tr>
      
  </tbody>
</table>

</div>
<div class="payment-note">
  Payment<br>
  <b>This invoice can be paid via PayPal, credit/debit card, bank transfer or the attached payment instructions.</b>
</div>

</div>

</body>
</html>
<script>
    init();
    
    function printDiv() {
        var printContents = document.getElementsByClassName("wrapper")[0].outerHTML;
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