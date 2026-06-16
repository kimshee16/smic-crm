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
          <?php
          if(isset($_GET['success1'])) {
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            Successfully assigned the process officer.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php
          }
          ?>
          <div class="card" style="overflow-x: scroll;">
            <!-- /.card-header -->
            <div class="card-body">
              <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile Number</th>
                  <th>Landline Number</th>
                  <th>Address</th>
                  <th>Assigned Officer</th>
                  <th>School</th>
                  <th>Country</th>
                  <th>Campus Location</th>
                  <th>Program</th>
                  <th>CRICOS Number</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                
                foreach ($clients as $row) {
                  if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                      $deletecustomer = "<a href='deactivateclient/".$row->client_id."' class='btn btn-danger btn-xs confirmation' title='Deactivate ".$row->client_surname.", ".$row->client_firstname." ".$row->client_middlename."'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                  } else {
                      $deletecustomer = "";
                  }

                  echo "<tr>
                    <td>".$row->client_surname.", ".$row->client_firstname." ".$row->client_middlename."</td>
                    <td>".$row->client_email."</td>
                    <td>".$row->client_mobileno."</td>
                    <td>".$row->client_phoneno."</td>
                    <td>".$row->client_address."</td>
                    <td>".$row->officer_name."</td>
                    
                    <td>".$row->provider_name."</td>
                    <td>".$row->client_country."</td>
                    <td>".$row->campus."</td>
                    <td>".$row->course_actual_name."</td>
                    <td>".$row->cricoscode."</td>
                    
                    <td><a href='editclientinfo2/".$row->ctclientid."' class='btn btn-primary btn-xs' title='Details'><i class='fa fa-edit' aria-hidden='true'></i></a> <a href='#' class='btn btn-primary btn-xs client_".$row->ctclientid."' data-toggle='modal' data-target='#assignModal' id='client_".$row->ctclientid."' onclick='putClientId(event)' title='Assign Officer to ".$row->client_surname.", ".$row->client_firstname." ".$row->client_middlename."'><i class='fa fa-user client_".$row->ctclientid."' aria-hidden='true'></i></a> ".$deletecustomer."</td>
                  </tr>";
                }

                
                ?>
                </tbody>
              </table>
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

  <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="assign">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Please Select Processing Officer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="assignofficer" method="post">
          <div class="modal-body">
              <div class="form-group">
                <label for="documentype">Client ID</label>
                <input type="text" name="clientid" id="clientid" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="documentype">Processing Officer</label>
                <select class="form-control select2" name="officer" required>
                    <?php
                    foreach ($officer as $row) {
                      echo "<option value='".$row->officer_id."'>".$row->officer_name."</option>";
                    }
                    ?>
                </select>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>

  <!-- /.content-wrapper -->
  
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false,
      "autoWidth": false,
      "ordering": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function putClientId(event) {
    var string1 = event.target.className;
    const stringArray = string1.split("_");
    document.getElementById('clientid').value = stringArray[1];
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


  var elems = document.getElementsByClassName('confirmation');
  var confirmIt = function (e) {
      if (!confirm('Are you sure to delete the entry?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
  }
  
</script>
</body>
</html>