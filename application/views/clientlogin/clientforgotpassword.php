<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/logo.png"/>
<title><?php echo $title; ?></title>
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
            <center><img src="<?php echo $asset_url; ?>images/logomain.png" alt="PSC Logo" width="200px"></center><br>
            <h5>Forgot Password</h5>
            <center>
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
                    } else if (isset($_GET['error4'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">Passwords are different!</div>
                    <?php
                    }
                    ?>
                <form action="<?php echo base_url(); ?>index.php/clientforgotpasswordsend" method="POST">
                    <input type="email" class="form-control" name="email" placeholder="Type email address">
                    <input type="password" class="form-control" name="password1" placeholder="Type password">
                    <input type="password" class="form-control" name="password2" placeholder="Confirm password"><br>
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </form>
            </center>
            <center><a href="<?php echo base_url(); ?>">Go Back</a></center>
        </div>
    </div>
</div>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
<script type='text/javascript' src=''></script>
<script type='text/javascript' src=''></script>
<script type='text/Javascript'>
    function checkConfirmed(e) {
        if (document.getElementById('confirm1').checked != true) {
                alert("Please confirm on policy checks!");
                e.preventDefault();
        } 

    let submitButton = document.querySelector('#submitButton');
    submitButton.addEventListener('click', function() {
     if (userText.value === c) {
     output.classList.add("correctCaptcha");
     output.innerHTML = "Correct!";
     } else {
     output.classList.add("incorrectCaptcha");
     output.innerHTML = "Incorrect, please try again";
     }
    });

/*
        if (document.getElementById('confirm2').checked != true) {
                alert("Please confirm on consent checks!");
                e.preventDefault();
        }
*/
    }

</script>
<script type='text/javascript' src='<?php echo $asset_url; ?>js/captcha_script.js'></script>
</body>
</html>