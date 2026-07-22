<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/favicon.png"/>
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
  
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  
  <style type="text/css">
    .dropdown-menu-lg {
      max-width: 550px !important;
      min-width: 450px !important;
    }
    .main-sidebar.sidebar-dark-primary {
      background: #89CFF0 !important;
      border-right: 1px solid #70bfe4;
      box-shadow: 6px 0 18px rgba(31, 45, 61, 0.10) !important;
    }

    .brand-link {
      background: #89CFF0;
      border-bottom: 1px solid #70bfe4 !important;
      padding: 18px 14px 14px;
      text-align: center;
    }

    .brand-link img {
      max-width: 168px;
      width: 100%;
    }

    .sidebar {
      padding: 12px 10px 18px;
    }

    .sidebar a {
      color: #263746 !important;
    }

    .user-panel {
      align-items: center;
      background: transparent;
      border: 0;
      box-shadow: none;
      margin: 4px 0 18px !important;
      padding: 2px 8px 12px !important;
    }

    .user-panel .image {
      padding-left: 0;
    }

    .sidebar-photo-trigger {
      background: transparent;
      border: 0;
      cursor: pointer;
      padding: 0;
      position: relative;
    }

    .sidebar-photo-trigger:focus {
      outline: 2px solid rgba(0, 123, 255, 0.45);
      outline-offset: 3px;
    }

    .sidebar-photo-trigger::after {
      align-items: center;
      background: #007bff;
      border: 2px solid #89CFF0;
      border-radius: 50%;
      bottom: -2px;
      color: #ffffff;
      content: "\f030";
      display: flex;
      font-family: "Font Awesome 5 Free";
      font-size: 9px;
      font-weight: 900;
      height: 18px;
      justify-content: center;
      opacity: 0;
      position: absolute;
      right: -3px;
      transition: opacity .15s ease;
      width: 18px;
    }

    .sidebar-photo-trigger:hover::after,
    .sidebar-photo-trigger:focus::after {
      opacity: 1;
    }

    .row {
        width: 100%;
    }

    .user-panel .image img {
      width: 38px;
      height: 38px;
      object-fit: cover;
      object-position: center;
      border: 2px solid #ffffff;
      box-shadow: 0 0 0 1px #d7e6f1;
    }

    .user-panel .info {
      min-width: 0;
      padding: 0 0 0 10px;
    }

    .user-panel .info a {
      color: #1f2d3d !important;
      font-weight: 700;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .user-panel .info small {
      color: #4b6174;
      display: block;
      font-size: 11px;
      margin-top: 1px;
    }

    .nav-sidebar .nav-item {
      margin-bottom: 3px;
    }

    .nav-sidebar .nav-link {
      align-items: center;
      border-radius: 6px;
      display: flex;
      min-height: 38px;
      padding: 9px 10px;
      transition: background-color .15s ease, color .15s ease, transform .15s ease;
    }

    .nav-sidebar .nav-link p {
      font-weight: 600;
      margin: 0;
    }

    .nav-sidebar .nav-link .nav-icon {
      color: #547086;
      font-size: 14px;
      margin-left: 0;
      margin-right: 10px;
      text-align: center;
      width: 20px;
    }

    .nav-sidebar .nav-link:hover {
      background: #e8f3fb;
      color: #123047 !important;
    }

    .nav-sidebar .nav-link:hover .nav-icon {
      color: #007bff;
    }

    .nav-sidebar .nav-link.active {
      background: #007bff !important;
      box-shadow: 0 8px 16px rgba(0, 123, 255, 0.22);
      color: #ffffff !important;
    }

    .nav-sidebar .nav-link.active .nav-icon,
    .nav-sidebar .nav-link.active p {
      color: #ffffff !important;
    }

    .sidebar-section-label {
      color: #4b6174;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0;
      margin: 14px 8px 7px;
      text-transform: uppercase;
    }

    .sidebar-section-label::before {
      background: rgba(31, 45, 61, 0.16);
      content: "";
      display: block;
      height: 1px;
      margin-bottom: 12px;
      width: 100%;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .brand-link {
      padding-left: 8px;
      padding-right: 8px;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .brand-link img {
      max-width: 44px;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .user-panel {
      justify-content: center;
      padding: 8px !important;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .sidebar-section-label,
    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .user-panel .info {
      display: none;
    }

    .table,
    table.table {
      background: #ffffff;
      border-color: #dbe4ee !important;
      color: #263746;
      font-size: 13px;
      margin-bottom: 0;
    }

    .table-bordered {
      border: 1px solid #dbe4ee !important;
    }

    .table thead th,
    table.dataTable thead th {
      background: #f4f8fb;
      border-bottom: 1px solid #cfdbe7 !important;
      border-color: #dbe4ee !important;
      color: #1f2d3d;
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 0;
      padding: 12px 10px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .table tbody td,
    .table tbody th,
    table.dataTable tbody td,
    table.dataTable tbody th {
      border-color: #e3ebf3 !important;
      padding: 12px 10px;
      vertical-align: top;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #ffffff;
    }

    .table-striped tbody tr:nth-of-type(even) {
      background-color: #f8fafc;
    }

    .table-hover tbody tr:hover,
    .table tbody tr:hover,
    table.dataTable tbody tr:hover {
      background-color: #eef7ff !important;
    }

    .table tfoot th,
    table.dataTable tfoot th {
      background: #f4f8fb;
      border-color: #dbe4ee !important;
      color: #1f2d3d;
      font-size: 12px;
      font-weight: 800;
      padding: 11px 10px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .table td:empty::before {
      color: #9aa8b5;
      content: "[empty]";
    }

    .table .btn,
    table.dataTable .btn {
      border-radius: 6px;
      box-shadow: none;
      font-weight: 700;
    }

    .table .btn-xs,
    table.dataTable .btn-xs {
      align-items: center;
      display: inline-flex;
      height: 31px;
      justify-content: center;
      margin: 2px;
      min-width: 31px;
      padding: 6px 8px;
    }

    .dataTables_wrapper {
      background: #ffffff;
      border: 1px solid #dbe4ee;
      border-radius: 8px;
      overflow-x: auto;
      overflow-y: visible;
      padding: 14px;
    }

    .dataTables_wrapper .row:first-child {
      align-items: center;
      margin-bottom: 12px;
    }

    .dataTables_wrapper .row:last-child {
      align-items: center;
      border-top: 1px solid #edf2f7;
      margin-top: 12px;
      padding-top: 12px;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_info {
      color: #52616f;
      font-size: 13px;
      font-weight: 600;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #cfd8e3;
      border-radius: 6px;
      color: #263746;
      min-height: 34px;
    }

    .dataTables_wrapper .dataTables_filter input {
      margin-left: 8px;
      min-width: 190px;
      padding: 6px 10px;
    }

    .dataTables_wrapper .dataTables_length select {
      margin: 0 6px;
      padding: 4px 24px 4px 8px;
    }

    .dataTables_wrapper .table {
      border-left: 0 !important;
      border-right: 0 !important;
      width: 100% !important;
    }

    .dataTables_wrapper .page-link {
      border-color: #dbe4ee;
      color: #007bff;
      font-weight: 700;
      min-width: 34px;
      text-align: center;
    }

    .dataTables_wrapper .page-item.active .page-link {
      background: #007bff;
      border-color: #007bff;
      color: #ffffff;
    }

    .dataTables_wrapper .page-item.disabled .page-link {
      color: #9aa8b5;
    }

    .card .table,
    .modal .table {
      border-radius: 8px;
      overflow: hidden;
    }

    .card-body > .table:not(.dataTable),
    .modal-body > .table:not(.dataTable) {
      border: 1px solid #dbe4ee;
    }

    .app-create-toolbar {
      align-items: center;
      display: flex;
      margin-bottom: 14px;
      min-height: 38px;
    }

    .card-header.app-create-toolbar {
      background: transparent;
      border-bottom: 0;
      padding: 0 0 14px;
    }

    .app-create-btn {
      align-items: center;
      display: inline-flex;
      font-weight: 700;
      gap: 7px;
      min-height: 38px;
      padding: 8px 13px;
      white-space: nowrap;
    }

    .app-create-btn i {
      font-size: 13px;
    }

    .profile-photo-preview {
      align-items: center;
      display: flex;
      gap: 14px;
    }

    .profile-photo-preview img {
      border: 2px solid #ffffff;
      box-shadow: 0 0 0 1px #d7e6f1;
      height: 74px;
      object-fit: cover;
      object-position: center;
      width: 74px;
    }

    @media (max-width: 767.98px) {
      .dataTables_wrapper {
        padding: 10px;
      }

      .dataTables_wrapper .dataTables_filter,
      .dataTables_wrapper .dataTables_length {
        text-align: left;
      }

      .dataTables_wrapper .dataTables_filter input {
        margin-left: 0;
        margin-top: 6px;
        width: 100%;
      }
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
      <!--<li class="nav-item">-->
      <!--  <a class="nav-link" href="<?php echo base_url(); ?>index.php/messages" title="Messages" target="_blank">-->
      <!--    <i class="far fa-comments" aria-hidden="true"></i>-->
      <!--  </a>-->
      <!--</li>-->
      <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#" title="Notifications" onclick="markasread();">
         <i class="far fa-bell"></i>
         <?php
           if($notifnum != "0") {
         ?>
         <span class="badge badge-warning navbar-badge" id="notifnum"><?php echo $notifnum; ?></span>
         <?php
           }
         ?>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <?php
           foreach ($notif as $row) {
             if ($row->seen == "0") {
           ?>
               <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item"> 
                 <small><b><?php echo $row->details; ?></b></small>
                 <span class="float-right text-muted text-sm"><b><?php echo $row->date_created; ?></b></span>
               </a>
         <?php
             } else {
               ?>
               <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item"> 
                 <small><?php echo $row->details; ?></small>
                 <span class="float-right text-muted text-sm"><?php echo $row->date_created; ?></span>
               </a>
               <?php
             }
           }
         ?>
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
    <a href="<?php echo base_url(); ?>index.php/dashboard" class="brand-link">
      <img src="<?php echo $asset_url; ?>images/logo-new-no-background-2.png" alt="PSC Logo" width="200px">
      <!-- <center><h1>SMIC</h1></center> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php
          $officerPhoto = $this->session->officer_photo;
          if ($this->session->officer_id != "") {
            $this->db->select('officer_name, officer_photo');
            $this->db->from('officer');
            $this->db->where('officer_id', $this->session->officer_id);
            $sidebarOfficerQuery = $this->db->get();
            $sidebarOfficer = $sidebarOfficerQuery->row();
            if ($sidebarOfficer) {
              $officerPhoto = $sidebarOfficer->officer_photo;
              $this->session->set_userdata(array(
                'officer_name' => $sidebarOfficer->officer_name,
                'officer_photo' => $sidebarOfficer->officer_photo
              ));
            }
          }
          if ($officerPhoto == "" || !file_exists(FCPATH."assets/images/".$officerPhoto)) {
            $officerPhoto = "nopic.jpg";
          }
        ?>
        <div class="image">
          <button type="button" class="sidebar-photo-trigger" data-toggle="modal" data-target="#officerPhotoModal" title="Change profile photo" aria-label="Change profile photo">
            <img src="<?php echo $asset_url; ?>images/<?php echo $officerPhoto; ?>" class="img-circle elevation-2" alt="User Image">
          </button>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->officer_name; ?></a>
          <small>Signed in</small>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>dashboard" class="nav-link<?php if($title == 'Dashboard'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <div class="sidebar-section-label">Student Monitoring</div>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>inquiries" class="nav-link<?php if($title == 'Inquiries'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-inbox"></i>
              <p>
                Inquiries
              </p>
            </a>
          </li>
          <?php
  if ($privilege_manage_clients == "1") {
?>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>customerinfo" class="nav-link<?php if($title == 'Client Information'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Client Information
              </p>
            </a>
          </li>
          <?php
  }
?>
          <?php
  if ($privilege_manage_studentapps == "1") {
?>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>applications" class="nav-link<?php if($title == 'Applications'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Applications
              </p>
            </a>
          </li>
          <?php
  }
?>
          <?php
  if ($privilege_manage_clients == "1") {
?>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>scholarships" class="nav-link<?php if($title == 'Scholarships'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Scholarships
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>clientmonitoring" class="nav-link<?php if($title == 'Client Monitoring'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Client Monitoring
              </p>
            </a>
          </li>
         <?php
  }
?>
          <?php
  if ($privilege_view_fees == "1") {
?>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>payments" class="nav-link<?php if($title == 'Payments'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Payments
              </p>
            </a>
          </li>
          <?php
          }
?>
          <li class="nav-item">
            <div class="sidebar-section-label">Administrator</div>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>adminmaintenance" class="nav-link<?php if($title == 'Admin Maintenance'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Admin Maintenance
              </p>
            </a>
          </li>
          <?php
  if ($privilege_manage_providers == "1") {
?>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>schools" class="nav-link<?php if($title == 'Schools and Programs'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Schools and Programs
              </p>
            </a>
          </li>
          <?php
  }
?>
          <?php
  if ($privilege_manage_reporting == "1") {
?>
          <li class="nav-item">
            <a href="<?php echo base_url()."index.php/" ?>reports" class="nav-link<?php if($title == 'Reports'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Reports
              </p>
            </a>
          </li>
          <?php
  }
?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="modal fade" id="officerPhotoModal" tabindex="-1" role="dialog" aria-labelledby="officerPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form class="modal-content" action="<?php echo base_url(); ?>index.php/updateofficerphoto" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="officerPhotoModalLabel">Profile Photo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
          <?php } ?>
          <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
          <?php } ?>
          <div class="profile-photo-preview mb-3">
            <img src="<?php echo $asset_url; ?>images/<?php echo $officerPhoto; ?>" class="img-circle" alt="Current profile photo">
            <div>
              <strong><?php echo $this->session->officer_name; ?></strong>
              <small class="d-block text-muted">Upload a JPG, PNG, GIF, or WEBP image.</small>
            </div>
          </div>
          <div class="form-group mb-0">
            <label for="officerPhotoInput">New photo</label>
            <input type="file" class="form-control-file" id="officerPhotoInput" name="officer_photo" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Upload Photo</button>
        </div>
      </form>
    </div>
  </div>
