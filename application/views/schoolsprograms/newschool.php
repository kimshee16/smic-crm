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
              <form action="saveschool" method="post">
                <div class="mb-3">
                  <label for="amount" class="form-label">School Name</label>
                  <textarea class="form-control" name="schoolname" placeholder="School Name" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Marketing Contact Name</label>
                  <input type="text" class="form-control" name="marketingname" placeholder="Marketing Contact Name" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Marketing Contact Phone Number</label>
                  <input type="text" class="form-control" name="marketingphone" placeholder="Marketing Contact Phone Number" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Marketing Contact Mobile Number</label>
                  <input type="text" class="form-control" name="marketingmobile" placeholder="Marketing Contact Mobile Number" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Admin Contact Name</label>
                  <input type="text" class="form-control" name="adminname" placeholder="Admin Contact Name" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Admin Contact Phone Number</label>
                  <input type="text" class="form-control" name="adminphone" placeholder="Admin Contact Phone Number" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance Contact Name</label>
                  <input type="text" class="form-control" name="financename" placeholder="Finance Contact Name" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance Contact Phone Number</label>
                  <input type="text" class="form-control" name="financephone" placeholder="Finance Contact Phone Number" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Fax No.</label>
                  <input type="text" class="form-control" name="faxno" placeholder="Fax No." required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Mailing Address</label>
                  <input type="text" class="form-control" name="mailingaddress" placeholder="Mailing Address" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Suburb</label>
                  <input type="text" class="form-control" name="suburb" placeholder="Suburb" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">State</label>
                  <input type="text" class="form-control" name="state" placeholder="State" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Postcode</label>
                  <input type="text" class="form-control" name="postcode" placeholder="Postcode" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance Mailing Address 1</label>
                  <input type="text" class="form-control" name="financemailing1" placeholder="Finance Mailing Address 1" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance Mailing Address 2</label>
                  <input type="text" class="form-control" name="financemailing2" placeholder="Finance Mailing Address 2" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance Suburb</label>
                  <input type="text" class="form-control" name="financesuburb" placeholder="Finance Suburb" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance State</label>
                  <input type="text" class="form-control" name="financestate" placeholder="Finance State" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Finance Postcode</label>
                  <input type="text" class="form-control" name="financepostcode" placeholder="Finance Postcode" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Notes</label>
                  <textarea class="form-control" name="notes" placeholder="Notes" required></textarea>
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

</body>
</html>
