<?php
    $this->load->view('layout/header');

    $active_admin_page = isset($active_admin_page) ? $active_admin_page : 'offices';
    $admin_page_urls = array(
      'offices' => base_url().'index.php/adminmaintenance',
      'officers' => base_url().'index.php/adminmaintenance/officers',
      'officer-assignment' => base_url().'index.php/adminmaintenance/officer-assignment',
      'region' => base_url().'index.php/adminmaintenance/region',
      'events' => base_url().'index.php/adminmaintenance/events',
      'privileges' => base_url().'index.php/adminmaintenance/privileges',
      'email-contents' => base_url().'index.php/adminmaintenance/email-contents',
      'parameters' => base_url().'index.php/adminmaintenance/parameters'
    );
?>
<style>
  .admin-maintenance-page .tab-pane > .app-create-toolbar {
    margin-top: 14px;
    margin-bottom: 6px;
    padding-bottom: 0;
  }

  .admin-maintenance-page .tab-pane > .card-body {
    padding-top: 8px;
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper admin-maintenance-page">
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
      <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
            <ul class="nav nav-tabs" id="MaintenanceTab" role="tablist">
                  <?php
                    if ($privilege_manage_offices == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'offices' ? 'active' : ''; ?>" id="offices1-tab" href="<?php echo $admin_page_urls['offices']; ?>" role="tab" aria-controls="offices1" aria-selected="<?php echo $active_admin_page == 'offices' ? 'true' : 'false'; ?>">Offices</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_officers == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'officers' ? 'active' : ''; ?>" id="officer1-tab" href="<?php echo $admin_page_urls['officers']; ?>" role="tab" aria-controls="officer1" aria-selected="<?php echo $active_admin_page == 'officers' ? 'true' : 'false'; ?>">Officers</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'officer-assignment' ? 'active' : ''; ?>" id="officerassignment-tab" href="<?php echo $admin_page_urls['officer-assignment']; ?>" role="tab" aria-controls="officerassignment" aria-selected="<?php echo $active_admin_page == 'officer-assignment' ? 'true' : 'false'; ?>">Officer Assignment</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'region' ? 'active' : ''; ?>" id="region1-tab" href="<?php echo $admin_page_urls['region']; ?>" role="tab" aria-controls="region1" aria-selected="<?php echo $active_admin_page == 'region' ? 'true' : 'false'; ?>">Region</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_events == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'events' ? 'active' : ''; ?>" id="events-tab" href="<?php echo $admin_page_urls['events']; ?>" role="tab" aria-controls="events" aria-selected="<?php echo $active_admin_page == 'events' ? 'true' : 'false'; ?>">Events</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_privilege == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'privileges' ? 'active' : ''; ?>" id="priviledges-tab" href="<?php echo $admin_page_urls['privileges']; ?>" role="tab" aria-controls="priviledges" aria-selected="<?php echo $active_admin_page == 'privileges' ? 'true' : 'false'; ?>">Privileges</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_parameters == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'email-contents' ? 'active' : ''; ?>" id="emailcontent-tab" href="<?php echo $admin_page_urls['email-contents']; ?>" role="tab" aria-controls="emailcontent" aria-selected="<?php echo $active_admin_page == 'email-contents' ? 'true' : 'false'; ?>">Email Contents</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link maintenancetabs <?php echo $active_admin_page == 'parameters' ? 'active' : ''; ?>" id="parameters-tab" href="<?php echo $admin_page_urls['parameters']; ?>" role="tab" aria-controls="parameters" aria-selected="<?php echo $active_admin_page == 'parameters' ? 'true' : 'false'; ?>">Parameters</a>
                  </li>
                  <?php
                    }
                  ?>
                </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane <?php echo $active_admin_page == 'offices' ? 'active' : ''; ?>" id="offices1" role="tabpanel" aria-labelledby="offices-tab">
                  <div class="card-header app-create-toolbar">
                    <a href="<?php echo base_url(); ?>index.php/newoffice" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Office</a>
                  </div>
                  <div class="card-body">
                    <table id="offices" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Code</th>
                        <th>Address 1</th>
                        <th>Address 2</th>
                        <th>Phone #</th>
                        <th>Fax #</th>
                        <th>Email</th>
                        <th>Flag</th>
                        <th>Manager</th>
                        <th>Region</th>
                        <th>Notes</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($offices as $row) {
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteoffices = "<a href='".base_url()."index.php/deleteoffice/".$row->offices_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                              $deleteoffices = "";
                        }

                        echo "<tr>
                          <td>".$row->offices_code."</td>
                          <td>".$row->offices_address1."</td>
                          <td>".$row->offices_address2."</td>
                          <td>".$row->offices_phoneno."</td>
                          <td>".$row->offices_faxno."</td>
                          <td>".$row->offices_email."</td>
                          <td>".$row->offices_flag."</td>
                          <td>".$row->officer_name."</td>
                          <td>".$row->region_name."</td>
                          <td>".$row->offices_notes."</td>
                          <td><a href='".base_url()."index.php/editoffice/".$row->offices_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteoffices."</td>
                        </tr>";
                      }
                      ?>
                      </tbody>
                    </table>
                  </div>

              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'officers' ? 'active' : ''; ?>" id="officer1" role="tabpanel" aria-labelledby="officer1-tab">
                  <div class="card-header app-create-toolbar">
                    <a href="<?php echo base_url(); ?>index.php/newofficer" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Officer</a>
                  </div>

                  <div class="card-body">
                    <table id="officer" class="table table-bordered table-striped officer1">
                      <thead>
                      <tr>
                        <th>Officer Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($officer as $row) {
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteofficer = "<a href='".base_url()."index.php/deactivateofficer/".$row->officer_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                              $deleteofficer = "";
                        }

                        echo "<tr>
                          <td>".$row->officer_name."</td>
                          <td>".$row->email."</td>
                          <td>".$row->officer_role."</td>
                          <td>".$row->officer_status."</td>
                          <td>".$row->officer_last_logged_date."</td>
                          <td><a href='".base_url()."index.php/editofficer/".$row->officer_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteofficer."</td>
                        </tr>";
                      }
                      ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Officer Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>

              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'officer-assignment' ? 'active' : ''; ?>" id="officerassignment" role="tabpanel" aria-labelledby="officerassignment-tab">
                  <div class="card-header app-create-toolbar">
                    <a href="<?php echo base_url(); ?>index.php/newassignment" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Region Assignment</a>
                  </div>

                  <div class="card-body">
                    <table id="assignment" class="table table-bordered table-striped officerassignment">
                      <thead>
                      <tr>
                        <th>Officer Name</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Date Created</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($officerassignment as $row) {
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteoa = "<a href='".base_url()."index.php/deactivateassignment/".$row->oaid."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                              $deleteoa = "";
                        }

                        echo "<tr>
                          <td>".$row->officer_name."</td>
                          <td>".$row->region_name."</td>
                          <td>".$row->city."</td>
                          <td>".$row->datecreated."</td>
                          <td><a href='".base_url()."index.php/editassignment/".$row->oaid."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteoa."</td>
                        </tr>";
                      }
                      ?>
                      </tbody>
                    </table>
                  </div>

              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'region' ? 'active' : ''; ?>" id="region1" role="tabpanel" aria-labelledby="region1-tab">
                  <div class="card-header app-create-toolbar">
                    <a href="<?php echo base_url(); ?>index.php/newregion" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Region</a>
                  </div>

                  <div class="card-body">
                    <table id="region" class="table table-bordered table-striped region1">
                      <thead>
                      <tr>
                        <th>Region</th>
                        <th>Region Description</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($region as $row2) {
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteregion = "<a href='".base_url()."index.php/deleteregion/".$row2->region_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                              $deleteregion = "";
                        }

                        echo "<tr>
                          <td>".$row2->region_name."</td>
                          <td>".$row2->region_description."</td>
                          <td><a href='".base_url()."index.php/editregion/".$row2->region_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteregion."</td>
                        </tr>";
                      }
                      ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Region</th>
                        <th>Region Description</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>

              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'events' ? 'active' : ''; ?>" id="events" role="tabpanel" aria-labelledby="events-tab">
                  <div class="card-header app-create-toolbar">
                    <a href="<?php echo base_url(); ?>index.php/newevent" class="btn btn-primary app-create-btn"><i class="fas fa-plus" aria-hidden="true"></i> New Event</a>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="event" class="table table-bordered table-striped region1">
                      <thead>
                      <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
                        <th>Event Location</th>
                        <th>Event Region</th>
                        <th>Event Info</th>
                        <th>Event Comments</th>
                        <th>Event Photo</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($events as $row2) {
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteevent = "<a href='".base_url()."index.php/deleteevent/".$row2->event_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                              $deleteevent = "";
                        }

                        if ($row2->event_photo != "") {
                          $photo = "<img src='".$asset_url."images/".$row2->event_photo."' width='150px'>";
                        } else {
                          $photo = "";
                        }
                        echo "<tr>
                          <td>".$row2->event_name."</td>
                          <td>".$row2->event_date."</td>
                          <td>".$row2->event_time."</td>
                          <td>".$row2->event_location."</td>
                          <td>".$row2->event_region."</td>
                          <td>".$row2->event_info."</td>
                          <td>".$row2->event_comments."</td>
                          <td>".$photo."</td>
                          <td><a href='".base_url()."index.php/editevent/".$row2->event_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteevent."</td>
                        </tr>";
                      }
                      ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
                        <th>Event Location</th>
                        <th>Event Region</th>
                        <th>Event Info</th>
                        <th>Event Comments</th>
                        <th>Event Photo</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'email-contents' ? 'active' : ''; ?>" id="emailcontent" role="tabpanel" aria-labelledby="emailcontent-tab">
                  <div class="card-body">
                     <?php
                      foreach ($emailcontents as $row6) {
                      ?>
                    <form action="<?php echo base_url(); ?>index.php/saveemailcontent" method="post">
                      <h5>Inquiry Auto Response Email</h5>
                      <div class="mb-3">
                        <label for="iaremailheader" class="form-label">Email header</label>
                        <textarea class="form-control" name="iaremailheader" placeholder="Email header" required><?php echo $row6->iaremailheader; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="iaremailbody" class="form-label">Email body</label>
                        <textarea class="form-control" name="iaremailbody" placeholder="Email body" required><?php echo $row6->iaremailbody; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="iaremailfooter" class="form-label">Email footer</label>
                        <textarea class="form-control" name="iaremailfooter" placeholder="Email footer" required><?php echo $row6->iaremailfooter; ?></textarea>
                      </div>
                      <h5>Marketing Email</h5>
                      <div class="mb-3">
                        <label for="memailheader" class="form-label">Email header</label>
                        <textarea class="form-control" name="memailheader" placeholder="Email header" required><?php echo $row6->memailheader; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailbody" class="form-label">Email body</label>
                        <textarea class="form-control" name="memailbody" placeholder="Email body" required><?php echo $row6->memailbody; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailfooter" class="form-label">Email footer</label>
                        <textarea class="form-control" name="memailfooter" placeholder="Email footer" required><?php echo $row6->memailfooter; ?></textarea>
                      </div>
                      <h5>Reminder Email</h5>
                      <div class="mb-3">
                        <label for="memailheader" class="form-label">Email header</label>
                        <textarea class="form-control" name="remailheader" placeholder="Email header" required><?php echo $row6->remailheader; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailbody" class="form-label">Email body</label>
                        <textarea class="form-control" name="remailbody" placeholder="Email body" required><?php echo $row6->remailbody; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailfooter" class="form-label">Email footer</label>
                        <textarea class="form-control" name="remailfooter" placeholder="Email footer" required><?php echo $row6->remailfooter; ?></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <?php
                      }
                      ?>
                  </div>
                  <!-- /.card-body -->
              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'parameters' ? 'active' : ''; ?>" id="parameters" role="tabpanel" aria-labelledby="parameters-tab">
                  <div class="card-body">
                     <?php
                      foreach ($parameters as $row7) {
                      ?>
                    <form action="<?php echo base_url(); ?>index.php/saveparameters" method="post">
                      <h5>Parameters</h5>
                      <div class="mb-3">
                        <label for="iaremailheader" class="form-label">Account Name</label>
                        <textarea class="form-control" name="account_name" placeholder="Email header" required><?php echo $row7->account_name; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="iaremailbody" class="form-label">Bank Name</label>
                        <textarea class="form-control" name="bank_name" placeholder="Email body" required><?php echo $row7->bank_name; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="iaremailfooter" class="form-label">Branch Name</label>
                        <textarea class="form-control" name="branch_name" placeholder="Email footer" required><?php echo $row7->branch_name; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailheader" class="form-label">BSB No</label>
                        <textarea class="form-control" name="bsb_no" placeholder="Email header" required><?php echo $row7->bsb_no; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailbody" class="form-label">Account No</label>
                        <textarea class="form-control" name="account_no" placeholder="Email body" required><?php echo $row7->account_no; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailfooter" class="form-label">Invoice Due Date</label>
                        <textarea class="form-control" name="invoice_due_day" placeholder="Email footer" required><?php echo $row7->invoice_due_day; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailheader" class="form-label">Invoice Prefix</label>
                        <textarea class="form-control" name="invoice_prefix" placeholder="Email header" required><?php echo $row7->invoice_prefix; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailbody" class="form-label">Address</label>
                        <textarea class="form-control" name="address" placeholder="Email body" required><?php echo $row7->address; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailfooter" class="form-label">Phone no</label>
                        <textarea class="form-control" name="phoneno" placeholder="Email footer" required><?php echo $row7->phoneno; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailfooter" class="form-label">Fax no</label>
                        <textarea class="form-control" name="faxno" placeholder="Email footer" required><?php echo $row7->faxno; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailheader" class="form-label">Email</label>
                        <textarea class="form-control" name="email" placeholder="Email header" required><?php echo $row7->email; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailbody" class="form-label">ABN</label>
                        <textarea class="form-control" name="abn" placeholder="Email body" required><?php echo $row7->abn; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="memailfooter" class="form-label">Redeemable Point</label>
                        <textarea class="form-control" name="redeemable_point" placeholder="Email footer" required><?php echo $row7->redeemable_point; ?></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <?php
                      }
                      ?>
                  </div>
                  <!-- /.card-body -->
              </div>
              <div class="tab-pane <?php echo $active_admin_page == 'privileges' ? 'active' : ''; ?>" id="priviledges" role="tabpanel" aria-labelledby="priviledges-tab">
                  <div class="card-body">
                    <form action="<?php echo base_url(); ?>index.php/updatepriviledge" method="post">
                     <table style="font-size: 10px;">
                      <thead>
                        <thead>
                          <tr>
                          <th></th> 
                          <th>Manage Clients</th>        
                          <th>Manage Officers</th>          
                          <th>Manage Education Providers</th>           
                          <th>Manage Student Applications</th>          
                          <th>Manage Student Documents</th>           
                          <th>Manage Commissions</th>           
                          <th>Manage VISA Applications</th>           
                          <th>Manage PR Documents</th>          
                          <th>Manage PR Fee Received</th>           
                          <th>Manage PR Fee Paid</th>           
                          <th>Manage Reporting</th>           
                          <th>Manage Channels</th>          
                          <th>Manage Offices</th>           
                          <th>Manage Parameters</th>         
                          <th>Manage Privileges</th>          
                          <th>Manage Database</th>          
                          <th>View Fees</th>          
                          <th>Staff Bonus</th>          
                          <th>Manage Events</th>
                          </tr> 
                        </thead>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($privilege as $row8) {
                        if($row8->privilege_id == "1"){
                          $name = "Admin";
                        }
                        elseif($row8->privilege_id == "2"){
                          $name = "Manager";
                        }
                        elseif($row8->privilege_id == "3"){
                          $name = "Staff";
                        }
                        elseif($row8->privilege_id == "4"){
                          $name = "Account";
                        }
                        elseif($row8->privilege_id == "5"){
                          $name = "Regional Manager";
                        }

                        if($row8->privilege_manage_clients == "1"){
                          $privilege_manage_clients = "<input type='checkbox' name='privilege_manage_clients' checked>";
                        }
                        elseif($row8->privilege_manage_clients == "0"){
                          $privilege_manage_clients = "<input type='checkbox' name='privilege_manage_clients'>";
                        }

                        if($row8->privilege_manage_officers == "1"){
                          $privilege_manage_officers = "<input type='checkbox' name='privilege_manage_officers' checked>";
                        }
                        elseif($row8->privilege_manage_officers == "0"){
                          $privilege_manage_officers = "<input type='checkbox' name='privilege_manage_officers'>";
                        }

                        if($row8->privilege_manage_providers == "1"){
                          $privilege_manage_providers = "<input type='checkbox' name='privilege_manage_providers' checked>";
                        }
                        elseif($row8->privilege_manage_providers == "0"){
                          $privilege_manage_providers = "<input type='checkbox' name='privilege_manage_providers'>";
                        }

                        if($row8->privilege_manage_studentapps == "1"){
                          $privilege_manage_studentapps = "<input type='checkbox' name='privilege_manage_studentapps' checked>";
                        }
                        elseif($row8->privilege_manage_studentapps == "0"){
                          $privilege_manage_studentapps = "<input type='checkbox' name='privilege_manage_studentapps'>";
                        }

                        if($row8->privilege_manage_studentdocs == "1"){
                          $privilege_manage_studentdocs = "<input type='checkbox' name='privilege_manage_studentdocs' checked>";
                        }
                        elseif($row8->privilege_manage_studentdocs == "0"){
                          $privilege_manage_studentdocs = "<input type='checkbox' name='privilege_manage_studentdocs'>";
                        }

                        if($row8->privilege_manage_commissions == "1"){
                          $privilege_manage_commissions = "<input type='checkbox' name='privilege_manage_commissions' checked>";
                        }
                        elseif($row8->privilege_manage_commissions == "0"){
                          $privilege_manage_commissions = "<input type='checkbox' name='privilege_manage_commissions'>";
                        }

                        if($row8->privilege_manage_prapps == "1"){
                          $privilege_manage_prapps = "<input type='checkbox' name='privilege_manage_prapps' checked>";
                        }
                        elseif($row8->privilege_manage_prapps == "0"){
                          $privilege_manage_prapps = "<input type='checkbox' name='privilege_manage_prapps'>";
                        }

                        if($row8->privilege_manage_prdocs == "1"){
                          $privilege_manage_prdocs = "<input type='checkbox' name='privilege_manage_prdocs' checked>";
                        }
                        elseif($row8->privilege_manage_prdocs == "0"){
                          $privilege_manage_prdocs = "<input type='checkbox' name='privilege_manage_prdocs'>";
                        }

                        if($row8->privilege_manage_prfeereceived == "1"){
                          $privilege_manage_prfeereceived = "<input type='checkbox' name='privilege_manage_prfeereceived' checked>";
                        }
                        elseif($row8->privilege_manage_prfeereceived == "0"){
                          $privilege_manage_prfeereceived = "<input type='checkbox' name='privilege_manage_prfeereceived'>";
                        }

                        if($row8->privilege_manage_prfeepaid == "1"){
                          $privilege_manage_prfeepaid = "<input type='checkbox' name='privilege_manage_prfeepaid' checked>";
                        }
                        elseif($row8->privilege_manage_prfeepaid == "0"){
                          $privilege_manage_prfeepaid = "<input type='checkbox' name='privilege_manage_prfeepaid'>";
                        }

                        if($row8->privilege_manage_reporting  == "1"){
                          $privilege_manage_reporting = "<input type='checkbox' name='privilege_manage_reporting' checked>";
                        }
                        elseif($row8->privilege_manage_reporting  == "0"){
                          $privilege_manage_reporting = "<input type='checkbox' name='privilege_manage_reporting'>";
                        }
                        if($row8->privilege_manage_channel == "1"){
                          $privilege_manage_channel = "<input type='checkbox' name='privilege_manage_channel' checked>";
                        }
                        elseif($row8->privilege_manage_channel == "0"){
                          $privilege_manage_channel = "<input type='checkbox' name='privilege_manage_channel'>";
                        }

                        if($row8->privilege_manage_parameters == "1"){
                          $privilege_manage_parameters = "<input type='checkbox' name='privilege_manage_parameters' checked>";
                        }
                        elseif($row8->privilege_manage_parameters == "0"){
                          $privilege_manage_parameters = "<input type='checkbox' name='privilege_manage_parameters'>";
                        }

                        if($row8->privilege_manage_privilege == "1"){
                          $privilege_manage_privilege = "<input type='checkbox' name='privilege_manage_privilege' checked>";
                        }
                        elseif($row8->privilege_manage_privilege == "0"){
                          $privilege_manage_privilege = "<input type='checkbox' name='privilege_manage_privilege'>";
                        }

                        if($row8->privilege_manage_database == "1"){
                          $privilege_manage_database = "<input type='checkbox' name='privilege_manage_database' checked>";
                        }
                        elseif($row8->privilege_manage_database == "0"){
                          $privilege_manage_database = "<input type='checkbox' name='privilege_manage_database'>";
                        }

                        if($row8->privilege_manage_offices == "1"){
                          $privilege_manage_offices = "<input type='checkbox' name='privilege_manage_offices' checked>";
                        }
                        elseif($row8->privilege_manage_offices == "0"){
                          $privilege_manage_offices = "<input type='checkbox' name='privilege_manage_offices'>";
                        }

                        if($row8->privilege_view_fees == "1"){
                          $privilege_view_fees = "<input type='checkbox' name='privilege_view_fees' checked>";
                        }
                        elseif($row8->privilege_view_fees == "0"){
                          $privilege_view_fees = "<input type='checkbox' name='privilege_view_fees'>";
                        }

                        if($row8->privilege_staff_bonus == "1"){
                          $privilege_staff_bonus = "<input type='checkbox' name='privilege_staff_bonus' checked>";
                        }
                        elseif($row8->privilege_staff_bonus == "0"){
                          $privilege_staff_bonus = "<input type='checkbox' name='privilege_staff_bonus'>";
                        }

                        if($row8->privilege_manage_events == "1"){
                          $privilege_manage_events = "<input type='checkbox' name='privilege_manage_events' checked>";
                        }
                        elseif($row8->privilege_manage_events == "0"){
                          $privilege_manage_events = "<input type='checkbox' name='privilege_manage_events'>";
                        }

                      ?>

                        <tr>
                          <th><?php echo $name; ?><?php echo "<input type='hidden' name='privilege_id' value='".$row8->privilege_id."'>"; ?></th>        
                          <th><?php echo $privilege_manage_clients; ?></th>
                          <th><?php echo $privilege_manage_officers; ?></th>
                          <th><?php echo $privilege_manage_providers; ?></th>
                          <th><?php echo $privilege_manage_studentapps; ?></th>
                          <th><?php echo $privilege_manage_studentdocs; ?></th>
                          <th><?php echo $privilege_manage_commissions; ?></th>
                          <th><?php echo $privilege_manage_prapps; ?></th> 
                          <th><?php echo $privilege_manage_prdocs; ?></th>  
                          <th><?php echo $privilege_manage_prfeereceived; ?></th>  
                          <th><?php echo $privilege_manage_prfeepaid; ?></th>  
                          <th><?php echo $privilege_manage_reporting; ?></th> 
                          <th><?php echo $privilege_manage_channel; ?></th>  
                          <th><?php echo $privilege_manage_parameters; ?></th>
                          <th><?php echo $privilege_manage_privilege; ?></th> 
                          <th><?php echo $privilege_manage_database; ?></th> 
                          <th><?php echo $privilege_manage_offices; ?></th> 
                          <th><?php echo $privilege_view_fees; ?></th> 
                          <th><?php echo $privilege_staff_bonus; ?></th>
                          <th><?php echo $privilege_manage_events; ?></th>
                        </tr>
                      <?php
                      }
                      ?>
                     </tbody>
                     </table><br>
                     <button class="btn btn-primary" type="button" onclick="processPriviledge();">Update</button>
                    </form>
                  </div>
                  <!-- /.card-body -->
              </div>
              </div>
            </div>
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
    $("#offices").DataTable({
      "responsive": true,
      "autoWidth": false,
      "ordering": false,
    });
    $("#officer").DataTable({
      "responsive": true,
      "autoWidth": false,
      "ordering": false,
    });
    $("#assignment").DataTable({
      "responsive": true,
      "autoWidth": false,
      "ordering": false,
    });
    $("#region").DataTable({
      "responsive": true,
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
<script type="text/javascript">
    function processPriviledge() {
      var baseurl11 = document.getElementById("baseurl").value;

      var privilege_id = "";
      var privilege_manage_clients = "";
      var privilege_manage_officers = "";
      var privilege_manage_providers = "";
      var privilege_manage_studentapps = "";
      var privilege_manage_studentdocs = "";
      var privilege_manage_commissions = "";
      var privilege_manage_prapps = "";
      var privilege_manage_prdocs = "";
      var privilege_manage_prfeereceived = "";
      var privilege_manage_prfeepaid = "";
      var privilege_manage_reporting = "";
      var privilege_manage_channel = "";
      var privilege_manage_parameters = "";
      var privilege_manage_privilege = "";
      var privilege_manage_database = "";
      var privilege_manage_offices = "";
      var privilege_view_fees = "";
      var privilege_staff_bonus = "";
      var privilege_manage_events = "";

      for(var i = 0; i < 5; i++) {

          privilege_id = document.getElementsByName("privilege_id")[i].value;

          if(document.getElementsByName("privilege_manage_clients")[i].checked == true) {
            privilege_manage_clients = "1";
          } else {
            privilege_manage_clients = "0";
          }

          if(document.getElementsByName("privilege_manage_officers")[i].checked == true) {
            privilege_manage_officers = "1";
          } else {
            privilege_manage_officers = "0";
          }

          if(document.getElementsByName("privilege_manage_providers")[i].checked == true) {
            privilege_manage_providers = "1";
          } else {
            privilege_manage_providers = "0";
          }

          if(document.getElementsByName("privilege_manage_studentapps")[i].checked == true) {
            privilege_manage_studentapps = "1";
          } else {
            privilege_manage_studentapps = "0";
          }

          if(document.getElementsByName("privilege_manage_studentdocs")[i].checked == true) {
            privilege_manage_studentdocs = "1";
          } else {
            privilege_manage_studentdocs = "0";
          }

          if(document.getElementsByName("privilege_manage_commissions")[i].checked == true) {
            privilege_manage_commissions = "1";
          } else {
            privilege_manage_commissions = "0";
          }

          if(document.getElementsByName("privilege_manage_prapps")[i].checked == true) {
            privilege_manage_prapps = "1";
          } else {
            privilege_manage_prapps = "0";
          }

          if(document.getElementsByName("privilege_manage_prdocs")[i].checked == true) {
            privilege_manage_prdocs = "1";
          } else {
            privilege_manage_prdocs = "0";
          }

          if(document.getElementsByName("privilege_manage_prfeereceived")[i].checked == true) {
            privilege_manage_prfeereceived = "1";
          } else {
            privilege_manage_prfeereceived = "0";
          }

          if(document.getElementsByName("privilege_manage_prfeepaid")[i].checked == true) {
            privilege_manage_prfeepaid = "1";
          } else {
            privilege_manage_prfeepaid = "0";
          }

          if(document.getElementsByName("privilege_manage_reporting")[i].checked == true) {
            privilege_manage_reporting = "1";
          } else {
            privilege_manage_reporting = "0";
          }

          if(document.getElementsByName("privilege_manage_channel")[i].checked == true) {
            privilege_manage_channel = "1";
          } else {
            privilege_manage_channel = "0";
          }

          if(document.getElementsByName("privilege_manage_parameters")[i].checked == true) {
            privilege_manage_parameters = "1";
          } else {
            privilege_manage_parameters = "0";
          }

          if(document.getElementsByName("privilege_manage_privilege")[i].checked == true) {
            privilege_manage_privilege = "1";
          } else {
            privilege_manage_privilege = "0";
          }

          if(document.getElementsByName("privilege_manage_database")[i].checked == true) {
            privilege_manage_database = "1";
          } else {
            privilege_manage_database = "0";
          }

          if(document.getElementsByName("privilege_manage_offices")[i].checked == true) {
            privilege_manage_offices = "1";
          } else {
            privilege_manage_offices = "0";
          }

          if(document.getElementsByName("privilege_view_fees")[i].checked == true) {
            privilege_view_fees = "1";
          } else {
            privilege_view_fees = "0";
          }

          if(document.getElementsByName("privilege_staff_bonus")[i].checked == true) {
            privilege_staff_bonus = "1";
          } else {
            privilege_staff_bonus = "0";
          }

          if(document.getElementsByName("privilege_manage_events")[i].checked == true) {
            privilege_manage_events = "1";
          } else {
            privilege_manage_events = "0";
          }

          $.ajax({
              type: "POST",
              url: baseurl11 + "index.php/updatepriviledge",
              data: {
                privilege_id: privilege_id,
                privilege_manage_clients: privilege_manage_clients,
                privilege_manage_officers: privilege_manage_officers,
                privilege_manage_providers: privilege_manage_providers,
                privilege_manage_studentapps: privilege_manage_studentapps,
                privilege_manage_studentdocs: privilege_manage_studentdocs,
                privilege_manage_commissions: privilege_manage_commissions,
                privilege_manage_prapps: privilege_manage_prapps,
                privilege_manage_prdocs: privilege_manage_prdocs,
                privilege_manage_prfeereceived: privilege_manage_prfeereceived,
                privilege_manage_prfeepaid: privilege_manage_prfeepaid,
                privilege_manage_reporting: privilege_manage_reporting,
                privilege_manage_channel: privilege_manage_channel,
                privilege_manage_parameters: privilege_manage_parameters,
                privilege_manage_privilege: privilege_manage_privilege,
                privilege_manage_database: privilege_manage_database,
                privilege_manage_offices: privilege_manage_offices,
                privilege_view_fees: privilege_view_fees,
                privilege_staff_bonus: privilege_staff_bonus,
                privilege_manage_events: privilege_manage_events
              },
              success: function(data) {
                  var obj = JSON.parse(data);
              },
              error: function(error) {
                alert("Error: "+error);
                console.log(error);
              }
          });

      }

      alert("Successfully updated the privileges!");
      location.reload();

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

  var elems = document.getElementsByClassName('confirmation');
  var confirmIt = function (e) {
      if (!confirm('Are you sure to delete the entry?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
  }
</script>
</body>
</html>
