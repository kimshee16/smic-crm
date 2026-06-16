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
              <?php
                foreach ($offices as $officerow) {
              ?>
              <form action="<?php echo base_url(); ?>index.php/updateoffice" method="post" enctype="multipart/form-data">
                <input type="hidden" name="offices_id" value="<?php echo $officerow->offices_id; ?>">
                <?php 
                    if(isset($error)) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $error; ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
                    }
                ?>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Code</label>
                  <input type="text" class="form-control" name="offices_code" placeholder="Office Code" value="<?php echo $officerow->offices_code; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Address 1</label>
                  <input type="text" class="form-control" name="offices_address1" placeholder="Office Address 1" value="<?php echo $officerow->offices_address1; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Address 2</label>
                  <input type="text" class="form-control" name="offices_address2" placeholder="Office Address 1" value="<?php echo $officerow->offices_address2; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Phone #</label>
                  <input type="text" class="form-control" name="offices_phoneno" placeholder="Office Address 1" value="<?php echo $officerow->offices_phoneno; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Fox #</label>
                  <input type="text" class="form-control" name="offices_faxno" placeholder="Office Address 1" value="<?php echo $officerow->offices_faxno; ?>" required>
                </div>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Email</label>
                  <input type="text" class="form-control" name="offices_email" placeholder="Office Code" value="<?php echo $officerow->offices_email; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Flag</label>
                  <!--<input type="text" class="form-control" name="offices_flag" placeholder="Office Address 1" required>-->
                  <select class="form-control" name="offices_flag" required>
                      <option value="">Select Office</option>
                      <option value="office" <?php if($officerow->offices_flag == "office"){echo "selected";} ?>>office</option>
                      <option value="subagent" <?php if($officerow->offices_flag == "subagent"){echo "selected";} ?>>subagent</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Manager</label>
                  <!--<input type="text" class="form-control" name="offices_address2" placeholder="Office Address 1" required>-->
                  <select class="form-control select2" name="offices_manager" required>
                      <option value="">Select Officer</option>
                      <?php
                        foreach ($officer as $row) {
                          if($row->officer_id == $officerow->offices_manager) {
                              echo "<option value='".$row->officer_id."' selected>".$row->officer_name."</option>";
                          } else {
                              echo "<option value='".$row->officer_id."'>".$row->officer_name."</option>";
                          }
                        }
                      ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Region</label>
                  <!--<input type="text" class="form-control" name="offices_phoneno" placeholder="Office Address 1" required>-->
                  <select class="form-control select2" name="offices_region" required>
                      <option value="">Select Region</option>
                      <?php
                        foreach ($region as $row) {
                          if($row->region_id == $officerow->offices_region) {
                              echo "<option value='".$row->region_id."' selected>".$row->region_name."</option>";
                          } else {
                              echo "<option value='".$row->region_id."'>".$row->region_name."</option>";
                          }
                        }
                      ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Office Notes</label>
                  <input type="text" class="form-control" name="offices_notes" placeholder="Office Notes" value="<?php echo $officerow->offices_notes; ?>" required>
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

  $('.select2').select2();

  document.getElementById("role").onchange = function() {
    var roletext = $("#role option:selected").text();
    $("#roletext").val(roletext);
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
</script>

</body>
</html>
