<?php include "db_connect.php"; ?>

<?php 
    if ($_SESSION["role"] == "manager") {
        $new_staff_email = $_POST["email"];

        $user_check_query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":email", $new_staff_email);
        $result->execute();

        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $query = "UPDATE `users` SET `role` = 'staff' WHERE `email` = :email";
            $result = $conn->prepare($query);
            $result->bindValue(":email", $new_staff_email);
            $result->execute();
            echo "<span style='color:green'>Entered email user have been upgraded to staff</span>";
        } else {
            echo "<span style='color:red'>Email does not exits in the database</span>";
        }
    } else {
        echo "<span style='color:red'>Only Manager can add staff!</span>";
    }
?>