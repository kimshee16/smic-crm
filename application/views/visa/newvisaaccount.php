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
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <form action="<?php echo base_url().'index.php/savevisaaccount'; ?>" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Client Visa ID</label>
                    <!--<input type="text" name="clientvisaid" class="form-control" value="<?php echo $client_visa_id; ?>" readonly>-->
                    <select name="clientvisaid" class="form-control">
                        <?php
                        
                        foreach($visa_application as $rows) {
                            echo "<option value=".$rows->client_visa_id.">Visa Subclass: ".$rows->new_Visa_subclass." Visa Expiry: ".$rows->visa_expiry_day."/".$rows->visa_expiry_month."/".$rows->visa_expiry_year."</option>";
                        }
                        
                        ?>
                    </select>
                    <input type="hidden" name="clientid" value="<?php echo $client_id; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="receiveddate" class="form-label">Received Date</label>
                    <input type="date" class="form-control" name="receiveddate" style="width: 50%;">
                  </div>
                  <div class="mb-3">
                    <label for="receivedamountexgst" class="form-label">Received Amount Except GST</label>
                    <input type="text" name="receivedamountexgst" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="receivedgst" class="form-label">Received GST</label>
                    <input type="text" name="receivedgst" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="disburseddate" class="form-label">Disbursed Date</label>
                    <input type="date" class="form-control" name="disburseddate" style="width: 50%;">
                  </div>
                  <div class="mb-3">
                    <label for="disbursedamountexgst" class="form-label">Disbursed Amount Except GST</label>
                    <input type="text" name="disbursedamountexgst" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="dispursedgst" class="form-label">Disbursed GST</label>
                    <input type="text" name="dispursedgst" class="form-control">
                  </div>
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