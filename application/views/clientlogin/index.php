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
float: right;
position: relative;
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
			<div class="col-6">
				<center><img src='<?php echo base_url(); ?>assets/images/logo-new.png' style="width: 200px;">
				<video width="420" height="240" controls autoplay="on" id="vid">
				  <source src="<?php echo $asset_url."videos/PSCregvideo.mp4"; ?>" type="video/mp4">
				</video>
				</center>
				<form action="do_upload" method="POST" onsubmit="checkConfirmed(event)" enctype="multipart/form-data">
					<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
					<input type="hidden" id="checkemailvalue">
		            <center><h3 class="information mt-4">Register</h3></center><br/>
		            <div class="row">
		            	<div class="col-sm-12">
		                   <div class="form-group">	
		                   	<h4>THANK YOU FOR EXPRESSING YOUR INTEREST</h4><br/><br/>
		                   	PLEASE FILL OUT THE DETAILS SO WE CAN ASSIST YOU FURTHER
		                   </div>
		               </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="firstname" placeholder="First Name" required> </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="lastname" placeholder="Last Name" required> </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="middlename" placeholder="Middle Name"> </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <div class="input-group"> <input class="form-control" type="text" name="mobile" placeholder="Mobile" required> </div>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <div class="input-group"> <input class="form-control" type="text" id="email" name="email" placeholder="Email Address" onfocusout="checkexistingemail();" required> </div>
		                    </div>
		                </div>
		            </div>
		            <br>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">

		                            <div class="mb-3">
		                              <label for="exampleFormControlInput1" class="form-label">Birth date</label>
		                              <input type="date" name="birthdate" class="form-control" id="exampleFormControlInput1" required>
		                            </div>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <select class="form-control" name="country" id="country" required onchange="EnableOrDisableVisa();">
		                            <option>Select Country</option>
		                            <?php
		                                foreach ($nationality as $row1) {
		                                  echo "<option>".$row1->en_short_name."</option>";
		                                }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <br>
		            <div class="row" id="visaexpdate" style="display: none;">
		                <div class="col-sm-12">
		                    <div class="form-group">

		                            <div class="mb-3">
		                              <label for="exampleFormControlInput1" class="form-label">Visa Expiration date</label>
		                              <input type="date" name="visaexpdate" class="form-control" id="exampleFormControlInput1">
		                            </div>
		                    </div>
		                </div>
		            </div>
		            <div class="row" id="visaheld" style="display: none;">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="visaheld" placeholder="Current Visa Held"> </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <select class="form-control" name="nationality" required>
		                            <option>Select Nationality</option>
		                            <?php
		                                foreach ($nationality as $row1) {
		                                  echo "<option>".$row1->nationality."</option>";
		                                }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <select class="form-control" name="city" required>
		                            <option>Select City</option>
		                            <option>Jakarta</option>
		                            <option>Manila</option>
		                            <option>Melbourne</option>
		                            <option>Sydney</option>
		                            <option>Surabaya</option>
		                            <option>Other</option>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <select class="form-control" name="qualifications" required>
		                            <option>Select Qualifications</option>
		                            <?php
		                                foreach ($qualifications as $row2) {
		                                  echo "<option>".$row2->value."</option>";
		                                }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <select class="form-control" name="civilstatus" required>
		                            <option>Select Civil Status</option>
		                            <?php
		                                foreach ($civilstatus as $row3) {
		                                  echo "<option>".$row3->value."</option>";
		                                }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <input class="form-control" type="password" name="password"  placeholder="Password" required> </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <input class="form-control" type="password" name="password2" placeholder="Re-type Password" required> </div>
		                </div>
		            </div>
		            <br>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <label for="resume" class="form-label">Resume</label>
		                        <input class="form-control" type="file" name="resume"> 
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
		                        <!-- <label for="name">Name</label> --> <textarea class="form-control" name="notes" placeholder="Notes"></textarea>
		                    </div>
		                </div>
		            </div>
		            <div class=" d-flex flex-column text-center px-5 mt-3 mb-3"><small><input type="checkbox" id="confirm1" name="confirm1"> I have read, understood and content to the Privacy Policy (clickable)</small></div>
		<div class=" d-flex flex-column text-center px-5 mt-3 mb-3"><small><input type="checkbox" id="confirm2" name="confirm2"> I consent to receiving information and updates</small></div> 

		 <canvas id="captcha">captcha text</canvas>
		 <input id="textBox" type="text" class="form-control" name="captcha" placeholder="Enter CAPTCHA Here"> <button id="refreshButton" type="button" class="btn btn-primary btn-block confirm-button">Refresh</button>
		 <span id="output"></span>
		<br><br>
		<button class="btn btn-primary btn-block confirm-button" type="submit" id="submitButton">Register</button>
		        </form>
				
			</div>
			
			<div class="login">
				
				<form class="login100-form validate-form" action="<?php echo base_url(); ?>index.php/clientlogintypical" method="post">
					<br>
					<span class="login100-form-title p-b-43">
						<h3>Login</h3>
						<h4>Already a PSC member? Login Here</h4>
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

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="<?php echo base_url(); ?>index.php/clientforgotpassword" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="btn btn-primary">
							Login
						</button>
					</div>
					
				</form>
			</div>
		</div><br><br><br>
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
    if(window.location.href.includes("/index.php/clientlogin?error3=1") || window.location.href.includes("/index.php/clientlogin")) {
        window.location.href = window.location.protocol+"//"+window.location.host;
    }
</script>
</body>
</html>