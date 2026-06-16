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
              
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <?php
                    if ($privilege_manage_clients == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="clientinfo-tab" data-toggle="tab" href="#clientinfo" role="tab" aria-controls="clientinfo" aria-selected="true">Marketing</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_studentdocs == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Counselling</a>
                  </li>
                  <?php
                    }
                  ?>
                  
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="admission-tab" data-toggle="tab" href="#admission" role="tab" aria-controls="admission" aria-selected="false">Admission</a>
                  </li>
                  
                  <!--<li class="nav-item">-->
                  <!--  <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">Payments</a>-->
                  <!--</li>-->
                  <?php
                    if ($privilege_manage_prdocs == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="visa-documentation-tab" data-toggle="tab" href="#visa-documentation" role="tab" aria-controls="visa-documentation" aria-selected="false">Visa Documentation</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_prdocs == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="finalization-tab" data-toggle="tab" href="#finalization" role="tab" aria-controls="finalization" aria-selected="false">Finalization</a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php
                    if ($privilege_manage_clients == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="result-tab" data-toggle="tab" href="#result" role="tab" aria-controls="result" aria-selected="false">Result</a>
                  </li>
                  <?php
                    }
                  ?>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="programoptions-tab" data-toggle="tab" href="#programoptions" role="tab" aria-controls="programoptions" aria-selected="false">Program Options</a>
                  </li>
                  -->
                  
                  <!--
                  <?php
                    if ($privilege_manage_studentapps == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="studentapplication-tab" data-toggle="tab" href="#studentapplication" role="tab" aria-controls="studentapplication" aria-selected="false">Student Application</a>
                  </li>
                  <?php
                    }
                  ?>
                  -->
                  
                  <!--
                  <?php
                    if ($privilege_manage_prapps == "1" && $privilege_manage_prdocs == "1") {
                  ?>
                  
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="visaapplication-tab" data-toggle="tab" href="#visaapplication" role="tab" aria-controls="visaapplication" aria-selected="false">Visa Applications</a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" id="visaeoi-tab" data-toggle="tab" href="#visaeoi" role="tab" aria-controls="visaeoi" aria-selected="false">Visa EOI</a>
                  </li>
                  
                  <?php
                    }
                  ?>
                  -->
                  
                  <!--
                  <?php
                    if ($privilege_manage_prfeereceived == "1" && $privilege_manage_prfeepaid == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="visaaccount-tab" data-toggle="tab" href="#visaaccount" role="tab" aria-controls="visaaccount" aria-selected="false">Visa Accounts</a>
                  </li>
                  <?php
                    }
                  ?>
                  -->
                  
                  <!--
                  <?php
                    if ($privilege_manage_studentapps == "1") {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link customerinfotabs" id="scholarshipallocation-tab" data-toggle="tab" href="#scholarshipallocation" role="tab" aria-controls="scholarshipallocation" aria-selected="false">Scholarship Allocation</a>
                  </li>
                  <?php
                    }
                  ?>
                  -->
                  
                  <!--<li class="nav-item">
                    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">Payments</a>
                  </li>-->
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="clientinfo" role="tabpanel" aria-labelledby="clientinfo-tab">
                <br>
                <form action="<?php echo base_url().'index.php/customerinfocontroller/do_upload' ?>" method="post"  onsubmit="validateData(event);" enctype="multipart/form-data">
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
                </div>
                <br>
                <div class="row">
                  <div class="col-6">
                    Client Information <button type="button" class="btn <?php if($row1->isonshore == "0") { echo "btn-primary"; } else { echo "btn-default"; } ?>" <?php if($row1->isonshore == "0") { echo "disabled"; } ?> id="offshoreswitch">Off-shore</button> <button type="button" class="btn <?php if($row1->isonshore == "1") { echo "btn-primary"; } else { echo "btn-default"; } ?>" <?php if($row1->isonshore == "1") { echo "disabled"; } ?> id="onshoreswitch">On-shore</button>
                    <input type="hidden" id="isonshore" name="isonshore" value="<?php echo $row1->isonshore; ?>">
                  </div>
                  <div class="col-3">
                  </div>
                  <div class="col-3">
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                  </div>
                  <div class="col-3">
                    <label for="amount" class="form-label">Update Photo:</label> <a class='btn btn-primary btn-xs' href="<?php echo base_url(); ?>index.php/resetphoto/<?php echo $row1->client_id; ?>">Reset Photo</a>
                        <input type="file" class="form-control" name="userfile" id="userfile">
                        <!--<small style="color: red;">Photo must be at maximum size of<br> 200px X 200px</small>-->
                  </div>
                  <div class="col-3">
                    <!--<img src="<?php echo $asset_url; ?>images/<?php echo $row1->client_photo; ?>" style="width: 150px; height: 150px;">-->
                    <img src="<?php echo $asset_url; ?>images/<?php echo $row1->client_photo; ?>" alt="" class="img-circle img-fluid">
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                      <div class="mb-3">
                        <input type="hidden" id="profilelink" value="<?php echo base_url()."index.php/profile/".$row1->client_id; ?>">
                        <button type="button" id="copyaction" class="btn btn-primary" title="Share/view <?php echo $row1->client_firstname." ".$row1->client_surname ?>'s profile"><i class="nav-icon fas fa-share-alt"></i></button> <label id="copynotif" style="display: none;">Profile link copied!</label>
                      </div>
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
                        <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?php echo $dob; ?>">
                      </div>
                      <?php
                      if($row1->isonshore == "1") {
                      ?>
                      <div class="mb-3">
                        <label for="payee" class="form-label">Visa Expiry Date</label>
                        <input type="date" class="form-control" name="vedate" id="vedate" <?php if($row1->isonshore == "0") { echo "readonly"; } ?> value="<?php echo $ve; ?>">
                      </div>
                      <?php
                      }
                      ?>
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
                      <div class="mb-3">
                        <label for="amount" class="form-label">Assigned Officer</label>
                        <div class="row">
                          <div class="col-6">
                            <?php
                                $officescode = "";
                                $officername = "";
                                $this->db->where('officer_id', $row1->client_officer_id);
                                $officerquery = $this->db->get('officer');
                                foreach ($officerquery->result() as $officerrow)
                                {
                                  $officername = $officerrow->officer_name;
                                }
                            ?>
                            <input type="text" class="form-control" name="office" value="<?php echo $officername; ?>" readonly>
                          </div>
                          <div class="col-6">
                            <select class="form-control select2" name="selectofficer">
                              <option value="">Select Officer</option>
                              <?php
                                foreach($officer as $row2) {
                              ?>
                                <option value="<?php echo $row2->officer_id; ?>"><?php echo $row2->officer_name; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="payee" class="form-label">Proposed Date of Interview</label>
                        <input type="date" class="form-control" name="pdateofinterview" value="<?php echo $row1->proposeddateofinterview; ?>">
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
                            <?php
                                $eventname = "";
                                $this->db->where('event_id', $row1->client_event_id);
                                $eventquery = $this->db->get('events');
                                foreach ($eventquery->result() as $eventrow)
                                {
                                  $eventname = $eventrow->event_name;
                                }
                            ?>
                            <input type="text" class="form-control" name="event" value="<?php echo $eventname; ?>" readonly>
                          </div>
                          <div class="col-6">
                            <select class="form-control select2" name="selectevent">
                              <option value="">Select Event</option>
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
                            <?php
                                $officescode = "";
                                $this->db->where('offices_id', $row1->client_office_id);
                                $officequery = $this->db->get('offices');
                                foreach ($officequery->result() as $officerow)
                                {
                                  $officescode = $officerow->offices_code;
                                }
                            ?>
                            <input type="text" class="form-control" name="office" value="<?php echo $officescode; ?>" readonly>
                          </div>
                          <div class="col-6">
                            <select class="form-control select2" name="selectoffice">
                              <option value="">Select Office</option>
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
                            <select class="form-control select2" name="selectflag">
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

                <button type="submit" class="btn btn-primary" id="clientinfosubmit">Submit</button> 
              </form>

                  </div>


    <!--
    
                  <div class="tab-pane fade" id="studentapplication" role="tabpanel" aria-labelledby="studentapplication-tab" style="overflow-x: scroll;">
                    <br>
                    <a href="<?php echo base_url(); ?>index.php/newapplication/<?php echo $client_id; ?>" class="btn btn-primary">New Application</a>
                    <br><br>
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
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                            $deleteapplication = "<a href='".base_url()."index.php/deleteapplicationfromcinfo/".$row->studentapp_id."/".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                            $deleteapplication = "";
                        }

                        echo "<tr>
                                <td>".$row->client_surname.", ".$row->client_firstname."</td>
                                <td>".$row->provider_name."</td>
                                <td>".$row->program."</td>
                                <td>".$row->studentapp_record_created_date."</td>
                                <td><a href='".base_url()."index.php/editapplication/".$row->studentapp_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteapplication."</td>
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
                  </div>
                  
    -->
                  
        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                       <!--<button type="button" class="btn btn-danger" id="deletedocumentfile">Delete Document</button>-->   
                      <input type="hidden" id="client_id2" value="<?php echo $client_id; ?>">
                      <input type="hidden" id="documentbaseurl" value="<?php echo base_url(); ?>">
                      <input type="hidden" id="imageasseturl2" value="<?php echo $asset_url.'images/fileicon.png'; ?>"><br><br>
                      <!--<table id="documentstable" style="font-size: 14px;">
                        <thead>
                          <th style="width: 20%;">Document Type</th>
                          <th style="width: 60%;">Document File URL</th>
                          <th style="width: 20%;">Date Uploaded</th>
                        </thead>
                        <tbody id="documentstabletbody"></tbody>
                      </table>-->
                      <div id="documentrow1">
                        <!--
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>
                        <div class="col">col</div>-->
                      </div>
                      <?php
                    if ($privilege_manage_studentdocs == "1") {
                  ?>
                      <h5>Student Interview Form</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#interviewModal">New Interview</button>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Interview Date</th>
                        <th>Time</th>
                        <th>Fully Accomplished Interview Form Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($interviews as $row) {

                        $dynamicDate = $row->interview_datetime;
                        $timestamp = strtotime($dynamicDate);
                
                        echo "<tr>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".date('h:i A', $timestamp)."</td>
                                <td><a href='".base_url()."assets/interviews/".$row->interview_link."'>".base_url()."assets/interviews/".$row->interview_link."</a></td>
                                <td><a href='".base_url()."index.php/editfile?type=interviews&id=".$row->id."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefile?type=interviews&id=".$row->id."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                      }
                      ?>
                      </tbody>
                    </table>
                    <?php
                    }
                  ?>
                    <br>
                    <h5>Program Options Form</h5>
                    <a href="<?php echo base_url(); ?>index.php/newprogramoption/<?php echo $client_id; ?>" class="btn btn-primary">New Program Option</a>
                    <table id="programoptionstable2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>School</th>
                          <th>Program</th>
                          <th>Indicative Annual Cost</th>
                          <th>Duration</th>
                          <th>Application Type</th>
                          <th>Requirement</th>
                          <th>Campus Location</th>
                          <th>Intake</th>
                          <th>PO Approval Link</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        foreach ($programoptions as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteprogramoption = "<a href='".base_url()."index.php/deletepo/".$row->poid."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deleteprogramoption = "";
                          }

                          echo "<tr>
                            <td>".$row->provider_name."</td>
                            <td>".$row->program."</td>
                            <td>".$row->indicativeannualcost."</td>
                            <td>".$row->duration."</td>
                            <td>".$row->location."</td>
                            <td>".$row->englishrequirement."</td>
                            <td>".$row->pocampuslocation."</td>
                            <td>".$row->pointake."</td>
                            <td><a href='".base_url()."index.php/programoptionform2/".$row->poid."' target='_blank'>".base_url()."index.php/programoptionform/".$row->poid."</a></td>
                            <td><a href='".base_url()."index.php/editprogramoptions/".$row->poid."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteprogramoption."</td>
                          </tr>";
                        }
                        
                        ?>
                        </tbody>
                      </table>
                    <?php
                    if ($privilege_view_fees == "1") {
                  ?>
                    <br>
                    <h5>Fees</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feeModal">New Fee</button>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Description</th>
                        <th>Date</th>
                        <th style="width: 60%;">Remarks</th>
                        <th>Receipt</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($fees as $row) {
                        $dynamicDate = $row->fee_date;
                        $timestamp = strtotime($dynamicDate);
                        echo "<tr>
                                <td>".$row->fee_description."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->fee_remarks."</td>
                                <td><a href='".base_url()."assets/fees/".$row->fee_receipt."'>".base_url()."assets/fees/".$row->fee_receipt."</a></td>
                                <td><a href='".base_url()."index.php/editfile?type=fee&id=".$row->id."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefile?type=fee&id=".$row->id."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                              
                      }
                      ?>
                      </tbody>
                    </table>
                    <?php
                    }
                  ?>
                    <?php
                    if ($privilege_manage_studentdocs == "1") {
                  ?>
                    <br>
                      <h5>Document Attachment</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#counsellingDocumentModal">Upload New Document</button>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 50%;">Description</th>
                        <th style="width: 20%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if (
                            $row->document_type == "Updated CV" || 
                            $row->document_type == "Birth Certificate" || 
                            $row->document_type == "Transcript of Records/ Form 138" || 
                            $row->document_type == "Employment Certificates" || 
                            $row->document_type == "Passport" || 
                            $row->document_type == "Diploma" || 
                            $row->document_type == "Award Certificates" || 
                            $row->document_type == "IELTS/ PTE"
                        ) {
                            echo "<tr>
                                <td>".$row->document_type."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";  
                        }
                      }
                      ?>
                      </tbody>
                    </table>
                    <?php
                    }
                  ?>
        </div>
        
        
        <div class="tab-pane fade" id="admission" role="tabpanel" aria-labelledby="admission-tab" style="overflow-x: scroll;">
                    <?php
                    if ($privilege_manage_studentapps == "1") {
                  ?>
                    <br>
                    <h5>Student Application</h5>
                    <a href="<?php echo base_url(); ?>index.php/newapplication/<?php echo $client_id; ?>" class="btn btn-primary">New Application</a>
                    <br><br>
                    <?php
                        foreach($client as $row1) {
                            $dob = $row1->client_dob_year."-".$row1->client_dob_month."-".$row1->client_dob_day;
                    ?>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>School</th>
                        <th>Program</th>
                        <th>Country</th>
                        <th>Campus</th>
                        <th>Intake</th>
                        <th>Status</th>
                        <th style="width: 20%;">Remarks</th>
                        <th>Birthday</th>
                        <th>COE</th>
                        <th>Course Start</th>
                        <th>Course End</th>
                        <?php 
                        if($row1->isonshore == "1") {
                        ?>
                        <th>VEVO Expiry Date</th>
                        <th>VEVO Expiry</th>
                        <?php
                        }
                        ?>
                        <th>Date Created</th>
                        <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($student_application as $row) {
                          $coe = $row->studentapp_coe_year."-".$row->studentapp_coe_month."-".$row->studentapp_coe_day;
                            $cs = $row->studentapp_course_starting_year."-".$row->studentapp_course_starting_month."-".$row->studentapp_course_starting_day;
                            $ce = $row->studentapp_course_end_year."-".$row->studentapp_course_end_month."-".$row->studentapp_course_end_day;
                            
                        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                            $deleteapplication = "<a href='".base_url()."index.php/deleteapplicationfromcinfo/".$row->studentapp_id."/".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        } else {
                            $deleteapplication = "";
                        }
                        
                        $dynamicDate = $row->studentapp_record_created_date;
                        $timestamp = strtotime($dynamicDate);
                        
                        if($row->vevo_expiry_date != "") {
                            $dynamicDate2 = $row->vevo_expiry_date;
                            $timestamp2 = strtotime($dynamicDate2);
                            $finaldate2 = date('d/m/Y', $timestamp2);
                        } else {
                            $finaldate2 = "";
                        }
                        
                        if($row->vevo_expiry == "") {
                            $vevo = "";    
                        } else {
                            $vevo = "<a href='".base_url()."assets/vevo/".$row->vevo_expiry."'>".base_url()."assets/vevo/".$row->vevo_expiry."</a>"; 
                        }
                        
                        if($row1->isonshore == "1") {
                        echo "<tr>
                                <td>".$row->studentapp_id."</td>
                                <td>".$row->client_surname.", ".$row->client_firstname."</td>
                                <td>".$row->provider_name."</td>
                                <td>".$row->program."</td>
                                <td>".$row->client_country."</td>
                                <td>".$row->campus."</td>
                                <td>".$row->saintake."</td>
                                <td>".$row->studentapp_flag."</td>
                                <td>".$row->remarks."</td>
                                <td>".$dob."</td>
                                <td>".$coe."</td>
                                <td>".$cs."</td>
                                <td>".$ce."</td>
                                <td>".$finaldate2."</td>
                                <td>".$vevo."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td><a href='".base_url()."index.php/editapplication/".$row->studentapp_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteapplication."</td>
                              </tr>";
                        } else {
                        echo "<tr>
                                <td>".$row->studentapp_id."</td>
                                <td>".$row->client_surname.", ".$row->client_firstname."</td>
                                <td>".$row->provider_name."</td>
                                <td>".$row->program."</td>
                                <td>".$row->client_country."</td>
                                <td>".$row->campus."</td>
                                <td>".$row->intake."</td>
                                <td>".$row->studentapp_flag."</td>
                                <td>".$row->remarks."</td>
                                <td>".$dob."</td>
                                <td>".$coe."</td>
                                <td>".$cs."</td>
                                <td>".$ce."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td><a href='".base_url()."index.php/editapplication/".$row->studentapp_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteapplication."</td>
                              </tr>";    
                        }
                      }
                      ?>
                      </tbody>
                    </table>
                    <?php } ?>
                    <br><br>
                    <?php } ?>
                    <?php
                    if ($privilege_manage_studentdocs == "1") {
                  ?>
                    <h5>Requirements</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#offerLetterModal" id="conditionalOfferLetterModalButton">New Offer Letter</button><br><br>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Type</th>
                        <th>Offer Letter</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>Attachment Link</th>
                        <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($admissionofferletter as $row) {
                            $dynamicDate = $row->date;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                    <td>".$row->type."</td>
                                    <td>".$row->conditionaloffer."</td>
                                    <td>".date('d/m/Y', $timestamp)."</td>
                                    <td>".$row->remarks."</td>
                                    <td><a href='".base_url()."assets/offerletters/".$row->attachmentlink."'>".base_url()."assets/offerletters/".$row->attachmentlink."</a></td>
                                    <td><a href='".base_url()."index.php/editfile?type=admissionofferletter&id=".$row->id."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefile?type=admissionofferletter&id=".$row->id."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                  </tr>";
                      }
                      ?>
                      </tbody>
                    </table>
                 <?php
                    }
                  ?>   
                    <!--<br><br>-->
                    <!--<h5>Full Offer Letter</h5>-->
                    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#offerLetterModal" id="fullOfferLetterModalButton">New Offer Letter</button><br><br>-->
                    <!--  <table id="example1" class="table table-bordered table-striped">-->
                    <!--  <thead>-->
                    <!--  <tr>-->
                    <!--    <th>Full Offer</th>-->
                    <!--    <th>Date</th>-->
                    <!--    <th>Remarks</th>-->
                    <!--    <th>Attachment Link</th>-->
                    <!--    <th>Actions</th>-->
                    <!--  </tr>-->
                    <!--  </thead>-->
                    <!--  <tbody>-->
                 
                    <!--  foreach ($admissionofferletter as $row) {-->
                    <!--    if($row->type == "Full Offer Letter") {-->
                    <!--        $dynamicDate = $row->date;-->
                    <!--        $timestamp = strtotime($dynamicDate);-->
                    <!--        echo "<tr>-->
                    <!--                <td>".$row->conditionaloffer."</td>-->
                    <!--                <td>".date('d/m/Y', $timestamp)."</td>-->
                    <!--                <td>".$row->remarks."</td>-->
                    <!--                <td><a href='".base_url()."assets/offerletters/".$row->attachmentlink."'>".base_url()."assets/offerletters/".$row->attachmentlink."</a></td>-->
                    <!--                <td><a href='".base_url()."index.php/editfile?type=admissionofferletter&id=".$row->id."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefile?type=admissionofferletter&id=".$row->id."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>-->
                    <!--              </tr>"; -->
                    <!--    }-->
                    <!--  }-->
                    <!--  ?>-->
                    <!--  </tbody>-->
                    <!--</table>-->
        </div>
        
        
        <div class="tab-pane fade" id="visa-documentation" role="tabpanel" aria-labelledby="visa-documentation-tab" style="overflow-x: scroll;">
                      <br>
                      <h5>Collecting Documents and Forms</h5>
                      <br>
                      <br>
                      <h5>School Documents</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visaDocumentModal" data-bs-type="schooldocuments" id="schoolDocumentModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Document Type</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 20%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if (
                            $row->document_type == "Confirmation of Environment" || 
                            $row->document_type == "OSHC Certificate" || 
                            $row->document_type == "Form 956" || 
                            $row->document_type == "Form 157A" || 
                            $row->document_type == "Excel" || 
                            $row->document_type == "Medical" || 
                            $row->document_type == "Passport Stamps" || 
                            $row->document_type == "English Proficiency Test" || 
                            $row->document_type == "CV" || 
                            $row->document_type == "Employment Certificate"
                        ) {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                <td>".$row->document_type."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->alias."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                        }      
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                      <h5>Financial Evidence</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visaDocumentModal" data-bs-type="financialevidence" id="financialEvidenceModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Document Type</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 20%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if (
                            $row->document_type == "Financial Support Statement" || 
                            $row->document_type == "Passport/ Valid ID" || 
                            $row->document_type == "Birth Certificate/ Marriage Certificate" || 
                            $row->document_type == "Family Tree" || 
                            $row->document_type == "Employment Certificate" || 
                            $row->document_type == "Payslip/ ITR" || 
                            $row->document_type == "Assets"
                        ) {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                <td>".$row->document_type."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->alias."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                        }      
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                      <h5>Asset Documents</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visaDocumentModal" data-bs-type="assetdocuments" id="assetDocumentsModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Document Type</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 20%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if (
                            $row->document_type == "Land Title" || 
                            $row->document_type == "OR/CR" || 
                            $row->document_type == "Deed of Sale" || 
                            $row->document_type == "DTI Permit" || 
                            $row->document_type == "BIR Permit" || 
                            $row->document_type == "BIR Certificate of Registration" || 
                            $row->document_type == "Business Permit/ Mayor's Permit/ Barangay Clearance" || 
                            $row->document_type == "Tax Payment/ BIR"
                        ) {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                <td>".$row->document_type."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->alias."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                        }      
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                      <h5>Financial Documents</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visaDocumentModal" data-bs-type="financialdocuments" id="financialDocumentsModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Document Type</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 20%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if (
                            $row->document_type == "Bank statements" || 
                            $row->document_type == "Bank Certificate"
                        ) {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                <td>".$row->document_type."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->alias."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                        }      
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                      <h5>GSR</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visaDocumentModal" data-bs-type="gsr" id="gsrModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Document Type</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 20%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        $dynamicDate = $row->date_uploaded;
                        $timestamp = strtotime($dynamicDate);
                        if (
                            $row->document_type == "GSR" || 
                            $row->document_type == "GSR - Students" || 
                            $row->document_type == "GSR - Admin" || 
                            $row->document_type == "GSR - HO"
                        )
                            echo "<tr>
                                <td>".$row->document_type."</td>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->alias."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                  
                  
        <div class="tab-pane fade" id="finalization" role="tabpanel" aria-labelledby="finalization-tab" style="overflow-x: scroll;">
                      <br>
                      
                     
                    <h5>Visa Application</h5>
                      <a href="<?php echo base_url(); ?>index.php/newvisaapplication/<?php echo $client_id; ?>" class="btn btn-primary">New Visa Application</a>
                      <br><br>
                      <table id="visaapplicationtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Visa Subclass</th>
                          <th>Critical Date</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($visa_application as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deletevap = "<a href='".base_url()."index.php/deletevisaapplication/".$row->client_visa_id."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deletevap = "";
                          }

                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->new_Visa_subclass."</td>
                            <td>".$row->visa_critical_month."/".$row->visa_critical_day."/".$row->visa_critical_year."</td>
                            <td>".$row->status."</td>
                            <td><a href='".base_url()."index.php/editvisaapplication/".$row->client_visa_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deletevap."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                       <br>
                      <h5>Final GSR</h5>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="finalGSRModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if($row->document_type == "Final GSR") {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                <td>".date('d/m/Y', $timestamp)."</td>
                                <td>".$row->remarks."</td>
                                <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                              </tr>";
                        }     
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                    <h5>Final DHA</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="finalDHAModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if($row->document_type == "Final DHA") {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                    <td>".date('d/m/Y', $timestamp)."</td>
                                    <td>".$row->remarks."</td>
                                    <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                    <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                  </tr>";
                        }      
                      }
                      ?>
                      </tbody>
                    </table>
                    
                    
                      
                  <!--    <br>-->
                  <!--<h5>Visa EOI</h5>-->
                  <!--    <a href="<?php echo base_url(); ?>index.php/newvisaeoi/<?php echo $client_id; ?>" class="btn btn-primary">New Visa EOI</a>-->
                  <!--    <br><br>-->
                  <!--    <table id="visaeoitable" class="table table-bordered table-striped">-->
                  <!--      <thead>-->
                  <!--      <tr>-->
                  <!--        <th>Client Name</th>-->
                  <!--        <th>EOI Number</th>-->
                  <!--        <th>Occupation</th>-->
                  <!--        <th>Created Date</th>-->
                  <!--        <th>Submitted Date</th>-->
                  <!--        <th>Skill Date</th>-->
                  <!--        <th>PY Date</th>-->
                  <!--        <th>English Test Date</th>-->
                  <!--        <th></th>-->
                  <!--      </tr>-->
                  <!--      </thead>-->
                  <!--      <tbody>-->
                        <?php
                        // foreach ($eoi as $row) {
                        //   if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                        //       $deleteeoi = "<a href='".base_url()."index.php/deletevisaeoi/".$row->eoi_id."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        //   } else {
                        //       $deleteeoi = "";
                        //   }

                        //   echo "<tr>
                        //     <td>".$row->client_surname.", ".$row->client_firstname."</td>
                        //     <td>".$row->eoi_number."</td>
                        //     <td>".$row->nominated_occupation."</td>
                        //     <td>".$row->eoi_created_date."</td>
                        //     <td>".$row->eoi_submitted_date."</td>
                        //     <td>".$row->skill_assessment_date."</td>
                        //     <td>".$row->py_completion_date."</td>
                        //     <td>".$row->english_competency_test_date."</td>
                        //     <td><a href='".base_url()."index.php/editvisaeoi/".$row->eoi_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteeoi."</td>
                        //   </tr>";
                        // }
                        ?>
                  <!--      </tbody>-->
                  <!--      <tfoot>-->
                  <!--      <tr>-->
                  <!--        <th>Client Name</th>-->
                  <!--        <th>EOI Number</th>-->
                  <!--        <th>Occupation</th>-->
                  <!--        <th>Created Date</th>-->
                  <!--        <th>Submitted Date</th>-->
                  <!--        <th>Skill Date</th>-->
                  <!--        <th>PY Date</th>-->
                  <!--        <th>English Test Date</th>-->
                  <!--        <th></th>-->
                  <!--      </tr>-->
                  <!--      </tfoot>-->
                  <!--    </table>-->
                      
                  <!--    <br>-->
                  <!--<h5>Visa Accounts</h5>-->
                  <!--<a href='<?php echo base_url(); ?>index.php/newvisaaccount/<?php echo $client_id; ?>' class='btn btn-primary'>New Visa Account</a>-->
                  <!--<br><br>-->
                  <!--    <table id="visaaccounttable" class="table table-bordered table-striped">-->
                  <!--      <thead>-->
                  <!--      <tr>-->
                  <!--        <th>Client Name</th>-->
                  <!--        <th>Visa Subclass</th>-->
                  <!--        <th>Balance</th>-->
                  <!--        <th>Description</th>-->
                  <!--        <th>Date Received</th>-->
                  <!--        <th>Received Amount ex GST</th>-->
                  <!--        <th>Received GST</th>-->
                  <!--        <th>Disbursement Date</th>-->
                  <!--        <th>Disbursed Amount ex GST</th>-->
                  <!--        <th>Disbursed GST</th>-->
                  <!--        <th></th>-->
                  <!--      </tr>-->
                  <!--      </thead>-->
                  <!--      <tbody>-->
                        <?php
                        // foreach ($visa_accounts as $row) {
                        //   if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                        //       $deletevac = "<a href='".base_url()."index.php/deletevisaaccount/".$row->visa_account_id."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        //   } else {
                        //       $deletevac = "";
                        //   }
                          
                        //   $received_amount_ex_gst = (int) $row->received_amount_ex_gst;
                        //   $received_gst = (int) $row->received_gst;
                        //   $disbursed_amount_ex_gst = (int) $row->disbursed_amount_ex_gst;
                        //   $disbursed_gst = (int) $row->disbursed_gst;

                        //   $balance = ($received_amount_ex_gst - $received_gst) - ($disbursed_amount_ex_gst - $disbursed_gst);

                        //   echo "<tr>
                        //     <td>".$row->client_surname.", ".$row->client_firstname."</td>
                        //     <td>".$row->new_Visa_subclass."</td>
                        //     <td>".$balance."</td>
                        //     <td>".$row->description."</td>
                        //     <td>".$row->received_date."</td>
                        //     <td>".$row->received_amount_ex_gst."</td>
                        //     <td>".$row->received_gst."</td>
                        //     <td>".$row->disbursed_date."</td>
                        //     <td>".$row->disbursed_amount_ex_gst."</td>
                        //     <td>".$row->disbursed_gst."</td>
                        //     <td><a href='".base_url()."index.php/editvisaaccount/".$row->visa_account_id."/".$client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deletevac."</td>
                        //   </tr>";
                        // }
                        ?>
                      <!--  </tbody>-->
                      <!--  <tfoot>-->
                      <!--  <tr>-->
                      <!--    <th>Client Name</th>-->
                      <!--    <th>Visa Subclass</th>-->
                      <!--    <th>Balance</th>-->
                      <!--    <th>Description</th>-->
                      <!--    <th>Date Received</th>-->
                      <!--    <th>Received Amount ex GST</th>-->
                      <!--    <th>Received GST</th>-->
                      <!--    <th>Disbursement Date</th>-->
                      <!--    <th>Disbursed Amount ex GST</th>-->
                      <!--    <th>Disbursed GST</th>-->
                      <!--    <th></th>-->
                      <!--  </tr>-->
                      <!--  </tfoot>-->
                      <!--</table>-->
                      
                      <br>
                    <h5>Medical</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="medicalModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                            foreach ($firebasefiles as $row) {
                                if($row->document_type == "Medical") {
                                    $dynamicDate = $row->date_uploaded;
                                    $timestamp = strtotime($dynamicDate);
                                    echo "<tr>
                                            <td>".date('d/m/Y', $timestamp)."</td>
                                            <td>".$row->remarks."</td>
                                            <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                            <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                          </tr>";
                                }      
                            }
                      ?>
                      </tbody>
                    </table>
                    
                    <br>
                    <h5>Biometrics</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="biometricsModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                            foreach ($firebasefiles as $row) {
                                
                                if($row->document_type == "Biometrics") {
                                    $dynamicDate = $row->date_uploaded;
                                    $timestamp = strtotime($dynamicDate);
                                    echo "<tr>
                                            <td>".date('d/m/Y', $timestamp)."</td>
                                            <td>".$row->remarks."</td>
                                            <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                            <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                          </tr>";
                                }      
                            }
                      ?>
                      </tbody>
                    </table>
                    
                    <br>
                    <h5>Additional Documents</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="additionalDocumentModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                            foreach ($firebasefiles as $row) {
                                if($row->document_type == "Additional Documents") {
                                    $dynamicDate = $row->date_uploaded;
                                    $timestamp = strtotime($dynamicDate);
                                    echo "<tr>
                                            <td>".date('d/m/Y', $timestamp)."</td>
                                            <td>".$row->remarks."</td>
                                            <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                            <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                          </tr>";
                                }      
                            }
                      ?>
                      </tbody>
                    </table>
                      <br>
                    <h5>Lodge Visa</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="lodgeVisaModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($firebasefiles as $row) {
                        if($row->document_type == "Lodge Visa") {
                            $dynamicDate = $row->date_uploaded;
                            $timestamp = strtotime($dynamicDate);
                            echo "<tr>
                                    <td>".date('d/m/Y', $timestamp)."</td>
                                    <td>".$row->remarks."</td>
                                    <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                    <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                  </tr>";
                        }      
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                    <h5>S56</h5>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizationDocumentModal" id="s56DocumentModalButton">Upload New Document</button>
                      <br><br>
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th style="width: 50%;">Remarks</th>
                        <th style="width: 30%;">Attachment Link</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                            foreach ($firebasefiles as $row) {
                                if($row->document_type == "S56") {
                                    $dynamicDate = $row->date_uploaded;
                                    $timestamp = strtotime($dynamicDate);
                                    echo "<tr>
                                            <td>".date('d/m/Y', $timestamp)."</td>
                                            <td>".$row->remarks."</td>
                                            <td><a href='".$row->document_link."'>".$row->document_link."</a></td>
                                            <td><a href='".base_url()."index.php/editfirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> "."<a href='".base_url()."index.php/deletefirebasefile?id=".$row->fbid."&client=".$row->client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>"."</td>
                                          </tr>";
                                }      
                            }
                      ?>
                      </tbody>
                    </table>
                  </div>
                  
                  
                  <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab" style="overflow-x: scroll;">
                      <br>
                      <a href="<?php echo base_url(); ?>index.php/newpayment/<?php echo $client_id; ?>" class="btn btn-primary">New Payment Entry</a>
                      <br><br>
                      <table id="paymentstable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Payment Type</th>
                          <th>Reference Number</th>
                          <th>Payment Description</th>
                          <th>Payment Schedule</th>
                          <th>Amount</th>
                          <th>Payment Attachment</th>
                          <th>Payee Name</th>
                          <th>Date of Payment</th>
                          <th>Processed by</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($payments as $row) {
                          echo "<tr>
                            <td>".$row->identity."</td>
                            <td>".$row->referencenumber."</td>
                            <td>".$row->paymentdescription."</td>
                            <td>".$row->paymentschedule."</td>
                            <td>".$row->currency." ".$row->amount."</td>
                            <td><a href='".base_url()."assets/receipts/".$row->paymentattachment."'>".base_url()."assets/receipts/".$row->paymentattachment."</a></td>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->paymentdate."</td>
                            <td>".$row->officer_name."</td>
                            <td><a href='".base_url()."index.php/archivepayment/".$row->paymentid."' class='btn btn-danger btn-xs'>Archive</a> <a href='".base_url()."index.php/payment_report/".$row->paymentid."' class='btn btn-primary btn-xs'>View PDF</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                  </div>
                  
                  
                  <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab" style="overflow-x: scroll;">
                    <br>
                    <?php
                        $resultCount = 0;
                        foreach ($result as $row) {
                            if($row->stage != "") {
                                $resultCount++;
                            }
                        }
                    ?>
                    
                    <?php
                        if($resultCount > 0) {
                    ?>
                        
                        <form action="<?php echo base_url(); ?>index.php/updateresult" method="POST">
                          <button class="btn btn-primary">Save Result</button><br><br>
                          <input type="hidden" class="form-control" id="client_id1" name="resultclientid" value="<?php echo $client_id; ?>" readonly>
                          <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Stages</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $row) {
                                ?>
                                    
                                    <?php
                                    
                                    if($row->stage == "Marketing") {
                                    
                                        echo '
                                            <tr>
                                    <td><input type="text" value="Marketing" name="stagemarketing" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusmarketing" value="'.$row->status.'" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksmarketing" value="'.$row->remarks.'" style="width: 100%;"></td>
                                </tr>
                                        ';
                                    
                                        
                                    } else if($row->stage == "Counselling") {
                                    
                                        echo '
                                            <tr>
                                    <td><input type="text" value="Counselling" name="stagecounselling" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statuscounselling" value="'.$row->status.'" style="width: 100%;"></td>
                                    <td><input type="text" name="remarkscounselling" value="'.$row->remarks.'" style="width: 100%;"></td>
                                </tr>
                                        ';
                                    
                                        
                                    } else if($row->stage == "Admission") {
                                    
                                        echo '
                                            <tr>
                                    <td><input type="text" value="Admission" name="stageadmission" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusadmission" value="'.$row->status.'" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksadmission" value="'.$row->remarks.'" style="width: 100%;"></td>
                                </tr>
                                        ';
                                    
                                        
                                    } else if($row->stage == "Visa Documentation") {
                                    
                                        echo '
                                            <tr>
                                    <td><input type="text" name="stagevisaadmission" value="Visa Documentation" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusvisaadmission" value="'.$row->status.'" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksvisaadmission" value="'.$row->remarks.'" style="width: 100%;"></td>
                                </tr>
                                        ';
                                    
                                        
                                    } else if($row->stage == "Finalization") {
                                    
                                        echo '
                                            <tr>
                                    <td><input type="text" name="stagefinalization" value="Finalization" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusfinalization" value="'.$row->status.'" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksfinalization" value="'.$row->remarks.'" style="width: 100%;"></td>
                                </tr>
                                        ';
                                    
                                        
                                    }
                                    
                                    ?>
                                    
                                <?php
                                }
                                ?>
                                
                            </tbody>
                          </table>
                        </form>
                    
                    <?php 
                        } else {
                    ?>
                        <form action="<?php echo base_url(); ?>index.php/saveresult" method="POST">
                          <button class="btn btn-primary">Save Result</button><br><br>
                          <input type="hidden" class="form-control" id="client_id1" name="resultclientid" value="<?php echo $client_id; ?>" readonly>
                          <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Stages</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" value="Marketing" name="stagemarketing" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusmarketing" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksmarketing" style="width: 100%;"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="Counselling" name="stagecounselling" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statuscounselling" style="width: 100%;"></td>
                                    <td><input type="text" name="remarkscounselling" style="width: 100%;"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="Admission" name="stageadmission" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusadmission" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksadmission" style="width: 100%;"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="stagevisaadmission" value="Visa Documentation" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusvisaadmission" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksvisaadmission" style="width: 100%;"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="stagefinalization" value="Finalization" readonly style="width: 100%;"></td>
                                    <td><input type="text" name="statusfinalization" style="width: 100%;"></td>
                                    <td><input type="text" name="remarksfinalization" style="width: 100%;"></td>
                                </tr>
                            </tbody>
                          </table>
                        </form>
                    <?php 
                    }
                    ?>
                  </div>
                  
                  
                  </div>
                </div> 
                  
        
        <!--
                  
                  <div class="tab-pane fade" id="visaapplication" role="tabpanel" aria-labelledby="visaapplication-tab" style="overflow-x: scroll;">
                      <br>
                      <a href="<?php echo base_url(); ?>index.php/newvisaapplication/<?php echo $client_id; ?>" class="btn btn-primary">New Visa Application</a>
                      <br><br>
                      <table id="visaapplicationtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Visa Subclass</th>
                          <th>Critical Date</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($visa_application as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deletevap = "<a href='".base_url()."index.php/deletevisaapplication/".$row->client_visa_id."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deletevap = "";
                          }

                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->new_Visa_subclass."</td>
                            <td>".$row->visa_critical_month."/".$row->visa_critical_day."/".$row->visa_critical_year."</td>
                            <td>".$row->status."</td>
                            <td><a href='".base_url()."index.php/editvisaapplication/".$row->client_visa_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deletevap." <a href='".base_url()."index.php/newvisaaccount/".$row->client_visa_id."/".$client_id."' class='btn btn-primary btn-xs' target='_blank'>New Visa Account</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client</th>
                          <th>Visa Subclass</th>
                          <th>Critical Date</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="visaeoi" role="tabpanel" aria-labelledby="visaeoi-tab" style="overflow-x: scroll;">
                      <br>
                      <a href="<?php echo base_url(); ?>index.php/newvisaeoi/<?php echo $client_id; ?>" class="btn btn-primary">New Visa EOI</a>
                      <br><br>
                      <table id="visaeoitable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client Name</th>
                          <th>EOI Number</th>
                          <th>Occupation</th>
                          <th>Created Date</th>
                          <th>Submitted Date</th>
                          <th>Skill Date</th>
                          <th>PY Date</th>
                          <th>English Test Date</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($eoi as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteeoi = "<a href='".base_url()."index.php/deletevisaeoi/".$row->eoi_id."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deleteeoi = "";
                          }

                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->eoi_number."</td>
                            <td>".$row->nominated_occupation."</td>
                            <td>".$row->eoi_created_date."</td>
                            <td>".$row->eoi_submitted_date."</td>
                            <td>".$row->skill_assessment_date."</td>
                            <td>".$row->py_completion_date."</td>
                            <td>".$row->english_competency_test_date."</td>
                            <td><a href='".base_url()."index.php/editvisaeoi/".$row->eoi_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteeoi."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client Name</th>
                          <th>EOI Number</th>
                          <th>Occupation</th>
                          <th>Created Date</th>
                          <th>Submitted Date</th>
                          <th>Skill Date</th>
                          <th>PY Date</th>
                          <th>English Test Date</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="visaaccount" role="tabpanel" aria-labelledby="visaaccount-tab" style="overflow-x: scroll;">
                      <br>
                      <table id="visaaccounttable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Client Name</th>
                          <th>Visa Subclass</th>
                          <th>Balance</th>
                          <th>Description</th>
                          <th>Date Received</th>
                          <th>Received Amount ex GST</th>
                          <th>Received GST</th>
                          <th>Disbursement Date</th>
                          <th>Disbursed Amount ex GST</th>
                          <th>Disbursed GST</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($visa_accounts as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deletevac = "<a href='".base_url()."index.php/deletevisaaccount/".$row->visa_account_id."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deletevac = "";
                          }
                          
                          $received_amount_ex_gst = (int) $row->received_amount_ex_gst;
                          $received_gst = (int) $row->received_gst;
                          $disbursed_amount_ex_gst = (int) $row->disbursed_amount_ex_gst;
                          $disbursed_gst = (int) $row->disbursed_gst;

                          $balance = ($received_amount_ex_gst - $received_gst) - ($disbursed_amount_ex_gst - $disbursed_gst);

                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->new_Visa_subclass."</td>
                            <td>".$balance."</td>
                            <td>".$row->description."</td>
                            <td>".$row->received_date."</td>
                            <td>".$row->received_amount_ex_gst."</td>
                            <td>".$row->received_gst."</td>
                            <td>".$row->disbursed_date."</td>
                            <td>".$row->disbursed_amount_ex_gst."</td>
                            <td>".$row->disbursed_gst."</td>
                            <td><a href='".base_url()."index.php/editvisaaccount/".$row->visa_account_id."/".$client_id."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deletevac."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Client Name</th>
                          <th>Visa Subclass</th>
                          <th>Balance</th>
                          <th>Description</th>
                          <th>Date Received</th>
                          <th>Received Amount ex GST</th>
                          <th>Received GST</th>
                          <th>Disbursement Date</th>
                          <th>Disbursed Amount ex GST</th>
                          <th>Disbursed GST</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="scholarshipallocation" role="tabpanel" aria-labelledby="scholarshipallocation-tab" style="overflow-x: scroll;">
                      <br>
                      <a href="<?php echo base_url(); ?>index.php/newscholarshipallocation/<?php echo $client_id; ?>" class="btn btn-primary">New Scholarship Allocation</a>
                      <br><br>
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
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deletecs = "<a href='".base_url()."index.php/deactivateschoallo/".$row->csid."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deletecs = "";
                          }

                          if($row->bactive == 1) {
                            $status = "Active";
                          } else {
                            $status = "Inactive";
                          }
                          echo "<tr>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->description."</td>
                            <td>".$status."</td>
                            <td>".$deletecs."</td>
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
                  </div>
                  <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab" style="overflow-x: scroll;">
                      <br>
                      <a href="<?php echo base_url(); ?>index.php/newpayment/<?php echo $client_id; ?>" class="btn btn-primary">New Payment Entry</a>
                      <br><br>
                      <table id="paymentstable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Payment Type</th>
                          <th>Reference Number</th>
                          <th>Payee Name</th>
                          <th>Date of Payment</th>
                          <th>Processed by</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($payments as $row) {
                          echo "<tr>
                            <td>".$row->identity."</td>
                            <td>".$row->referencenumber."</td>
                            <td>".$row->client_surname.", ".$row->client_firstname."</td>
                            <td>".$row->paymentdate."</td>
                            <td>".$row->officer_name."</td>
                            <td><a href='archivepayment/".$row->paymentid."' class='btn btn-danger btn-xs'>Archive</a></td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Payment Type</th>
                          <th>Reference Number</th>
                          <th>Payee Name</th>
                          <th>Date of Payment</th>
                          <th>Processed by</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                  </div>
                  <div class="tab-pane fade" id="programoptions" role="tabpanel" aria-labelledby="programoptions-tab" style="overflow-x: scroll;">
                      <br>
                      <a href="<?php echo base_url(); ?>index.php/newprogramoption/<?php echo $client_id; ?>" class="btn btn-primary">New Program Option</a>
                      <br><br>
                      <table id="programoptionstable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>School</th>
                          <th>Program</th>
                          <th>Indicative Annual Cost</th>
                          <th>Duration</th>
                          <th>Location</th>
                          <th>English Requirement</th>
                          <th>Intake</th>
                          <th>Important to Consider</th>
                          <th>Outcome</th>
                          <th>PO Approval Link</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        foreach ($programoptions as $row) {
                          if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin" || $this->session->officer_role == "manager") {
                              $deleteprogramoption = "<a href='".base_url()."index.php/deletepo/".$row->poid."/".$client_id."' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                          } else {
                              $deleteprogramoption = "";
                          }

                          echo "<tr>
                            <td>".$row->provider_name."</td>
                            <td>".$row->program."</td>
                            <td>".$row->indicativeannualcost."</td>
                            <td>".$row->duration."</td>
                            <td>".$row->location."</td>
                            <td>".$row->englishrequirement."</td>
                            <td>".$row->intake."</td>
                            <td>".$row->importanttoconsider."</td>
                            <td>".$row->migrationpathway."</td>
                            <td><a href='".base_url()."index.php/programoptionform2/".$row->poid."' target='_blank'>".base_url()."index.php/programoptionform/".$row->poid."</a></td>
                            <td><a href='".base_url()."index.php/editprogramoptions/".$row->poid."' class='btn btn-primary btn-xs'><i class='fa fa-edit' aria-hidden='true'></i></a> ".$deleteprogramoption."</td>
                          </tr>";
                        }
                        
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>School</th>
                          <th>Program</th>
                          <th>Indicative Annual Cost</th>
                          <th>Duration</th>
                          <th>Location</th>
                          <th>English Requirement</th>
                          <th>Intake</th>
                          <th>Important to Consider</th>
                          <th>Outcome</th>
                          <th>PO Approval Link</th>
                          <th></th>
                        </tr>
                        </tfoot>
                      </table>
                  </div>
                  
                 --> 
                  
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
    <!-- Button trigger modal -->

    <!-- Add New Document Modal -->
    <div class="modal fade" id="counsellingDocumentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="finalizationDocumentForm">
              <input type="hidden" id="baseurl1" value="<?php echo base_url(); ?>">
              <div class="form-group">
                <label for="client_id1">Client ID</label>
                <input type="text" class="form-control" id="client_id1" value="<?php echo $client_id; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="documentype">Document Type</label>
                <select id="documentype1" class="form-control select2" style="width: 100%;">
                  <option value="Updated CV">Updated CV</option>
                  <option value="Birth Certificate">Birth Certificate</option>
                  <option value="Transcript of Records/ Form 138">Transcript of Records/ Form 138</option>
                  <option value="Employment Certificates">Employment Certificates</option>
                  <option value="Passport">Passport</option>
                  <option value="Diploma">Diploma</option>
                  <option value="Award Certificates">Award Certificates</option>
                  <option value="IELTS/ PTE">IELTS/ PTE</option>
                </select>
              </div>
              <div class="form-group">
                <label for="documenalias1">Document Alias</label>
                <input type="text" class="form-control" id="documenalias1" placeholder="e.g. Form 956 / Driver's license / CV / Land Title">
              </div>
              <div class="form-group">
                <label for="documentfile">Remarks</label>
                <input type="text" class="form-control" id="documentremarks1">
              </div>
              <div class="form-group">
                <label for="documentfile">Document File</label>
                <input type="file" class="form-control" id="documentfile1">
                <p id="warningdocu1" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                    <script>
                    document.getElementById("documentfile1").addEventListener("change", function () {
                        const file = this.files[0]; // Get the selected file
                        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                        const warning = document.getElementById("warningdocu1");
                    
                        if (file && file.size > maxSize) {
                            warning.style.display = "block"; // Show warning
                            this.value = ""; // **Remove the selected file**
                        } else {
                            warning.style.display = "none"; // Hide warning if file is valid
                        }
                    });
                    </script>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <label id="savefiletofirebaselabel1"></label></label> <button type="button" id="savefiletofirebase1" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Add New Document Modal -->
    <div class="modal fade" id="visaDocumentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="visaDocumentForm">
              <input type="hidden" id="baseurl2" value="<?php echo base_url(); ?>">
              <div class="form-group">
                <label for="client_id1">Client ID</label>
                <input type="text" class="form-control" id="client_id2" value="<?php echo $client_id; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="documentype">Document Type</label>
                <select id="documentype2" class="form-control select2" style="width: 100%;">
                  <option value="">Select Document Type</option>
                  <option value="Confirmation of Environment">Confirmation of Environment</option>
                  <option value="OSHC Certificate">OSHC Certificate</option>
                  <option value="Form 956">Form 956</option>
                  <option value="Form 157A">Form 157A</option>
                  <option value="Excel">Excel</option>
                  <option value="Medical">Medical</option>
                  <option value="Passport Stamps">Passport Stamps</option>
                  <option value="English Proficiency Test">English Proficiency Test</option>
                  <option value="CV">CV</option>
                  <option value="Employment Certificate">Employment Certificate</option>
                  <option value="Financial Support Statement">Financial Support Statement</option>
                  <option value="Passport/ Valid ID">Passport/ Valid ID</option>
                  <option value="Birth Certificate/ Marriage Certificate">Birth Certificate/ Marriage Certificate</option>
                  <option value="Family Tree">Family Tree</option>
                  <option value="Employment Certificate">Employment Certificate</option>
                  <option value="Payslip/ ITR">Payslip/ ITR</option>
                  <option value="Assets">Assets</option>
                  <option value="Land Title">Land Title</option>
                  <option value="OR/CR">OR/CR</option>
                  <option value="Deed of Sale">Deed of Sale</option>
                  <option value="DTI Permit">DTI Permit</option>
                  <option value="BIR Permit">BIR Permit</option>
                  <option value="BIR Certificate of Registration">BIR Certificate of Registration</option>
                  <option value="Business Permit/ Mayor's Permit/ Barangay Clearance">Business Permit/ Mayor's Permit/ Barangay Clearance</option>
                  <option value="Tax Payment/ BIR">Tax Payment/ BIR</option>
                  <option value="Bank statements">Bank statements</option>
                  <option value="Bank Certificate">Bank Certificate</option>
                  <option value="GSR - Students">GSR - Students</option>
                  <option value="GSR - Admin">GSR - Admin</option>
                  <option value="GSR - HO">GSR - HO</option>
                  
                  <option value="Others">Others</option>
                </select>
              </div>
              <div class="form-group">
                <label for="documenalias">Document Alias</label>
                <input type="text" class="form-control" id="documenalias2" placeholder="e.g. Form 956 / Driver's license / CV / Land Title">
              </div>
              <div class="form-group">
                <label for="documentfile">Remarks</label>
                <input type="text" class="form-control" id="documentremarks2">
              </div>
              <div class="form-group">
                <label for="documentfile">Document File</label>
                <input type="file" class="form-control" id="documentfile2">
                <p id="warningdocu2" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                    <script>
                    document.getElementById("documentfile2").addEventListener("change", function () {
                        const file = this.files[0]; // Get the selected file
                        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                        const warning = document.getElementById("warningdocu2");
                    
                        if (file && file.size > maxSize) {
                            warning.style.display = "block"; // Show warning
                            this.value = ""; // **Remove the selected file**
                        } else {
                            warning.style.display = "none"; // Hide warning if file is valid
                        }
                    });
                    </script>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <label id="savefiletofirebaselabel2"></label></label> <button type="button" id="savefiletofirebase2" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Add New Finalization Document Modal -->
    <div class="modal fade" id="finalizationDocumentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="documentForm">
              <input type="hidden" id="baseurl3" value="<?php echo base_url(); ?>">
              <div class="form-group">
                <label for="client_id1">Client ID</label>
                <input type="text" class="form-control" id="client_id3" value="<?php echo $client_id; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="documentype">Document Type</label>
                <select id="documentype3" class="form-control select2" style="width: 100%;">
                  <option value="">Select Document Type</option>
                  <option value="Final GSR">Final GSR</option>
                  <option value="Final DHA">Final DHA</option>
                  <option value="Lodge Visa">Lodge Visa</option>
                  <option value="Medical">Medical</option>
                  <option value="Biometrics">Biometrics</option>
                  <option value="Additional Documents">Additional Documents</option>
                  <option value="Others">Others</option>
                </select>
              </div>
              <div class="form-group">
                <label for="documenalias">Document Alias</label>
                <input type="text" class="form-control" id="documenalias3" placeholder="e.g. Form 956 / Driver's license / CV / Land Title">
              </div>
              <div class="form-group">
                <label for="documentfile">Remarks</label>
                <input type="text" class="form-control" id="documentremarks3">
              </div>
              <div class="form-group">
                <label for="documentfile">Document File</label>
                <input type="file" class="form-control" id="documentfile3">
                <p id="warningdocu3" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                    <script>
                    document.getElementById("documentfile3").addEventListener("change", function () {
                        const file = this.files[0]; // Get the selected file
                        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                        const warning = document.getElementById("warningdocu3");
                    
                        if (file && file.size > maxSize) {
                            warning.style.display = "block"; // Show warning
                            this.value = ""; // **Remove the selected file**
                        } else {
                            warning.style.display = "none"; // Hide warning if file is valid
                        }
                    });
                    </script>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <label id="savefiletofirebaselabel3"></label></label> <button type="button" id="savefiletofirebase3" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Add New Interview Modal -->
    <div class="modal fade" id="interviewModal" tabindex="-1" role="dialog" aria-labelledby="interviewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Interview Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?php echo base_url(); ?>index.php/saveinterview" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
              <input type="hidden" id="baseurl1" value="<?php echo base_url(); ?>">
              <input type="hidden" name="formtype" value="new">
              <div class="form-group">
                <label for="client_id1">Client ID</label>
                <input type="text" class="form-control" id="client_id1" name="interviewclientid" value="<?php echo $client_id; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="documentype">Interview Date and Time</label>
                <input type="datetime-local" name="interviewdatetime" class="form-control">
              </div>
              <div class="form-group">
                <label for="documentfile">Upload Fully Accomplished Interview Form</label>
                <input type="file" class="form-control" id="interviewfile" name="interviewfile">
                <p id="warninginterview" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                    <script>
                    document.getElementById("interviewfile").addEventListener("change", function () {
                        const file = this.files[0]; // Get the selected file
                        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                        const warning = document.getElementById("warninginterview");
                    
                        if (file && file.size > maxSize) {
                            warning.style.display = "block"; // Show warning
                            this.value = ""; // **Remove the selected file**
                        } else {
                            warning.style.display = "none"; // Hide warning if file is valid
                        }
                    });
                    </script>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Add New Fee Modal -->
    <div class="modal fade" id="feeModal" tabindex="-1" role="dialog" aria-labelledby="interviewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Fee Receipt</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?php echo base_url(); ?>index.php/savefee" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <input type="hidden" id="baseurl1" value="<?php echo base_url(); ?>">
                  <input type="hidden" name="formtype" value="new">
                  <div class="form-group">
                    <label for="client_id1">Client ID</label>
                    <input type="text" class="form-control" id="client_id1" name="feeclientid" value="<?php echo $client_id; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="documentype">Fee Description</label>
                    <!--<input type="text" name="feedescription" class="form-control">-->
                    <select name="feedescription" class="form-control select2" style="width: 100%;">
                        <option value="Admin Fee">Admin Fee</option>
                        <option value="Refusal Fee">Refusal Fee</option>
                        <option value="Processing Fee">Processing Fee</option>
                        <option value="Tuition Fee">Tuition Fee</option>
                        <option value="Visa Application Fee">Visa Application Fee</option>
                        <option value="OSCH">OSCH</option>
                        <option value="Others">Others</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="documentype">Fee Amount</label>
                    <input type="number" name="feeamount" step=".01" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="documentype">Fee Date</label>
                    <input type="date" name="feedatetime" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="documentype">Fee Remarks</label>
                    <input type="text" name="feeremarks" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="documentfile">Upload Fee Receipt</label>
                    <input type="file" class="form-control" id="feefile" name="feefile">
                    <p id="warningfee" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                    <script>
                    document.getElementById("feefile").addEventListener("change", function () {
                        const file = this.files[0]; // Get the selected file
                        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                        const warning = document.getElementById("warningfee");
                    
                        if (file && file.size > maxSize) {
                            warning.style.display = "block"; // Show warning
                            this.value = ""; // **Remove the selected file**
                        } else {
                            warning.style.display = "none"; // Hide warning if file is valid
                        }
                    });
                    </script>
                  </div>
              </div>
          <div class="modal-footer">
            <!--<button type="button" onclick="ResetFile()" class="btn btn-primary">Reset</button> -->
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Add New Offer Letter Modal -->
    <div class="modal fade" id="offerLetterModal" tabindex="-1" role="dialog" aria-labelledby="offerLetterModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Offer Letter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?php echo base_url(); ?>index.php/saveofferletter" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <input type="hidden" id="baseurl1" value="<?php echo base_url(); ?>">
                  <input type="hidden" name="formtype" value="new">
                  <div class="form-group">
                    <label for="client_id1">Client ID</label>
                    <input type="text" class="form-control" id="client_id1" name="offerletterclientid" value="<?php echo $client_id; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="documentype" id="lettertypelabel">Offer Letter Type</label>
                    <!--<select name="offerlettertype" class="form-control select2" style="width: 100%;">-->
                    <!--    <option value="Conditional Offer Letter">Conditional Offer Letter</option>-->
                    <!--    <option value="Provisional Offer Letter">Provisional Offer Letter</option>-->
                    <!--    <option value="Full Offer Letter">Full Offer Letter</option>-->
                    <!--</select>-->
                    <br><input type="radio" name="offerlettertype" value="Conditional Offer Letter"> Conditional Offer Letter<br>
                    <input type="radio" name="offerlettertype" value="Provisional Offer Letter"> Provisional Offer Letter<br>
                    <input type="radio" name="offerlettertype" value="Full Offer Letter"> Full Offer Letter
                  </div>
                  <div class="form-group">
                    <label for="documentype" id="lettertypelabel">Offer Letter</label>
                    <!--<select name="offerletterconditionaloffer" class="form-control select2" style="width: 100%;">-->
                    <!--    <option value="GSR">GSR</option>-->
                    <!--    <option value="Financial Documents">Financial Documents</option>-->
                    <!--    <option value="IELTS/PTE">IELTS/PTE</option>-->
                    <!--</select>-->
                    <br><input type="radio" name="offerletterconditionaloffer" value="GSR"> GSR<br>
                    <input type="radio" name="offerletterconditionaloffer" value="Financial Documents"> Financial Documents<br>
                    <input type="radio" name="offerletterconditionaloffer" value="IELTS/PTE"> IELTS/PTE
                  </div>
                  <div class="form-group">
                    <label for="documentype">Offer Letter Date</label>
                    <input type="date" name="offerletterdate" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="documentype">Offer Letter Remarks</label>
                    <input type="text" name="offerletterremarks" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="documentfile">Offer Letter Attachment</label>
                    <input type="file" class="form-control" id="offerletterfile" name="offerletterfile">
                    <p id="warningoffer" style="color: red; display: none;">File size exceeds 10MB! Please select a smaller file.</p>
                    <script>
                    document.getElementById("offerletterfile").addEventListener("change", function () {
                        const file = this.files[0]; // Get the selected file
                        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                        const warning = document.getElementById("warningoffer");
                    
                        if (file && file.size > maxSize) {
                            warning.style.display = "block"; // Show warning
                            this.value = ""; // **Remove the selected file**
                        } else {
                            warning.style.display = "none"; // Hide warning if file is valid
                        }
                    });
                    </script>
                  </div>
              </div>
          <div class="modal-footer"><button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    
