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
                    foreach ($scholarships as $row) {
              ?>
              <form action="<?php echo base_url(); ?>index.php/updatescholarshipfile" method="post">
                <input type="hidden" name="scholarshipid" value="<?php echo $row->scholarshipid; ?>">
                <div class="mb-3">
                  <label for="program" class="form-label">Payment Type</label>
                  <select class="form-control select2" name="paymenttype" required>
                    <?php
                    foreach ($mastersetting as $row2) {
                      if ($row2->id == $row->paymenttype) {
                            echo "<option value='".$row2->id."' selected>".$row2->identity."</option>";
                      } else {
                            echo "<option value='".$row2->id."'>".$row2->identity."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">School</label>
                  <select class="form-control select2" name="school" required>
                    <?php
                    foreach ($education_provider as $row3) {
                      if ($row3->provider_id == $row->school) {
                            echo "<option value='".$row3->provider_id."' selected>".$row3->provider_name."</option>";
                      } else {
                            echo "<option value='".$row3->provider_id."'>".$row3->provider_name."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Program</label>
                  <select class="form-control select2" name="program" required>
                    <?php
                    foreach ($schoolprograms as $row4) {
                      if ($row4->spid == $row->programid) {
                            echo "<option value='".$row4->spid."' selected>".$row4->program."</option>";
                      } else {
                            echo "<option value='".$row4->spid."'>".$row4->program."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Description</label>
                  <textarea class="form-control" name="description" placeholder="Description" required><?php echo $row->description; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Scholarship Type</label>
                  <textarea class="form-control" name="scholarshiptype" placeholder="Scholarship Type" required><?php echo $row->type; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Amount/Percentage</label>
                  <input type="number" class="form-control" name="amount" placeholder="Amount/Percentage" value="<?php echo $row->amount; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Valid From</label>
                  <input type="date" class="form-control" name="valid_from" value="<?php echo $row->valid_from; ?>" style="width: 50%;">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Valid To</label>
                  <input type="date" class="form-control" name="valid_to" value="<?php echo $row->valid_to; ?>" style="width: 50%;">
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
