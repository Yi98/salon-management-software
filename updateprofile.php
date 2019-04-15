<?php include "db_connect.php"; ?>

<?php
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    
    echo "<img style='width:100%' src='".$location."'/>";

    $query = "UPDATE `users` SET name = :name, email = :email WHERE userId = :id";
    $result = $conn->prepare($query);
    $result->bindValue(":id", $_SESSION["id"]);
    $result->bindValue(":name", $conn->quote($name));
    $result->bindValue(":email", $conn->quote($email));
    $result->execute();
?>