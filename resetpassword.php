<?php include "db_connect.php" ?>

<?php
    $reset_password_error_message = "";
    $reset_password_success_message = "";
    $reset_password = "";
    $reset_repeatpassword = "";
    $reset_password_status_suc_message = "";
    $reset_password_status_err_message = "";

    $fp_code = "";
    if (isset($_GET["fp_code"])) {
        $fp_code = $_GET["fp_code"];
        //echo $fp_code;
        $user_check_query = "SELECT * FROM `users` WHERE `forgotPasswordId` = :fp_code LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":fp_code", $fp_code);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (!empty($_POST) && $user) {
                $reset_password = $conn->quote($_POST["reset_password"]);
                $password_encrypted = md5($reset_password);
                $user_update_query = "UPDATE `users` SET `password`='$password_encrypted' WHERE `forgotPasswordId`='$fp_code'";
                $update = $conn->prepare($user_update_query);
                $update->execute();

                $user_update_query = "UPDATE `users` SET `forgotPasswordId`=NULL WHERE `forgotPasswordId`='$fp_code'";
                $update = $conn->prepare($user_update_query);
                $update->execute();

                $reset_password_status_suc_message = "Your account password has been reset successfully. Please login with your new password.";
            } else if (!empty($_POST) && !$user) {
                $reset_password_status_err_message = "Some problem occurred. please try again by clicking link sent to your email after finish submit forgot password form";
            }
        } else {
            $reset_password_status_err_message = "Some problem occurred. please try again or start by entering through the reset password link sent to your email";
        }
        
        // Check whether the identity code exists in the database
        
    } else {
        header('location: index.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    
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
    <!-- Sign up form -->
    <div class="vertical-center">
        <div class="reset-password-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="reset-password-content">
                    <div class="reset-password-form  col-md-6 col-md-offset-3">
                        <h2 class="form-title">Reset Password</h2>
                        <p class="reset-password-instruction">Enter your new password here</p>
                        <?php echo "<span style='color:green'>$reset_password_status_suc_message</span>" ?>
                        <?php echo "<span style='color:red'>$reset_password_status_err_message</span>" ?>
                        <form method="POST" class="reset-password-form-inner" id="reset-password-form" onSubmit="return startResetPasswordValidate()">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-lock"></i></label>
                                    <input type="password" name="reset_password" id="reset-password" placeholder="Your New Password" class="form-control" autocomplete="off" value="<?php echo str_replace(array("'", '"'), "",$reset_password) ?>"/>
                                </div>
                                <span id="reset-password-alert"></span>
                                <?php echo "<span style='color:red'>$reset_password_error_message</span>" ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-lock-1"></i></label>
                                    <input type="password" name="repeat_password" id="reset-repeatpassword" placeholder="Repeat New Password" class="form-control" autocomplete="off" value="<?php echo str_replace(array("'", '"'), "",$reset_repeatpassword) ?>"/>
                                </div>
                                <span id="reset-retypepassword-alert"></span>
                                <?php echo "<span style='color:red'>$reset_password_error_message</span>" ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="resetpassword" id="resetpassword" class="btn btn-info" value="Submit"/>
                                <a class="existing-member" href="login.php" class="reset-password-image-link">I just remember my password</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>    
    </div>
    
    <!-- script.js -->
    <script src="script.js"></script>
</body>
    

</html>