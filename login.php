<?php include "db_connect.php"; ?>

<?php

    if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) 
    {
        header('location: index.php');
    } else 
    {
        $login_email = "";
        $login_error_message = "";

        if (!empty($_POST)) {
            $login_email = $conn->quote($_POST["email"]);
            $login_password = $conn->quote($_POST["password"]);

            $hashed_password = md5($login_password);

            // Find user from the database's user table
            $user_check_query = "SELECT * FROM `users` WHERE `email` = :email AND `password` = '$hashed_password' LIMIT 1";

            $result = $conn->prepare($user_check_query);
            $result->bindValue(":email", $login_email);
            $result->execute();

            $currentUser = $result->fetch(PDO::FETCH_ASSOC);

            if (is_array($currentUser)) {
                $date = date("Y-m-d H:i:s");
                $id = $currentUser['userId'];
                $user_update_query = "UPDATE `users` SET `lastSignIn`='$date' WHERE `userId`='$id'";
                $update = $conn->prepare($user_update_query);
                $update->execute();

                $_SESSION["id"] = trim($currentUser["userId"], "'");
                $_SESSION["name"] = trim($currentUser["name"], "'");
                $_SESSION["email"] = trim($currentUser["email"], "'");
                $_SESSION["role"] = trim(newUser["role"], "'");
                $_SESSION["success"] = "You are now logged in";
                header('location: index.php');
                exit;
            } else {
                $login_error_message = "Email or Password is incorrect";
            }
        }
    }
?>

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
    <!-- Sign up form -->
    <div class="vertical-center">
        <div class="log-in-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="login-content">
                    <div class="login-form  col-md-6">
                        <h2 class="form-title">Log In</h2>
                        <p class="login-instruction">Log In with your social media account or email address</p>
                        <div class="social-media-login-container">
                            <a href="#" class="fa fa-facebook"></a>
                            <a href="#" class="fa fa-google"></a>
                            <a href="#" class="fa fa-twitter"></a>
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
    
    <!-- script.js -->
    <script src="script.js"></script>
</body>

</html>