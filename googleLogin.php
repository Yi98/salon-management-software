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
        $_SESSION["role"] = "user";
        header("Location: index.php");
      }
        
    } else {
      $google_authUrl = $client->createAuthUrl();
    }


?>