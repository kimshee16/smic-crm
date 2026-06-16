<!DOCTYPE html>
<html lang="en">
<head>
	<title>Progress Study e-Client Form / Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/logo.png"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">

<style>
.login {
/*float: right;*/
/*position: relative;*/
border: 1px solid black;
padding: 10px 10px 10px 10px;
height: 450px;
width: 350px;
border-radius: 25px;
background: #F4F4F4;
top: 200px;
left: 50px;
}

@media (min-width: 300px) {
  .col-6 {
    max-width: 100%;
  }
}

</style>

</head>
<body>
	<br><br>
	<div class="container">
		<div class="row">
		    <div class="col-6"><img src="<?php echo $asset_url; ?>images/logo-new-no-background.png" alt="PSC Logo" width="300px"></div>
			<div class="col-6">
				<div class="login">
				
				<form class="login100-form validate-form" action="<?php echo base_url(); ?>index.php/clientlogintypical" method="post">
					<br>
					<input type="hidden" name="gotopage" id="gotopage">
					<span class="login100-form-title p-b-43">
						<h3>Kindly login to access your current transaction</h3>
					</span><br>
					<?php
                    if (isset($_GET['success1'])) {
                    ?>
                        <div class="alert alert-success" role="alert">Password successfully changed!</div>
                    <?php
                    }
                    ?>
					<?php 
					if (isset($_GET['error1'])) {
					?>
						<div class="alert alert-danger" role="alert">Incorrect email or password!</div>
					<?php
					} else if (isset($_GET['error2'])) {
					?>
					    <div class="alert alert-danger" role="alert">This user was already inactive!</div>
					<?php
					} else if (isset($_GET['error3'])) {
					?>
					    <div class="alert alert-danger" role="alert">Please login first to CRM!</div>
					<?php
					}
					?>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<span class="label-input100">Email</span> 
						<input class="form-control" type="text" name="email">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span> 
						<input class="form-control" type="password" name="password">
					</div>
                    <br><br>
					<div class="container-login100-form-btn">
						<button class="btn btn-primary">
							Login
						</button>
					</div>
					
				</form>
			</div>
			</div>
		</div>
	</div>
	
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/animsition/js/animsition.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/countdowntime/countdowntime.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
	<script type='text/Javascript'>
    function checkConfirmed(e) {
        if (document.getElementById('confirm1').checked != true) {
		    alert("Please confirm on policy checks!");
		    e.preventDefault();
		    return false;
		}

		if(document.getElementById("checkemailvalue").value == "1") {
			alert("Email already existing!");
			e.preventDefault();
			return false;
		}

		if (userText.value !== c) {
		    //output.classList.add("correctCaptcha");
		    //output.innerHTML = "Correct!";
		    alert("Incorrect CAPTCHA entry!");
			e.preventDefault();
			return false;
		}

    }

    function checkexistingemail() {
        var baseurl10 = document.getElementById("baseurl").value;
        var email = document.getElementById("email").value;
        $.ajax({
            type: "GET",
            url: baseurl10 + "index.php/checkexistingemail/"+email,
            success: function(data) {
            	var obj = JSON.parse(data);
            	if(obj[0].length > 0 || obj[1].length > 0) {
            		document.getElementById("checkemailvalue").value = "1";
            	} else {
            		document.getElementById("checkemailvalue").value = "0";
            	}
            },
            error: function(error) {
              console.log(error);
            }
        });     	
    }

</script>
<script type='text/javascript' src='<?php echo $asset_url; ?>js/captcha_script.js'></script>
<script type="text/javascript">
	function EnableOrDisableVisa() {
    	if(document.getElementById("country").value == "Australia") {
    		document.getElementById("visaexpdate").style.display = "block";
    		document.getElementById("visaheld").style.display = "block";
    	} else {
    		document.getElementById("visaexpdate").style.display = "none";
    		document.getElementById("visaheld").style.display = "none";
    	}
    }
</script>
<script>
    const url = new URL(window.location.href);
    const valueParam = url.searchParams.get('value');
    document.getElementById("gotopage").value = valueParam;
</script>
</body>
</html>