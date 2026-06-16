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
              
              <form action="<?php echo base_url(); ?>index.php/updateprogramoptions" method="post" enctype="multipart/form-data">
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <input type="hidden" name="poid" value="<?php echo $poid; ?>">
                <?php
                    foreach ($programoptions as $row) {
                ?>
                <input type="hidden" name="sp_id" value="<?php echo $row->sp_id; ?>">
                <div class="mb-3">
                  <label for="amount" class="form-label">CRICOS Code</label>
                  <input type="text" class="form-control" name="cricoscode" placeholder="CRICOS Code" value="<?php echo $row->cricoscode; ?>">
                </div>
                <div class="mb-3">
                  <input type="hidden" name="client_id" value="<?php echo $row->client_id; ?>">
                  <label for="client" class="form-label">School</label>
                  <select class="form-control select2" name="provider_id" id="provider" onchange="getPrograms()">
                    <!--<option value="<?php echo $row->provider_id; ?>"><?php echo $row->provider_name; ?></option>-->
                    <?php
                    foreach ($schools as $row2) {
                    //   echo "<option value='".$row2->provider_id."'>".$row2->provider_name."</option>";
                      
                      if($row->provider_id == $row2->provider_id) {
                            echo "<option value='".$row2->provider_id."' selected>".$row2->provider_name."</option>";
                      } else {
                            echo "<option value='".$row2->provider_id."'>".$row2->provider_name."</option>";
                      }
                    }
                    ?>
                  </select> 
                </div>
                <div class="mb-3">
                  <label for="client" class="form-label">Select Student Application for this PO</label>
                  <select class="form-control select2" name="application_id">
                    <option value='0'></option>
                    <?php
                    foreach ($applications as $row1) {
                      if($row->application_id == $row1->studentapp_id) {
                            echo "<option value='".$row1->studentapp_id."' selected>Student Application #".$row1->studentapp_id." - ".$row1->provider_name." - ".$row1->studentapp_course_name."</option>";
                      } else {
                            echo "<option value='".$row1->studentapp_id."'>Student Application #".$row1->studentapp_id." - ".$row1->provider_name." - ".$row1->studentapp_course_name."</option>";
                      }
                    }
                    ?>
                  </select> 
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Program</label>
                  <select class="form-control select2" name="sp_id" id="programlist" onchange="getProgramDetails();">
                    <!--<option value="<?php echo $row->sp_id; ?>"><?php echo $row->program; ?></option>-->
                    <?php
                    foreach ($programs as $row1) {
                      if($row->sp_id == $row1->spid) {
                            echo "<option value='".$row1->spid."' selected>".$row1->program."</option>";
                      } else {
                            echo "<option value='".$row1->spid."' >".$row1->program."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="program" class="form-label">Attach Scholarship</label>
                  <select class="form-control select2" name="scholarship_id" id="scholarshiplist">
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Program Link/URL</label>
                  <input type="text" class="form-control" name="programlink" placeholder="Program Link/URL" value="<?php echo $row->programlink; ?>">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">School/Website Link/URL</label>
                  <input type="text" class="form-control" name="schoollink" placeholder="School/Website Link/URL" value="<?php echo $row->schoollink; ?>">
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Indicative Annual Cost</label>
                  <input type="number" class="form-control" name="indicativeannualcost" id="indicativeannualcost" value="<?php echo $row->indicativeannualcost; ?>" placeholder="Indicative Annual Cost">
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Duration</label>
                  <input type="text" class="form-control" id="duration" name="duration" value="<?php echo $row->duration; ?>" placeholder="Duration">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Location Type</label>
                  <!--<input type="text" class="form-control" name="location" value="<?php echo $row->location; ?>" placeholder="Location" required>-->
                  <select name="location" class="form-control">
                      <option value="Onshore"<?php if($row->location == "Onshore") { echo 'selected'; } ?>>Onshore</option>
                      <option value="Offshore" <?php if($row->location == "Offshore") { echo 'selected'; } ?>>Offshore</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Requirement</label>
                  <input type="text" class="form-control" name="englishrequirement" id="englishrequirement" value="<?php echo $row->englishrequirement; ?>" placeholder="Requirement">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Intake</label>
                  <input type="text" class="form-control" id="intake" name="intake" value="<?php echo $row->pointake; ?>" placeholder="Intake">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Campus Location</label>
                  <input type="text" class="form-control" id="campuslocation" name="campuslocation" value="<?php echo $row->pocampuslocation; ?>" placeholder="Campus Location">
                </div>
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Important To Consider</label>-->
                <!--  <input type="text" class="form-control" name="importanttoconsider" value="<?php echo $row->importanttoconsider; ?>" placeholder="Important To Consider" required>-->
                <!--</div>-->
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Outcome</label>-->
                <!--  <input type="text" class="form-control" name="migrationpathway" value="<?php echo $row->migrationpathway; ?>" placeholder="Outcome" required>-->
                <!--</div>-->
                <div class="mb-3">
                  <label for="amount" class="form-label">Others</label>
                  <input type="text" class="form-control" name="others" placeholder="Others" value="<?php echo $row->others; ?>">
                </div>
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">Birthday</label>-->
                <!--  <input type="date" class="form-control" name="birthday" placeholder="Birthday" value="<?php echo $row->birthday; ?>" style="width: 50%;">-->
                <!--</div>-->
                
                <!--<div class="mb-3">-->
                <!--  <label for="amount" class="form-label">English Test Result</label>-->
                <!--  <input type="text" class="form-control" name="englishtestresult" placeholder="English Test Result" value="<?php echo $row->englishtestresult; ?>">-->
                <!--</div>-->
                <div class="mb-3">
                  <label for="amount" class="form-label">Remarks</label>
                  <input type="text" class="form-control" name="remarks" placeholder="Remarks" value="<?php echo $row->remarks; ?>">
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Follow-up Date</label>
                  <input type="date" class="form-control" name="followupdate" placeholder="Follow-up Date" value="<?php echo $row->followupdate; ?>" style="width: 50%;">
                </div>
                
                <br><br>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Process Status</label>
                  <select class="form-control" name="processstatus">
                      <option value="Waiting" <?php if($row->processstatus == "Waiting") { echo "selected"; }; ?>>Waiting</option>
                      <option value="On-hold" <?php if($row->processstatus == "On-hold") { echo "selected"; }; ?>>On-hold</option>
                      <option value="Withdrawn" <?php if($row->processstatus == "Withdrawn") { echo "selected"; }; ?>>Withdrawn</option>
                      <option value="For admissions" <?php if($row->processstatus == "For admissions") { echo "selected"; }; ?>>For admissions</option>
                  </select>
                </div>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Date of Payment</label>
                  <input type="date" class="form-control" name="dateofpayment" placeholder="Follow-up Date" value="<?php echo $row->dateofpayment; ?>" style="width: 50%;">
                </div>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Number of Dependent</label>
                  <input type="number" class="form-control" step="0" name="numberofdependent" placeholder="Number of Dependent" value="<?php echo $row->numberofdependent; ?>">
                </div>
                
                <div class="mb-3">
                  <label for="pofile" class="form-label">Program Options File</label>
                  <?php if (!empty($row->pofile)) : ?>
                    <p class="mb-2">
                      Current: 
                      <a href="<?php echo base_url('assets/pofiles/'.$row->pofile); ?>" target="_blank">
                        <?php echo $row->pofile; ?>
                      </a>
                    </p>
                  <?php endif; ?>
                  <input type="file" class="form-control" name="pofile" id="pofile">
                  <small class="form-text text-muted">Leave empty to keep the current file.</small>
                </div>
                
                <?php
                    }
                ?>
                <button type="submit" class="btn btn-primary">Submit</button>
                <br><br>
                <!--<h3>Expenses Details</h3>-->
                <!--<a href="<?php echo base_url(); ?>index.php/programoptionsdetailsnew/<?php echo $poid; ?>">Add New Program Option Cost Details</a>-->
                <!--<br>-->
                
                
                <!--      <table class="table table-bordered table-striped">-->
                <!--        <thead>-->
                <!--        <tr>-->
                <!--          <th>Table Category</th>-->
                <!--          <th>Cost Category</th>-->
                <!--          <th>Payment Type</th>-->
                <!--          <th>Amount Without Scholarship</th>-->
                <!--          <th>Amount With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </thead>-->
                <!--        <tbody>-->
                <!--        <?php
                // <!--        foreach ($newprogramoptionsdetails as $row) {-->
                // <!--          echo "<tr>-->
                // <!--            <td>".$row->table_category."</td>-->
                // <!--            <td>".$row->cost_category."</td>-->
                // <!--            <td>".$row->payment_type."</td>-->
                // <!--            <td>".$row->amount_without_scholarship."</td>-->
                // <!--            <td>".$row->amount_with_scholarship."</td>-->
                // <!--            <td><a href='".base_url()."index.php/deleteprogramoptiondetailnew/".$poid."/".$row->id."' class='btn btn-danger btn-xs'>Delete</a></td>-->
                // <!--          </tr>";-->
                // <!--        }
                        ?>
                <!--        </tbody>-->
                <!--      </table>-->
                
                
                <!--<h4>Without Dependent</h4>-->
                <!--<a href="<?php echo base_url(); ?>index.php/newprogramoptiondetailwithoutdependent/<?php echo $poid; ?>">Add New Program Option Details Without Dependent</a>-->
                <!--      <table class="table table-bordered table-striped">-->
                <!--        <thead>-->
                <!--        <tr>-->
                <!--          <th>Category</th>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </thead>-->
                <!--        <tbody>-->
                        
                <!--        foreach ($programoptionsdetailwithoutdependent as $row) {-->
                <!--          echo "<tr>-->
                <!--            <td>".$row->category."</td>-->
                <!--            <td>".$row->type."</td>-->
                <!--            <td>".$row->woscholarship."</td>-->
                <!--            <td>".$row->wscholarship."</td>-->
                <!--            <td><a href='".base_url()."index.php/deleteprogramoptiondetailwithoutdependent/".$poid."/".$row->id."' class='btn btn-danger btn-xs'>Delete</a></td>-->
                <!--          </tr>";-->
                <!--        }-->
                <!--        ?>-->
                <!--        </tbody>-->
                <!--        <tfoot>-->
                <!--        <tr>-->
                <!--          <th>Category</th>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </tfoot>-->
                <!--      </table>-->
                <!--<br>-->
                <!--<h4>Estimated Initial Payment</h4>-->
                <!--<a href="<?php echo base_url(); ?>index.php/newprogramoptiondetaileipwithoutdependent/<?php echo $poid; ?>">Add New Estimated Initial Payment Without Dependent</a>-->
                <!--      <table class="table table-bordered table-striped">-->
                <!--        <thead>-->
                <!--        <tr>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </thead>-->
                <!--        <tbody>-->
                        
                <!--        foreach ($programoptionsdetaileipwithoutdependent as $row) {-->
                <!--          echo "<tr>-->
                <!--            <td>".$row->type."</td>-->
                <!--            <td>".$row->woscholarship."</td>-->
                <!--            <td>".$row->wscholarship."</td>-->
                <!--            <td><a href='".base_url()."index.php/deleteprogramoptiondetaileipwithoutdependent/".$row->id."' class='btn btn-danger btn-xs'>Delete</a></td>-->
                <!--          </tr>";-->
                <!--        }-->
                <!--        ?>-->
                <!--        </tbody>-->
                <!--        <tfoot>-->
                <!--        <tr>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </tfoot>-->
                <!--      </table>-->
                <!--<br>-->
                <!--<h4>With Dependent</h4>-->
                <!--<a href="<?php echo base_url(); ?>index.php/newprogramoptiondetailwithdependent/<?php echo $poid; ?>">Add New Program Option Details With Dependent</a>-->
                <!--      <table class="table table-bordered table-striped">-->
                <!--        <thead>-->
                <!--        <tr>-->
                <!--          <th>Category</th>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </thead>-->
                <!--        <tbody>-->
                        
                <!--        foreach ($programoptionsdetailwithdependent as $row) {-->
                <!--          echo "<tr>-->
                <!--            <td>".$row->category."</td>-->
                <!--            <td>".$row->type."</td>-->
                <!--            <td>".$row->woscholarship."</td>-->
                <!--            <td>".$row->wscholarship."</td>-->
                <!--            <td><a href='".base_url()."index.php/deleteprogramoptiondetailwithdependent/".$poid."/".$row->id."' class='btn btn-danger btn-xs'>Delete</a></td>-->
                <!--          </tr>";-->
                <!--        }-->
                <!--        ?>-->
                <!--        </tbody>-->
                <!--        <tfoot>-->
                <!--        <tr>-->
                <!--          <th>Category</th>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </tfoot>-->
                <!--      </table>-->
                <!--<br>-->
                <!--<h4>Estimated Initial Payment</h4>-->
                <!--<a href="<?php echo base_url(); ?>index.php/newprogramoptiondetaileipwithdependent/<?php echo $poid; ?>">Add New Estimated Initial Payment With Dependent</a>-->
                <!--      <table class="table table-bordered table-striped">-->
                <!--        <thead>-->
                <!--        <tr>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </thead>-->
                <!--        <tbody>-->
                        
                <!--        foreach ($programoptionsdetaileipwithdependent as $row) {-->
                <!--          echo "<tr>-->
                <!--            <td>".$row->type."</td>-->
                <!--            <td>".$row->woscholarship."</td>-->
                <!--            <td>".$row->wscholarship."</td>-->
                <!--            <td><a href='".base_url()."index.php/deleteprogramoptiondetaileipwithdependent/".$row->id."' class='btn btn-danger btn-xs'>Delete</a></td>-->
                <!--          </tr>";-->
                <!--        }-->
                <!--        ?>-->
                <!--        </tbody>-->
                <!--        <tfoot>-->
                <!--        <tr>-->
                <!--          <th>Expenses Type</th>-->
                <!--          <th>Without Scholarship</th>-->
                <!--          <th>With Scholarship</th>-->
                <!--          <th></th>-->
                <!--        </tr>-->
                <!--        </tfoot>-->
                <!--      </table>-->
                      
                      
                      
                <!-- <a href="<?php echo base_url(); ?>index.php/newprogramoptiondetails/<?php echo $poid; ?>">Add New Program Option Details</a>
                      <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Expenses Type</th>
                          <th>Per Person</th>
                          <th>Amount Required</th>
                          <th>Number of Family</th>
                          <th>Amount to Access</th>
                          <th>Confirm Access to Funds</th>
                          <th></th>
                        </tr> z
                        </thead>
                        <tbody>
                        <?php
                        
                        foreach ($programoptionsdetails as $row) {
                          echo "<tr>
                            <td>".$row->expensestype."</td>
                            <td>".$row->perperson."</td>
                            <td>".$row->amountrequired."</td>
                            <td>".$row->numberoffamily."</td>
                            <td>".$row->amounttoaccess."</td>
                            <td>".$row->confirmaccesstofunds."</td>
                            <td><a href='".base_url()."index.php/editprogramoptiondetails/".$row->podid."' class='btn btn-primary btn-xs'>Edit</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Expenses Type</th>
                          <th>Per Person</th>
                          <th>Amount Required</th>
                          <th>Number of Family</th>
                          <th>Amount to Access</th>
                          <th>Confirm Access to Funds</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table> -->

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
  $('.select2').select2();
</script>

<script>

  var baseurl = document.getElementById("baseurl").value;

//   initialPrograms();
  initialScholarships();
  
//   function initialPrograms() {
//     $("#programlist").empty();
//     var sp_id = document.getElementById("sp_id").value;
//     $.ajax({
//           type: "GET",
//           url: baseurl + "index.php/getprogramfromschool/1",
//           success: function(data) {
//               var obj = JSON.parse(data);
//               //alert(obj[0].program);
//               for(var i = 0; i < obj.length; i++) {
//                 if(sp_id == obj[i].spid) {
//                     $("#programlist").append("<option value=" + obj[i].spid + " selected>" + obj[i].program + "</option>");
//                 } else {
//                     $("#programlist").append("<option value=" + obj[i].spid + ">" + obj[i].program + "</option>");
//                 }
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
                 
                $("#scholarshiplist").append("<option value=" + obj[i].scholarshipid + ">" + stfinal + "</option>");
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
