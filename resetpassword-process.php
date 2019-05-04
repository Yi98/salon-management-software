<?php
    $reset_password = "";
    $reset_repeatpassword = "";
    $reset_password_error_message = "";
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