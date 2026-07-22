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
              <li class="breadcrumb-item active"><a href="schools">Schools</a></li>
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
          <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
          <div class="card">
            <div class="card-header app-create-toolbar">
              <a href="newprogram" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Program</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Program</th>
                  <th>School</th>
                  <th>Program Type</th>
                  <th>Campus Location</th>
                  <th>Intake/s</th>
                  <th>Scholarships</th>
                  <th>Requirements</th>
                  <th>Tuition Fee</th>
                  <th>Currency</th>
                  <th>Duration</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $finalschostring = "";
                $outerexplode = "";
                $innerexplode = "";
                
                foreach ($programs as $row) {
                  if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                      $deleteprogram = "<a href='".base_url()."index.php/deleteprogram/".$row->spid."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                  } else {
                      $deleteprogram = "";
                  }
                  
                  
                  if($row->scholarships != "") {
                      $outerexplode = explode("[=====]", $row->scholarships);
                      for($o = 0; $o < count($outerexplode); $o++) {
                          $innerexplode = explode("[===]", $outerexplode[$o]);
                          $finalschostring .= "<a href='".base_url()."index.php/editscholarshipfile/".$innerexplode[0]."'>".$innerexplode[1]."</a>";
                      }
                  } else {
                      $finalschostring = "";
                  }
                  

                  echo "<tr>
                    <td>".$row->spid."</td>
                    <td>".$row->program."</td>
                    <td>".$row->provider_name."</td>
                    <td>".$row->programtype."</td>
                    <td>".$row->campuslocation."</td>
                    <td>".$row->intake."</td>
                    <td>".$finalschostring."</td>
                    <td>".$row->applicationfee."</td>
                    <td>".$row->tuition."</td>
                    <td>".$row->currency."</td>
                    <td>".$row->costofliving."</td>
                    <td><a href='editprogram/".$row->spid."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteprogram."</td>
                  </tr>";
                  
                  $finalschostring = "";
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
      "ordering": false,
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
