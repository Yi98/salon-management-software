<?php include "db_connect.php"; ?>
<?php
     if (isset($_SESSION["role"]) && $_SESSION["role"] == "staff" || isset($_SESSION["role"]) && $_SESSION["role"] == "manager") {
        header("location: staff/dashboard.php");
    } else if (isset($_SESSION["role"]) && $_SESSION["role"] == "user") {
        header("location: index.php");
    }
?>
<!-- Social Media Login -->
<?php include "twitterBack.php"; ?>
<?php include "googleLogin.php"; ?>
<?php include "facebookLogin.php"; ?>

<!-- Sign Up process backend logic -->
<?php include "signup-process.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    
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
    <h1 class="display-4  text-center">Sign Up</h1>
    <!-- Sign up form -->
    <div class="vertical-center signup-vertical-center">
        <div class="sign-up-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="signup-content">
                    <div class="signup-form  col-md-6">
                        <h2 class="form-title">Sign up</h2>
                        <p class="signup-instruction">Sign up with your social media account or email address</p>
                        <div class="social-media-signup-container">
                            <a href="<?php echo $fb_login_url; ?>" class="fa fa-facebook"></a>
                            <a href="<?php echo $google_authUrl; ?>" class="fa fa-google"></a>
                            <a href="twitterLogin.php" class="fa fa-twitter"></a>
                        </div>
                        <div class="or-separator">
                            <p class="or-separator-line"><span class="or-separator-line-text">or</span></p>
                        </div>
                        <form method="POST" class="register-form" id="register-form" autocomplete="autocomplete" action="signup.php" onSubmit="return startSignUpValidate()">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name"><i class="flaticon-privacy"></i></label>
                                    <input type="text" name="name" id="name" placeholder="Your Name" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$name) ?>"/>
                                </div>
                                <span id="signup-name-alert"></span>
                                <?php echo "<span style='color:red'>$name_existed_error</span>" ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-mail"></i></label>
                                    <input type="text" name="email" id="email" placeholder="Your Email" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$email) ?>"/>
                                   
                                </div>
                                 <span id="signup-email-alert"></span>
                                 <?php echo "<span style='color:red'>$email_existed_error</span>" ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="contact"><i class="flaticon-auricular-phone-symbol-in-a-circle"></i></label>
                                    <input type="tel" name="contact" id="contact" placeholder="Your contact number" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$tel) ?>"/>
                                   
                                </div>
                                 <span id="contact-email-alert"></span>
                                 <?php echo "<span style='color:red'>$contact_existed_error</span>" ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="pass"><i class="flaticon-lock"></i></label>
                                    <input type="password" name="pass" id="pass" placeholder="Password" class="form-control" />
                                    
                                </div>
                                <span id="signup-password-alert"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="re-pass"><i class="flaticon-lock-1"></i></label>
                                    <input type="password" name="re_pass" id="re-pass" placeholder="Repeat your password" class="form-control"/>
                                </div>
                                <span id="signup-retypepassword-alert"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="signup_user" id="signup" class="btn btn-info" value="Register"/>
                                <a  class="existing-member" href="login.php" class="signup-image-link">I am already member</a>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image col-md-6">
                    <img class="img-fluid" src="images\signup-image.jpg" alt="sign up image">
                    </div>
                </div>
            </div>
        </div>    
    </div>
<?php include "footer.php"; ?>
    <!-- script.js -->
    <script src="script.js"></script>
    
</body>
</html>