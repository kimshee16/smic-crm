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
                      foreach ($education_provider as $row) {
                ?>
                  <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <form action="<?php echo base_url().'index.php/updateschool'; ?>" method="post">
                  <input type="hidden" name="provider_id" value="<?php echo $row->provider_id; ?>">
                  <div class="mb-3">
                    <label for="amount" class="form-label">School Name</label>
                    <textarea class="form-control" name="schoolname" placeholder="School Name" required><?php echo $row->provider_name; ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Marketing Contact Name</label>
                    <input type="text" class="form-control" name="marketingname" placeholder="Marketing Contact Name" value="<?php echo $row->provider_marketing_contact_name; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Marketing Contact Phone Number</label>
                    <input type="text" class="form-control" name="marketingphone" placeholder="Marketing Contact Phone Number" value="<?php echo $row->provider_marketing_contact_phoneno; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Marketing Contact Mobile Number</label>
                    <input type="text" class="form-control" name="marketingmobile" placeholder="Marketing Contact Mobile Number" value="<?php echo $row->provider_marketing_mobileno; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Admin Contact Name</label>
                    <input type="text" class="form-control" name="adminname" placeholder="Admin Contact Name" value="<?php echo $row->provider_admin_contact_name; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Admin Contact Phone Number</label>
                    <input type="text" class="form-control" name="adminphone" placeholder="Admin Contact Phone Number" value="<?php echo $row->provider_admin_contact_phoneno; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance Contact Name</label>
                    <input type="text" class="form-control" name="financename" placeholder="Finance Contact Name" value="<?php echo $row->provider_finance_contact_name; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance Contact Phone Number</label>
                    <input type="text" class="form-control" name="financephone" placeholder="Finance Contact Phone Number" value="<?php echo $row->provider_finance_contact_phoneno; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Fax No.</label>
                    <input type="text" class="form-control" name="faxno" placeholder="Fax No." value="<?php echo $row->provider_faxno; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Mailing Address</label>
                    <input type="text" class="form-control" name="mailingaddress" placeholder="Mailing Address" value="<?php echo $row->provider_mailing_address; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Suburb</label>
                    <input type="text" class="form-control" name="suburb" placeholder="Suburb" value="<?php echo $row->provider_suburb; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">State</label>
                    <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $row->provider_state; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Postcode</label>
                    <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="<?php echo $row->provider_postcode; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance Mailing Address 1</label>
                    <input type="text" class="form-control" name="financemailing1" placeholder="Finance Mailing Address 1" value="<?php echo $row->provider_finance_mailing_address1; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance Mailing Address 2</label>
                    <input type="text" class="form-control" name="financemailing2" placeholder="Finance Mailing Address 2" value="<?php echo $row->provider_finance_mailing_address2; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance Suburb</label>
                    <input type="text" class="form-control" name="financesuburb" placeholder="Finance Suburb" value="<?php echo $row->provider_finance_suburb1; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance State</label>
                    <input type="text" class="form-control" name="financestate" placeholder="Finance State" value="<?php echo $row->provider_finance_state1; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Finance Postcode</label>
                    <input type="text" class="form-control" name="financepostcode" placeholder="Finance Postcode" value="<?php echo $row->provider_finance_postcode1; ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Notes</label>
                    <textarea class="form-control" name="notes" placeholder="Notes" required><?php echo $row->provider_notes; ?></textarea>
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