<?php
  $this->load->view('layout/header');
?>

<div class="content-wrapper">
  <div class="content-header reports-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $title; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content reports-page">
    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
    <div class="container-fluid">
      <div class="reports-toolbar">
        <div>
          <span class="reports-eyebrow">Report Center</span>
          <h2>Generate operational reports</h2>
        </div>
        <div class="reports-toolbar-meta">
          <i class="far fa-calendar-alt"></i>
          <span><?php echo date('d M Y'); ?></span>
        </div>
      </div>

      <section class="report-section">
        <div class="report-section-heading">
          <div>
            <h3>Student Application Reports</h3>
            <p>Admission, commission, invoice, and course movement reports.</p>
          </div>
        </div>

        <div class="row report-grid">
          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-user-graduate"></i></span>
                <div>
                  <h4>Student Application Status</h4>
                  <p>Filter applications by current status.</p>
                </div>
              </div>
              <form action="student_application_report" method="post">
                <div class="form-group">
                  <label for="student-status">Status</label>
                  <select name="status" id="student-status" class="form-control" required>
                    <option value="" selected>Status</option>
                    <option value="Discontinue">Discontinue</option>
                    <option value="WIP">WIP</option>
                    <option value="Completed">Completed</option>
                    <option value="Visa Refused">Visa Refused</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-hourglass-half"></i></span>
                <div>
                  <h4>Outstanding Commission</h4>
                  <p>Review pending commission within a date range.</p>
                </div>
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label>Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label>Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-file-invoice"></i></span>
                <div>
                  <h4>Invoices To-Do</h4>
                  <p>Find invoices that need follow-up.</p>
                </div>
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label>Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label>Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-hand-holding-usd"></i></span>
                <div>
                  <h4>Commission Received</h4>
                  <p>Summarize received commission by period.</p>
                </div>
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label>Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label>Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-check-circle"></i></span>
                <div>
                  <h4>Course Completed</h4>
                  <p>Track completed courses by date range.</p>
                </div>
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label>Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label>Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-play-circle"></i></span>
                <div>
                  <h4>Course Started</h4>
                  <p>Track course commencements by date range.</p>
                </div>
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label>Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label>Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>

      <section class="report-section">
        <div class="report-section-heading">
          <div>
            <h3>Visa Application Reports</h3>
            <p>Visa application, EOI, and account reports.</p>
          </div>
        </div>

        <div class="row report-grid">
          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-passport"></i></span>
                <div>
                  <h4>Visa Application Status</h4>
                  <p>Generate visa records by application status.</p>
                </div>
              </div>
              <form action="visa_application_report" method="post">
                <div class="form-group">
                  <label for="visa-status">Status</label>
                  <select name="status" id="visa-status" class="form-control" required>
                    <option value="">Please Select Status</option>
                    <option value="Discontinue">Discontinue</option>
                    <option value="WIP">WIP</option>
                    <option value="Completed">Completed</option>
                    <option value="Visa Refused">Visa Refused</option>
                    <option value="Submitted">Submitted</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-clipboard-list"></i></span>
                <div>
                  <h4>Visa EOI</h4>
                  <p>Export EOI records by flag.</p>
                </div>
              </div>
              <form action="visa_eoi" method="post">
                <div class="form-group">
                  <label for="eoi-status">Flag</label>
                  <select name="status" id="eoi-status" class="form-control" required>
                    <option value="">Please Select Flag</option>
                    <option value="All">All</option>
                    <option value="Expired">Expired</option>
                    <option value="Discontinued">Discontinued</option>
                    <option value="Invited">Invited</option>
                    <option value="Created">Created</option>
                    <option value="Submitted">Submitted</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>

          <div class="col-xl-4 col-md-6 col-12">
            <div class="report-card">
              <div class="report-card-header">
                <span class="report-icon"><i class="fas fa-wallet"></i></span>
                <div>
                  <h4>Visa Accounts</h4>
                  <p>Review received and disbursed visa account data.</p>
                </div>
              </div>
              <form action="visa_account" method="post">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label>Date From</label>
                    <input type="date" name="datefrom" class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label>Date To</label>
                    <input type="date" name="dateto" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-file-export"></i> Generate Report
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>
</div>

<?php
  $this->load->view('layout/footer');
?>

<aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="<?php echo $asset_url; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo $asset_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/sparklines/sparkline.js"></script>
<script src="<?php echo $asset_url; ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo $asset_url; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $asset_url; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo $asset_url; ?>dist/js/adminlte.js"></script>
<script src="<?php echo $asset_url; ?>dist/js/pages/dashboard.js"></script>
<script src="<?php echo $asset_url; ?>dist/js/demo.js"></script>

<style type="text/css">
  .reports-page {
    padding-bottom: 24px;
  }

  .reports-toolbar {
    align-items: center;
    background: #ffffff;
    border: 1px solid #d9e2ec;
    border-left: 4px solid #007bff;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 18px 20px;
  }

  .reports-eyebrow {
    color: #007bff;
    display: block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0;
    margin-bottom: 4px;
    text-transform: uppercase;
  }

  .reports-toolbar h2 {
    color: #1f2d3d;
    font-size: 24px;
    font-weight: 700;
    margin: 0;
  }

  .reports-toolbar-meta {
    align-items: center;
    color: #52616f;
    display: flex;
    font-weight: 600;
    gap: 8px;
  }

  .report-section {
    margin-bottom: 24px;
  }

  .report-section-heading {
    align-items: flex-end;
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
  }

  .report-section-heading h3 {
    color: #1f2d3d;
    font-size: 19px;
    font-weight: 700;
    margin: 0;
  }

  .report-section-heading p {
    color: #6c757d;
    margin: 2px 0 0;
  }

  .report-grid > [class*="col-"] {
    display: flex;
  }

  .report-card {
    background: #ffffff;
    border: 1px solid #d9e2ec;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(31, 45, 61, 0.08);
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
    padding: 18px;
    width: 100%;
  }

  .report-card-header {
    align-items: flex-start;
    display: flex;
    gap: 12px;
    min-height: 76px;
  }

  .report-icon {
    align-items: center;
    background: #e8f2ff;
    border: 1px solid #cce2ff;
    border-radius: 6px;
    color: #007bff;
    display: inline-flex;
    flex: 0 0 38px;
    height: 38px;
    justify-content: center;
    width: 38px;
  }

  .report-card h4 {
    color: #1f2d3d;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 4px;
  }

  .report-card p {
    color: #6c757d;
    line-height: 1.35;
    margin: 0;
  }

  .report-card form {
    margin-top: auto;
  }

  .report-card label {
    color: #34495e;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 5px;
  }

  .report-card .form-control {
    border-color: #cfd8e3;
    min-height: 38px;
  }

  .report-card .btn {
    align-items: center;
    display: inline-flex;
    font-weight: 700;
    gap: 8px;
    justify-content: center;
  }

  @media (max-width: 767.98px) {
    .reports-toolbar {
      align-items: flex-start;
      flex-direction: column;
      gap: 12px;
    }

    .report-card-header {
      min-height: auto;
    }
  }
</style>

<script type="text/javascript">
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
