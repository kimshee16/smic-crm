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
              
              <form action="<?php echo base_url(); ?>index.php/saveprogramoptions" method="post" enctype="multipart/form-data">
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                <div class="mb-3">
                  <label for="amount" class="form-label">CRICOS Code</label>
                  <input type="text" class="form-control" name="cricoscode" placeholder="CRICOS Code">
                </div>
                <div class="mb-3">
                  <label for="client" class="form-label">School</label>
                  <select class="form-control select2" name="provider_id" id="provider" onchange="getPrograms();getScholarship();" >
                    <?php
                    foreach ($schools as $row) {
                      echo "<option value='".$row->provider_id."'>".$row->provider_name."</option>";
                    }
                    ?>
                  </select> 
                </div>
                <div class="mb-3">
                  <label for="client" class="form-label">Select Student Application for this PO</label>
                  <select class="form-control select2" name="application_id">
                    <option value='0'></option>
                    <?php
                    foreach ($applications as $row) {
                      $application_programs = isset($row->application_programs) ? $row->application_programs : $row->studentapp_course_name;
                      echo "<option value='".$row->studentapp_id."'>Student Application #".$row->studentapp_id." - ".$row->provider_name." - ".$application_programs."</option>";
                    }
                    ?>
                  </select> 
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Program</label>
                  <select class="form-control select2" name="sp_id" id="programlist" onchange="getProgramDetails();">
                  </select>
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Attach Scholarship</label>
                  <select class="form-control select2" name="scholarship_id" id="scholarshiplist">
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Program Link/URL</label>
                  <input type="text" class="form-control" name="programlink" placeholder="Program Link/URL">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">School/Website Link/URL</label>
                  <input type="text" class="form-control" name="schoollink" placeholder="School/Website Link/URL">
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Indicative Annual Cost</label>
                  <input type="number" class="form-control" id="indicativeannualcost" name="indicativeannualcost" placeholder="Indicative Annual Cost">
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Duration</label>
                  <input type="text" class="form-control" id="duration" name="duration" placeholder="Duration">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Location Type</label>
                  <!--<input type="text" class="form-control" name="location" placeholder="Location" required>-->
                  <select name="location" class="form-control">
                      <option value="Onshore">Onshore</option>
                      <option value="Offshore">Offshore</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Requirement</label>
                  <input type="text" class="form-control" id="englishrequirement" name="englishrequirement" placeholder="Requirement">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Intake</label>
                  <input type="text" class="form-control" id="intake" name="intake" placeholder="Intake">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Campus Location</label>
                  <input type="text" class="form-control" step="0" id="campuslocation" name="campuslocation" placeholder="Campus Location">
                </div>
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Important To Consider</label>-->
                <!--  <input type="text" class="form-control" name="importanttoconsider" placeholder="Important To Consider" required>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Outcome</label>-->
                <!--  <input type="text" class="form-control" name="migrationpathway" placeholder="Outcome" required>-->
                <!--</div>-->
                <div class="mb-3">
                  <label for="amount" class="form-label">Others</label>
                  <input type="text" class="form-control" name="others" placeholder="Others">
                </div>
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Birthday</label>-->
                <!--  <input type="date" class="form-control" name="birthday" placeholder="Birthday" style="width: 50%;">-->
                <!--</div>-->
                
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">English Test Result</label>-->
                <!--  <input type="text" class="form-control" name="englishtestresult" placeholder="English Test Result">-->
                <!--</div>-->
                <div class="mb-3">
                  <label for="amount" class="form-label">Remarks</label>
                  <input type="text" class="form-control" name="remarks" placeholder="Remarks">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Follow-up Date</label>
                  <input type="date" class="form-control" name="followupdate" placeholder="Follow-up Date" style="width: 50%;">
                </div>
                
                <br><br>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Date of Payment</label>
                  <input type="date" class="form-control" name="dateofpayment" placeholder="Follow-up Date" style="width: 50%;">
                </div>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Number of Dependent</label>
                  <input type="number" class="form-control" step="0" name="numberofdependent" placeholder="Number of Dependent">
                </div>
                
                <div class="mb-3">
                  <label for="pofile" class="form-label">Program Options File</label>
                  <input type="file" class="form-control" name="pofile" id="pofile">
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
  $('.select2').select2();
