<?php include "db_connect.php"; ?>

<?php
    $note = $_POST["note"];
    
    $query = "UPDATE `users` SET note = :note WHERE userId = :id";
    $result = $conn->prepare($query);
    $result->bindValue(":id", $_SESSION["id"]);
    $result->bindValue(":note", $note);
    $result->execute();
?>