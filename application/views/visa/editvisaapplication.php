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
                      foreach ($visa_application as $row) {
                ?>
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <form action="<?php echo base_url().'index.php/updatevisaapplication'; ?>" method="post">
                  <div class="mb-3">
                    <input type="hidden" name="clientvisaid" value="<?php echo $row->client_visa_id; ?>">
                    <label for="clientname" class="form-label">Client Name</label>
                    <input type="hidden" name="clientid" value="<?php echo $row->client_id; ?>">
                    <input type="text" name="clientname" class="form-control" value="<?php echo $row->client_surname.', '.$row->client_firstname.' '.$row->client_middlename; ?>" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="visasubclass" class="form-label">Visa Subclass</label>
                    <input type="text" name="visasubclass" class="form-control" value="<?php echo $row->new_Visa_subclass; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visasubclassheld" class="form-label">Current Visa Subclass Held</label>
                    <input type="text" name="visasubclassheld" class="form-control" value="<?php echo $row->current_visa_subclass_held; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Visa Description</label>
                    <input type="text" name="description" class="form-control" value="<?php echo $row->visa_description; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="nameofdependents" class="form-label">Name of Dependents</label>
                    <input type="text" name="nameofdependents" class="form-control" value="<?php echo $row->name_of_dependents; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="notes" class="form-label">Other Notes</label>
                    <input type="text" name="notes" class="form-control" value="<?php echo $row->visa_other_notes; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="costagreementsigned" class="form-label">Cost Agreement Signed</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="costagreementsigned" id="costagreementsignedyes" value="yes"> Yes &nbsp;&nbsp; <input type="radio" name="costagreementsigned" id="costagreementsignedno" value="no"> No
                  </div>
                  <div class="mb-3">
                    <label for="costagreementissued" class="form-label">Cost Agreement Issued</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="costagreementissued" id="costagreementissuedyes" value="yes"> Yes &nbsp;&nbsp; <input type="radio" name="costagreementissued" id="costagreementissuedno" value="no"> No
                  </div>
                  <?php 
                      if($row->costs_agreement_issued == "yes") {
                        echo "<script>document.getElementById('costagreementissuedyes').checked = true;</script>";
                      } else {
                        echo "<script>document.getElementById('costagreementissuedno').checked = true;</script>";
                      }

                      if($row->costs_agreement_signed == "yes") {
                        echo "<script>document.getElementById('costagreementsignedyes').checked = true;</script>";
                      } else {
                        echo "<script>document.getElementById('costagreementsignedno').checked = true;</script>";
                      }
                  ?>
                  <div class="mb-3">
                    <label for="visaexpirydate" class="form-label">Visa Expiry Date</label>
                    <input type="date" class="form-control" name="visaexpirydate" value="<?php echo $row->visa_expiry_year.'-'.$row->visa_expiry_month.'-'.$row->visa_expiry_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visaafplodgeddate" class="form-label">Visa AFP Lodged Date</label>
                    <input type="date" class="form-control" name="visaafplodgeddate" value="<?php echo $row->visa_afp_lodged_year.'-'.$row->visa_afp_lodged_month.'-'.$row->visa_afp_lodged_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visalodgeddate" class="form-label">Visa Lodged Date</label>
                    <input type="date" class="form-control" name="visalodgeddate" value="<?php echo $row->visa_lodged_year.'-'.$row->visa_lodged_month.'-'.$row->visa_lodged_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visacriticaldate" class="form-label">Visa Critical Date</label>
                    <input type="date" class="form-control" name="visacriticaldate" value="<?php echo $row->visa_critical_year.'-'.$row->visa_critical_month.'-'.$row->visa_critical_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="skillassessmentlodgeddate" class="form-label">Skill Assessment Lodged Date</label>
                    <input type="date" class="form-control" name="skillassessmentlodgeddate" value="<?php echo $row->skills_assessment_lodged_year.'-'.$row->skills_assessment_lodged_month.'-'.$row->skills_assessment_lodged_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="englishtestdate" class="form-label">English Test Date</label>
                    <input type="date" class="form-control" name="englishtestdate" value="<?php echo $row->english_test_year.'-'.$row->english_test_month.'-'.$row->english_test_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visadecisiondate" class="form-label">Visa Decision Date</label>
                    <input type="date" class="form-control" name="visadecisiondate" value="<?php echo $row->visa_decision_year.'-'.$row->visa_decision_month.'-'.$row->visa_decision_day; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="flag" class="form-label">Flag</label>
                    <select class="form-control" name="flag">
                      <option value="Withdrawn" <?php if($row->status == "Withdrawn") { echo "selected"; } ?>>Withdrawn</option>
                      <option value="Lodged" <?php if($row->status == "Lodged") { echo "selected"; } ?>>Lodged</option>
                      <option value="Granted" <?php if($row->status == "Granted") { echo "selected"; } ?>>Granted</option>
                      <option value="Refused" <?php if($row->status == "Refused") { echo "selected"; } ?>>Refused</option>
                      <option value="Appealing" <?php if($row->status == "Appealing") { echo "selected"; } ?>>Appealing</option>
                      <option value="Discontinued" <?php if($row->status == "Discontinued") { echo "selected"; } ?>>Discontinued</option>
                      <option value="EOI" <?php if($row->status == "EOI") { echo "selected"; } ?>>EOI</option>
                      <option value="Submitted" <?php if($row->status == "Submitted") { echo "selected"; } ?>>Submitted</option>
                      <option value="WIP" <?php if($row->status == "WIP") { echo "selected"; } ?>>WIP</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="visadateofsubmission" class="form-label">Date of Submission</label>
                    <input type="date" class="form-control" name="visadateofsubmission" value="<?php echo $row->visadateofsubmission; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="visadateofsubmission" class="form-label">Result Release Date</label>
                    <input type="date" class="form-control" name="visaresultreleasedate" value="<?php echo $row->visaresultreleasedate; ?>">
                  </div>
                   <div class="mb-3">
                    <label for="visadateofsubmission" class="form-label">Intake</label>
                    <input type="date" class="form-control" name="visa_intake" value="<?php echo $row->visaresultreleasedate; ?>">
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