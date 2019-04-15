<?php
    $name = "";
    $email = "";
    $name_existed_error = " ";
    $email_existed_error = " ";

    if (!empty($_POST)) {
        $signup_password = "";
        $errors = array();
        
        // Get form data from form
        $name = $conn->quote($_POST["name"]);
        $email = $conn->quote($_POST["email"]);
        $signup_password = $conn->quote($_POST["pass"]);
        
        // Trim the data
        $name = trim($name);
        $email = trim($email);
        
        $user_check_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":name", $name);
        $result->bindValue(":email", $email);
        $result->execute();
        
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user["name"] === $name) {
                array_push($errors, "Name already exits");
                $name_existed_error = "Name already taken";
            }
            if ($user["email"] === $email) {
                array_push($errors, "email already exists");
                $email_existed_error = "Email already taken";
            }
        }

        if (count($errors) == 0) {
            // Encrypt password
            $password_encrypted = md5($signup_password);
            // format date
            $date = date("Y-m-d H:i:s");

            $query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, '$password_encrypted', :name, 'user', '', '$date');";
            
            // Insert the user
            $result = $conn->prepare($query);
            $result->bindValue(":name", $name);
            $result->bindValue(":email", $email);
            $result->execute();
            
            // Select the signed user from database 
            $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

            $result = $conn->prepare($user_find_query);
            $result->bindValue(":name", $name);
            $result->bindValue(":email", $email);
            $result->execute();

            $newUser = $result->fetch(PDO::FETCH_ASSOC);

            $_SESSION["id"] = trim($newUser["userId"], "'");
            $_SESSION["name"] = trim($newUser["name"], "'");
            $_SESSION["email"] = trim($newUser["email"], "'");
            $_SESSION["role"] = trim($newUser["role"], "'");
            $_SESSION["success"] = "You are now logged in";
            header('location: index.php');
            exit;
        }
    }
?>
