<?php
    session_start();
    
    unset($_SESSION["id"]);
    unset($_SESSION["name"]); 
    unset($_SESSION["email"]); 
    unset($_SESSION["role"]); 
    unset($_SESSION["success"]);
    unset($_SESSION["access_token"]);
    session_destroy();
    header("Location:index.php");
?>