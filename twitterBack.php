
<!-- Twitter Login -->
<?php 

    require "vendor/autoload.php"; 
    use Abraham\TwitterOAuth\TwitterOAuth;

    if (isset($_SESSION['oauth_token'])){
        if($_GET['oauth_token'] || $_GET['oauth_verifier'])
    {
            
        $connection = new TwitterOAuth("teTUHiwRi9WNg1rhbAMN7TOGX", "zz8O3WgKVMhVfOq8w2MaGhiCW70vfyk49SjJvBsHcmHxus7daU", $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $access_token = $connection->oauth('oauth/access_token', array('oauth_verifier' => $_REQUEST['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));

        $connection = new TwitterOAuth("teTUHiwRi9WNg1rhbAMN7TOGX", "zz8O3WgKVMhVfOq8w2MaGhiCW70vfyk49SjJvBsHcmHxus7daU", $access_token['oauth_token'], $access_token['oauth_token_secret']);
        
        $params = array('include_email'=>'true','include_entitiles'=>'false','skip_status'=>'true');
        $user_info = $connection->get('account/verify_credentials', $params);
            
        $oauth_token = $access_token['oauth_token'];
        $oauth_token_secret = $access_token['oauth_token_secret'];
            
        $user_id = $user_info->id;
        $user_name = $user_info->name;
        $user_pic = $user_info->profile_image_url_https;

        $username = $user_info->screen_name;

        $_SESSION["access_token"] = $oauth_token;
        $_SESSION["name"] = $user_name;
        $_SESSION["email"] = $user_info->email;
        $_SESSION["role"] = "user";
            
        //
        $user_check_query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":email", $user_info->email);
        $result->execute();

        $userdatabase = $result->fetch(PDO::FETCH_ASSOC);
        $date = date("Y-m-d H:i:s");
        if ($userdatabase) {
            if ($userdatabase["email"] == $user_info->email) {
                $user_update_query = "UPDATE `users` SET `lastSignIn`='$date' WHERE `userId`=:id";
                $update = $conn->prepare($user_update_query);
                $update->bindValue(":id",  $userdatabase["userId"]);
                $update->execute();
                
                $_SESSION["id"] = $userdatabase["userId"];
                $_SESSION["name"] = $userdatabase["name"];
                               $_SESSION["role"] = $userdatabase["role"];
                $_SESSION["email"] = $userdatabase["email"];
 
 
            } else {
                $user_store_query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, NULL, :name, 'user', '', '$date')";
                // Insert the user
                $result = $conn->prepare($user_store_query);
                $result->bindValue(":name",  $user_name);
                $result->bindValue(":email", $user_info->email);
                $result->execute();

                 // Select the signed user from database 
                $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

                $result = $conn->prepare($user_find_query);
                $result->bindValue(":name",  $user_name);
                $result->bindValue(":email", $user_info->email);
                $result->execute();

                $newUser = $result->fetch(PDO::FETCH_ASSOC);

                $_SESSION["id"] = $newUser["userId"];
                $_SESSION["name"] = $user_name;
                $_SESSION["email"] = $user_info->email;
                $_SESSION["role"] = "user";
            }
        } else {
            $date = date("Y-m-d H:i:s");
                $user_store_query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, NULL, :name, 'user', '', '$date')";
                // Insert the user
                $result = $conn->prepare($user_store_query);
                $result->bindValue(":name",  $user_name);
                $result->bindValue(":email", $user_info->email);
                $result->execute();

                 // Select the signed user from database 
                $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

                $result = $conn->prepare($user_find_query);
                $result->bindValue(":name",  $user_name);
                $result->bindValue(":email", $user_info->email);
                $result->execute();

                $newUser = $result->fetch(PDO::FETCH_ASSOC);

                $_SESSION["id"] = $newUser["userId"];
                $_SESSION["name"] = $user_name;
                $_SESSION["email"] = $user_info->email;
                $_SESSION["role"] = "user";
        }
            
        unset($_SESSION['oauth_token']);
        
        if ($_SESSION["role"] != "user") {
            header('Location: staff/dashboard.php');    
            exit();
        } else {
            header('Location: index.php');
            
        }

    }else 
    {
        unset($_SESSION['oauth_token']);
        header('Location: login.php');
    }
    }
    
 
?>