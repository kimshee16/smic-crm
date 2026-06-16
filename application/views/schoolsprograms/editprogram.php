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
              <?php
                foreach ($schoolprograms as $row) {
              ?>
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <form action="<?php echo base_url().'index.php/updateprogram'; ?>" method="post">
                <input type="hidden" name="spid" value="<?php echo $row->spid; ?>">
                <div class="mb-3">
                  <label for="amount" class="form-label">Program Name</label>
                  <input type="text" class="form-control" name="program" value="<?php echo $row->program; ?>" ></textarea>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Description</label>
                  <textarea class="form-control" name="description" placeholder="Description" ><?php echo $row->description; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">School</label>
                  <select class="form-control select2" name="school" >
                    <?php
                    foreach ($education_provider as $row2) {
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
                  <label for="payee" class="form-label">Program Level</label>
                  <select class="form-control select2" name="programlevel" >
                    <?php
                    foreach ($qualifications as $row3) {
                        
                        if($row3->value == $row->programtype) {
                            echo "<option value='".$row3->value."' selected>".$row3->value."</option>";
                        } else {
                            echo "<option value='".$row3->value."'>".$row3->value."</option>"; 
                        }
                      
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Currency</label>
                  <select class="form-control select2" name="currency" >
                    <?php
                      echo "<option value='".$row->currency."'>".$row->currency."</option>";
                    ?>
                    <?php
                    foreach ($currency as $row4) {
                      echo "<option value='".$row4->currency."'>".$row4->currency."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Requirement</label>
                  <input type="number" class="form-control" name="applicationfee" placeholder="Requirement" step=".01" value="<?php echo $row->applicationfee; ?>" >
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Tuition Fee</label>
                  <input type="number" class="form-control" name="tuitionfee" placeholder="Tuition Fee" step=".01" value="<?php echo $row->tuition; ?>" >
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Duration</label>
                  <input type="text" class="form-control" name="costofliving" placeholder="Duration" step=".01" value="<?php echo $row->costofliving; ?>" >
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Campus Location</label>
                  <input type="text" class="form-control" name="campuslocation" placeholder="Campus Location" step=".01" value="<?php echo $row->campuslocation; ?>" >
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Intake</label>
                  <input type="text" class="form-control" name="intake" placeholder="Intake" step=".01" value="<?php echo $row->intake; ?>" >
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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

</body>
</html>
