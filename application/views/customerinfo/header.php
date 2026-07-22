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
  <style type="text/css">
    .select2-container .select2-selection--single{
        height:34px !important;
    }
    .select2-container--default .select2-selection--single{
             border: 1px solid #ccc !important; 
         border-radius: 0px !important; 
    }
    .dropdown-menu-lg {
      max-width: 550px !important;
      min-width: 450px !important;
    }
    .sidebar-dark-primary {
      background-color: #89CFF0 !important;
    }
    .sidebar a {
      color: #000 !important;
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
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>index.php/messages" title="Messages" target="_blank">
          <i class="far fa-comments" aria-hidden="true"></i>
        </a>
      </li>
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
    <a href="index3.html" class="brand-link">
      <center><img src="<?php echo $asset_url; ?>images/smic-logo.png" alt="PSC Logo" width="200px"></center>
      <!-- <center><h1>SMIC</h1></center> -->
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
            <a href="dashboard" class="nav-link<?php if($title == 'Dashboard'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adminmaintenance" class="nav-link<?php if($title == 'Admin Maintenance'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Admin Maintenance
              </p>
            </a>
          </li>
          <?php
  if ($privilege_manage_providers == "1") {
?>
          <li class="nav-item">
            <a href="schools" class="nav-link<?php if($title == 'Schools and Programs'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Schools and Programs
              </p>
            </a>
          </li>
          <?php
  }
?>
          <li class="nav-item">
            <a href="inquiries" class="nav-link<?php if($title == 'Inquiries'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inquiries
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="customerinfo" class="nav-link<?php if($title == 'Client Information'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Client Information
              </p>
            </a>
          </li>
          <?php
  if ($privilege_manage_studentapps == "1") {
?>
          <li class="nav-item">
            <a href="applications" class="nav-link<?php if($title == 'Applications'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Applications
              </p>
            </a>
          </li>
          <?php
  }
?>
          <li class="nav-item">
            <a href="scholarships" class="nav-link<?php if($title == 'Scholarships'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Scholarships
              </p>
            </a>
          </li>
          <?php
  if ($privilege_manage_reporting == "1") {
?>
          <li class="nav-item">
            <a href="reports" class="nav-link<?php if($title == 'Reports'){ echo ' active';} ?>">
              <i class="nav-icon fas fa-th"></i>
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
