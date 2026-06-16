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
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
    
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              
              <form action="<?php echo base_url(); ?>index.php/savenewpayment" method="post" enctype="multipart/form-data">
                <center><h2>TRANSACTION INFORMATION</h2></center>
                <input type="hidden" name="savetype" value="new">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Payment Type</label>
                          <input type="hidden" name="formtype" value="new">
                          <select class="form-control" name="paymenttype">
                            <option value='Acknowledgement Receipt'>Acknowledgement Receipt</option>
                            <option value='Tax Invoice'>Tax Invoice</option>
                            <option value='Pass-due Invoice'>Pass-due Invoice</option>
                            <option value='Commission'>Commission</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Reference</label>
                          <input type="text" class="form-control" name="reference">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Description</label>
                          <input type="text" class="form-control" name="description">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Date</label>
                          <input type="date" class="form-control" name="paymentdate">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Total Price</label>
                          <input type="number" class="form-control" name="totalprice" step="0.01" min="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Tax Number</label>
                          <input type="text" class="form-control" name="taxnumber">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Total Price in words</label>
                          <input type="text" class="form-control" name="totalpriceinwords">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Due Date</label>
                          <input type="date" class="form-control" name="duedate">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!--<div class="col-3">-->
                    <!--    <div class="mb-3">-->
                    <!--      <label for="amount" class="form-label">Discount</label>-->
                    <!--      <input type="number" class="form-control" name="discount" step="0.01" min="0">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Discount %</label>
                          <input type="number" class="form-control" name="discountpercent" id="discountpercent" step="0.01" min="0"  max="100" value="0">
                        </div>
                    </div>
                    <!--<div class="col-3">-->
                    <!--    <div class="mb-3">-->
                    <!--      <label for="amount" class="form-label">Penalty</label>-->
                    <!--      <input type="number" class="form-control" name="penalty">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Penalty %</label>
                          <input type="number" class="form-control" name="penaltypercent" id="penaltypercent" step="0.01" min="0"  max="100" value="0">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Letterhead template</label>
                          <select name="letterhead" class="form-control">
                              <option value="">Select template</option>
                              <option value="PSCTemplate-A4.jpg">PSCTemplate-A4.jpg</option>
                              <option value="SMICTemplateA4.jpg">SMICTemplateA4.jpg</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">GST/Tax %</label>
                          <input type="number" class="form-control" name="taxpercent" id="taxpercent" step="0.01" min="0"  max="100" value="0">
                        </div>
                    </div>
                    <!--<div class="col-6">-->
                    <!--    <div class="mb-3">-->
                    <!--      <label for="amount" class="form-label">Letter footer image</label>-->
                    <!--      <input type="file" class="form-control" name="footer">-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                
                <br><br>
                <button class="btn btn-primary btn-xs" type="button" id="addrow">Add row</button> <button class="btn btn-success btn-xs" type="button" id="addrow" onclick="computeTotalAmount();">Compute total</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50%">Description</th>
                            <th style="width: 10%">Quantity</th>
                            <th style="width: 10%">Unit Price</th>
                            <th style="width: 20%">Amount</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody id="pricetBody"></tbody>
                </table>
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-1">
                        <div class="mb-3">
                          <label for="amount" class="form-label">GST/Tax Amount</label>
                          <input type="text" class="form-control" name="gstamount" placeholder="Total Amount" id="gstamount" readonly>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Discount Amount</label>
                          <input type="text" class="form-control" name="discountamount" placeholder="Discount Amount" id="discountamount" readonly>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Penalty Amount</label>
                          <input type="text" class="form-control" name="penaltyamount" placeholder="Penalty Amount" id="penaltyamount" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Grand Amount</label>
                          <input type="text" class="form-control" name="totalamount" placeholder="Total Amount" id="totalamount" readonly>
                        </div> 
                    </div>
                </div>
                
                <br><br>
                <center><h2>COMPANY INFORMATION</h2></center>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Company Logo</label>
                          <input type="file" class="form-control" name="companylogo">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Company Name</label>
                          <input type="text" class="form-control" name="companyname">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Business/Institution Registration Number</label>
                          <input type="text" class="form-control" name="businessregistrationnumber">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Company Address</label>
                          <input type="text" class="form-control" name="companyaddress">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Invoice/Acknowledgement/Commission Number</label>
                          <input type="text" class="form-control" name="invoicenumber">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Contact Details</label>
                          <input type="text" class="form-control" name="contactdetails">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Schedule</label>
                            <select class="form-control" name="schedule">
                                <option value="Term">Term</option>
                                <option value="Semester">Semester</option>
                                <option value="Annual">Annual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Bank Name</label>
                          <input type="text" class="form-control" name="bankname">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Bank Account Number</label>
                          <input type="text" class="form-control" name="backaccountnumber">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Bank Identifier Code</label>
                          <input type="text" class="form-control" name="bankidentifiercode">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Branch Number</label>
                          <input type="text" class="form-control" name="banknumber">
                        </div>
                    </div>
                </div>
                
                <br><br>
                <center><h2>PAYOR INFORMATION</h2></center>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="payee" class="form-label">Payer Name</label>
                            <input type="text" class="form-control" name="payeename" id="payeename">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="amount" class="form-label">Client ID</label>
                          <input type="hidden" name="formtype" value="new">
                          <select class="form-control select2" name="payee" id="payee" style="width: 100% !important;">
                                <?php
                                    foreach ($clients as $row3) {
                                      echo "<option value='".$row3->client_id."'>".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";
                                    // echo "<option value='".$row3->client_id."'>".$row3->client_id."</option>";
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
                          <input type="text" class="form-control" name="address" id="payeeaddress">
                        </div>
                    </div>
                </div>
                  
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Payment Type</label>-->
                <!--  <input type="hidden" name="formtype" value="new">-->
                <!--  <select class="form-control" name="paymenttype">-->
                <!--    <option value='Acknowledgement Receipt'>Acknowledgement Receipt</option>-->
                <!--    <option value='Invoice'>Invoice</option>-->
                <!--    <option value='Payment Receipt'>Payment Receipt</option>-->
                <!--    <option value='Commissiont'>Commission</option>-->
                <!--  </select>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Business Registration Number</label>-->
                <!--  <input type="text" class="form-control" name="businessregistrationnumber">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Schedule</label>-->
                <!--  <select class="form-control" name="paymentschedule">-->
                <!--      <option value="Term">Term</option>-->
                <!--      <option value="Semester">Semester</option>-->
                <!--      <option value="Annual">Annual</option>-->
                <!--  </select>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Invoice Number</label>-->
                <!--  <input type="text" class="form-control" name="invoicenumber" value="<?php echo $next_invoice_number; ?>">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="paymentdate" class="form-label">Date</label>-->
                <!--  <input type="date" class="form-control" name="paymentdate" style="width: 50%;">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="payee" class="form-label">Payer Name</label>-->
                <!--  <select class="form-control select2" name="payee" style="width: 100% !important;">-->
                <!--    <?php
                // <!--    foreach ($clients as $row3) {-->
                // <!--      echo "<option value='".$row3->client_id."'>".$row3->client_surname.", ".$row3->client_firstname." ".$row3->client_middlename."</option>";-->
                // <!--    }-->
                    ?>-->
                <!--  </select>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Student ID</label>-->
                <!--  <input type="text" class="form-control" name="studentid">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Reference Number</label>-->
                <!--  <input type="text" class="form-control" name="referencenumber">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Description</label>-->
                <!--  <input type="text" class="form-control" name="paymentdescription">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Quantity</label>-->
                <!--  <input type="number" class="form-control" name="quantity">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Unit Price</label>-->
                <!--  <input type="text" class="form-control" name="unitprice">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">GST</label>-->
                <!--  <input type="text" class="form-control" name="gst">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Amount</label>-->
                <!--  <input type="number" class="form-control" name="amount">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Currency</label>-->
                <!--  <input type="text" class="form-control" name="currency">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Total Price</label>-->
                <!--  <input type="text" class="form-control" name="totalprice">-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Payment Attachment</label>-->
                <!--  <input type="file" class="form-control" name="paymentattachment">-->
                <!--</div>-->
                
                <br><br>
                <button type="submit" class="btn btn-primary">Submit</button>
                
                
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
        var newTR = document.createElement("tr");
        newTR.setAttribute('class','detailsrows');
        var dynahtml = `
                <td><input type='text' name='detaildescription[]'></td>
                <td><input type='number' name='detailquantity[]'></td>
                <td><input type='number' name='detailunitprice[]' ></td>
                <td><input type='text' name='detailamount' class='amounts' readonly></td>
                <td><button class='btn btn-danger btn-xs' onclick='parentNode.parentNode.remove();'>Remove</button></td>
        `;
        newTR.innerHTML = dynahtml;
        document.getElementById("pricetBody").appendChild(newTR);
        // applyGSTfromAdd();
    }
    
    // function applyGST(element) {
    //     var fields = document.getElementsByClassName('gstfields');
    //     for(var i = 0; i < fields.length; i++) {
    //         fields[i].value = element.value;
    //     }
    // }
    
    function applyGSTfromAdd() {
        var fields = document.getElementsByClassName('gstfields');
        fields[fields.length-1].value = fields[0].value;
    }
    
    function computeTotalAmount() {
        var detailsrows = document.getElementsByClassName('detailsrows');
        var total = 0;
        var amount1 = 0;
        for(var i = 0; i < detailsrows.length; i++) {
            if(detailsrows[i].children[1].children[0].value != '' && detailsrows[i].children[2].children[0].value != '') {
                const baseAmount = (parseFloat(detailsrows[i].children[1].children[0].value) * parseFloat(detailsrows[i].children[2].children[0].value));
                detailsrows[i].children[3].children[0].value = baseAmount;
                
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
        
        const gstRate = parseFloat(document.getElementById("taxpercent").value);
        const discountRate = parseFloat(document.getElementById("discountpercent").value);
        const penaltyRate = parseFloat(document.getElementById("penaltypercent").value);
        
        const gstAmount = (total * gstRate) / 100;
        const discountAmount = (total * discountRate) / 100;
        const penaltyAmount = (total * penaltyRate) / 100;
        
        const grandtotal = (total + penaltyAmount + gstAmount) - discountAmount;
                
        document.getElementById("totalamount").value = grandtotal.toFixed(2);
        document.getElementById("gstamount").value = gstAmount.toFixed(2);
        document.getElementById("discountamount").value = discountAmount.toFixed(2);
        document.getElementById("penaltyamount").value = penaltyAmount.toFixed(2);
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
