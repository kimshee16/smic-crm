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
          if(isset($_GET['success'])) {
          ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success transferred inquirer to client table!</strong>
              <button type="button" class="close" id="closealert" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
          }
          ?>
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <input type="hidden" value="<?php echo base_url(); ?>" id="baseurl">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Inquirer Name</th>
                  <th>Birthday</th>
                  <th>Mobile Number</th>
                  <th>Email Address</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Resume</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $roleass = "";
                foreach ($officerassignment as $row5) {
                    $roleass = $row5->region_name;
                }
                echo $roleass;
                foreach ($inquiries as $row) {
                  
                //   if($row->inquiries_country == $roleass && $roleid == '5') {
                      if($row->inquiries_status == "Transferred") {
                            $transferbutton = "";
                          } else {
                            $transferbutton = "<a href='transferinquirytoclient/".$row->inquiries_id."' class='btn btn-primary btn-xs customRedirect' title='Approve ".$row->inquiries_surname.", ".$row->inquiries_firstname." ".$row->inquiries_middlename." as Client'><i class='fa fa-check' aria-hidden='true'></i></a>";
                          }
        
                          if($row->inquiries_resume != "") {
                            $filedata = "<a href='".$asset_url."resume/".$row->inquiries_resume."'><img src='".$asset_url."images/fileicon.png' style='width: 20px;'> ".$row->inquiries_resume."</a>";
                          } else {
                            $filedata = "";
                          }
        
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteinquiry = "<a href='deleteinquiry/".$row->inquiries_id."' class='btn btn-danger btn-xs confirmation' title='Delete Inquiry'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deleteinquiry = "";
                          }
        
                          echo "<tr>
                            <td>".$row->inquiries_surname.", ".$row->inquiries_firstname." ".$row->inquiries_middlename."</td>
                            <td>".$row->inquiries_dob_month."/".$row->inquiries_dob_day."/".$row->inquiries_dob_year."</td>
                            <td>".$row->inquiries_mobileno."</td>
                            <td>".$row->inquiries_email."</td>
                            <td>".$row->inquiries_address."</td>
                            <td>".$row->inquiries_status."</td>
                            <td>".$filedata."</td>
                            <td><input type='hidden' value='".$row->inquiries_email."'><a href='#' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#viewInquiryModal' data-inquiriesid='".$row->inquiries_id."' title='View Inquiry'><i class='fa fa-eye' aria-hidden='true'></i></a> ".$transferbutton." ".$deleteinquiry."</td>
                            </tr>";
                        }
                // }
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
    <div class="modal fade bd-example-modal-lg" id="viewInquiryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Name: <label id="inquiriesname"></label></br>
            Birthday: <label id="inquiriesbirthday"></label></br>
            Phone #: <label id="inquiriesphone"></label></br>
            Mobile #: <label id="inquiriesmobile"></label></br>
            Email Address: <label id="inquiriesemail"></label></br>
            Qualifications: <label id="inquiriesqualifications"></label></br>
            Dependence: <label id="inquiriesdependence"></label></br>
            Civil Status: <label id="inquiriescivilstatus"></label></br>
            Country: <label id="inquiriescountry"></label></br>
            City: <label id="inquiriescity"></label></br>
            Notes: <label id="inquiriesnotes"></label></br>
            Status: <label id="inquiriesstatus"></label></br>
            Nationality: <label id="inquiriesnationality"></label></br>
            Resume: <label id="inquiriesresume"></label></br>
          </div>
        </div>
      </div>
    </div>

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
      "ordering": false,
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

  $('#viewInquiryModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var inquiriesid = button.data('inquiriesid') // Extract info from data-* attributes
    var baseurl = $("#baseurl").val();
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    //modal.find('.modal-title').text('New message to ' + recipient)
    //modal.find('.modal-body input').val(recipient)
    $.ajax({
        type: "GET",
        url: baseurl + "index.php/getsingleinquiry/" + inquiriesid,
        success: function(data) {
          var obj = JSON.parse(data);
          for (var x = 0; x < obj.length; x++) {
              document.getElementById("inquiriesname").innerText = obj[x].inquiries_surname + ", " + obj[x].inquiries_firstname + " " + obj[x].inquiries_middlename;
              document.getElementById("inquiriesbirthday").innerText = obj[x].inquiries_dob_month + "/" + obj[x].inquiries_dob_day + "/" + obj[x].inquiries_dob_year;
              document.getElementById("inquiriesphone").innerText = obj[x].inquiries_phoneno;
              document.getElementById("inquiriesmobile").innerText = obj[x].inquiries_mobileno;
              document.getElementById("inquiriesemail").innerText = obj[x].inquiries_email;
              document.getElementById("inquiriesqualifications").innerText = obj[x].inquiries_qualifications;
              document.getElementById("inquiriesdependence").innerText = obj[x].inquiries_dependents;
              document.getElementById("inquiriescivilstatus").innerText = obj[x].inquiries_civilstatus;
              document.getElementById("inquiriescountry").innerText = obj[x].inquiries_country;
              document.getElementById("inquiriescity").innerText = obj[x].inquiries_city;
              document.getElementById("inquiriesnotes").innerText = obj[x].inquiries_notes;
              document.getElementById("inquiriesstatus").innerText = obj[x].inquiries_status;
              document.getElementById("inquiriesnationality").innerText = obj[x].inquiries_nationality;
              document.getElementById("inquiriesresume").innerText = obj[x].inquiries_resume;
          }
        },
        error: function(error) {
          alert(error);
        }
    });

  })

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
  
  document.getElementById("closealert").onclick = function() {
    let url = new URL(window.location.href);
    url.searchParams.delete("success");
    let updatedUrl = url.toString();
    window.location.href = updatedUrl;
  }

  var elems = document.getElementsByClassName('confirmation');
  var confirmIt = function (e) {
      if (!confirm('Are you sure to delete the entry?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
  }

</script>
<script type='text/javascript'>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".customRedirect").forEach(function (link) {
            link.addEventListener("click", function (event) {
                event.preventDefault();

                let redirectUrl = this.getAttribute("href");
                let email = this.parentElement.children[0].value;
                
                fetch("https://hook.eu2.make.com/71bdysz2v9hrwm0j2q7t5ypamxjmjgin?type=activateaccount&email="+email, {
                    method: "POST"
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Webhook Response:", data);
                    window.location.href = redirectUrl;
                })
                .catch(error => {
                    console.error("Error sending data to webhook:", error);
                    alert("An error occurred. Please try again.");
                });
            });
        });
    });
</script>
</body>
</html>