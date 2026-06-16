<?php
    $this->load->view('layout/header');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h4 class="m-0 text-dark">Student Application Report</h4>
        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Student Application Status</div>
              <div class="card-body">
                <form action="student_application_report" method="post">
                  <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required="">
                      <option value="" selected="">Status</option>
                      <option value="Discontinue">Discontinue</option>
                      <option value="WIP">WIP</option>
                      <option value="Completed">Completed</option>
                      <option value="Visa Refused">Visa Refused</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Outstanding Commision</div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Invoices To-Do</div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Commission Received</div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Course Completed</div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Course Started</div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <h4 class="m-0 text-dark">Visa Application Report</h4>
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Visa Application Status</div>
              <div class="card-body">
                <form action="visa_application_report" method="post">
                  <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required="">
                        <option value="">Please Select Status</option>
                        <option value="Discontinue">Discontinue</option>
                        <option value="WIP">WIP</option>
                        <option value="Completed">Completed</option>
                        <option value="Visa Refused">Visa Refused</option>
                        <option value="Submitted">Submitted</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Visa EOI</div>
              <div class="card-body">
                <form action="visa_eoi" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <select name="status" id="status" class="form-control" required="">
                        <option value="">Please Select Flag</option>
                        <option value="All">All</option>
                        <option value="Expired">Expired</option>
                        <option value="Discontinued">Discontinued</option>
                        <option value="Invited">Invited</option>
                        <option value="Created">Created</option>
                        <option value="Submitted">Submitted</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
              <div class="card-header">Visa Accounts</div>
              <div class="card-body">
                <form action="visa_account" method="post">
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="clientvisaid" class="form-label">Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Generate Report</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
            <!-- /.card -->
    </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
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
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $asset_url; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo $asset_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo $asset_url; ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $asset_url; ?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo $asset_url; ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $asset_url; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $asset_url; ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $asset_url; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo $asset_url; ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $asset_url; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $asset_url; ?>dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $asset_url; ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $asset_url; ?>dist/js/demo.js"></script>

<script type="text/javascript">
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
