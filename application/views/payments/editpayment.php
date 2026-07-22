<?php
    $this->load->view('layout/header');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
    <style>
      .payment-entry-card {
        border: 1px solid #d8e4f0;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(13, 34, 56, .08);
      }

      .payment-entry-form {
        color: #0d2238;
      }

      .payment-entry-form center {
        display: block;
        margin: 28px 0 14px;
        text-align: left;
      }

      .payment-entry-form center:first-of-type {
        margin-top: 0;
      }

      .payment-entry-form h2 {
        border-bottom: 1px solid #d8e4f0;
        font-size: 18px;
        font-weight: 800;
        letter-spacing: 0;
        margin: 0;
        padding-bottom: 10px;
        text-transform: none;
      }

      .payment-entry-form label {
        color: #20364d;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 6px;
      }

      .payment-entry-form .form-control,
      .payment-entry-form .select2-container--default .select2-selection--single {
        border-color: #cfdce9;
        border-radius: 6px;
        min-height: 38px;
      }

      .payment-entry-form .mb-3 {
        margin-bottom: 14px !important;
      }

      .payment-lines-toolbar {
        align-items: center;
        display: flex;
        gap: 8px;
        justify-content: space-between;
        margin: 18px 0 10px;
      }

      .payment-lines-actions {
        display: flex;
        gap: 8px;
      }

      .payment-lines-toolbar h2 {
        border: 0;
        font-size: 16px;
        margin: 0;
        padding: 0;
      }

      .payment-lines-table {
        border: 1px solid #d8e4f0;
        border-radius: 8px;
        overflow: hidden;
      }

      .payment-lines-table table {
        margin-bottom: 0;
      }

      .payment-lines-table thead th {
        background: #f1f6fb;
        border-bottom: 1px solid #d8e4f0;
        color: #0d2238;
        font-size: 12px;
        text-transform: uppercase;
      }

      .payment-lines-table td {
        vertical-align: middle;
      }

      .payment-lines-table input {
        width: 100%;
      }

      .payment-summary {
        background: #f7fbff;
        border: 1px solid #d8e4f0;
        border-radius: 8px;
        margin-top: 12px;
        padding: 14px;
      }

      .payment-summary .form-control[readonly] {
        background: #fff;
        font-weight: 700;
      }

      .payment-submit-bar {
        align-items: center;
        border-top: 1px solid #d8e4f0;
        display: flex;
        justify-content: flex-end;
        margin-top: 28px;
        padding-top: 18px;
      }

      @media (max-width: 767px) {
        .payment-lines-toolbar,
        .payment-submit-bar {
          align-items: stretch;
          flex-direction: column;
        }

        .payment-lines-actions {
          flex-direction: column;
        }
      }
    </style>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
    
          <div class="card payment-entry-card">
            <!-- /.card-header -->
            <div class="card-body">
              <form class="payment-entry-form" action="<?php echo base_url(); ?>index.php/savenewpayment" method="post" enctype="multipart/form-data">
                
                <?php
                
                foreach($payment as $row) {
                
                ?>
                
                <center><h2>Transaction Information</h2></center>
                <input type="hidden" name="savetype" value="edit">
                <input type="hidden" name="newpayments_id" value="<?php echo $row->newpayments_id; ?>">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Payment Type</label>
                          <input type="hidden" name="formtype" value="new">
                          <select class="form-control" name="paymenttype">
                            <option value='Acknowledgement Receipt' <?php if($row->paymenttype == "Acknowledgement Receipt") echo "selected"; ?>>Acknowledgement Receipt</option>
                            <option value='Tax Invoice' <?php if($row->paymenttype == "Tax Invoice") echo "selected"; ?>>Tax Invoice</option>
                            <option value='Pass-due Invoice' <?php if($row->paymenttype == "Pass-due Invoice") echo "selected"; ?>>Pass-due Invoice</option>
                            <option value='Commission' <?php if($row->paymenttype == "Commission") echo "selected"; ?>>Commission</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Reference</label>
                          <input type="text" class="form-control" name="reference" value="<?php echo $row->reference; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Description</label>
                          <input type="text" class="form-control" name="description" value="<?php echo $row->description; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Date</label>
                          <input type="date" class="form-control" name="paymentdate" value="<?php echo $row->paymentdate; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Total Price</label>
                          <input type="number" class="form-control" name="totalprice" step="0.01" min="0" value="<?php echo $row->totalprice; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Tax Number</label>
                          <input type="text" class="form-control" name="taxnumber" value="<?php echo $row->taxnumber; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Total Price in words</label>
                          <input type="text" class="form-control" name="totalpriceinwords" value="<?php echo $row->totalpriceinwords; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Due Date</label>
                          <input type="date" class="form-control" name="duedate" value="<?php echo $row->duedate; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!--<div class="col-3">-->
                    <!--    <div class="mb-3">-->
                    <!--      <label for="amount" class="form-label">Discount</label>-->
                    <!--      <input type="number" class="form-control" name="discount" step="0.01" min="0" value="<?php echo $row->discount; ?>">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Discount %</label>
                          <input type="number" class="form-control" name="discountpercent" id="discountpercent" step="0.01" min="0"  max="100" value="<?php echo $row->discountpercent; ?>">
                        </div>
                    </div>
                    <!--<div class="col-3">-->
                    <!--    <div class="mb-3">-->
                    <!--      <label for="amount" class="form-label">Penalty</label>-->
                    <!--      <input type="number" class="form-control" name="penalty" value="<?php echo $row->penalty; ?>">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Penalty %</label>
                          <input type="number" class="form-control" name="penaltypercent" id="penaltypercent" step="0.01" min="0"  max="100" value="<?php echo $row->penaltypercent; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Letterhead template</label>
                          <!--<input type="hidden" name="letterheadfile" value="<?php echo $row->letterhead; ?>">-->
                          <!--<input type="file" class="form-control" name="letterhead">-->
                          <select name="letterhead" class="form-control">
                              <option value="">Select template</option>
                              <option value="PSCTemplate-A4.jpg" <?php if($row->letterhead == "PSCTemplate-A4.jpg") echo "selected"; ?>>PSCTemplate-A4.jpg</option>
                              <option value="SMICTemplateA4.jpg" <?php if($row->letterhead == "SMICTemplateA4.jpg") echo "selected"; ?>>SMICTemplateA4.jpg</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">GST/Tax %</label>
                          <input type="number" class="form-control" name="taxpercent" id="taxpercent" step="0.01" min="0"  max="100" value="<?php echo $row->taxpercent; ?>">
                        </div>
                    </div>
                    <!--<div class="col-6">-->
                    <!--    <div class="mb-3">-->
                    <!--      <label for="amount" class="form-label">Letter footer image</label> <label style="color: red">If you will not upload new file, just leave this field.</label>-->
                    <!--      <input type="hidden" name="footerfile" value="<?php echo $row->footer; ?>">-->
                    <!--      <input type="file" class="form-control" name="footer">-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                <div class="payment-lines-toolbar">
                    <h2>Line Items</h2>
                    <div class="payment-lines-actions">
                        <button class="btn btn-primary btn-sm" type="button" id="addrow"><i class="fas fa-plus" aria-hidden="true"></i> Add row</button>
                        <button class="btn btn-success btn-sm" type="button" id="compute-total" onclick="computeTotalAmount();"><i class="fas fa-calculator" aria-hidden="true"></i> Compute total</button>
                    </div>
                </div>
                <div class="payment-lines-table">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="width: 50%">Description</th>
                            <th style="width: 12%">Quantity</th>
                            <th style="width: 14%">Unit Price</th>
                            <th style="width: 17%">Amount</th>
                            <th style="width: 7%"></th>
                        </tr>
                    </thead>
                    <tbody id="pricetBody">
                        <?php
                            $total = 0;
                            foreach($paymentdetails as $row1) {
                        ?>
                                <tr class="detailsrows">
                                    <td><input type='text' class='form-control form-control-sm' name='detaildescription[]' value="<?php echo $row1->description; ?>"></td>
                                    <td><input type='number' class='form-control form-control-sm' name='detailquantity[]' value="<?php echo $row1->quantity; ?>"></td>
                                    <td><input type='number' class='form-control form-control-sm' name='detailunitprice[]' value="<?php echo $row1->unit_price; ?>"></td>
                                    <td><input type='text' class='form-control form-control-sm amounts' name='detailamount' readonly value="<?php
                                            $amount = ($row1->unit_price * $row1->quantity);
                                            $total += $amount;
                                            echo $amount;
                                        ?>"></td>
                                    <td><button type='button' class='btn btn-danger btn-xs remove-line' onclick='parentNode.parentNode.remove(); computeTotalAmount();'><i class='fas fa-trash' aria-hidden='true'></i></button></td>
                                    <td><input type='hidden' name='detailid[]' value="<?php echo $row1->id; ?>"></td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                </div>
                <div class="payment-summary">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-2 col-md-3">
                        <div class="mb-3">
                          <label for="amount" class="form-label">GST/Tax Amount</label>
                          <input type="text" class="form-control" name="gstamount" placeholder="Total Amount" id="gstamount" readonly value="<?php
                            $gstAmount = 0;
                            $gstRate = $row->taxpercent;
                            $gstAmount = ($total * $gstRate) / 100;
                            echo $gstAmount;
                          ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Discount Amount</label>
                          <input type="text" class="form-control" name="discountamount" placeholder="Discount Amount" id="discountamount" readonly value="<?php
                            $discountAmount = 0;
                            $discountRate = $row->discountpercent;
                            $discountAmount = ($total * $discountRate) / 100;
                            echo $discountAmount;
                          ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Penalty Amount</label>
                          <input type="text" class="form-control" name="penaltyamount" placeholder="Penalty Amount" id="penaltyamount" readonly value="<?php
                            $penaltyAmount = 0;
                            $penaltyRate = $row->penaltypercent;
                            $penaltyAmount = ($total * $penaltyRate) / 100;
                            echo $penaltyAmount;
                          ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 ml-auto">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Grand Amount</label>
                          <input type="text" class="form-control" name="totalamount" placeholder="Total Amount" id="totalamount" readonly value="<?php
                            $grandTotal = 0;
                            $grandTotal = ($total + $gstAmount + $penaltyAmount) - $discountAmount;
                            echo $grandTotal;
                          ?>">
                        </div> 
                    </div>
                </div>
                </div>
                
                <br><br>
                <center><h2>Company Information</h2></center>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Company Logo</label> <label style="color: red">If you will not upload new file, just leave this field.</label>
                          <input type="hidden" name="companylogofile" value="<?php echo $row->companylogo; ?>">
                          <input type="file" class="form-control" name="companylogo">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Company Name</label>
                          <input type="text" class="form-control" name="companyname" value="<?php echo $row->companyname; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Business/Institution Registration Number</label>
                          <input type="text" class="form-control" name="businessregistrationnumber" value="<?php echo $row->businessregistrationnumber; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Company Address</label>
                          <input type="text" class="form-control" name="companyaddress" value="<?php echo $row->companyaddress; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Invoice/Acknowledgement/Commission Number</label>
                          <input type="text" class="form-control" name="invoicenumber" value="<?php echo $row->invoicenumber; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Contact Details</label>
                          <input type="text" class="form-control" name="contactdetails" value="<?php echo $row->invoicenumber; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Schedule</label>
                            <select class="form-control" name="schedule">
                                <option value="Term" <?php if($row->schedule == "Term") echo "selected"; ?>>Term</option>
                                <option value="Semester" <?php if($row->schedule == "Semester") echo "selected"; ?>>Semester</option>
                                <option value="Annual" <?php if($row->schedule == "Annual") echo "selected"; ?>>Annual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Bank Name</label>
                          <input type="text" class="form-control" name="bankname" value="<?php echo $row->bankname; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Bank Account Number</label>
                          <input type="text" class="form-control" name="bankaccountnumber" value="<?php echo $row->bankaccountnumber; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Bank Identifier Code</label>
                          <input type="text" class="form-control" name="bankidentifiercode" value="<?php echo $row->bankidentifiercode; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Branch Number</label>
                          <input type="text" class="form-control" name="banknumber" value="<?php echo $row->branchnumber; ?>">
                        </div>
                    </div>
                </div>
                
                <br><br>
                <center><h2>Payer Information</h2></center>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="payee" class="form-label">Payer Name</label>
                            <input type="text" class="form-control" name="payeename" id="payeename" value="<?php echo $row->payorname ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Client</label>
                          <input type="hidden" name="formtype" value="new">
                          <select class="form-control select2" name="payee" id="payee" style="width: 100% !important;">
                                <?php
                                    foreach ($clients as $row3) {
                                        if($row3->client_id == $row->client_id) {
                                            echo "<option value='".$row3->client_id."' selected>".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";
                                            //   echo "<option value='".$row3->client_id."'>".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";
                                            // echo "<option value='".$row3->client_id."' selected>".$row3->client_id."</option>";
                                        } else {
                                            echo "<option value='".$row3->client_id."'>".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";
                                            //   echo "<option value='".$row3->client_id."'>".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";
                                            // echo "<option value='".$row3->client_id."'>".$row3->client_id."</option>";
                                        }   
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Address</label>
                          <input type="text" class="form-control" name="address" id="payeeaddress" value="<?php echo $row->address ?>">
                        </div>
                    </div>
                </div>
                
                
                <!--<input type="hidden" name="editfilelink" value="<?php echo $row->paymentattachment; ?>">-->
                <!--<input type="hidden" name="formtype" value="edit">-->
                <!--<input type="hidden" name="paymentid" value="<?php echo $row->paymentid; ?>">-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Payment Type</label>-->
                <!--  <input type="hidden" name="formtype" value="new">-->
                <!--  <select class="form-control" name="paymenttype">-->
                <!--    <option value='Acknowledgement Receipt' <?php if($row->paymenttype == 'Acknowledgement Receipt') { echo 'selected'; } ?>>Acknowledgement Receipt</option>-->
                <!--    <option value='Invoice' <?php if($row->paymenttype == 'Invoice') { echo 'selected'; } ?>>Invoice</option>-->
                <!--    <option value='Payment Receipt' <?php if($row->paymenttype == 'Payment Receipt') { echo 'selected'; } ?>>Payment Receipt</option>-->
                <!--    <option value='Commission' <?php if($row->paymenttype == 'Commission') { echo 'selected'; } ?>>Commission</option>-->
                <!--  </select>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Business Registration Number</label>-->
                <!--  <input type="text" class="form-control" name="businessregistrationnumber" value="<?php echo $row->payment_business_registration_number; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Schedule</label>-->
                <!--  <select class="form-control" name="paymentschedule">-->
                <!--      <option value="Term" <?php if($row->paymenttype == 'Term') { echo 'selected'; } ?>>Term</option>-->
                <!--      <option value="Semester" <?php if($row->paymenttype == 'Semester') { echo 'selected'; } ?>>Semester</option>-->
                <!--      <option value="Annual" <?php if($row->paymenttype == 'Annual') { echo 'selected'; } ?>>Annual</option>-->
                <!--  </select>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Invoice Number</label>-->
                <!--  <input type="text" class="form-control" name="invoicenumber" value="<?php echo $row->invoice_number; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="paymentdate" class="form-label">Date</label>-->
                <!--  <input type="date" class="form-control" name="paymentdate" style="width: 50%;" value="<?php echo $row->paymentdate; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="payee" class="form-label">Payer Name</label>-->
                <!--  <select class="form-control select2" name="payee" style="width: 100% !important;">-->
                    <?php
                // <!--    foreach ($clients as $row3) {-->
                // <!--      if($row3->payee == $row->client_id){-->
                // <!--          $selectedstring = "selected";-->
                // <!--      } else {-->
                // <!--          $selectedstring = "";-->
                // <!--      }-->
                // <!--      echo "<option value='".$row3->client_id."' ".$selectedstring.">".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";-->
                // <!--    }-->
                    ?>
                <!--  </select>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Reference Number</label>-->
                <!--  <input type="text" class="form-control" name="referencenumber" value="<?php echo $row->referencenumber; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Description</label>-->
                <!--  <input type="text" class="form-control" name="paymentdescription" value="<?php echo $row->paymentdescription; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Quantity</label>-->
                <!--  <input type="number" class="form-control" name="quantity" value="<?php echo $row->quantity; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Unit Price</label>-->
                <!--  <input type="text" class="form-control" name="unitprice" value="<?php echo $row->unit_price; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">GST</label>-->
                <!--  <input type="text" class="form-control" name="gst" value="<?php echo $row->gst; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Amount</label>-->
                <!--  <input type="number" class="form-control" name="amount" value="<?php echo $row->amount; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Currency</label>-->
                <!--  <input type="text" class="form-control" name="currency" value="<?php echo $row->currency; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Total Price</label>-->
                <!--  <input type="text" class="form-control" name="totalprice" value="<?php echo $row->total_price; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Payment Attachment</label>-->
                <!--  <input type="file" class="form-control" name="paymentattachment">-->
                <!--</div>-->
                
                
                <?php
                
                }
                
                ?>
                
                <div class="payment-submit-bar">
                    <a href="<?php echo base_url(); ?>index.php/payments" class="btn btn-outline-secondary mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save" aria-hidden="true"></i> Submit</button>
                </div>
              </form>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $this->load->view('layout/footer');
?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo $asset_url; ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $asset_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $asset_url; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $asset_url; ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $asset_url; ?>dist/js/demo.js"></script>
<!-- page script -->

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
//   $(function () {
//     $("#example1").DataTable({
//       "responsive": true,
//       "autoWidth": false,
//     });
//     $('#example2').DataTable({
//       "paging": true,
//       "lengthChange": false,
//       "searching": false,
//       "ordering": true,
//       "info": true,
//       "autoWidth": false,
//       "responsive": true,
//     });
//   });

  $('.select2').select2();
</script>
<script>
    document.getElementById("addrow").onclick = function() {
        addPaymentRow();
    }

    function addPaymentRow() {
        var newTR = document.createElement("tr");
        newTR.setAttribute('class','detailsrows');
        var dynahtml = `
                <td><input type='text' class='form-control form-control-sm payment-line-input' name='detaildescription[]'></td>
                <td><input type='number' class='form-control form-control-sm payment-line-input' name='detailquantity[]' min='0' step='0.01'></td>
                <td><input type='number' class='form-control form-control-sm payment-line-input' name='detailunitprice[]' min='0' step='0.01'></td>
                <td><input type='text' class='form-control form-control-sm amounts' name='detailamount' readonly></td>
                <td><button type='button' class='btn btn-danger btn-xs remove-line' onclick='parentNode.parentNode.remove(); computeTotalAmount();'><i class='fas fa-trash' aria-hidden='true'></i></button></td>
                <td><input type='hidden' name='detailid[]' value=""></td>
        `;
        newTR.innerHTML = dynahtml;
        document.getElementById("pricetBody").appendChild(newTR);
    }
    
    function applyGST(element) {
        var fields = document.getElementsByClassName('gstfields');
        for(var i = 0; i < fields.length; i++) {
            fields[i].value = element.value;
        }
    }
    
    function applyGSTfromAdd() {
        var fields = document.getElementsByClassName('gstfields');
        if (fields.length > 1) {
            fields[fields.length-1].value = fields[0].value;
        }
    }
    
    function computeTotalAmount() {
        var detailsrows = document.getElementsByClassName('detailsrows');
        var total = 0;
        var amount1 = 0;
        for(var i = 0; i < detailsrows.length; i++) {
            if(detailsrows[i].children[1].children[0].value != '' && detailsrows[i].children[2].children[0].value != '') {
                const baseAmount = (parseFloat(detailsrows[i].children[1].children[0].value) * parseFloat(detailsrows[i].children[2].children[0].value));
                detailsrows[i].children[3].children[0].value = baseAmount.toFixed(2);
                
                // const gstAmount = (baseAmount * gstRate) / 100;
                // const discountAmount = (baseAmount * discountRate) / 100;
                // const penaltyAmount = (baseAmount * penaltyRate) / 100;
                // const totalAmount = baseAmount + gstAmount + penaltyAmount - discountAmount;

                // amount1 = (parseInt(detailsrows[i].children[1].children[0].value) * parseInt(detailsrows[i].children[2].children[0].value));
                
                
                // detailsrows[i].children[3].children[0].value = gstAmount;
                // detailsrows[i].children[4].children[0].value = discountAmount;
                // detailsrows[i].children[5].children[0].value = penaltyAmount;
            }
        }
        
        var amounts = document.getElementsByClassName('amounts');
        for(var j = 0; j < amounts.length; j++) {
            if(amounts[j].value != '') {
                var value = parseFloat(amounts[j].value);
                total += value;  // keep as number
            }
        }
        
        const gstRate = parseFloat(document.getElementById("taxpercent").value) || 0;
        const discountRate = parseFloat(document.getElementById("discountpercent").value) || 0;
        const penaltyRate = parseFloat(document.getElementById("penaltypercent").value) || 0;
        
        const gstAmount = (total * gstRate) / 100;
        const discountAmount = (total * discountRate) / 100;
        const penaltyAmount = (total * penaltyRate) / 100;
        
        const grandtotal = (total + penaltyAmount + gstAmount) - discountAmount;
                
        document.getElementById("totalamount").value = grandtotal.toFixed(2);
        document.getElementById("gstamount").value = gstAmount.toFixed(2);
        document.getElementById("discountamount").value = discountAmount.toFixed(2);
        document.getElementById("penaltyamount").value = penaltyAmount.toFixed(2);
    }

    document.getElementById("pricetBody").addEventListener("input", function(event) {
        if (event.target.name == "detailquantity[]" || event.target.name == "detailunitprice[]") {
            computeTotalAmount();
        }
    });

    ["taxpercent", "discountpercent", "penaltypercent"].forEach(function(id) {
        document.getElementById(id).addEventListener("input", computeTotalAmount);
    });

    if (document.getElementsByClassName("detailsrows").length == 0) {
        addPaymentRow();
    }
    
    getClient();
    
    document.getElementById("payee").onchange = function() {
        getClient();
    }
    
    function getClient() {
        var id = document.getElementById("payee").value;
        var baseurl = document.getElementById("baseurl").value;
        $.ajax({
              type: "GET",
              url: baseurl + "index.php/new_payment_getclientdetails/" + id,
              success: function(data) {
                  var obj = JSON.parse(data);
                  document.getElementById("payeename").value = obj[0].client_surname+", "+obj[0].client_firstname+" "+obj[0].client_middlename;
                  document.getElementById("payeeaddress").value = obj[0].client_address;
              },
              error: function(error) {
                alert("Error!");
              }
        });
    }
</script>
</body>
</html>