//   $(function () {
//     $("#example1").DataTable({
//       "responsive": true,
//       "autoWidth": false,
//     });
//     $('#example2').DataTable({
//       "paging": true,
//       "lengthChange": false,
//       "searching": false,
//       "ordering": true,
//       "info": true,
//       "autoWidth": false,
//       "responsive": true,
//     });
//   });
</script>

<script>

  var baseurl = document.getElementById("baseurl").value;

  initialPrograms();
  initialScholarships();
  getProgramDetails();
  
  function initialPrograms() {
    $("#programlist").empty();
    $.ajax({
          type: "GET",
          url: baseurl + "index.php/getprogramfromschool/1",
          success: function(data) {
              var obj = JSON.parse(data);
              
              for(var i = 0; i < obj.length; i++) {
                $("#programlist").append("<option value=" + obj[i].spid + ">" + obj[i].program + "</option>");
              }
          },
          error: function(error) {
            alert("Error!");
          }
      });
  }
  
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
              
          },
          error: function(error) {
            alert("Error!");
          }
      });
  }
  
  function getProgramDetails() {
    var id = document.getElementById("programlist").value;
    if(id == "") {
        id = 1;
    }
    $.ajax({
          type: "GET",
          url: baseurl + "index.php/getprogramdetails/" + id,
          success: function(data) {
              var obj = JSON.parse(data);
              console.log(obj);
              document.getElementById("campuslocation").value = obj[0].campuslocation;
              document.getElementById("intake").value = obj[0].intake;
              document.getElementById("englishrequirement").value = obj[0].applicationfee;
              document.getElementById("duration").value = obj[0].costofliving;
              document.getElementById("indicativeannualcost").value = obj[0].tuition;
              
          },
          error: function(error) {
            console.log(error);
          }
      });
  }
  
  function initialScholarships() {
    $("#scholarshiplist").empty();
    $.ajax({
          type: "GET",
          url: baseurl + "index.php/getscholarshopfromschool/1",
          success: function(data) {
              var obj = JSON.parse(data);
              var stfinal = "";
              //alert(obj[0].program);
              $("#scholarshiplist").append("<option value='0'></option>");
              for(var i = 0; i < obj.length; i++) {
                
                stfinal = shortenString(obj[i].type) + " - " + shortenString(obj[i].description) + " - " + obj[i].identity + " - " + obj[i].amount;
                 
                $("#scholarshiplist").append("<option value='" + obj[i].scholarshipid + "'>" + stfinal + "</option>");
              }
          },
          error: function(error) {
            alert("Error!");
          }
      });
  }

  function getScholarship() {
    var id = document.getElementById("provider").value;
    $("#scholarshiplist").empty();
    $.ajax({
          type: "GET",
          url: baseurl + "index.php/getscholarshopfromschool/" + id,
          success: function(data) {
              var obj = JSON.parse(data);
              //alert(obj[0].program);
              $("#scholarshiplist").append("<option value='0'></option>");
              for(var i = 0; i < obj.length; i++) {
                stfinal = shortenString(obj[i].type) + " - " + shortenString(obj[i].description) + " - " + obj[i].identity + " - " + obj[i].amount;
                 
                $("#scholarshiplist").append("<option value=" + obj[i].scholarshipid + ">" + stfinal + "</option>");
              }
          },
          error: function(error) {
            alert("Error!");
          }
      });
  }
  
  function shortenString(string, length = 30) {
    if (string.length > length) {
        return string.substring(0, length) + '...';
    }
    return string;
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
</body>
</html>
