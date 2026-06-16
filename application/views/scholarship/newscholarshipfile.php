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
              <form action="savescholarshipfile" method="post">
                <div class="mb-3">
                  <label for="program" class="form-label">Payment Type</label>
                  <select class="form-control select2" name="paymenttype" required>
                    <?php
                    foreach ($mastersetting as $row) {
                      echo "<option value='".$row->id."'>".$row->identity."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">School</label>
                  <select class="form-control select2" name="school" required>
                    <?php
                    foreach ($education_provider as $row) {
                      echo "<option value='".$row->provider_id."'>".$row->provider_name."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Program</label>
                  <select class="form-control select2" name="program" required>
                    <?php
                    foreach ($schoolprograms as $row) {
                      echo "<option value='".$row->spid."'>".$row->program."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Description</label>
                  <textarea class="form-control" name="description" placeholder="Description" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Scholarship Type</label>
                  <textarea class="form-control" name="scholarshiptype" placeholder="Scholarship Type" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Amount/Percentage</label>
                  <input type="number" class="form-control" name="amount" placeholder="Amount/Percentage" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Valid From</label>
                  <input type="date" class="form-control" name="valid_from" style="width: 50%;">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Valid To</label>
                  <input type="date" class="form-control" name="valid_to" style="width: 50%;">
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
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
<script>
    $('.select2').select2();
</script>
</body>
</html>
