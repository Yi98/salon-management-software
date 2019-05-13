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
    
    <h1 class="display-4  text-center">Login</h1>
    <!-- Log In form -->
    <div class="vertical-center login-vertical-center">
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
                                    <label class="input-group-addon" for="email"><i class="flaticon-mail"></i></label>
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
<?php include "footer.php"; ?>

        <!-- script.js -->
    <script src="script.js"></script>
</body>

</html>