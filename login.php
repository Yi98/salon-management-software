<?php include "db_connect.php"; ?>

<!-- Social Media Login -->


<?php include "twitterBack.php"; ?>
<?php include "googleLogin.php"; ?>  
<?php include "facebookLogin.php"; ?>

<!-- Log In process backend logic -->
<?php include "login-process.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    
    <!-- icon css link -->
    <link rel="stylesheet" type="text/css" href="font/flaticon.css"/>
    
    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <!-- Include navigation bar -->
    <?php include "navigationBar.php" ?>
    
    <!-- Log In form -->
    <div class="vertical-center">
        <div class="log-in-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="login-content">
                    <div class="login-form  col-md-6">
                        <h2 class="form-title">Log In</h2>
                        <p class="login-instruction">Log In with your social media account or email address</p>
                        <div class="social-media-login-container">
                            <a href="<?php echo $fb_login_url; ?>" class="fa fa-facebook"></a>
                            <a href="<?php echo $google_authUrl; ?>" class="fa fa-google"></a>
                            <a href="twitterLogin.php" class="fa fa-twitter"></a>
                        </div>
                        <div class="or-separator">
                            <p class="or-separator-line"><span class="or-separator-line-text">or</span></p>
                        </div>
                        <?php echo "<span style='color:red'>$login_error_message</span>" ?>
                        <form method="POST" class="login-form" id="login-form" onSubmit="return validateLogInEmail()">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                    <input type="text" name="email" id="login-email" placeholder="Your Login Email" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$login_email) ?>"/>
                                </div>
                                <span id="login-email-alert"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="pass"><i class="flaticon-lock "></i></label>
                                    <input type="password" name="password" id="password" placeholder="Password" class="form-control"/>
                                </div>
                            </div>
                            <a href="forgotPassword.php">Forgot Password?</a>
                            <div class="form-group">
                                <input type="submit" name="login" id="login" class="btn btn-info" value="Log In"/>
                                <a  class="existing-member" href="signup.php" class="login-image-link">Not yet member?</a>
                            </div>
                        </form>
                    </div>
                    <div class="login-image col-md-6">
                    <img class="img-fluid" src="images\login-image.jpg" alt="log in image">
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
    <!-- Pop up form, here for testing, later need to change to dashboard -->
    <?php
        $add_staff_email = "";
        $add_staff_success_message = "";
        $add_staff_error_message = "";
                        
        
    ?>
    <button id="add_new_staff_button" class="btn btn-info">Add new staff</button>
    
    <div class="vertical-center add-staff-popup">
        <div class="add-staff-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="add-staff-content">
                    <div class="add-staff-form  col-md-6 col-md-offset-3">
                        <button id="close_new_staff_button">
                            &times;
                        </button>
                        
                        <h2 class="form-title">Add new staff</h2>
                        <p class="add-staff-instruction">Enter new staff email (new staff required to signed up as a existing user before this action can be proceed)</p>
                        <form method="POST" class="add-staff-form-inner" id="add-staff-form" onSubmit="return addStaffValidation()">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                    <input type="text" name="add-staff-email" id="add-staff-email" placeholder="New staff email" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$add_staff_email) ?>"/>
                                </div>
                                <span id="add-staff-email-alert"></span>
                                <?php echo "<span style='color:green'>$add_staff_success_message</span>" ?>
                                <?php echo "<span style='color:red'>$add_staff_error_message</span>" ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addstaff" id="addstaff" class="btn btn-info" value="Add Staff"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
    <!-- script.js -->
    <script src="script.js"></script>
    <script>
        $("#add_new_staff_button").on("click", function(){
            $(".add-staff-popup").addClass("add-staff-popup-active");
        });
        $("#close_new_staff_button").on("click", function(){
            $(".add-staff-popup").removeClass("add-staff-popup-active");
        });
    </script>
</body>

</html>