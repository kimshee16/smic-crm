<?php $this->load->view('layout/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
      <div class="container-fluid">
        <style>
          .today-task-toolbar {
            align-items: center;
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-bottom: 12px;
          }

          .priority-task-list {
            border: 1px solid #d8e4f0;
            border-radius: 8px;
            overflow: hidden;
          }

          .priority-task-row {
            align-items: center;
            border-bottom: 1px solid #e5eef7;
            display: grid;
            gap: 12px;
            grid-template-columns: 28px 94px minmax(220px, 1fr) 150px 112px;
            padding: 12px 14px;
          }

          .priority-task-row:nth-child(even) {
            background: #f7fbff;
          }

          .priority-task-row:last-child {
            border-bottom: 0;
          }

          .priority-task-client {
            color: #0d2238;
            font-weight: 700;
            line-height: 1.25;
          }

          .priority-task-detail {
            color: #30475e;
            font-size: 13px;
            line-height: 1.35;
            margin-top: 3px;
          }

          .priority-task-module {
            color: #7b8ca3;
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .02em;
            margin-top: 4px;
            text-transform: uppercase;
          }

          .priority-due {
            color: #41576f;
            font-size: 12px;
            font-weight: 700;
          }

          .priority-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
          }

          .priority-empty {
            border: 1px solid #d8e4f0;
            border-radius: 8px;
            color: #6c7d90;
            padding: 28px;
            text-align: center;
          }

          @media (max-width: 991px) {
            .priority-task-row {
              grid-template-columns: 28px 86px minmax(0, 1fr);
            }

            .priority-due,
            .priority-actions {
              grid-column: 3;
            }

            .priority-actions {
              justify-content: flex-start;
            }
          }
        </style>
        <?php
          $vedcounter = 0;
          foreach ($prapplicationforchecking as $row1) {
              //$date1=date_create("2022-08-01");
              $date1=date_create(date("Y-m-d"));
              $date2=date_create($row1->visa_expiry_year."-".$row1->visa_expiry_month."-".$row1->visa_expiry_day);
              $diff=date_diff($date1,$date2);
              if((int) $diff->format("%a") < 92) {
                $vedcounter++;
              }
              //echo $row1;
          }
        ?>
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-default">
              <div class="inner">
                <h3><?php echo $vedcounter; ?></h3>
                <p>VISA EXPIRING DATES FOR THE NEXT 3 MONTHS</p>
              </div>
              <a href="#" class="small-box-footer" data-toggle='modal' data-target='#visaexpModal'>More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-default">
              <div class="inner">
                <h3><?php echo $student_application; ?></h3>
                <p>STUDENT APPLICATIONS (WIP)</p>
              </div>
              <a href="#" class="small-box-footer" data-toggle='modal' data-target='#saWIPModal'>More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-default">
              <div class="inner">
                <h3><?php echo $pr_application; ?></h3>
                <p>VISA APPLICATIONS (WIP)</p>
              </div>
              <a href="#" class="small-box-footer" data-toggle='modal' data-target='#vaWIPModal'>More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <?php
            $vcdcounter = 0;
            foreach ($prapplicationforchecking as $row1) {
                //$date1=date_create("2022-08-01");
                $date1=date_create(date("Y-m-d"));
                $date2=date_create($row1->visa_critical_year."-".$row1->visa_critical_month."-".$row1->visa_critical_day);
                $diff=date_diff($date1,$date2);
                if((int) $diff->format("%a") < 92) {
                  $vcdcounter++;
                }
                //echo $row1;
            }
          ?>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-default">
              <div class="inner">
                <h3><?php echo $vcdcounter; ?></h3>
                <p>VISA CRITICAL DATES FOR THE NEXT 3 MONTHS</p>
              </div>
              <a href="#" class="small-box-footer" data-toggle='modal' data-target='#visacriticalModal'>More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        <?php
          $criticalStudentVisaExpiry = isset($critical_student_visa_expiry) ? $critical_student_visa_expiry : array();
          $studentVisaExpirySummary = isset($student_visa_expiry_summary) ? $student_visa_expiry_summary : null;
          $visaExpiryChartLabels = array();
          $visaExpiryChartData = array();
          $visaExpiryChartColors = array();

          foreach ($criticalStudentVisaExpiry as $row1) {
            $clientName = preg_replace("/\s+/", " ", trim($row1->client_firstname." ".$row1->client_middlename." ".$row1->client_surname));
            if ($clientName == "") {
              $clientName = "Client #".$row1->client_id;
            }

            $daysLeft = (int) $row1->days_until_expiry;
            $visaExpiryChartLabels[] = $clientName." (#".$row1->studentapp_id.")";
            $visaExpiryChartData[] = $daysLeft;

            if ($daysLeft <= 14) {
              $visaExpiryChartColors[] = "#dc3545";
            } elseif ($daysLeft <= 30) {
              $visaExpiryChartColors[] = "#fd7e14";
            } elseif ($daysLeft <= 60) {
              $visaExpiryChartColors[] = "#ffc107";
            } else {
              $visaExpiryChartColors[] = "#17a2b8";
            }
          }

          $expiredVisaCount = $studentVisaExpirySummary ? (int) $studentVisaExpirySummary->expired_count : 0;
          $nextThirtyVisaCount = $studentVisaExpirySummary ? (int) $studentVisaExpirySummary->next_30_count : 0;
          $nextNinetyVisaCount = $studentVisaExpirySummary ? (int) $studentVisaExpirySummary->next_90_count : 0;
        ?>
        <div class="row">
          <div class="col-lg-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Critical Student Visa Expiry</h3>
                <div class="card-tools">
                  <span class="badge badge-danger"><?php echo $nextThirtyVisaCount; ?> in 30 days</span>
                  <span class="badge badge-warning"><?php echo $nextNinetyVisaCount; ?> in 31-90 days</span>
                  <span class="badge badge-secondary"><?php echo $expiredVisaCount; ?> expired</span>
                </div>
              </div>
              <div class="card-body">
                <?php if (count($criticalStudentVisaExpiry) > 0) { ?>
                  <div class="chart" style="position: relative; height: 300px;">
                    <canvas id="critical-student-visa-expiry-chart"></canvas>
                  </div>
                <?php } else { ?>
                  <div class="text-muted text-center py-4">No valid student visa expiry dates in the next 90 days.</div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Most Critical</h3>
              </div>
              <div class="card-body p-0">
                <?php if (count($criticalStudentVisaExpiry) > 0) { ?>
                  <table class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th>Client</th>
                        <th>Expiry</th>
                        <th>Days</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $criticalCount = 0;
                        foreach ($criticalStudentVisaExpiry as $row1) {
                          if ($criticalCount >= 5) {
                            break;
                          }

                          $clientName = preg_replace("/\s+/", " ", trim($row1->client_firstname." ".$row1->client_middlename." ".$row1->client_surname));
                          if ($clientName == "") {
                            $clientName = "Client #".$row1->client_id;
                          }

                          $daysLeft = (int) $row1->days_until_expiry;
                          $expiryDate = strtotime($row1->vevo_expiry_date) ? date("d/m/Y", strtotime($row1->vevo_expiry_date)) : "";
                          $badgeClass = $daysLeft <= 14 ? "badge-danger" : ($daysLeft <= 30 ? "badge-warning" : "badge-info");
                      ?>
                        <tr>
                          <td>
                            <?php echo htmlspecialchars($clientName, ENT_QUOTES, "UTF-8"); ?><br>
                            <small class="text-muted"><?php echo htmlspecialchars((string) $row1->studentapp_flag, ENT_QUOTES, "UTF-8"); ?></small>
                          </td>
                          <td><?php echo $expiryDate; ?></td>
                          <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $daysLeft; ?></span></td>
                          <td><a href="<?php echo base_url()."index.php/editapplication/".$row1->studentapp_id; ?>" class="btn btn-primary btn-xs">Details</a></td>
                        </tr>
                      <?php
                          $criticalCount++;
                        }
                      ?>
                    </tbody>
                  </table>
                <?php } else { ?>
                  <div class="text-muted text-center py-4">No critical student visa expiry records.</div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
        <div class="col-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Today's Priority Tasks</h3>
            </div>
            <div class="card-body">
              <div class="today-task-toolbar">
                <div class="text-muted">
                  <?php echo count($tasklist); ?> active item<?php echo count($tasklist) == 1 ? '' : 's'; ?>, sorted by urgency
                </div>
                <button class="btn btn-primary btn-sm" onclick="donetasklist();"><i class="fas fa-check" aria-hidden="true"></i> Tag selected as Done</button>
              </div>

              <?php if (count($tasklist) > 0) { ?>
                <div class="priority-task-list">
                  <?php
                    $i = 0;
                    foreach ($tasklist as $task) {
                      $priorityBadge = 'badge-info';
                      if ($task['priority_label'] == 'Critical') {
                        $priorityBadge = 'badge-danger';
                      } elseif ($task['priority_label'] == 'High') {
                        $priorityBadge = 'badge-warning';
                      }
                  ?>
                    <div class="priority-task-row">
                      <div>
                        <input
                          type="checkbox"
                          id="tasklistdata_<?php echo $i; ?>"
                          class="tasklistdata"
                          data-client-id="<?php echo (int) $task['client_id']; ?>"
                          data-module="<?php echo htmlspecialchars($task['module'], ENT_QUOTES, 'UTF-8'); ?>"
                          data-associated-id="<?php echo (int) $task['associated_id']; ?>"
                          data-details="<?php echo htmlspecialchars($task['details'], ENT_QUOTES, 'UTF-8'); ?>">
                      </div>
                      <div><span class="badge <?php echo $priorityBadge; ?>"><?php echo htmlspecialchars($task['priority_label'], ENT_QUOTES, 'UTF-8'); ?></span></div>
                      <div>
                        <div class="priority-task-client"><?php echo htmlspecialchars($task['client_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="priority-task-detail"><?php echo htmlspecialchars($task['details'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <span class="priority-task-module"><?php echo htmlspecialchars(str_replace('Dashboard ', '', $task['module']), ENT_QUOTES, 'UTF-8'); ?></span>
                      </div>
                      <div class="priority-due"><?php echo htmlspecialchars($task['due_text'], ENT_QUOTES, 'UTF-8'); ?></div>
                      <div class="priority-actions">
                        <a href="<?php echo htmlspecialchars($task['url'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-xs" title="Open client work"><i class="fas fa-eye" aria-hidden="true"></i></a>
                        <button type="button" class="btn btn-success btn-xs" title="Tag done" onclick="completePriorityTask(this);"><i class="fas fa-check" aria-hidden="true"></i></button>
                      </div>
                    </div>
                  <?php
                      $i++;
                    }
                  ?>
                </div>
              <?php } else { ?>
                <div class="priority-empty">No priority tasks need attention right now.</div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Approval Tasks</h3>
                </div>
                <div class="card-body">
                  <table style='width: 100%;'>
                  <?php
                    foreach ($inquiries as $row) {
                  ?>
                    <tr>
                      <td style='width: 80%;'><?php echo $row->inquiries_firstname." ".$row->inquiries_middlename." ".$row->inquiries_surname; ?></td>
                      <td style='width: 20%;'><input type='hidden' value='<?php echo $row->inquiries_email; ?>'><a href="transferinquirytoclientfromdashboard/<?php echo $row->inquiries_id; ?>" class="btn btn-primary btn-xs customRedirect" title="<?php echo 'Approve '.$row->inquiries_firstname.' '.$row->inquiries_middlename.' '.$row->inquiries_surname." as Client" ?>"><i class="fa fa-check" aria-hidden="true"></i></a></td>
                    <tr>
                  <?php
                    }
                  ?>
                  </table>
                </div>
              </div>
        </div>
      </div>

        <!--
        <div class="row">
          <section class="col-lg-7 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div>
            </div>
            -->

            <!-- DIRECT CHAT -->
            <!--
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>

                <div class="card-tools">
                  <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                          data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="direct-chat-messages">
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Alexander Pierce</span>
                      <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo $asset_url; ?>dist/img/user1-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text">
                      Is this template really for free? That's unbelievable!
                    </div>
                  </div>

                  <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">Sarah Bullock</span>
                      <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo $asset_url; ?>dist/img/user3-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text">
                      You better believe it!
                    </div>
                  </div>

                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Alexander Pierce</span>
                      <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo $asset_url; ?>dist/img/user1-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text">
                      Working with AdminLTE on a great new app! Wanna join?
                    </div>
                  </div>
                  <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">Sarah Bullock</span>
                      <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo $asset_url; ?>dist/img/user3-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text">
                      I would love to.
                    </div>
                  </div>
                </div>

                <div class="direct-chat-contacts">
                  <ul class="contacts-list">
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="<?php echo $asset_url; ?>dist/img/user1-128x128.jpg">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Count Dracula
                            <small class="contacts-list-date float-right">2/28/2015</small>
                          </span>
                          <span class="contacts-list-msg">How have you been? I was...</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="<?php echo $asset_url; ?>dist/img/user7-128x128.jpg">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Sarah Doe
                            <small class="contacts-list-date float-right">2/23/2015</small>
                          </span>
                          <span class="contacts-list-msg">I will be waiting for...</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="<?php echo $asset_url; ?>dist/img/user3-128x128.jpg">
                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nadia Jolie
                            <small class="contacts-list-date float-right">2/20/2015</small>
                          </span>
                          <span class="contacts-list-msg">I'll call you back at...</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="<?php echo $asset_url; ?>dist/img/user5-128x128.jpg">
                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nora S. Vans
                            <small class="contacts-list-date float-right">2/10/2015</small>
                          </span>
                          <span class="contacts-list-msg">Where is your new...</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="<?php echo $asset_url; ?>dist/img/user6-128x128.jpg">
                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            John K.
                            <small class="contacts-list-date float-right">1/27/2015</small>
                          </span>
                          <span class="contacts-list-msg">Can I take a look at...</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="<?php echo $asset_url; ?>dist/img/user8-128x128.jpg">
                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Kenneth M.
                            <small class="contacts-list-date float-right">1/4/2015</small>
                          </span>
                          <span class="contacts-list-msg">Never mind I found...</span>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
            -->

            <!-- TO DO List -->
            <!--
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  To Do List
                </h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo1" id="todoCheck1">
                      <label for="todoCheck1"></label>
                    </div>
                    <span class="text">Design a nice theme</span>
                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                      <label for="todoCheck2"></label>
                    </div>
                    <span class="text">Make the theme responsive</span>
                    <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo3" id="todoCheck3">
                      <label for="todoCheck3"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo4" id="todoCheck4">
                      <label for="todoCheck4"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo5" id="todoCheck5">
                      <label for="todoCheck5"></label>
                    </div>
                    <span class="text">Check your messages and notifications</span>
                    <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo6" id="todoCheck6">
                      <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add item</button>
              </div>
            </div>
          </section>
          -->

          <!--
          <section class="col-lg-5 connectedSortable">
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors
                </h3>
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm daterange"
                          data-toggle="tooltip"
                          title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                </div>
              </div>
            </div>
            -->
            <!-- solid sales graph -->
            <!--
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Sales Graph
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">
                    <div class="text-white">Mail-Orders</div>
                  </div>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">
                    <div class="text-white">Online</div>
                  </div>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">
                    <div class="text-white">In-Store</div>
                  </div>
                </div>
              </div>
            </div>
            -->

            <!-- Calendar -->
            <!--
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu float-right" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body pt-0">
                <div id="calendar" style="width: 100%"></div>
              </div>
            </div>
            -->

            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
    <div class="modal fade" id="visaexpModal" tabindex="-1" role="dialog" aria-labelledby="visaexpModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visa Expiration List (within less than 3 months)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Client Visa ID</th>
                  <th>Client</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($prapplicationforchecking as $row1) {
                      echo "<tr>";
                      //$date1=date_create("2022-08-01");
                      $date1=date_create(date("Y-m-d"));
                      $date2=date_create($row1->visa_expiry_year."-".$row1->visa_expiry_month."-".$row1->visa_expiry_day);
                      $diff=date_diff($date1,$date2);
                      if((int) $diff->format("%a") < 92) {
                        echo "<td>".$row1->client_visa_id."</td>";
                        echo "<td>".$row1->client_surname.", ".$row1->client_firstname."</td>";
                        echo "<td><a href='".base_url()."index.php/editvisaapplication/".$row1->client_visa_id."'>Details</a></td>";
                      }
                      echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="visacriticalModal" tabindex="-1" role="dialog" aria-labelledby="visacriticalModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visa Critical List (within less than 3 months)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Client Visa ID</th>
                  <th>Client</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($prapplicationforchecking as $row1) {
                      echo "<tr>";
                      //$date1=date_create("2022-08-01");
                      $date1=date_create(date("Y-m-d"));
                      $date2=date_create($row1->visa_critical_year."-".$row1->visa_critical_month."-".$row1->visa_critical_day);
                      $diff=date_diff($date1,$date2);
                      if((int) $diff->format("%a") < 92) {
                        echo "<td>".$row1->client_visa_id."</td>";
                        echo "<td>".$row1->client_surname.", ".$row1->client_firstname."</td>";
                        echo "<td><a href='".base_url()."index.php/editvisaapplication/".$row1->client_visa_id."'>Details</a></td>";
                      }
                      echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="saWIPModal" tabindex="-1" role="dialog" aria-labelledby="saWIPModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Student Application in WIP Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Application ID</th>
                  <th>Client</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($safordashboarddata as $row1) {
                      echo "<tr>";
                      echo "<td>".$row1->studentapp_id."</td>";
                      echo "<td>".$row1->client_surname.", ".$row1->client_firstname."</td>";
                      echo "<td><a href='".base_url()."index.php/editapplication/".$row1->studentapp_id."'>Details</a></td>";
                      echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="vaWIPModal" tabindex="-1" role="dialog" aria-labelledby="vaWIPModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visa Expiration List (within less than 3 months)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Client Visa ID</th>
                  <th>Client</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($vafordashboarddata as $row1) {
                      echo "<tr>";
                      echo "<td>".$row1->client_visa_id."</td>";
                      echo "<td>".$row1->client_surname.", ".$row1->client_firstname."</td>";
                      echo "<td><a href='".base_url()."index.php/editvisaapplication/".$row1->client_visa_id."'>Details</a></td>";
                      echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('layout/footer'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo $asset_url; ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $asset_url; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo $asset_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo $asset_url; ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $asset_url; ?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo $asset_url; ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $asset_url; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $asset_url; ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $asset_url; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo $asset_url; ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $asset_url; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $asset_url; ?>dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $asset_url; ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $asset_url; ?>dist/js/demo.js"></script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
      var chartCanvas = document.getElementById("critical-student-visa-expiry-chart");
      if (!chartCanvas) {
        return;
      }

      var visaExpiryLabels = <?php echo json_encode($visaExpiryChartLabels); ?>;
      var visaExpiryDays = <?php echo json_encode($visaExpiryChartData, JSON_NUMERIC_CHECK); ?>;
      var visaExpiryColors = <?php echo json_encode($visaExpiryChartColors); ?>;

      new Chart(chartCanvas.getContext("2d"), {
          type: "horizontalBar",
          data: {
              labels: visaExpiryLabels,
              datasets: [{
                  label: "Days until expiry",
                  data: visaExpiryDays,
                  backgroundColor: visaExpiryColors,
                  borderColor: visaExpiryColors,
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: {
                  display: false
              },
              scales: {
                  xAxes: [{
                      ticks: {
                          beginAtZero: true,
                          suggestedMax: 90,
                          precision: 0
                      },
                      scaleLabel: {
                          display: true,
                          labelString: "Days until visa expiry"
                      }
                  }],
                  yAxes: [{
                      ticks: {
                          fontSize: 11,
                          callback: function(value) {
                              return value.length > 32 ? value.substring(0, 32) + "..." : value;
                          }
                      }
                  }]
              },
              tooltips: {
                  callbacks: {
                      label: function(tooltipItem) {
                          var days = tooltipItem.xLabel;
                          return days + (days == 1 ? " day remaining" : " days remaining");
                      },
                      title: function(tooltipItems, data) {
                          return data.labels[tooltipItems[0].index];
                      }
                  }
              }
          }
      });
  });
</script>

<script type="text/javascript">
  function selectedPriorityTasks() {
    return Array.prototype.slice.call(document.getElementsByClassName("tasklistdata")).filter(function(task) {
      return task.checked;
    });
  }

  function savePriorityTask(task) {
    var baseurl = document.getElementById("baseurl").value;
    return $.ajax({
      type: "POST",
      url: baseurl + "index.php/completetodaystask",
      data: {
        client_id: task.getAttribute("data-client-id"),
        module: task.getAttribute("data-module"),
        associated_id: task.getAttribute("data-associated-id"),
        details: task.getAttribute("data-details")
      }
    });
  }

  function completePriorityTask(button) {
    var row = button.closest(".priority-task-row");
    var task = row ? row.querySelector(".tasklistdata") : null;
    if (!task) {
      return;
    }

    button.disabled = true;
    savePriorityTask(task).done(function() {
      location.reload();
    }).fail(function(error) {
      button.disabled = false;
      alert("Unable to save the task as done.");
      console.log(error);
    });
  }

  function donetasklist() {
    var tasks = selectedPriorityTasks();
    if (tasks.length == 0) {
      alert("Please select at least one priority task.");
      return;
    }

    $.when.apply($, tasks.map(savePriorityTask)).done(function() {
      location.reload();
    }).fail(function(error) {
      alert("Unable to save one or more tasks as done.");
      console.log(error);
    });
  }

  function markasread() {
      var baseurl = document.getElementById("baseurl").value;
      $.ajax({
          type: "GET",
          url: baseurl + "index.php/markasread",
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
