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
    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
    
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <?php
                    foreach ($application as $row) {
                  ?>
              <form action="<?php echo base_url(); ?>index.php/saveapplication" method="post" enctype="multipart/form-data" id="applicationform">
                <input type="hidden" name="studentapp_id" value="<?php echo $row->studentapp_id; ?>">
                <input type="hidden" name="editfilelink" value="<?php echo $row->vevo_expiry; ?>">
                <input type="hidden" name="formtype" value="edit">
                <div class="mb-3">
                  <label for="payee" class="form-label">Customer</label>
                      <input type="hidden" name="clientid" value="<?php echo $row->client_id; ?>">
                      <input type="text" name="clientname" class="form-control" value="<?php echo $row->client_surname.', '.$row->client_firstname.' '.$row->client_middlename; ?>" readonly>
                </div>
                <div class="mb-3">
                  <label for="client" class="form-label">School</label>
                  <select class="form-control select2" name="school" id="provider" onchange="getPrograms()" required style="width: 100%;">
                    <?php
                    foreach ($schools as $row3) {
                      if($row->provider_id == $row3->provider_id) {
                          $selected = "selected";
                      } else {
                          $selected = "";
                      }
                      echo "<option value='".$row3->provider_id."' ".$selected.">".$row3->provider_name."</option>";
                    }
                    ?>
                  </select> 
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Program</label>
                  <select class="form-control select2" name="program[]" id="programlist" required multiple style="width: 100%;">
                      <?php
                        $selectedProgramIds = isset($selected_program_ids) ? $selected_program_ids : array();
                        foreach ($programs as $row3) {
                          if(in_array($row3->spid, $selectedProgramIds)) {
                              $selected = "selected";
                          } else {
                              $selected = "";
                          }
                          echo "<option value='".$row3->spid."' ".$selected.">".$row3->program."</option>";
                        }
                      ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Course Start Date</label>
                  <input type="date" name="startdate" class="form-control" value="<?php echo $row->studentapp_course_starting_year.'-'.$row->studentapp_course_starting_month.'-'.$row->studentapp_course_starting_day; ?>" style="width: 50%;">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Course End Date</label>
                  <input type="date" name="enddate" class="form-control" value="<?php echo $row->studentapp_course_end_year.'-'.$row->studentapp_course_end_month.'-'.$row->studentapp_course_end_day; ?>" style="width: 50%;">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">COE Date</label>
                  <input type="date" name="coedate" class="form-control" value="<?php echo $row->studentapp_coe_year.'-'.$row->studentapp_coe_month.'-'.$row->studentapp_coe_day; ?>" style="width: 50%;">
                </div>
                <div class="mb-3">
                    <label for="flag" class="form-label">Flag</label>
                    <select class="form-control select2" name="flag" style="width: 100%;">
                      <option value="Withdrawn" <?php if($row->studentapp_flag == "Withdrawn") { echo "selected"; } ?>>Withdrawn</option>
                      <option value="Appealing" <?php if($row->studentapp_flag == "Appealing") { echo "selected"; } ?>>Completed</option>
                      <option value="Discontinued" <?php if($row->studentapp_flag == "Discontinued") { echo "selected"; } ?>>Discontinued</option>
                      <option value="Submitted" <?php if($row->studentapp_flag == "Submitted") { echo "selected"; } ?>>Submitted</option>
                      <option value="WIP" <?php if($row->studentapp_flag == "WIP") { echo "selected"; } ?>>WIP</option>
                      
                      <option value="Admitted" <?php if($row->studentapp_flag == "Admitted") { echo "selected"; } ?>>Admitted</option>
                      <option value="Conditional Offer Letter" <?php if($row->studentapp_flag == "Conditional Offer Letter") { echo "selected"; } ?>>Conditional Offer Letter</option>
                      <option value="Full Offer Letter" <?php if($row->studentapp_flag == "Full Offer Letter") { echo "selected"; } ?>>Full Offer Letter</option>
                      <option value="Withdrawn" <?php if($row->studentapp_flag == "Withdrawn") { echo "selected"; } ?>>Withdrawn</option>
                      <option value="Refused" <?php if($row->studentapp_flag == "Refused") { echo "selected"; } ?>>Refused</option>
                    </select>
                  </div>
                <div class="mb-3">
                  <label for="remarks" class="form-label">Campus</label>
                  <input type="text" class="form-control" name="campus" value="<?php echo $row->campus; ?>">
                </div>
                <div class="mb-3">
                  <label for="intake" class="form-label">Intake</label>
                  <input type="text" class="form-control" name="intake" value="<?php echo $row->intake; ?>">
                </div>
                <div class="mb-3">
                  <label for="remarks" class="form-label">Remarks</label>
                  <input type="text" class="form-control" name="remarks" value="<?php echo $row->remarks; ?>">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">VEVO Expiry Date</label>
                  <input type="date" name="vevo_expiry_date" class="form-control" value="<?php echo $row->vevo_expiry_date; ?>"  style="width: 50%;">
                </div>
                <div class="mb-3">
                    <label class="form-label">VEVO Expiry</label>
                    <?php
                      if($row->vevo_expiry != "") {
                        echo "<div><a href='".base_url()."assets/vevo/".$row->vevo_expiry."' target='_blank'>".$row->vevo_expiry."</a></div>";
                      }
                    ?>
                </div>
                <button type="submit" class="btn btn-primary" id="applicationsubmit">Submit</button>
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

  $('.select2').select2();

  var baseurl = document.getElementById("baseurl").value;

//   initialPrograms();
//   function initialPrograms() {
//     $("#programlist").empty();
//     $.ajax({
//           type: "GET",
//           url: baseurl + "index.php/getprogramfromschool/1",
//           success: function(data) {
//               var obj = JSON.parse(data);
//               //alert(obj[0].program);
//               for(var i = 0; i < obj.length; i++) {
//                 $("#programlist").append("<option value=" + obj[i].spid + ">" + obj[i].program + "</option>");
//               }
//           },
//           error: function(error) {
//             alert("Error!");
//           }
//       });
//   }

  function getPrograms() {
    var id = document.getElementById("provider").value;
    $("#programlist").empty();
    $.ajax({
          type: "GET",
          url: baseurl + "index.php/getprogramfromschool/" + id,
          success: function(data) {
              var obj = JSON.parse(data);
              //alert(obj[0].program);
              for(var i = 0; i < obj.length; i++) {
                $("#programlist").append("<option value=" + obj[i].spid + ">" + obj[i].program + "</option>");
              }
              $("#programlist").trigger("change");
          },
          error: function(error) {
            alert("Error!");
          }
      });
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
<script>
    $('.select2').select2();
</script>
<script>
document.getElementById("applicationform").addEventListener("submit", function () {
    document.getElementById("applicationsubmit").disabled = true;
});
</script>
</body>
</html>
