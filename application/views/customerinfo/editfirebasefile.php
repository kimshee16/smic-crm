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
              foreach($firebasefiles as $row) {
            ?>
              <form>
                <input type="hidden" name="fbid" id="fbid" value="<?php echo $row->fbid; ?>">
                <input type="hidden" name="editfilelink" id="editfilelink" value="<?php echo $row->document_link; ?>">
                <input type="hidden" name="editfilename" id="editfilename" value="<?php echo $row->document_name; ?>">
                <input type="hidden" name="editfileclientid" id="updateclientid" value="<?php echo $client; ?>">
                <div class="mb-3">
                    <label for="documentype">Document Type</label>
                    <input type="text" name="updatedocumenttype" class="form-control" value="<?php echo $row->document_type; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="documenalias">Document Alias</label>
                    <input type="text" class="form-control" id="updatedocumenalias" value="<?php echo $row->alias; ?>">
                </div>
                <div class="form-group">
                    <label for="documentfile">Remarks</label>
                    <input type="text" class="form-control" id="updatedocumentremarks" value="<?php echo $row->remarks; ?>">
                </div>
                <div class="form-group">
                    <label for="documentfile">Document File</label>
                    <input type="file" class="form-control" id="updatedocumentfile">
                    <p id="warning" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                </div>
                <button type="button" id="updatefiletofirebase" class="btn btn-primary">Save changes</button>
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
document.getElementById("updatedocumentfile").addEventListener("change", function () {
    const file = this.files[0]; // Get the selected file
    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
    const warning = document.getElementById("warning");

    if (file && file.size > maxSize) {
        warning.style.display = "block"; // Show warning
        this.value = ""; // **Remove the selected file**
    } else {
        warning.style.display = "none"; // Hide warning if file is valid
    }
});
</script>
</body>
</html>
