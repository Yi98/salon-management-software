<?php include "db_connect.php"; ?>

<?php
    $name = "";
    $email = "";
    $name_existed_error = " ";
    $email_existed_error = " ";

    if (!empty($_POST)) {
        $signup_password = "";
        $errors = array();
        
        // Get form data from form
        $name = $conn->quote($_POST["name"]);
        $email = $conn->quote($_POST["email"]);
        $signup_password = $conn->quote($_POST["pass"]);
        
        // Trim the data
        $name = trim($name);
        $email = trim($email);
        
        $user_check_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":name", $name);
        $result->bindValue(":email", $email);
        $result->execute();
        
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user["name"] === $name) {
                array_push($errors, "Name already exits");
                $name_existed_error = "Name already taken";
            }
            if ($user["email"] === $email) {
                array_push($errors, "email already exists");
                $email_existed_error = "Email already taken";
            }
        }

        if (count($errors) == 0) {
            // Encrypt password
            $password_encrypted = md5($signup_password);
            // format date
            $date = date("Y-m-d H:i:s");

            $query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, '$password_encrypted', :name, 'user', '', '$date');";
            
            // Insert the user
            $result = $conn->prepare($query);
            $result->bindValue(":name", $name);
            $result->bindValue(":email", $email);
            $result->execute();
            
            // Select the signed user from database
            $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

            $result = $conn->prepare($user_find_query);
            $result->bindValue(":name", $name);
            $result->bindValue(":email", $email);
            $result->execute();

            $newUser = $result->fetch(PDO::FETCH_ASSOC);

            // Clear the form data
            //$name = "";
            //$email = "";
            //$name_existed_error = " ";
            //$email_existed_error = " ";
            
            $_SESSION["id"] = trim($newUser["userId"], "'");
            $_SESSION["name"] = trim($newUser["name"], "'");
            $_SESSION["email"] = trim($newUser["email"], "'");
            $_SESSION["role"] = trim($newUser["role"], "'");
            $_SESSION["success"] = "You are now logged in";
            header('location: index.php');
            exit;
        }
    }
?>

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
    <!-- Sign up form -->
    <div class="vertical-center">
        <div class="sign-up-container container col-md-offset-2 col-md-8">
            <div class="row equal">
                <div class="signup-content">
                    <div class="signup-form  col-md-6">
                        <h2 class="form-title">Sign up</h2>
                        <p class="signup-instruction">Sign up with your social media account or email address</p>
                        <div class="social-media-signup-container">
                            <a href="#" class="fa fa-facebook"></a>
                            <a href="#" class="fa fa-google"></a>
                            <a href="#" class="fa fa-twitter"></a>
                        </div>
                        <div class="or-separator">
                            <p class="or-separator-line"><span class="or-separator-line-text">or</span></p>
                        </div>
                        <form method="POST" class="register-form" id="register-form" autocomplete="autocomplete" action="signup.php" onSubmit="return startSignUpValidate()">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name"><i class="flaticon-id-card"></i></label>
                                    <input type="text" name="name" id="name" placeholder="Your Name" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$name) ?>"/>
                                </div>
                                <span id="signup-name-alert"></span>
                                <?php echo "<span style='color:red'>$name_existed_error</span>" ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                    <input type="text" name="email" id="email" placeholder="Your Email" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$email) ?>"/>
                                   
                                </div>
                                 <span id="signup-email-alert"></span>
                                 <?php echo "<span style='color:red'>$email_existed_error</span>" ?>
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
    
    <!-- script.js -->
    <script src="script.js"></script>
    
</body>
</html>