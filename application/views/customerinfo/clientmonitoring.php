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
              <li class="breadcrumb-item"><a href="https://crm.smic.education/index.php/dashboard">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <?php
          if(isset($_GET['success1'])) {
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            Successfully assigned the process officer.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php
          }
          ?>
          <div class="card" style="overflow-x: scroll;">
            <!-- /.card-header -->
            <div class="card-body">
              <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <table id="example1" class="table table-bordered table-striped" style="text-align: center; align-items: center;">
                <thead>
                    <tr>
                      <th rowspan="2" style="width: 200px;">CLIENT NAME</th>
                      <th colspan="5" style="background-color: #c6e0b4;">PROGRAM OPTIONS</th>
                      <th colspan="6" style="background-color: #e2efda;">ADMISSION</th>
                      <th colspan="8" style="background-color: #a9d08e;">NOTICE OF PAYMENT</th>
                      <th colspan="8" style="background-color: #548235; color: white;">KPI</th>
                    </tr>
                    <tr>
                      <th style="width: 10px;background-color: #c6e0b4;">Date Created</th>
                      <th style="width: 250px; background-color: #c6e0b4;">Remarks</th>
                      <th style="width: 250px; background-color: #c6e0b4;">Client Acceptance Status</th>
                      <th style="width: 10px;background-color: #c6e0b4;">Status</th>
                      <th style="width: 10px;background-color: #c6e0b4;">Follow-up Date</th>
                      
                      <th style="width: 10px; background-color: #e2efda;">Location</th>
                      <th style="width: 10px; background-color: #e2efda;">Intake</th>
                      <th style="width: 50px; background-color: #e2efda;">Date of Admission</th>
                      <th style="width: 10px; background-color: #e2efda;">Status</th>
                      <th style="width: 10px; background-color: #e2efda;">VEVO Expiry</th>
                      <th style="width: 10px; background-color: #e2efda;">English</th>
                     
                      <th style="width: 10px; background-color: #a9d08e;">Tuition Fee</th>
                      <th style="width: 10px; background-color: #a9d08e;">Visa Application</th>
                      <th style="width: 10px; background-color: #a9d08e;">OSHC</th>
                      <th style="width: 10px; background-color: #a9d08e;">Admin Fee</th>
                      <th style="width: 10px; background-color: #a9d08e;">Refusal Fee</th>
                      <th style="width: 10px; background-color: #a9d08e;">Processing Fee</th>
                      <th style="width: 10px; background-color: #a9d08e;">Date Payment</th>
                      <th style="width: 10px; background-color: #a9d08e;">Dependent</th>
                      
                      <th style="width: 10px; background-color: #548235; color: white;">Intake</th>
                      <th style="width: 10px; background-color: #548235; color: white;">Status</th>
                      <th style="width: 10px; background-color: #548235; color: white;">Date of Submission</th>
                      <th style="width: 10px; background-color: #548235; color: white;">Result Release</th>
                      <th style="width: 10px; background-color: #548235; color: white;">Visa Expiration</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                foreach ($clients as $row) {
                  
                  $dynamicDate_sacreateddate = $row->sacreateddate;
                  $timestamp_sacreateddate = strtotime($dynamicDate_sacreateddate);
                  
                  if($row->visa_expiry_year != "") {
                      $dynamicDate_vaexpirydate = $row->visa_expiry_year . "-" . $row->visa_expiry_month . "-" . $row->visa_expiry_day;
                      $timestamp_vaexpirydate = strtotime($dynamicDate_vaexpirydate);
                      $finalvaexpirydate = date('d/m/Y', $timestamp_vaexpirydate);
                  } else {
                      $finalvaexpirydate = "";
                  }
                  
                  if($row->visadateofsubmission != "") {
                      $dynamicDate_visadateofsubmission = $row->visadateofsubmission;
                      $timestamp_visadateofsubmission = strtotime($dynamicDate_visadateofsubmission);
                      $finalvisadateofsubmission = date('d/m/Y', $timestamp_visadateofsubmission);
                  } else {
                      $finalvisadateofsubmission = "";
                  }
                  
                  if($row->visaresultreleasedate != "") {
                      $dynamicDate_visaresultreleasedate = $row->visaresultreleasedate;
                      $timestamp_visaresultreleasedate = strtotime($dynamicDate_visaresultreleasedate);
                      $finalvisaresultreleasedate = date('d/m/Y', $timestamp_visaresultreleasedate);
                  } else {
                      $finalvisaresultreleasedate = "";
                  }
                  
                  if($row->visa_intake != "") {
                      $dynamicDate_visa_intake = $row->visa_intake;
                      $timestamp_visa_intake = strtotime($dynamicDate_visa_intake);
                      $finalvisa_intake = date('d/m/Y', $timestamp_visa_intake);
                  } else {
                      $finalvisa_intake = "";
                  }
                  if($row->sa_vevo_expiry_date == "") {
                            $vevodate = "";    
                        } else {
                            $dynamicDate_vevo_expiry_date = $row->sa_vevo_expiry_date;
                              $timestamp_vevo_expiry_date = strtotime($dynamicDate_vevo_expiry_date);
                              $finalvevo_expiry_date = date('d/m/Y', $timestamp_vevo_expiry_date);
                              
                            $vevodate = $finalvevo_expiry_date; 
                        }
                        
                  if($row->poprocessstatus == "Waiting") {
                      $pocolor = "#ffc107";
                      $pofontcolor = "white";
                  } elseif($row->poprocessstatus == "On-hold") {
                      $pocolor = "#ff4c00";
                      $pofontcolor = "white";
                  } elseif($row->poprocessstatus == "Withdrawn") {
                      $pocolor = "#dc3545";
                      $pofontcolor = "white";
                  } elseif($row->poprocessstatus == "For admissions") {
                      $pocolor = "#198754";
                      $pofontcolor = "white";
                  } else {
                      $pocolor = "";
                      $pofontcolor = "black";
                  }
                  
                  if($row->postatus == "Accepted") {
                      $po2color = "#0d6efd";
                      $po2fontcolor = "white";
                  } elseif($row->postatus == "Rejected") {
                      $po2color = "#dc3545";
                      $po2fontcolor = "white";
                  } else {
                      $po2color = "";
                      $po2fontcolor = "black";
                  }
                  
                  if($row->studentapp_flag == "Withdrawn") {
                      $sacolor = "#ffc107";
                      $safontcolor = "white";
                  } elseif($row->studentapp_flag == "Conditional Offer Letter") {
                      $sacolor = "#ff4c00";
                      $safontcolor = "white";
                  } elseif($row->studentapp_flag == "Full Offer Letter") {
                      $sacolor = "#198754";
                      $safontcolor = "white";
                  } elseif($row->studentapp_flag == "Refused") {
                      $sacolor = "#dc3545";
                      $safontcolor = "white";
                  } elseif($row->studentapp_flag == "Admitted") {
                      $sacolor = "#0d6efd";
                      $safontcolor = "white";
                  } else {
                      $sacolor = "";
                      $safontcolor = "black";
                  }
                  
                  if($row->vastatus == "Lodged") {
                      $vapcolor = "#0d6efd";
                      $vapfontcolor = "white";
                  } elseif($row->vastatus == "Granted") {
                      $vapcolor = "#198754";
                      $vapfontcolor = "white";
                  } elseif($row->vastatus == "Refused") {
                      $vapcolor = "#dc3545";
                      $vapfontcolor = "white";
                  } else {
                      $vapcolor = "";
                      $vapfontcolor = "black";
                  }
                  
                  echo "<tr>
                    <td>".$row->client_surname.", ".$row->client_firstname."</td>
                    
                    <td>".$row->poprepdate."</td>
                    <td>".$row->poremarks."</td>
                    <td style='background-color:".$po2color.";color:".$po2fontcolor.";'>".$row->postatus."</td>
                    <td style='background-color:".$pocolor.";color:".$pofontcolor.";'>".$row->poprocessstatus."</td>
                    <td>".$row->pofollowupdate."</td>
                    
                    <td>".$row->polocation."</td>
                    <td>".$row->pointake."</td>
                    <td>".$row->sacreateddate."</td>
                    <td style='background-color:".$sacolor.";color:".$safontcolor.";'>".$row->studentapp_flag."</td>
                    <td>".$vevodate."</td>
                    <td>".$row->poenglishrequirement."</td>
                    
                    <td>".$row->tuitionfeeamount."</td>
                    <td>".$row->visaapplicationfeeamount."</td>
                    <td>".$row->oschfeeamount."</td>
                    <td>".$row->adminfeeamount."</td>
                    <td>".$row->refusalfeeamount."</td>
                    <td>".$row->processingfeeamount."</td>
                    <td>".$row->dateofpayment."</td>
                    <td>".$row->numberofdependent."</td>
                    
                    <td>".$finalvisa_intake."</td>
                    <td style='background-color:".$vapcolor.";color:".$vapfontcolor.";'>".$row->vastatus."</td>
                    <td>".$finalvisadateofsubmission."</td>
                    <td>".$finalvisaresultreleasedate."</td>
                    <td>".$finalvaexpirydate."</td>
                  </tr>";
                }

                
                ?>
                </tbody>
              </table>
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

  <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="assign">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Please Select Processing Officer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="assignofficer" method="post">
          <div class="modal-body">
              <div class="form-group">
                <label for="documentype">Client ID</label>
                <input type="text" name="clientid" id="clientid" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="documentype">Processing Officer</label>
                <select class="form-control select2" name="officer" required>
                    <?php
                    foreach ($officer as $row) {
                      echo "<option value='".$row->officer_id."'>".$row->officer_name."</option>";
                    }
                    ?>
                </select>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>

  <!-- /.content-wrapper -->
  
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false,
      "autoWidth": true,
      "ordering": false
    });
  });

  function putClientId(event) {
    var string1 = event.target.className;
    alert(string1);
    const stringArray = string1.split("_");
    document.getElementById('clientid').value = stringArray[1];
  }

  function markasread() {
      var baseurl10 = document.getElementById("baseurl").value;
      $.ajax({
          type: "GET",
          url: baseurl10 + "index.php/markasread",
          success: function(data) {
              document.getElementById("notifnum").remove();
          },
          error: function(error) {
            console.log(error);
          }
      });
  }


  var elems = document.getElementsByClassName('confirmation');
  var confirmIt = function (e) {
      if (!confirm('Are you sure to delete the entry?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
  }
  
</script>
</body>
</html>