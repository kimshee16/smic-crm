<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/favicon.png"/>
    <link rel="shortcut icon" href="<?php echo $asset_url; ?>profile/images/fav.jpg">
    <link rel="stylesheet" href="<?php echo $asset_url; ?>profile/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $asset_url; ?>profile/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $asset_url; ?>profile/css/style.css" />
</head>

<body>
	<?php
	foreach($client as $row) {
		$dob = $row->client_dob_year."-".$row->client_dob_month."-".$row->client_dob_day;
        $ve = $row->client_ve_year."-".$row->client_ve_month."-".$row->client_ve_day;
	?>
    <div class="container-fluid overcover">
        <div class="container profile-box">
           <div class="cover-image row">
               <img src="<?php echo $asset_url; ?>profile/images/bloogs-6.jpg" alt="">
           </div>
            <div class="row">
                <div class="col-lg-8 col-md-7 detail-px no-padding">
                    <h3>Comments about <?php echo $row->client_firstname." ".$row->client_surname ?></h3>
                    <p><?php echo $row->client_comments ?></p>
                    
                    <h3 class="mth3">Qualifications</h3>
                    <div class="fx-ro">
                        <div class="detail">
                            <b><?php 
                            		if($row->client_qualifications == "[empty]" || $row->client_qualifications == "") {
                            			echo "";
                            		} else {
                            			echo $row->client_qualifications;	
                            		}
                               ?>
                            </b>
                        </div>
                    </div>
                    
                    <h3 class="mth3">Assigned Office and Administering Officer</h3>
                    <?php
                    	$this->db->where('officer_id', $row->client_officer_id);
                        $officerquery = $this->db->get('officer');
                        foreach ($officerquery->result() as $officerrow)
                        {
                          ?>
                          	<div class="fx-ro">
		                        <div class="detail">
		                            <b>Officer</b>
		                            <p><?php echo $officerrow->officer_name; ?></p>
		                        </div>
		                    </div>
                          <?php
                        }
                    ?>
                    
                    <?php
                        $officescode = "";
                        $this->db->where('offices_id', $row->client_office_id);
                        $officequery = $this->db->get('offices');
                        foreach ($officequery->result() as $officerow)
                        {
                          	?>
                          	<div class="fx-ro">
		                        <div class="detail">
		                            <b>Office</b>
		                            <p><?php echo $officerow->offices_code; ?></p>
		                        </div>
		                    </div>
                          	<?php
                        }
                    ?>
                    
                    <h3 class="mth3">Attended Event</h3>
                    
                    <?php
                        $eventname = "";
                        $this->db->where('event_id', $row->client_event_id);
                        $eventquery = $this->db->get('events');
                        foreach ($eventquery->result() as $eventrow)
                        {
                        	?>
                          		<div class="fx-ro">
			                        <div class="detail">
			                            <b>Event</b>
			                            <p><?php echo $eventrow->event_name; ?></p>
			                        </div>
			                    </div>
                          	<?php
                        }
                    ?>
                    
                </div>
                <div class="col-lg-4 col-md-5 leftgh">
                    <div class="img-box">
                    	<?php
                    		if($row->client_photo != "") {
                    	?>
                         <img src="<?php echo $asset_url; ?>images/<?php echo $row->client_photo; ?>" alt="">   
                    	<?php
                    		} else {
                    			?>
                    			<img src="<?php echo $asset_url; ?>images/nopic.jpg" alt="">
                    			<?php 
                    		}
                    	?>
                    </div>
                    <div class="name-det">
                        
                   
                     <h2><?php echo $row->client_firstname." ".$row->client_surname; ?></h2>
                     
                     <h3>Contact</h3>
                     
                     <b>Name: </b><p><?php echo $row->client_firstname." ".$row->client_surname; ?> <br>
                     <b>Phone #: </b><?php if($row->client_phoneno != "[empty]" || $row->client_phoneno != "") { echo $row->client_phoneno; } ?> <br>
                     <b>Mobile #: </b><?php if($row->client_mobileno != "[empty]" || $row->client_mobileno != "") { echo $row->client_mobileno; } ?>
                 		</p>
                     
                     <b>Address: </b><p><?php echo $row->client_address." ".$row->client_suburb." ".$row->client_state." ".$row->client_postcode; ?></p>
                     
                     <b>Email Address: </b><p><?php echo $row->client_email; ?></p>
                     
                     <h3>Other Information</h3>
                     
                     <b>Date of Birth: </b><p><?php echo $dob; ?></p>
                     <b>Overseas Mobile #: </b><p><?php echo $row->client_overseas_mobileno; ?></p>
                     <b>Overseas Address: </b><p><?php echo $row->client_overseas_address; ?></p>
                     <b>Visa Expiry Date: </b><p><?php echo $ve; ?></p>
                        
                    </div>
                    
                   
                     
                </div>
            </div>
        </div>
    </div>
    <?php
    	}
    ?>
</body>

<script src="<?php echo $asset_url; ?>profile/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo $asset_url; ?>profile/js/popper.min.js"></script>
<script src="<?php echo $asset_url; ?>profile/js/bootstrap.min.js"></script>
<script src="<?php echo $asset_url; ?>profile/js/script.js"></script>


</html>