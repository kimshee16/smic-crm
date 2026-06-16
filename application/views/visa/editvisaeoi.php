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
                      foreach ($eoi as $row) {
                ?>
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <form action="<?php echo base_url().'index.php/updatevisaeoi'; ?>" method="post">
                  <div class="mb-3">
                    <input type="hidden" name="eoiid" value="<?php echo $row->eoi_id; ?>">
                    <label for="clientname" class="form-label">Client Name</label>
                    <input type="hidden" name="clientid" value="<?php echo $row->client_id; ?>">
                    <input type="text" name="clientname" class="form-control" value="<?php echo $row->client_surname.', '.$row->client_firstname.' '.$row->client_middlename; ?>" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="eoinumber" class="form-label">EOI Number</label>
                    <input type="text" name="eoinumber" class="form-control" value="<?php echo $row->eoi_number; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="occupation" class="form-label">Occupation</label>
                    <input type="text" name="occupation" class="form-control" value="<?php echo $row->nominated_occupation; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visasubclass" class="form-label">Visa Subclass</label>
                    <input type="number" name="visasubclass" class="form-control" value="<?php echo $row->visa_subclasses; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="preferreddate" class="form-label">Preferred Date</label>
                    <input type="date" class="form-control" name="preferreddate" value="<?php echo $row->preferred_date; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="skillassessmentdate" class="form-label">Skill Assessment Date</label>
                    <input type="date" class="form-control" name="skillassessmentdate" value="<?php echo $row->skill_assessment_date; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="pycompletiondate" class="form-label">PY Completion Date</label>
                    <input type="date" class="form-control" name="pycompletiondate" value="<?php echo $row->py_completion_date; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="englishcompetencytestdate" class="form-label">English Competency Test Date</label>
                    <input type="date" class="form-control" name="englishcompetencytestdate" value="<?php echo $row->english_competency_test_date; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="englishcompetencydate" class="form-label">English Competency Level</label>
                    <input type="text" class="form-control" name="englishcompetencylevel" value="<?php echo $row->english_competency_level; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <input type="text" class="form-control" name="notes" value="<?php echo $row->notes; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="flag" class="form-label">Flag</label>
                    <select class="form-control" name="flag">
                      <option value="<?php echo $row->flag; ?>"><?php echo $row->flag; ?></option>
                      <option value="Expired">Expired</option>
                      <option value="Discontinued">Discontinued</option>
                      <option value="Invited">Invited</option>
                      <option value="Created">Created</option>
                      <option value="Submitted">Submitted</option>
                    </select>
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