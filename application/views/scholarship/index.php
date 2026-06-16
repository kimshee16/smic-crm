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
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="scholarshipfile-tab" data-toggle="tab" href="#scholarshipfile" role="tab" aria-controls="scholarshipfile" aria-selected="true">Scholarship File</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="scholarshipallocation-tab" data-toggle="tab" href="#scholarshipallocation" role="tab" aria-controls="scholarshipallocation" aria-selected="false">Scholarship Allocation</a>
                  </li>
                </ul>
              <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="scholarshipfile" role="tabpanel" aria-labelledby="scholarshipfile-tab">
                      <br>
                      <h3 class="card-title"><a href="newscholarshipfile">Add New Scholarship File</a></h3><br>
                      <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Scholarship Type</th>
                          <th>Payment Type</th>
                          <th>Amount</th>
                          <th>Date Created</th>
                          <th>Valid From</th>
                          <th>Valid To</th>
                          <th>School</th>
                          <th>Program</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($scholarships as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteschofile = "<a href='deactivateschofile/".$row->scholarshipid."' class='btn btn-danger btn-xs'><i class='fa fa-trash confirmation' aria-hidden='true'></i></a>";
                          } else {
                              $deleteschofile = "";
                          }

                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->type."</td>
                            <td>".$row->identity."</td>
                            <td>".$row->amount."</td>
                            <td>".$row->datecreated."</td>
                            <td>".$row->valid_from."</td>
                            <td>".$row->valid_to."</td>
                            <td>".$row->provider_name."</td>
                            <td>".$row->program."</td>
                            <td>".$status."</td>
                            <td><a href='editscholarshipfile/".$row->scholarshipid."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteschofile."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="scholarshipallocation" role="tabpanel" aria-labelledby="scholarshipallocation-tab">
                      <br>
                      <h3 class="card-title"><a href="newscholarshipallocation">Add New Scholarship Allocation</a></h3><br>
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th width="40%">Remarks</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteschoallo = "<a href='deactivateschoallo/".$row->csid."' class='btn btn-danger btn-xs'><i class='fa fa-trash confirmation' aria-hidden='true'></i></a>";
                          } else {
                              $deleteschoallo = "";
                          }

                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td>".$row->csremarks."</td>
                            <td>".$deleteschoallo."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                  </div>
              </div>

              
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
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
      "responsive": true,
      "autoWidth": false,
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
      if (!confirm('Are you sure to deactivate the entry?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
  }
</script>
</body>
</html>