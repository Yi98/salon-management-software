<?php include "db_connect.php" ?>
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
?>
<?php
    
    $forgot_password_error_message = "";
    $forgot_password_success_message = "";
    $forgot_password_email = "";

    if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) 
    {
        header('location: index.php');
    } else {
        if (!empty($_POST)) {
            $forgot_password_email = $conn->quote($_POST["email"]);
            
            $user_check_query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";

            $result = $conn->prepare($user_check_query);
            $result->bindValue(":email", $forgot_password_email);
            $result->execute();

            $currentUser = $result->fetch(PDO::FETCH_ASSOC);

            if (is_array($currentUser)) {
                // currently here 
                // Generate a unique string
                $uniqidStr = md5(uniqid(mt_rand()));
                
                // THIS ONE HAVEN'T BEING IMPLEMENTED YET
                $check_forgot_password_column_query = 
                "IF COL_LENGTH(`users`, `forgotPasswordId`) IS NULL
                BEGIN
                    ALTER `forgotPasswordId` varchar(32) utf8_unicode_ci DEFAULT NULL,
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
                        $mail->addAddress('bong1hongyeah@gmail.com', $currentUser["name"]);     // Add a recipient

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body    = $mailContent;
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        //echo 'Message has been sent';
                    } catch (Exception $e) {
                        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                    $status = "Success";
                    $message = "Please check your e-mail, we have sent a password reset link to your registered email.";
                    $forgot_password_success_message = $status." ".$message;
                    //header('location: forgotpassword.php');
                    //exit;
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
    <!-- Sign up form -->
    <div class="vertical-center">
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
    
    <!-- script.js -->
    <script src="script.js"></script>
</body>
    

</html>