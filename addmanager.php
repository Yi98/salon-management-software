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
            if ($user["role"] == "user") {
                echo "<span style='color:red'>Entered email user is not staff yet, only can upgrade staff to manager</span>";
            } else {
                $query = "UPDATE `users` SET `role` = 'manager' WHERE `email` = :email";
                $result = $conn->prepare($query);
                $result->bindValue(":email", $new_staff_email);
                $result->execute();
                echo "<span style='color:green'>Entered email staff have been upgraded to manager</span>";
            }
        } else {
            echo "<span style='color:red'>Email does not exits in the database</span>";
        }
    } else {
        echo "<span style='color:red'>Only Manager can add staff!</span>";
    }
?>