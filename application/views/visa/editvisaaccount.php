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
    
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <?php
                      foreach ($visa_accounts as $row) {
                ?>
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <form action="<?php echo base_url().'index.php/updatevisaaccount'; ?>" method="post">
                  <div class="mb-3">
                    <input type="hidden" name="visaaccountid" value="<?php echo $row->visa_account_id; ?>">
                    <input type="hidden" name="clientid" value="<?php echo $client_id; ?>">
                    <label for="clientvisaid" class="form-label">Client Visa ID</label>
                    <!--<input type="text" name="clientvisaid" class="form-control" value="<?php echo $row->client_visa_id; ?>" readonly>-->
                    <select name="clientvisaid" class="form-control">
                        <?php
                        
                        foreach($visa_application as $rows2) {
                            if($row->client_visa_id == $rows2->client_visa_id) {
                                echo "<option value='".$rows2->client_visa_id."' selected>Visa Subclass: ".$rows2->new_Visa_subclass." Visa Expiry: ".$rows2->visa_expiry_day."/".$rows2->visa_expiry_month."/".$rows2->visa_expiry_year."</option>";
                            } else {
                                echo "<option value='".$rows2->client_visa_id."'>Visa Subclass: ".$rows2->new_Visa_subclass." Visa Expiry: ".$rows2->visa_expiry_day."/".$rows2->visa_expiry_month."/".$rows2->visa_expiry_year."</option>";
                            }
                            
                        }
                        
                        ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" value="<?php echo $row->description; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="receiveddate" class="form-label">Received Date</label>
                    <input style="width: 50%;" type="date" class="form-control" name="receiveddate" value="<?php echo $row->received_date; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="receivedamountexgst" class="form-label">Received Amount Except GST</label>
                    <input type="text" name="receivedamountexgst" class="form-control" value="<?php echo $row->received_amount_ex_gst; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="receivedgst" class="form-label">Received GST</label>
                    <input type="text" name="receivedgst" class="form-control" value="<?php echo $row->received_gst; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="disburseddate" class="form-label">Disbursed Date</label>
                    <input style="width: 50%;" type="date" class="form-control" name="disburseddate" value="<?php echo $row->disbursed_date; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="disbursedamountexgst" class="form-label">Disbursed Amount Except GST</label>
                    <input type="text" name="disbursedamountexgst" class="form-control" value="<?php echo $row->disbursed_amount_ex_gst; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="dispursedgst" class="form-label">Disbursed GST</label>
                    <input type="text" name="dispursedgst" class="form-control" value="<?php echo $row->disbursed_gst; ?>">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php
                      }
                    ?>
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
<!-- bs-custom-file-input -->
<script src="<?php echo $asset_url; ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $asset_url; ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $asset_url; ?>dist/js/demo.js"></script>
<!-- DataTables -->
<script src="<?php echo $asset_url; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
  $(function () {

    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#studentapplicationtable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#visaapplicationtable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#visaeoitable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#visaaccounttable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#scholarshipallocationtable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#paymentstable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

  });

  $('.select2').select2();

</script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});

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
</script>
</body>
</html>