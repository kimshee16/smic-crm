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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="card-body" style="overflow-x: scroll;">
                <a href="<?php echo base_url(); ?>index.php/newpayment" class="btn btn-primary">New Payment Entry</a><br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Payment Type</th>
                  <th>Reference Number</th>
                  <th>Description</th>
                  <th>Schedule</th>
                  <th>Amount</th>
                  <th>Attachment</th>
                  <th>Payer Name</th>
                  <th>Date</th>
                  <th>Processed by</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $attachments = "";
                foreach ($payments as $row) {
                  
                  if($row->paymenttype == "Acknowledgement Receipt") {
                      $attachments = base_url()."index.php/viewpayment_acknowledgementreceipt";
                  } elseif($row->paymenttype == "Tax Invoice") {
                      $attachments = base_url()."index.php/viewpayment_invoice";
                  } elseif($row->paymenttype == "Pass-due Invoice") {
                      $attachments = base_url()."index.php/viewpayment_paymentreceipt";
                  } elseif($row->paymenttype == "Commission") {
                      $attachments = base_url()."index.php/viewpayment_commission";
                  }
                    
                  echo "<tr>
                    <td>".$row->paymenttype."</td>
                    <td>".$row->reference."</td>
                    <td>".$row->description."</td>
                    <td>".$row->schedule."</td>
                    <td>".$row->totalprice."</td>
                    <td><a href='".$attachments."/".$row->id."' target='_blank'>View/print receipt</a></td>
                    <td>".$row->payorname."</td>
                    <td>".$row->paymentdate."</td>
                    <td>".$row->officer_name."</td>
                    <td><a href='archivepayment/".$row->id."' class='btn btn-danger btn-xs'>Delete</a> <a href='editpayment/".$row->id."' class='btn btn-primary btn-xs'>Edit</a></td>
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
      "responsive": false,
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
</script>
</body>
</html>
