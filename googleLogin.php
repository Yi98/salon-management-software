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
      $_SESSION['google_access_token'] = $client->getAccessToken();
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }

    //Set Access Token to make Request
    if (isset($_SESSION['google_access_token']) && $_SESSION['google_access_token']) {
      $client->setAccessToken($_SESSION['google_access_token']);
    }

    //Get User Data from Google Plus
    //If New, Insert to Database
    if ($client->getAccessToken()) {
      $objOAuthService =  new \Google_Service_Oauth2($client);
      $userData = $objOAuthService->userinfo->get();
      if(!empty($userData)) {
        $_SESSION["google_access_token"] = implode(" ",($client->getAccessToken()));
          // REMOVE THREE LINES BELOW
        $_SESSION["name"] = $userData["name"];
        $_SESSION["email"] = $userData["email"];
        $_SESSION["role"] = "user";
          //
        $user_check_query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":email", $userData["email"]);
        $result->execute();

        $userdatabase = $result->fetch(PDO::FETCH_ASSOC);
        $date = date("Y-m-d H:i:s");
        if ($userdatabase) {

                $user_update_query = "UPDATE `users` SET `lastSignIn`='$date' WHERE `userId`=:id";
                $update = $conn->prepare($user_update_query);
                $update->bindValue(":id",  $userdatabase["userId"]);
                $update->execute();
                
                $_SESSION["id"] = $userdatabase["userId"];
                $_SESSION["name"] = $userdatabase["name"];
                $_SESSION["email"] = $userData["email"];
                $_SESSION["role"] = $userdatabase["role"];

        } else {
            $date = date("Y-m-d H:i:s");
                $user_store_query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, NULL, :name, 'user', '', '$date')";
                // Insert the user
                $result = $conn->prepare($user_store_query);
                $result->bindValue(":name",  $userData["name"]);
                $result->bindValue(":email", $userData["email"]);
                $result->execute();

                 // Select the signed user from database 
                $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

                $result = $conn->prepare($user_find_query);
                $result->bindValue(":name",  $userData["name"]);
                $result->bindValue(":email", $userData["email"]);
                $result->execute();

                $newUser = $result->fetch(PDO::FETCH_ASSOC);

                $_SESSION["id"] = $newUser["userId"];
                $_SESSION["name"] = $userData["name"];
                $_SESSION["email"] = $userData["email"];
                $_SESSION["role"] = "user";
        }

        if ($_SESSION["role"] != "user") {
            header('Location: staff/dashboard.php');    
            exit();
        } else {
            header('Location: index.php');
        }
      }
        
    } else {
      $google_authUrl = $client->createAuthUrl();
    }


?>