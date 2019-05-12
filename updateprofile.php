<?php include "db_connect.php"; ?>

<?php
    $name = $_POST["name"];
    $email = $_POST["email"];
    $id = $_POST["id"];
    $contact = $_POST["contact"];

    $query = "UPDATE `users` SET name = :name, email = :email, contact = :contact WHERE userId = :id";
    $result = $conn->prepare($query);
    $result->bindValue(":id", $id);
    $result->bindValue(":name", $name);
    $result->bindValue(":email", $email);
    $result->bindValue(":contact", $contact);
    $result->execute();
    
?>