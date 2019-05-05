<?php echo "<section id='navigation-bar'>   
            <div class='appointment-container'>
                <nav id='sticky-nav'>
                    <ul>" 
?>
<?php 
    // Check whether the sign in user are staff
    if ( isset($_SESSION["id"]) && $_SESSION["role"] == "staff") {
        echo "<li><p><a href='dashboard.php'>DASHBOARD</a></p></li>
        <li><p><a href='appointment.php'>APPOINTMENT LIST</a></p></li>
        <li><p><a href='inventory.php'>INVENTORY LIST</a></p></li>
        <li><p><a href='user.php'>USER LIST</a></p></li>";
    } else {
        echo "<li><p><a href='index.php'>HOME</a></p></li>
        <li><p><a href='appointment.php'>APPOINTMENT</a></p></li>
        <li><p><a href='inventory.php'>PRODUCT</a></p></li>";
    }
?>

<?php
    if (isset($_SESSION["id"]) && !empty($_SESSION["id"]) || isset($_SESSION["access_token"])) {
        $query = "SELECT * FROM `users` WHERE `userId`=:id";

        $data = $conn->prepare($query);
        $data->bindValue(":id", $_SESSION["id"]);
        $data->execute();

        $currentUser = $data->fetch(PDO::FETCH_ASSOC);
        $id = $_SESSION["id"];
        if ($currentUser["image_path"] != NULL) {
            $image_path = $currentUser['image_path'];
            if ($currentUser["role"] == "staff") {
                echo "<a style='color:black;text-decoration:none;' href='../profile.php?id=$id'><span id='profile_image'><img style='height:auto; max-height:40px; margin-right:1%;' src='../'.'$image_path'/></span>";
            } else {
                echo "<a style='color:black;text-decoration:none;' href='profile.php?id=$id'><span id='profile_image'><img style='height:auto; max-height:40px; margin-right:1%;' src='$image_path'/></span>";
            }
        } else {
            if ($currentUser["role"] == "staff") {
                echo "<a style='color:black;text-decoration:none;' href='../profile.php?id=$id'><span id='profile_image'><img id='profile_image_placeholder' style='height:auto; max-height:40px; margin-right:1%;' src='../images/profile-placeholder.png'/></span>";
            } else {
                echo "<a style='color:black;text-decoration:none;' href='profile.php?id=$id'><span id='profile_image'><img id='profile_image_placeholder' style='height:auto; max-height:40px; margin-right:1%;' src='images/profile-placeholder.png'/></span>";
            }
        }
        echo '<span>'.$_SESSION["name"].'</span></a>';
    }
?>
                        
<?php 
    if (isset($_SESSION["access_token"])) {
        if ($_SESSION["role"] == "staff") {
            echo '<li id="logout-button"><p id="logout-nav-btn"><a href="logout.php">LOG OUT</a></p></li>';
        } else {
            echo '<li id="logout-button"><p id="logout-nav-btn"><a href="../logout.php">LOG OUT</a></p></li>';
        }
    } else {
        if (!isset($_SESSION["id"]) && empty($_SESSION["id"])) {
            echo '<li id="login-button" ><p id="login-nav-btn"><a href="login.php">LOG IN</a></p></li>';
        } else {
            if ($_SESSION["role"] == "staff") {
                echo '<li id="logout-button"><p id="logout-nav-btn"><a href="logout.php">LOG OUT</a></p></li>';
            } else {
                echo '<li id="logout-button"><p id="logout-nav-btn"><a href="../logout.php">LOG OUT</a></p></li>';
            }
        }
    }
?>

<?php 
    echo "</ul>
            </nav>
        </div>
    </section>"
?>