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
        $text = $user_info->status->text;
        $username = $user_info->screen_name;

        $_SESSION["access_token"] = $oauth_token;
        $_SESSION["name"] = $user_name;
        $_SESSION["email"] = $user_info->email;
        unset($_SESSION['oauth_token']);
        header('Location: index.php');
    }else 
    {
        unset($_SESSION['oauth_token']);
        header('Location: login.php');
    }
    }
    
 
?>