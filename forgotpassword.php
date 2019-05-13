<?php include "db_connect.php" ?>
<?php include "forgotpassword-process.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password?</title>
    
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
    
    <!-- Sign up form -->
    <div class="vertical-center forgot-vertical-center">
        <div class="forgot-password-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="forgot-password-content">
                    <div class="forgot-password-form  col-md-6 col-md-offset-3">
                        <h2 class="form-title">Forgot Password</h2>
                        <p class="forgot-password-instruction">Enter you email address that you used to register. We'll send you an email with your username and a link to reset your password</p>
                        <form method="POST" class="forgot-password-form-inner" id="forgot-password-form" onSubmit="return forgotPasswordEmailValidation()">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                    <input type="text" name="email" id="forgot-password-email" placeholder="Your Registered Email" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$forgot_password_email) ?>"/>
                                </div>
                                <span id="forgot-password-email-alert"></span>
                                <?php echo "<span style='color:green'>$forgot_password_success_message</span>" ?>
                                <?php echo "<span style='color:red'>$forgot_password_error_message</span>" ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="forgotpassword" id="forgotpassword" class="btn btn-info" value="Submit"/>
                                <a class="existing-member" href="login.php" class="forgot-password-image-link">I just remember my password</a>
                            </div>
                        </form>
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