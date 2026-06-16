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
                    if($type == "admissionofferletter") {
              
                    foreach ($admissionofferletter as $row) {
                  ?>
              <form action="<?php echo base_url(); ?>index.php/saveofferletter" method="post" enctype="multipart/form-data">
                <input type="hidden" name="admissionofferletterid" value="<?php echo $row->id; ?>">
                <input type="hidden" name="editfilelink" value="<?php echo $row->attachmentlink; ?>">
                <input type="hidden" name="editfileclientid" value="<?php echo $client; ?>">
                <input type="hidden" name="formtype" value="edit">
                <div class="mb-3">
                    <label for="documentype">Offer Letter Type</label>
                    <!--<select name="offerlettertype" class="form-control select2">-->
                    <!--    <option value="Conditional Offer Letter" <?php if($row->type == "Conditional Offer Letter") { echo "selected"; }; ?>>Conditional Offer Letter</option>-->
                    <!--    <option value="Provisional Offer Letter" <?php if($row->type == "Provisional Offer Letter") { echo "selected"; }; ?>>Provisional Offer Letter</option>-->
                    <!--    <option value="Full Offer Letter" <?php if($row->type == "Full Offer Letter") { echo "selected"; }; ?>>Full Offer Letter</option>-->
                    <!--</select>-->
                    <br><input type="radio" name="offerlettertype" value="Conditional Offer Letter" <?php if($row->type == "Conditional Offer Letter") { echo "checked"; } ?>> Conditional Offer Letter<br>
                    <input type="radio" name="offerlettertype" value="Provisional Offer Letter" <?php if($row->type == "Provisional Offer Letter") { echo "checked"; } ?>> Provisional Offer Letter<br>
                    <input type="radio" name="offerlettertype" value="Full Offer Letter" <?php if($row->type == "Full Offer Letter") { echo "checked"; } ?>> Full Offer Letter
                </div>
                <div class="mb-3">
                    <label for="documentype">Offer Letter</label>
                    <!--<select name="offerletterconditionaloffer" class="form-control select2">-->
                    <!--    <option value="GSR" <?php if($row->conditionaloffer == "GSR") { echo "selected"; }; ?>>GSR</option>-->
                    <!--    <option value="Financial Documents" <?php if($row->conditionaloffer == "Financial Documents") { echo "selected"; }; ?>>Financial Documents</option>-->
                    <!--    <option value="IELTS/PTE" <?php if($row->conditionaloffer == "IELTS/PTE") { echo "selected"; }; ?>>IELTS/PTE</option>-->
                    <!--</select>-->
                    <br><input type="radio" name="offerletterconditionaloffer" value="GSR" <?php if($row->conditionaloffer == "GSR") { echo "checked"; } ?>> GSR<br>
                    <input type="radio" name="offerletterconditionaloffer" value="Financial Documents" <?php if($row->conditionaloffer == "Financial Documents") { echo "checked"; } ?>> Financial Documents<br>
                    <input type="radio" name="offerletterconditionaloffer" value="IELTS/PTE" <?php if($row->conditionaloffer == "IELTS/PTE") { echo "checked"; } ?>> IELTS/PTE
                </div>
                <div class="mb-3">
                    <label for="documentype">Offer Letter Date</label>
                    <input type="date" name="offerletterdate" class="form-control" value="<?php echo $row->date; ?>">
                </div>
                <div class="mb-3">
                    <label for="documentype">Offer Letter Remarks</label>
                    <input type="text" name="offerletterremarks" class="form-control" value="<?php echo $row->remarks; ?>">
                </div>
                <div class="mb-3">
                    <label for="documentfile">Upload New Offer Letter Attachment</label>
                    <input type="file" class="form-control" id="offerletterfile" name="offerletterfile">
                    <p id="warningoffer" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              <script>document.getElementById("offerletterfile").addEventListener("change", function () {
                    const file = this.files[0]; // Get the selected file
                    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                    const warning = document.getElementById("warningoffer");
                
                    if (file && file.size > maxSize) {
                        warning.style.display = "block"; // Show warning
                        this.value = ""; // **Remove the selected file**
                    } else {
                        warning.style.display = "none"; // Hide warning if file is valid
                    }
                });
                </script>

              <?php
                    }
              
                    } elseif($type == "fee") {
              
                    foreach ($fee as $row) {
                  ?>
              
              <form action="<?php echo base_url(); ?>index.php/savefee" method="post" enctype="multipart/form-data">
                <input type="hidden" name="feeid" value="<?php echo $row->id; ?>">
                <input type="hidden" name="editfilelink" value="<?php echo $row->fee_receipt; ?>">
                <input type="hidden" name="editfileclientid" value="<?php echo $client; ?>">
                <input type="hidden" name="formtype" value="edit">
                <div class="form-group">
                    <label for="documentype">Fee Description</label>
                    <select name="feedescription" class="form-control select2">
                        <option value="Admin Fee" <?php if($row->fee_description == "Admin Fee") { echo "selected"; }; ?>>Admin Fee</option>
                        <option value="Refusal Fee" <?php if($row->fee_description == "Refusal Fee") { echo "selected"; }; ?>>Refusal Fee</option>
                        <option value="Processing Fee" <?php if($row->fee_description == "Processing Fee") { echo "selected"; }; ?>>Processing Fee</option>
                        <option value="Tuition Fee" <?php if($row->fee_description == "Tuition Fee") { echo "selected"; }; ?>>Tuition Fee</option>
                        <option value="Visa Application Fee" <?php if($row->fee_description == "Visa Application Fee") { echo "selected"; }; ?>>Visa Application Fee</option>
                        <option value="OSCH" <?php if($row->fee_description == "OSCH") { echo "selected"; }; ?>>OSCH</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="documentype">Fee Amount</label>
                    <input type="number" name="feeamount" step=".01" value="<?php echo $row->fee_amount; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="documentype">Fee Date</label>
                    <input type="date" name="feedatetime" class="form-control" value="<?php echo $row->fee_date; ?>">
                </div>
                <div class="form-group">
                    <label for="documentype">Fee Remarks</label>
                    <input type="text" name="feeremarks" class="form-control" value="<?php echo $row->fee_remarks; ?>">
                </div>
                <div class="form-group">
                    <label for="documentfile">Upload Fee Receipt</label>
                    <input type="file" class="form-control" id="feefile" name="feefile">
                    <p id="warningfee" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              <script>
                document.getElementById("feefile").addEventListener("change", function () {
                    const file = this.files[0]; // Get the selected file
                    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                    const warning = document.getElementById("warningfee");
                
                    if (file && file.size > maxSize) {
                        warning.style.display = "block"; // Show warning
                        this.value = ""; // **Remove the selected file**
                    } else {
                        warning.style.display = "none"; // Hide warning if file is valid
                    }
                });
                </script>
              
              <?php
                    }
              
                    }
                    elseif($type == "interviews") {
              
                    foreach ($interviews as $row) {
                  ?>
                  
              <form action="<?php echo base_url(); ?>index.php/saveinterview" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <input type="hidden" name="interviewid" value="<?php echo $row->id; ?>">
                  <input type="hidden" name="editfilelink" value="<?php echo $row->interview_link; ?>">
                  <input type="hidden" name="editfileclientid" value="<?php echo $client; ?>">
                  <input type="hidden" name="formtype" value="edit">
                  <div class="form-group">
                    <label for="documentype">Interview Date and Time</label>
                    <input type="datetime-local" name="interviewdatetime" class="form-control" value="<?php echo $row->interview_datetime; ?>">
                  </div>
                  <div class="form-group">
                    <label for="documentfile">Upload Fully Accomplished Interview Form</label>
                    <input type="file" class="form-control" id="interviewfile" name="interviewfile">
                    <p id="warninginterview" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                  </div>
                
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>    
              <script>
                document.getElementById("interviewfile").addEventListener("change", function () {
                    const file = this.files[0]; // Get the selected file
                    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                    const warning = document.getElementById("warninginterview");
                
                    if (file && file.size > maxSize) {
                        warning.style.display = "block"; // Show warning
                        this.value = ""; // **Remove the selected file**
                    } else {
                        warning.style.display = "none"; // Hide warning if file is valid
                    }
                });
                </script>
                  
              <?php
                    }
              
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

  initialPrograms();
  function initialPrograms() {
    $("#programlist").empty();
    $.ajax({
          type: "GET",
          url: baseurl + "index.php/getprogramfromschool/1",
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
