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
              <li class="breadcrumb-item active"><a href="programs">Programs</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
          <div class="card">
            <div class="card-header app-create-toolbar">
              <a href="newschool" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New School</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>School</th>
                  <th>Marketing Contact Name</th>
                  <th>Admin Contact Name</th>
                  <th>Finance Contact Name</th>
                  <th>Mailing Address</th>
                  <th>Mobile Number</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($schools as $row) {
                  if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                      $deleteschools = "<a href='".base_url()."index.php/deleteschool/".$row->provider_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                  } else {
                      $deleteschools = "";
                  }

                  echo "<tr>
                    <td>".$row->provider_id."</td>
                    <td>".$row->provider_name."</td>
                    <td>".$row->provider_marketing_contact_name."</td>
                    <td>".$row->provider_admin_contact_name."</td>
                    <td>".$row->provider_finance_contact_name."</td>
                    <td>".$row->provider_mailing_address."</td>
                    <td>".$row->provider_marketing_mobileno."</td>
                    <td><a href='editschool/".$row->provider_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteschools."</td>
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
