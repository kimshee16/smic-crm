<?php
    $this->load->view('layout/header');
?>
<style>
  .scholarship-page .tab-content {
    padding-top: 16px;
  }

  .scholarship-toolbar {
    align-items: center;
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .scholarship-table-wrap {
    overflow-x: auto;
    width: 100%;
  }

  .scholarship-table-wrap .dataTables_wrapper {
    min-width: 100%;
  }

  .scholarship-table-wrap table.dataTable {
    width: 100% !important;
  }

  .scholarship-actions {
    display: inline-flex;
    gap: 6px;
    white-space: nowrap;
  }

  .scholarship-actions .btn {
    align-items: center;
    display: inline-flex;
    height: 32px;
    justify-content: center;
    min-width: 32px;
    padding: 6px;
  }

  .scholarship-status {
    border-radius: 999px;
    display: inline-flex;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    padding: 6px 10px;
  }

  .scholarship-status.active {
    background: #e6f7ee;
    color: #147a43;
  }

  .scholarship-status.inactive {
    background: #eef2f6;
    color: #667789;
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper scholarship-page">
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
                      <div class="scholarship-toolbar">
                        <a href="newscholarshipfile" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship File</a>
                      </div>
                      <div class="scholarship-table-wrap">
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
                          <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($scholarships as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteschofile = "<a href='deactivateschofile/".$row->scholarshipid."' class='btn btn-danger btn-xs confirmation' title='Deactivate scholarship file' aria-label='Deactivate scholarship file'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deleteschofile = "";
                          }

                          if($row->bactive == 1) {
                            $status = "<span class='scholarship-status active'>Active</span>";
                          } else {
                            $status = "<span class='scholarship-status inactive'>Inactive</span>";
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
                            <td><span class='scholarship-actions'><a href='editscholarshipfile/".$row->scholarshipid."' class='btn btn-primary btn-xs' title='Edit scholarship file' aria-label='Edit scholarship file'><i class='fa fa-edit' aria-hidden='true'></i></a>".$deleteschofile."</span></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
                  <div class="tab-pane fade" id="scholarshipallocation" role="tabpanel" aria-labelledby="scholarshipallocation-tab">
                      <div class="scholarship-toolbar">
                        <a href="newscholarshipallocation" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship Allocation</a>
                      </div>
                      <div class="scholarship-table-wrap">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th width="40%">Remarks</th>
                          <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteschoallo = "<a href='deactivateschoallo/".$row->csid."' class='btn btn-danger btn-xs confirmation' title='Deactivate scholarship allocation' aria-label='Deactivate scholarship allocation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deleteschoallo = "";
                          }

                          if($row->bactive == 1) {
                            $status = "<span class='scholarship-status active'>Active</span>";
                          } else {
                            $status = "<span class='scholarship-status inactive'>Inactive</span>";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td>".$row->csremarks."</td>
                            <td><span class='scholarship-actions'>".$deleteschoallo."</span></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                      </div>
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
      "responsive": false,
      "autoWidth": false,
      "scrollX": true,
      "columnDefs": [
        { "orderable": false, "searchable": false, "targets": 4 }
      ]
    });
    $('#example2').DataTable({
      "responsive": false,
      "autoWidth": false,
      "scrollX": true,
      "columnDefs": [
        { "orderable": false, "searchable": false, "targets": 9 }
      ]
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
      $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
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
