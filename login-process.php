<?php 
    $login_email = "";
    $login_error_message = "";
    if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) 
    {
        header('location: index.php');
    } else if (isset($_POST["login"]))
    {
        if (!empty($_POST)) {
            $login_email = $_POST["email"];
            $login_password = $_POST["password"];

            $hashed_password = md5($login_password);

            // Find user from the database's user table
            $user_check_query = "SELECT * FROM `users` WHERE `email` = :email AND `password` = '$hashed_password' LIMIT 1";

            $result = $conn->prepare($user_check_query);
            $result->bindValue(":email", $login_email);
            $result->execute();

            $currentUser = $result->fetch(PDO::FETCH_ASSOC);

            if (is_array($currentUser)) {
                if ($currentUser['banned'] === NULL){
                  $date = date("Y-m-d H:i:s");
                  $id = $currentUser['userId'];
                  $user_update_query = "UPDATE `users` SET `lastSignIn`='$date' WHERE `userId`='$id'";
                  $update = $conn->prepare($user_update_query);
                  $update->execute();

                  $_SESSION["id"] = trim($currentUser["userId"], "'");
                  $_SESSION["name"] = trim($currentUser["name"], "'");
                  $_SESSION["email"] = trim($currentUser["email"], "'");
                  $_SESSION["role"] = trim($currentUser["role"], "'");
                  $_SESSION["success"] = "You are now logged in";
                  if ($_SESSION["role"] == "user") {
                      header('location: index.php');
                  } else {
                      header('location: staff/dashboard.php');
                  }
                  exit;
                } else {
                  $login_error_message = "User has been banned. Please contact 03-3338383 for further assistance.";
                }
        
                
            } else {
                $login_error_message = "Email or Password is incorrect";
            }
        }
    }
?>
