<?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';
    
    $forgot_password_error_message = "";
    $forgot_password_success_message = "";
    $forgot_password_email = "";

    if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) 
    {
        header('location: index.php');
    } else {
        if (!empty($_POST)) {
            $forgot_password_email = $_POST["email"];
            
            $user_check_query = "SELECT * FROM `users` WHERE `email` = :email AND `password` IS NOT NULL";

            $result = $conn->prepare($user_check_query);
            $result->bindValue(":email", $forgot_password_email);
            $result->execute();
            $currentUser = $result->fetch(PDO::FETCH_ASSOC);

            if (is_array($currentUser)) {
                $uniqidStr = md5(uniqid(mt_rand()));
    
                $check_forgot_password_column_query = 
                "IF COL_LENGTH(`users`, `forgotPasswordId`) IS NULL
                BEGIN
                    ALTER `forgotPasswordId` varchar(32) DEFAULT NULL,
                END";
                
                // update data with forgot pass code
                $user_update_query = "UPDATE `users` SET `forgotPasswordId`='$uniqidStr' WHERE `email`=:email";
                $update = $conn->prepare($user_update_query);
                $update->bindValue(":email", $forgot_password_email);
                $update->execute();
                
                if ($update) {
                    $resetPassLink = "http://localhost/salon-management-software/resetPassword.php?fp_code=".$uniqidStr;
                    $subject = "Password Update Request";
                    $mailContent = "Dear ".$currentUser["name"].", <br/>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.<br/>To reset your password, visit the following link: <a href='".$resetPassLink."'>".$resetPassLink."</a><br/><br/>Regards,<br/>Smile and Style Salon";
                    
                    $mail = new PHPMailer(true);
                    /////
                    try {
                        //Server settings
                        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                        $mail->isSMTP();                                            // Set mailer to use SMTP
                        $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'smileandstylesalon@gmail.com';                     // SMTP username
                        $mail->Password   = 'smileandstyle';                               // SMTP password
                        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                        $mail->Port       = 587;                                    // TCP port to connect to
                        $mail->AuthType = 'LOGIN';

                        //Recipients
                        $mail->setFrom('smileandstylesalon@gmail.com', 'Smile And Style Salon');
                        $mail->addAddress($_POST["email"], $currentUser["name"]);     // Add a recipient

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body    = $mailContent;
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                    } catch (Exception $e) {
                        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                    $status = "Success";
                    $message = "Please check your e-mail, we have sent a password reset link to your registered email.";
                    $forgot_password_success_message = $status." ".$message;
                } else {
                    $status = "Error";
                    $message = "Some problem occurred, please try again.";
                    $forgot_password_error_message = $status.$message;
                }
            } else {
                $forgot_password_error_message = "Email entered is not registered or signed up";
            }
        } 
    }
?>