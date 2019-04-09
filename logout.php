<?php
    session_start();
    
    unset($_SESSION["id"]);
    unset($_SESSION["name"]); 
    unset($_SESSION["email"]); 
    unset($_SESSION["role"]); 
    unset($_SESSION["success"]);
    session_destroy();
    header("Location:index.php");
?>