<!--
<option>Certified copies of all relevant academic transcripts, award and certificate from all
your complete or incomplete study.</option>
<option>IELTS result</option>
<option>Evidence of your work experience in the form of a current resume and statements
of employee which should be an official document from your employer
outlining your job title, responsibilities and duration of employment.</option>
<option>Passport/photograph of passport size</option>
<option>Birth Certificate</option>
<option>National Identity</option>
<option>VAR: Passport</option>
<option>VAR: Photograph Passport Size</option>
<option>VAR: Birth Certificate</option>
<option>VAR: National Identity</option>
<option>VAR: Transcript of records</option>
<option>VAR: Awards and Certificate</option>
<option>VAR: Statement of purpose / Genuine Temporary Entrant (see below)</option>
<option>VAR: Work Reference Letter (attached at least 2 reference letter)</option>
<option>VAR: Assets Documents</option>
<option>VAR: Medical Check-up Details</option>
<option>Sponsor: Sponsorship declaration/Statement (write down address and phone number)</option>
<option>Sponsor: Sponsor’s passport or National Identity</option>
<option>Sponsor: Bank Reference</option>
<option>Sponsor: Bank Statement (3 months before the application)</option>
<option>Sponsor: Source of Income</option>
-->

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
<!-- bs-custom-file-input -->
<script src="<?php echo $asset_url; ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $asset_url; ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $asset_url; ?>dist/js/demo.js"></script>
<!-- DataTables -->
<script src="<?php echo $asset_url; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    if(window.location.href.includes('#counselling')) {
        setTimeout(function (){
            document.getElementById("documents-tab").click();
        }, 1000);
    }
    
    if(window.location.href.includes('#admission')) {
        setTimeout(function (){
            document.getElementById("admission-tab").click();
        }, 1000);
    }
    
    if(window.location.href.includes('#visa')) {
        setTimeout(function (){
            document.getElementById("visa-documentation-tab").click();
        }, 1000);
    }
    
    if(window.location.href.includes('#finalization')) {
        setTimeout(function (){
            document.getElementById("finalization-tab").click();
        }, 1000);
    }
    
    if(window.location.href.includes('#result')) {
        setTimeout(function (){
            document.getElementById("result-tab").click();
        }, 1000);
    }
    
    if(window.location.href.includes('#payments')) {
        setTimeout(function (){
            document.getElementById("payments-tab").click();
        }, 1000);
    }
