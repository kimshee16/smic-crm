<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/favicon.png"/>
<title>e-Client Form</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<style>
    body {
    background-color: #FFEBEE
}

.card {
    width: 400px;
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
        <form action="do_upload" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
            <center><img src="<?php echo $asset_url; ?>images/logo-new-no-background-2.png" alt="PSC Logo" width="200px"></center>
            <h6 class="information mt-4">Please provide following information</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="firstname" placeholder="First Name"> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="lastname" placeholder="Last Name"> </div>
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
                        <div class="input-group"> <input class="form-control" type="text" name="mobile" placeholder="Mobile"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group"> <input class="form-control" type="text" name="email" id="email" placeholder="Email Address" required> </div>
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
                        <select class="form-control" name="country" required>
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
                        <!-- <label for="name">Name</label> --> <input class="form-control" type="text" name="noofdependents" placeholder="Dependents"> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                         <label for="name">Remember your password so that you can use it on your transactions to this system.</label> <input class="form-control" type="password" name="password"  placeholder="Password" required> </div>
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
            <div class=" d-flex flex-column text-center px-5 mt-3 mb-3"><small><input type="checkbox" id="confirm1" name="confirm1"> I have read, understood and content to the Privacy Policy (clickable)</small></div>
<div class=" d-flex flex-column text-center px-5 mt-3 mb-3"><small><input type="checkbox" id="confirm2" name="confirm2"> I consent to receiving information and updates</small></div> 

 <!--<canvas id="captcha">captcha text</canvas>-->
 <!--<input id="textBox" type="text" class="form-control" name="captcha" placeholder="Enter CAPTCHA Here"> <button id="refreshButton" type="button" class="btn btn-primary btn-block confirm-button">Refresh</button>-->
 <!--<span id="output"></span>-->
<br><br>
<button class="btn btn-primary btn-block confirm-button" type="submit" id="submitButton">Submit</button>
        </form>
        </div>
    </div>
</div>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
<script type='text/Javascript'>
    // function checkConfirmed(e) {
    //     if (document.getElementById('confirm1').checked != true) {
    //             alert("Please confirm on policy checks!");
    //             e.preventDefault();
    //     } 

    // let submitButton = document.querySelector('#submitButton');
    // submitButton.addEventListener('click', function() {
    //  if (userText.value === c) {
    //  output.classList.add("correctCaptcha");
    //  output.innerHTML = "Correct!";
    //  } else {
    //  output.classList.add("incorrectCaptcha");
    //  output.innerHTML = "Incorrect, please try again";
    //  }
    // });

    

/*
        if (document.getElementById('confirm2').checked != true) {
                alert("Please confirm on consent checks!");
                e.preventDefault();
        }
*/
    // }

    // function checkConfirmed2() {
    //     var baseurl10 = document.getElementById("baseurl").value;
    //     $.ajax({
    //         type: "GET",
    //         url: baseurl10 + "index.php/checkexistingemail"+document.getElementById("email").value,
    //         success: function(data) {
    //             console.log(data);
    //         },
    //         error: function(error) {
    //           console.log(error);
    //         }
    //     });
    // }
    

</script>

<script type='text/javascript'>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault();
            fetch("https://hook.eu2.make.com/71bdysz2v9hrwm0j2q7t5ypamxjmjgin?type=welcomeemail&email="+document.getElementById("email").value, {
                method: "POST"
            })
            .then(response => response.text())
            .then(data => {
                event.target.submit();
            })
            .catch(error => {
                console.error("Error sending data to webhook:", error);
                alert("An error occurred. Please try again.");
            });
        });
    });
</script>

</body>
</html>