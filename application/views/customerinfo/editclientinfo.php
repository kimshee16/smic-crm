<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/logo.png"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $asset_url; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $asset_url; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $asset_url; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $asset_url; ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="<?php echo $asset_url; ?>css/app-tables.css">
  <style type="text/css">
    .select2-container .select2-selection--single{
        height:34px !important;
    }
    .select2-container--default .select2-selection--single{
             border: 1px solid #ccc !important; 
         border-radius: 0px !important; 
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>index.php/signout">
          <i class="fas fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <center><img src="<?php echo $asset_url; ?>images/logomainwhite.png" alt="PSC Logo" width="140px"></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $asset_url; ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->officer_name; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url().'index.php/dashboard'; ?>" class="nav-link<?php if($title == 'Dashboard'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'index.php/customerinfo'; ?>" class="nav-link<?php if($title == 'Client Information'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Client Information
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'index.php/schools'; ?>" class="nav-link<?php if($title == 'Schools and Programs'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Schools and Programs
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'index.php/applications'; ?>" class="nav-link<?php if($title == 'Applications'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Applications
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'index.php/adminmaintenance'; ?>" class="nav-link<?php if($title == 'Admin Maintenance'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Admin Maintenance
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'index.php/scholarships'; ?>" class="nav-link<?php if($title == 'Scholarships'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Scholarships
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
            <div class="card-body">
              
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="clientinfo-tab" data-toggle="tab" href="#clientinfo" role="tab" aria-controls="clientinfo" aria-selected="true">Client Information</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="studentapplication-tab" data-toggle="tab" href="#studentapplication" role="tab" aria-controls="studentapplication" aria-selected="false">Student Application</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="visaapplication-tab" data-toggle="tab" href="#visaapplication" role="tab" aria-controls="visaapplication" aria-selected="false">Visa Applications</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="visaeoi-tab" data-toggle="tab" href="#visaeoi" role="tab" aria-controls="visaeoi" aria-selected="false">Visa Expressions of Interest</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="visaaccount-tab" data-toggle="tab" href="#visaaccount" role="tab" aria-controls="visaaccount" aria-selected="false">Visa Accounts</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Required Documents</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="scholarshipallocation-tab" data-toggle="tab" href="#scholarshipallocation" role="tab" aria-controls="scholarshipallocation" aria-selected="false">Scholarship Allocation</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">Payments</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="clientinfo" role="tabpanel" aria-labelledby="clientinfo-tab">
                <br>
                <form action="Adminmaintenancecontroller/do_upload" method="post" enctype="multipart/form-data">
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
                      ?>
                <?php
                  foreach($client as $row1) {
                    $dob = $row1->client_dob_year."-".$row1->client_dob_month."-".$row1->client_dob_day;
                    $ve = $row1->client_ve_year."-".$row1->client_ve_month."-".$row1->client_ve_day;
                ?>

                <div class="row">
                  <div class="col-6">
                    <a href="<?php echo base_url().'index.php/customerinfo' ?>"><i class="nav-icon fas fa-chevron-left"></i> Back</a>
                  </div>
                  <div class="col-3">
                    <label for="amount" class="form-label">Update Photo:</label>
                        <input type="file" class="form-control" name="clientphoto">
                  </div>
                  <div class="col-3">
                    <img src="<?php echo $asset_url; ?>images/<?php echo $row1->client_photo; ?>" style="width: 150px; height: 150px;">
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                      <div class="mb-3">
                        <label for="amount" class="form-label">Client ID</label>
                        <input type="text" class="form-control" name="clientid" value="<?php echo $row1->client_id; ?>" readonly>
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" value="<?php echo $row1->client_firstname; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Surname</label>
                        <input type="text" class="form-control" name="lastname" value="<?php echo $row1->client_surname; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" value="<?php echo $row1->client_middlename; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="payee" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="birthdate" value="<?php echo $dob; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="payee" class="form-label">Visa Expiry Date</label>
                        <input type="date" class="form-control" name="vedate" value="<?php echo $ve; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="payee" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phoneno" value="<?php echo $row1->client_phoneno; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" name="mobileno" value="<?php echo $row1->client_mobileno; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Overseas Mobile Number</label>
                        <input type="text" class="form-control" name="Overseasmobileno" value="<?php echo $row1->client_overseas_mobileno; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $row1->client_email; ?>">
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="mb-3">
                        <label for="amount" class="form-label">Client Address</label>
                        <input type="text" class="form-control" name="clientaddress" value="<?php echo $row1->client_address; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Suburb</label>
                        <input type="text" class="form-control" name="suburb" value="<?php echo $row1->client_suburb; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="<?php echo $row1->client_state; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Postcode</label>
                        <input type="text" class="form-control" name="postcode" value="<?php echo $row1->client_postcode; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Overseas Address</label>
                        <input type="text" class="form-control" name="overseasaddress" value="<?php echo $row1->client_overseas_address; ?>">
                      </div> 
                      <div class="mb-3">
                        <label for="amount" class="form-label">Comments</label>
                        <input type="text" class="form-control" name="comment" value="<?php echo $row1->client_comments; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Qualifications</label>
                        <input type="text" class="form-control" name="qualification" value="<?php echo $row1->client_qualifications; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="amount" class="form-label">Attended Event</label>
                        <div class="row">
                          <div class="col-6">
                            <input type="text" class="form-control" name="event" value="<?php echo $row1->client_event_id; ?>" readonly>
                          </div>
                          <div class="col-6">
                            <select class="form-control" name="selectevent">
                              <option value="0">Select Event</option>
                              <?php
                                foreach($events as $row2) {
                              ?>
                                <option value="<?php echo $row2->event_id; ?>"><?php echo $row2->event_name; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div> 
                      <div class="mb-3">
                        <label for="amount" class="form-label">Administering Office</label>
                        <div class="row">
                          <div class="col-6">
                            <input type="text" class="form-control" name="office" value="<?php echo $row1->client_office_id; ?>" readonly>
                          </div>
                          <div class="col-6">
                            <select class="form-control" name="selectoffice">
                              <option value="0">Select Office</option>
                              <?php
                                foreach($offices as $row2) {
                              ?>
                                <option value="<?php echo $row2->offices_id; ?>"><?php echo $row2->offices_code; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div> 
                      <div class="mb-3">
                        <label for="amount" class="form-label">Client Status</label>
                        <div class="row">
                          <div class="col-6">
                            <input type="text" class="form-control" name="flag" value="<?php echo $row1->client_flag; ?>" readonly>
                          </div>
                          <div class="col-6">
                            <select class="form-control" name="selectflag">
                              <option value="">Select Flag</option>
                              <option value="active">active</option>
                              <option value="inactive">inactive</option>
                            </select>
                          </div>
                        </div>
                      </div>    
                  </div>
                      
                  </div>
                  <?php
                    }
                  ?>

                <button type="submit" class="btn btn-primary">Submit</button> 
              </form>

                  </div>

                  <div class="tab-pane fade" id="studentapplication" role="tabpanel" aria-labelledby="studentapplication-tab">
                    <br>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Student</th>
                        <th>School</th>
                        <th>Program</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($student_application as $row) {
                        echo "<tr>
                          <td>".$row->client_surname.", ".$row->client_firstname."</td>
                          <td>".$row->provider_name."</td>
                          <td>".$row->studentapp_course_name."</td>
                          <td>".$row->studentapp_record_created_date."</td>
                          <td><a href='#' class='btn btn-primary btn-xs'>Edit</a></td>
                        </tr>";
                      }
                      ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Student</th>
                        <th>School</th>
                        <th>Program</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                      </tr>
                      </tfoot>
                    </table>
                    <a href="<?php echo base_url(); ?>index.php/newapplication/103" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Application</a>
                  </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Ramirez</div>
                  <div class="tab-pane fade" id="visaapplication" role="tabpanel" aria-labelledby="visaapplication-tab">
                      <br>
                      <table id="visaapplicationtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td><a href='deactivatescholarshipallocation/".$row->csid."' class='btn btn-primary btn-xs'>Deactivate</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th> 
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                    <a href="<?php echo base_url(); ?>index.php/newscholarshipallocation/103" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship Allocation</a>
                  </div>
                  <div class="tab-pane fade" id="visaeoi" role="tabpanel" aria-labelledby="visaeoi-tab">
                      <br>
                      <table id="visaeoitable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td><a href='deactivatescholarshipallocation/".$row->csid."' class='btn btn-primary btn-xs'>Deactivate</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                    <a href="<?php echo base_url(); ?>index.php/newscholarshipallocation/103" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship Allocation</a>
                  </div>
                  <div class="tab-pane fade" id="visaaccount" role="tabpanel" aria-labelledby="visaaccount-tab">
                      <br>
                      <table id="visaaccounttable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td><a href='deactivatescholarshipallocation/".$row->csid."' class='btn btn-primary btn-xs'>Deactivate</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                    <a href="<?php echo base_url(); ?>index.php/newscholarshipallocation/103" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship Allocation</a>
                  </div>
                  <div class="tab-pane fade" id="scholarshipallocation" role="tabpanel" aria-labelledby="scholarshipallocation-tab">
                      <br>
                      <table id="scholarshipallocationtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td><a href='deactivatescholarshipallocation/".$row->csid."' class='btn btn-primary btn-xs'>Deactivate</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                    <a href="<?php echo base_url(); ?>index.php/newscholarshipallocation/103" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship Allocation</a>
                  </div>
                  <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                      <br>
                      <table id="paymentstable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($clientscholarship as $row) {
                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td><a href='deactivatescholarshipallocation/".$row->csid."' class='btn btn-primary btn-xs'>Deactivate</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client</th>
                          <th>Scholarship</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                    <a href="<?php echo base_url(); ?>index.php/newscholarshipallocation/103" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Scholarship Allocation</a>
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
  <footer class="main-footer">
    <strong>@2024 SMIC CRM.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

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
    $("#studentapplicationtable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#visaapplicationtable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#visaeoitable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#visaaccounttable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#scholarshipallocationtable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#paymentstable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

  });

  $('.select2').select2();

</script>

</body>
</html>