</script>

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

    $("#programoptionstable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    
    $("#programoptionstable2").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

  });

  function ResetFile() {
    document.getElementById("finalizationDocumentForm").reset();
  }

  document.getElementsByClassName("customerinfotabs")[0].click();

  function validateData(evt) {
    if (document.getElementById("birthdate").value == "") {
      alert("Birth date has wrong date format. Kindly replace with appropriate date.");
      evt.preventDefault();
      return false;
    }
    
    // if (document.getElementById("vedate").value == "") {
    //   alert("Visa expiration date has wrong date format. Kindly replace with appropriate date.");
    //   evt.preventDefault();
    //   return false;
    // }

    return true;
  }

  function markasread() {
      var baseurl10 = document.getElementById("baseurl1").value;
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

  const fileSelector = document.getElementById('userfile');
  var fileList = 0;
  fileSelector.addEventListener('change', (event) => {
      fileList = event.target.files;

      var reader = new FileReader();

      //Read the contents of Image File.
      reader.readAsDataURL(fileList[0]);
      reader.onload = function (e) {

        //Initiate the JavaScript Image object.
        var image = new Image();

        //Set the Base64 string return from FileReader as source.
        image.src = e.target.result;

        //Validate the File Height and Width.
        image.onload = function () {
          var height = this.height;
          var width = this.width;
        //   if (height > 200 || width > 200) {
        //     alert("Photo size must not exceed 200px X 200px!");
        //     document.getElementById("clientinfosubmit").disabled = true;
        //   } else {
            // alert("Photo size valid! Photo added.");
            alert("Photo added.");
            document.getElementById("clientinfosubmit").disabled = false;
        //   }
        };
      };

  });

  var elems = document.getElementsByClassName('confirmation');
  var confirmIt = function (e) {
      if (!confirm('Are you sure to delete the entry?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
  }
  
  document.getElementById("copyaction").onclick = function() {
    navigator.clipboard.writeText(document.getElementById("profilelink").value).then(
        function () {
            document.getElementById("copynotif").style.display = "block";
        },
        function (error) {
            console.log("Something went wrong.");
        }
    );
  }
  
  document.getElementById("offshoreswitch").onclick = function() {
        document.getElementById("isonshore").value = 0;
        
        document.getElementById("clientinfosubmit").click();
  }
  
  document.getElementById("onshoreswitch").onclick = function() {
        document.getElementById("isonshore").value = 1;
        document.getElementById("clientinfosubmit").click();
  }

  document.getElementById("programoptionstable2").parentNode.style.overflowX = "scroll";
  
  
    // const visaDocumentModal = document.getElementById('visaDocumentModal')
    // if (visaDocumentModal) {
    //   visaDocumentModal.addEventListener('show.bs.modal', event => {
    //     const uploaddocumenttype = button.getAttribute('data-bs-type')
    //     const modalBodySelect = visaDocumentModal.querySelector('.modal-body select')
    //     alert("Kim!");
    //     if(uploaddocumenttype == "schooldocuments") {
    //         modalBodySelect.innerHTML = `<option value="">Select Document Type</option>
    //               <option value="Confirmation of Environment">Confirmation of Environment</option>
    //               <option value="OSHC Certificate">OSHC Certificate</option>
    //               <option value="Form 956">Form 956</option>
    //               <option value="Form 157A">Form 157A</option>
    //               <option value="Excel">Excel</option>
    //               <option value="Medical">Medical</option>
    //               <option value="Passport Stamps">Passport Stamps</option>
    //               <option value="English Proficiency Test">English Proficiency Test</option>
    //               <option value="CV">CV</option>
    //               <option value="Employment Certificate">Employment Certificate</option>`;
    //     }
        
    //   })
    // }
    
    document.getElementById("schoolDocumentModalButton").onclick = function() {
        document.getElementById("documentype2").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Confirmation of Environment">Confirmation of Environment</option>
                  <option value="OSHC Certificate">OSHC Certificate</option>
                  <option value="Form 956">Form 956</option>
                  <option value="Form 157A">Form 157A</option>
                  <option value="Excel">Excel</option>
                  <option value="Medical">Medical</option>
                  <option value="Passport Stamps">Passport Stamps</option>
                  <option value="English Proficiency Test">English Proficiency Test</option>
                  <option value="CV">CV</option>
                  <option value="Employment Certificate">Employment Certificate</option>`;
    }
    
    document.getElementById("financialEvidenceModalButton").onclick = function() {
        document.getElementById("documentype2").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Financial Support Statement">Financial Support Statement</option>
                  <option value="Passport/ Valid ID">Passport/ Valid ID</option>
                  <option value="Birth Certificate/ Marriage Certificate">Birth Certificate/ Marriage Certificate</option>
                  <option value="Family Tree">Family Tree</option>
                  <option value="Employment Certificate">Employment Certificate</option>
                  <option value="Payslip/ ITR">Payslip/ ITR</option>
                  <option value="Assets">Assets</option>`;
    }
    
    document.getElementById("assetDocumentsModalButton").onclick = function() {
        document.getElementById("documentype2").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Land Title">Land Title</option>
                  <option value="OR/CR">OR/CR</option>
                  <option value="Deed of Sale">Deed of Sale</option>
                  <option value="DTI Permit">DTI Permit</option>
                  <option value="BIR Permit">BIR Permit</option>
                  <option value="BIR Certificate of Registration">BIR Certificate of Registration</option>
                  <option value="Business Permit/ Mayor's Permit/ Barangay Clearance">Business Permit/ Mayor's Permit/ Barangay Clearance</option>
                  <option value="Tax Payment/ BIR">Tax Payment/ BIR</option>`;
    }
    
    document.getElementById("financialDocumentsModalButton").onclick = function() {
        document.getElementById("documentype2").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Bank statements">Bank statements</option>
                  <option value="Bank Certificate">Bank Certificate</option>`;
    }
    
    document.getElementById("gsrModalButton").onclick = function() {
        document.getElementById("documentype2").innerHTML = `<option value="">Select Document Type</option>
                  <option value="GSR - Students">GSR - Students</option>
                  <option value="GSR - Admin">GSR - Admin</option>
                  <option value="GSR - HO">GSR - HO</option>`;
    }
    
    document.getElementById("finalGSRModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Final GSR">Final GSR</option>`;
    }
    
    document.getElementById("finalDHAModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Final DHA">Final DHA</option>`;
    }
    
    document.getElementById("lodgeVisaModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Lodge Visa">Lodge Visa</option>`;
    }
    
    document.getElementById("medicalModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Medical">Medical</option>`;
    }
    
    document.getElementById("biometricsModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Biometrics">Biometrics</option>`;
    }
    
    document.getElementById("additionalDocumentModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="Additional Documents">Additional Documents</option>`;
    }
    
    document.getElementById("s56DocumentModalButton").onclick = function() {
        document.getElementById("documentype3").innerHTML = `<option value="">Select Document Type</option>
                  <option value="S56">S56</option>`;
    }
    
    // document.getElementById("conditionalOfferLetterModalButton").onclick = function() {
    //     document.getElementById("offerlettertype").value = `Conditional Offer Letter`;
    //     document.getElementById("lettertypelabel").innerText = `Conditional Offer Letter`;
    // }
    
    // document.getElementById("fullOfferLetterModalButton").onclick = function() {
    //     document.getElementById("offerlettertype").value = `Full Offer Letter`;
    //     document.getElementById("lettertypelabel").innerText = `Full Offer Letter`;
    // }
    
    

</script>
<script>
    $('.select2').select2();
</script>
</body>
</html>