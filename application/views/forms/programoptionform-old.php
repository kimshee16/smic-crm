<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/logo.png"/>
<title>Program Option Form</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<style>
    body {
    background-color: #FFEBEE
}

.card {
    width: 1000px;
    background-color: #fff;
    border: none;
    border-radius: 12px
}

label.radio {
    cursor: pointer;
    width: 100%
}

label.radio input {
    position: absolute;
    top: 0;
    left: 0;
    visibility: hidden;
    pointer-events: none
}

label.radio span {
    padding: 7px 14px;
    border: 2px solid #eee;
    display: inline-block;
    color: #039be5;
    border-radius: 10px;
    width: 100%;
    height: 48px;
    line-height: 27px
}

label.radio input:checked+span {
    border-color: #039BE5;
    background-color: #81D4FA;
    color: #fff;
    border-radius: 9px;
    height: 48px;
    line-height: 27px
}

.form-control {
    margin-top: 10px;
    height: 48px;
    border: 2px solid #eee;
    border-radius: 10px
}

.form-control:focus {
    box-shadow: none;
    border: 2px solid #039BE5
}

.agree-text {
    font-size: 12px
}

.terms {
    font-size: 12px;
    text-decoration: none;
    color: #039BE5
}

.confirm-button {
    height: 50px;
    border-radius: 10px
}</style>
                                </head>
                                <body oncontextmenu='return false' class='snippet-body'>
                                <div class="container mt-5 mb-5 d-flex justify-content-center">
    <div class="card px-1 py-4">
        <div class="card-body">
        <form action="<?php echo base_url().'index.php/' ?>acceptpo" method="POST">
            <input type="hidden" name="poid" value="<?php echo $poid; ?>">
            <center><img src="<?php echo $asset_url; ?>images/logomain.png" alt="PSC Logo" width="200px"></center>
            <h1>Program Options Form</h1>
            <br>
            <?php
                foreach ($programoptions as $row) {
            ?>
            <div><b>School:</b> <?php echo $row->client_surname.", ".$row->client_firstname." ".$row->client_middlename; ?></div>
            <div><b>School:</b> <?php echo $row->provider_name; ?></div>
            <div><b>Program:</b> <?php echo $row->program; ?></div>
            <div><b>Indicative Annual Cost:</b> <?php echo $row->indicativeannualcost; ?></div>
            <div><b>Duration:</b> <?php echo $row->duration; ?></div>
            <div><b>Location:</b> <?php echo $row->location; ?></div>
            <div><b>English Requirement:</b> <?php echo $row->englishrequirement; ?></div>
            <div><b>Intake:</b> <?php echo $row->intake; ?></div>
            <div><b>Important to Consider:</b> <?php echo $row->importanttoconsider; ?></div>
            <div><b>Migration Pathway</b> <?php echo $row->migrationpathway; ?></div>
            <?php
                }
            ?>
            <br>
            <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Scholarship</th>
                          <th>Payment Type</th>
                          <th>Amount/%</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($scholarships as $row) {
                          if ($row->identity == "PERCENTAGE") {
                            echo "<tr>
                            <td>".$row->description."</td>
                            <td>".$row->identity."</td>
                            <td>".$row->amount." %</td>
                          </tr>";
                            } else {
                                echo "<tr>
                            <td>".$row->description."</td>
                            <td>".$row->identity."</td>
                            <td>".$row->amount."</td>
                          </tr>";
                            }
                            }
                        ?>
                        </tbody>
                      </table>
                      
            <br>
            <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Expenses Type</th>
                          <th>Per Person</th>
                          <th>Amount Required</th>
                          <th>Number of Family</th>
                          <th>Amount to Access</th>
                          <th>Confirm Access to Funds</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($programoptionsdetails as $row) {
                          echo "<tr>
                            <td>".$row->expensestype."</td>
                            <td>".$row->perperson."</td>
                            <td>".$row->amountrequired."</td>
                            <td>".$row->numberoffamily."</td>
                            <td>".$row->amounttoaccess."</td>
                            <td>".$row->confirmaccesstofunds."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
            <br>
            <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Others</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($programoptions as $row) {
                          echo "<tr>
                            <td>".$row->others."</td>
                          </tr>";
                        }
                        ?>
                        </tbody>
                      </table>
            <br>
            <input type="submit" value="Accept" class="btn btn-primary btn-block confirm-button" name="acceptButton" id="submitButton" style="width: 400px;"> <a href="<?php echo base_url().'index.php/'; ?>rejectpo/<?php echo $poid; ?>" class="btn btn-default btn-block confirm-button" name="rejectButton" style="width: 400px;">Reject</a>
            
        </form>
        </div>
    </div>
</div>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
<script type='text/javascript' src='<?php echo $asset_url; ?>js/captcha_script.js'></script>
</body>
</html>