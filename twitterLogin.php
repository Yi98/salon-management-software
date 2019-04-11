<!-- Twitter -->
<?php 
    session_start();

    require "vendor/autoload.php"; 
    use Abraham\TwitterOAuth\TwitterOAuth;


    $connection = new TwitterOAuth("teTUHiwRi9WNg1rhbAMN7TOGX", "zz8O3WgKVMhVfOq8w2MaGhiCW70vfyk49SjJvBsHcmHxus7daU");

    $request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => "http://localhost/salon-management-software/login.php"));


    $_SESSION['oauth_token'] = $request_token['oauth_token'];

    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));

    header('Location: ' . $url);
?>