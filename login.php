<?php include "db_connect.php"; ?>
<?php include "twitterBack.php"; ?>

<!-- Overall login php -->
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
<!-- Unsure why facebook need to be on the bottom, while google top to allow login happen -->
<!-- Google social login -->

<?php

    require "vendor/autoload.php"; 

    $client_id = '993021568317-9a6ejtq7kb5ipc99tl9u1dscoa9iahj4.apps.googleusercontent.com';
    $client_secret = 'oMtXNC8ZXVsFSOTg4Lkk3ZgE';
    $redirect_uri = 'http://localhost/salon-management-software/login.php';
    $simple_api_key = 'AIzaSyAPkP_QS-PgGrnbJsoKkDwbJgM_cOIx1IE';

    $client = new Google_Client();
    $client->setApplicationName("PHP Google OAuth Login Example");
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->setDeveloperKey($simple_api_key);
    $client->addScope(array("https://www.googleapis.com/auth/userinfo.profile", "https://www.googleapis.com/auth/userinfo.email"));
    $client->setAccessType ("offline");
    $client->setApprovalPrompt ("force");

    if (isset($_GET['code'])) {
      $client->authenticate($_GET['code']);
        // ACCESS TOKEN RETURN NULL
      $_SESSION['access_token'] = $client->getAccessToken();
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }

    //Set Access Token to make Request
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
    }

    //Get User Data from Google Plus
    //If New, Insert to Database
    if ($client->getAccessToken()) {
      $objOAuthService =  new \Google_Service_Oauth2($client);
      $userData = $objOAuthService->userinfo->get();
      if(!empty($userData)) {
        $_SESSION["access_token"] = implode(" ",($client->getAccessToken()));
        $_SESSION["name"] = $userData["name"];
        $_SESSION["email"] = $userData["email"];
        header("Location: index.php");
      }
        
    } else {
      $authUrl = $client->createAuthUrl();
    }

?>  

<!-- Facebook login php  -->
<?php
    require "vendor/autoload.php";

    $fb = new Facebook\Facebook([
        "app_id" => "2199009383524440",
        "app_secret" => "20beaba1dc33f9db6a3a703979723015",
        "default_graph_version" => "v2.7"
        
    ]);
    
    $helper = $fb->getRedirectLoginHelper();
    $login_url = $helper->getLoginUrl("http://localhost/salon-management-software/login.php",["email"]);
    

    try {
        $accessToken = $helper->getAccessToken();
        if (isset($accessToken)) {
            // Problem Here
            $_SESSION["access_token"] = (string)$accessToken;
            
            if ($_SESSION["access_token"]) {
                try {
                    //$info = explode('=', $accessToken);
                    //$fb->setDefaultAccessToken($info[1]);
                    $fb->setDefaultAccessToken($_SESSION["access_token"]);
                    $res = $fb->get("/me?locale=en_US&fields=name,email", $_SESSION["access_token"]);
                    $user = $res->getGraphUser();
                    $_SESSION["name"] = $user->getField("name");
                    $_SESSION["email"] = $user->getField("email");
                    header("Location: index.php");
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
            
            //header("Location: index.php");
            
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
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
                            <a href="<?php echo $login_url; ?>" class="fa fa-facebook"></a>
                            <a href="<?php echo $authUrl; ?>" class="fa fa-google"></a>
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
    
    <!-- script.js -->
    <script src="script.js"></script>
</body>

</html>