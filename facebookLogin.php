 <?php 
    require "vendor/autoload.php";

    $fb = new Facebook\Facebook([
        "app_id" => "2199009383524440",
        "app_secret" => "20beaba1dc33f9db6a3a703979723015",
        "default_graph_version" => "v2.7"
    ]);
    
    $helper = $fb->getRedirectLoginHelper();
    $fb_login_url = $helper->getLoginUrl("http://localhost/salon-management-software/login.php",["email"]);
    
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
                    $_SESSION["role"] = "user";
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