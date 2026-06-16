<!--



-->

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/favicon.png"/>
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
}

.px-1 {
    padding-right: 0 !important;
    padding-left: 0 !important;
}

.py-4 {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

.template-header {
    padding-top: 30px;
    padding-bottom: 30px;
    background-color: #0d419a;
}

.template-footer {
    padding-top: 20px;
    padding-bottom: 20px;
    background-color: #0d419a;
}

.template-header h1 {
    color: #fff;
}

.template-footer h3 {
    color: #fff;
}

.template-divider-small {
    height: 10px;
    background-color: #0d419a;
}

.template-image {
    padding-top: 20px;
    padding-bottom: 20px;
}

.card-body {
    padding: 0 !important;
}

.template-content {
    padding-left: 80px;
    padding-right: 80px;
}

</style>
</head>
<body class='snippet-body'>
<div class="container mt-5 mb-5 d-flex justify-content-center">
    
    <div class="card px-1 py-4">
        <div class="template-header"><center><h1><b>PROGRAM OPTIONS (PO)</b></h1></center></div>
        <div class="card-body">
        <form action="<?php echo base_url().'index.php/' ?>acceptpo" method="POST">
            <input type="hidden" name="poid" value="<?php echo $poid; ?>">
            <div class="template-image"><center><img src="<?php echo $asset_url; ?>images/logo-new-no-background-2.png" alt="PSC Logo" width="200px"></center></div>
            <div class="template-divider-small"></div>
            <br>
            <div class="template-content">
                <?php
                    $schoid = 0;
                    $pofile = '';
                    foreach ($programoptions as $row) {
                        $schoid = $row->scholarship_id;
                        $pofile = !empty($row->pofile) ? $row->pofile : '';
                ?>
                <table style="width: 100%;">
                    <tbody>
                        <tr><td style="width: 50%;"><h5><b>Name of Student:</b></h5></td><td style="width: 50%;"><h5><?php echo $row->client_surname.", ".$row->client_firstname." ".$row->client_middlename; ?></h5></td></tr>
                    </tbody>
                </table>
                <br><br>
                <table style="width: 100%;">
                    <tbody>
                        <tr><td style="width: 50%;"><h5><b>Institution</b></h5></td><td><h5><?php echo $row->provider_name; ?></h5></td></tr>
                        <tr><td><h5><b>Course/Program</b></h5></td><td><h5><a href="<?php echo $row->programlink; ?>" style="text-decoration: none; color: #0d419a;"><?php echo $row->program; ?></a></h5></td></tr>
                    </tbody>
                </table>
                <br><br>
                <table style="width: 100%;">
                    <tbody>
                        <tr><td style="width: 50%;"><h5><b>School/Program Website Link </b></h5></td><td style="width: 50%;"><h5><?php echo $row->schoollink; ?></h5></td></tr>
                        <tr><td style="width: 50%;"><h5><b>CRICOS Code</b></h5></td><td style="width: 50%;"><h5><?php echo $row->cricoscode; ?></h5></td></tr>
                    </tbody>
                </table>
                
                <!-- <br>
                <h5> <?php echo $row->provider_name; ?></h5>
                <h5> <?php echo $row->program; ?></h5>
                <br>
                <h5><b>Indicative Annual Cost:</b> <?php echo $row->indicativeannualcost; ?></h5>
                <h5><b>Scholarship:</b> 
                    <?php
                        foreach ($scholarships as $row) {
                            if ($row->identity == "PERCENTAGE") {
                                echo $row->description." - ".$row->identity." - ".$row->amount."%";
                            } else {
                                echo $row->description." - ".$row->identity." - ".$row->amount;
                            }
                        }
                    ?>
                </h5>
                <br>
                <h5><b>Duration:</b> <?php echo $row->duration; ?></h5>
                <h5><b>Location:</b> <?php echo $row->location; ?></h5>
                <h5><b>English Requirement:</b> <?php echo $row->englishrequirement; ?></h5>
                <h5><b>Intake:</b> <?php echo $row->intake; ?></h5> -->
                
                <!-- <h5><b>Important to Consider:</b> <?php echo $row->importanttoconsider; ?></h5> -->
                <!-- <h5><b>Migration Pathway</b> <?php echo $row->migrationpathway; ?></h5> -->
                <?php
                    }
                ?>
                <br>
                <!-- <table class="table table-bordered table-striped">
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
                          
                <br> -->
                <br>
                
                <?php if (!empty($pofile)) :
                    $fileUrl = base_url('assets/pofiles/'.$pofile);
                    $ext = strtolower(pathinfo($pofile, PATHINFO_EXTENSION));
                ?>
                    <!-- Attachment Panel -->
                    <div class="my-3 p-3 border rounded" style="background:#f8f9fa;">
                        <h5 class="mb-3"><b>Attachments</b></h5>
                
                        <?php if ($ext === 'pdf'): ?>
                            <a class="btn btn-outline-primary me-2" href="<?php echo $fileUrl; ?>" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> View PDF
                            </a>
                            <a class="btn btn-outline-secondary" href="<?php echo $fileUrl; ?>" download>
                                <i class="fa fa-download"></i> Download PDF
                            </a>
                            <div class="mt-3">
                                <iframe src="<?php echo $fileUrl; ?>" style="width:100%; height:600px; border:1px solid #e0e0e0; border-radius:8px;"></iframe>
                            </div>
                
                        <?php elseif (in_array($ext, ['doc','docx'])): ?>
                            <a class="btn btn-outline-primary" href="<?php echo $fileUrl; ?>" download>
                                <i class="fa fa-file-word-o"></i> Download Word
                            </a>
                
                        <?php elseif (in_array($ext, ['xls','xlsx'])): ?>
                            <a class="btn btn-outline-success" href="<?php echo $fileUrl; ?>" download>
                                <i class="fa fa-file-excel-o"></i> Download Excel
                            </a>
                
                        <?php else: ?>
                            <a class="btn btn-outline-secondary" href="<?php echo $fileUrl; ?>" download>
                                <i class="fa fa-download"></i> Download Attachment
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <input type="submit" value="Accept" class="btn btn-primary btn-block confirm-button" name="acceptButton" id="submitButton" style="width: 400px;"> <a href="<?php echo base_url().'index.php/'; ?>rejectpo/<?php echo $poid; ?>" class="btn btn-default btn-block confirm-button" name="rejectButton" style="width: 400px;">Reject</a>
            </div>
            <br>
        </form>
        </div>
        <div class="template-footer"><center><h3>w w w . p r o g r e s s - s t u d y . c o m . a u</h3></center></div>
    </div>
</div>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
<script type='text/javascript' src='<?php echo $asset_url; ?>js/captcha_script.js'></script>
<script type="text/javascript">
    var itemwoscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemwoscholarship").length; i++) {
        itemwoscholarship += parseInt(document.getElementsByClassName("itemwoscholarship")[i].innerText);
    }
    document.getElementById("totalwoscholarship").innerText = parseFloat(itemwoscholarship);

    var itemwscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemwscholarship").length; i++) {
        itemwscholarship += parseInt(document.getElementsByClassName("itemwscholarship")[i].innerText);
    }
    document.getElementById("totalwscholarship").innerText = parseFloat(itemwscholarship);

    var itemwithdependentwoscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemwithdependentwoscholarship").length; i++) {
        itemwithdependentwoscholarship += parseInt(document.getElementsByClassName("itemwithdependentwoscholarship")[i].innerText);
    }
    document.getElementById("totalwithdependentwoscholarship").innerText = parseFloat(itemwithdependentwoscholarship);

    var itemwithdependentwscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemwithdependentwscholarship").length; i++) {
        itemwithdependentwscholarship += parseInt(document.getElementsByClassName("itemwithdependentwscholarship")[i].innerText);
    }
    document.getElementById("totalwithdependentwscholarship").innerText = parseFloat(itemwithdependentwscholarship);

    var itemeipwithoutdependentwoscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemeipwithoutdependentwoscholarship").length; i++) {
        itemeipwithoutdependentwoscholarship += parseInt(document.getElementsByClassName("itemeipwithoutdependentwoscholarship")[i].innerText);
    }
    document.getElementById("totaleipwithoutdependentwoscholarship").innerText = parseFloat(itemeipwithoutdependentwoscholarship);

    var itemeipwithoutdependentwscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemeipwithoutdependentwscholarship").length; i++) {
        itemeipwithoutdependentwscholarship += parseInt(document.getElementsByClassName("itemeipwithoutdependentwscholarship")[i].innerText);
    }
    document.getElementById("totaleipwithoutdependentwscholarship").innerText = parseFloat(itemeipwithoutdependentwscholarship);

    var itemeipwithdependentwoscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemeipwithdependentwoscholarship").length; i++) {
        itemeipwithdependentwoscholarship += parseInt(document.getElementsByClassName("itemeipwithdependentwoscholarship")[i].innerText);
    }
    document.getElementById("totaleipwithdependentwoscholarship").innerText = parseFloat(itemeipwithdependentwoscholarship);

    var itemeipwithdependentwscholarship = 0;
    for(var i = 0; i < document.getElementsByClassName("itemeipwithdependentwscholarship").length; i++) {
        itemeipwithdependentwscholarship += parseInt(document.getElementsByClassName("itemeipwithdependentwscholarship")[i].innerText);
    }
    document.getElementById("totaleipwithdependentwscholarship").innerText = parseFloat(itemeipwithdependentwscholarship);

</script>
</body>
</html>