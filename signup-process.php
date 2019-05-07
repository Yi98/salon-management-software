<?php
    $name = "";
    $email = "";
    $tel = "";
    $name_existed_error = " ";
    $email_existed_error = " ";
    $contact_existed_error = " ";

    if (!empty($_POST)) {
        $signup_password = "";
        $errors = array();
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
        $signup_password = $_POST["pass"];
        
        // Trim the data
        $name = trim($name);
        $email = trim($email);
        $contact = trim($contact);
        
        $user_check_query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";

        $result = $conn->prepare($user_check_query);
        $result->bindValue(":email", $email);
        $result->execute();
        
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
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

            $query = "INSERT INTO `users` (email, password, contact, name, role, note, lastSignIn) VALUES (:email, '$password_encrypted', :contact, :name, 'user', '', '$date');";
            
            // Insert the user
            $result = $conn->prepare($query);
            $result->bindValue(":name", $name);
            $result->bindValue(":email", $email);
            $result->bindValue(":contact", $contact);
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
            if ($_SESSION["role"] == "user") {
                header('location: index.php');
                exit;
            } else {
                header('location: staff/dashboard.php');
            }
          
        }
    }
?>
