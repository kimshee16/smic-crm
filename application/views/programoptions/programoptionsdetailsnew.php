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
              
              <form action="<?php echo base_url(); ?>index.php/saveprogramoptionsdetailsnew" method="post">
                <?php
                foreach($programoptions as $row) {
                ?>
                <div class="mb-3">
                  <label for="woscholarship" class="form-label">Scholarship Attached</label>
                  <input type="text" class="form-control" name="scholarshipamount" id="scholarshipamount" value="<?php echo $row->amount; ?>" readonly>
                  <input type="text" class="form-control" name="scholarshippaymenttype" id="scholarshippaymenttype" value="<?php echo $row->identity; ?>" readonly>
                  <input type="text" class="form-control" name="scholarshiptype" id="scholarshiptype" value="<?php echo $row->type; ?>" readonly>
                </div>
                <?php
                }
                ?>
                <input type="hidden" name="poid" value="<?php echo $poid; ?>">
                <div class="mb-3">
                  <label for="type" class="form-label">Table Category</label>
                  <select name="tablecategory" class="form-control" required>
                    <option option="">Select Table Category</option>
                    <option option=""></option>
                    <option option="Without Dependent Table">Without Dependent Table</option>
                    <option option="Showmoney Without Dependent Table">Showmoney Without Dependent Table</option>
                    <option option="With Dependent Table">With Dependent Table</option>
                    <option option="Showmoney With Dependent Table">Showmoney With Dependent Table</option>
                    <option option="Subsequent Table">Subsequent Table</option>
                    <option option="Showmoney Subsequent Table">Showmoney Subsequent Table</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="type" class="form-label">Cost Category</label>
                  <select name="costcategory" class="form-control" required>
                    <option option="">Select Cost Category</option>
                    <option option=""></option>
                    <option option="Living Expenses">Living Expenses</option>
                    <option option="Travel">Travel</option>
                    <option option="Tuition Fee">Tuition Fee</option>
                    <option option="1st Sem Tuition Fee">1st Sem Tuition Fee</option>
                    <option option="Insurance 2 Years">Insurance 2 Years</option>
                    <option option="Student Visa">Student Visa</option>
                    <option option="Additional">Additional</option>
                    <option option="Student Visa Application">Student Visa Application</option>
                    <option option="Dependent Visa">Dependent Visa</option>
                    <option option="Dependent Child 1">Dependent Child 1</option>
                    <option option="Dependent Child 2">Dependent Child 2</option>
                    <option option="Admin Fee">Admin Fee</option>
                    <option option="Number of Dependent ">Number of Dependent </option>
                    <option option="Number of Child">Number of Child</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="type" class="form-label">Payment Type (No need to select to this fields if the Cost Category is the following: Admin Fee/Number of Dependent/Number of Child)</label>
                  <select name="paymenttype" class="form-control" required>
                    <option option="">Select Payment Type</option>
                    <option option=""></option>
                    <option option="Yourself (Student)">Yourself (Student)</option>
                    <option option="Partner">Partner</option>
                    <option option="First Child">First Child</option>
                    <option option="Each Additional Child">Each Additional Child</option>
                    <option option="Return Airfare (each/one-way)">Return Airfare (each/one-way)</option>
                    <option option="Annual Tuition Fee">Annual Tuition Fee</option>
                    <option option="Material Fee">Material Fee</option>
                    <option option="Application Fee">Application Fee</option>
                    <option option="Tuition (Child)">Tuition (Child)</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="woscholarship" class="form-label">Amount Without Scholarship (if there's Scholarship data attached, Amount with Scholarship will be auto-computed below)</label>
                  <input type="number" step="" class="form-control" name="woscholarship" id="woscholarship" placeholder="Amount Without Scholarship" required oninput="changeAmount();">
                </div>
                <div class="mb-3">
                  <label for="wscholarship" class="form-label">Amount With Scholarship</label>
                  <input type="number" class="form-control" name="wscholarship" id="wscholarship" placeholder="Amount With Scholarship">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>

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
</script>

<script>
    function changeAmount() {
        if(document.getElementById("scholarshipamount").value == "") {
            document.getElement("wscholarship").value = document.getElement("woscholarship").value;
        } else {
            if(document.getElementById("scholarshippaymenttype").value == "PERCENTAGE") {
                var percentageamount = parseInt(document.getElementById("scholarshipamount").value) / 100;
                var initialdiscountamount = parseInt(document.getElementById("woscholarship").value) * percentageamount;
                document.getElementById("wscholarship").value = parseInt(document.getElementById("woscholarship").value) - initialdiscountamount;
            } else {
                document.getElementById("wscholarship").value = parseInt(document.getElementById("woscholarship").value) - parseInt(document.getElementById("scholarshipamount").value);
            }
        }
    }
</script>

</body>
</html>
