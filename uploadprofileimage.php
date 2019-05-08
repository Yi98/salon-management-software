<?php include "db_connect.php"; ?>

<?php 
if ($_FILES["file"]["name"] != "") 
{
    $test = explode(".", $_FILES["file"]["name"]);
    $extension = end($test);
    // From here it limit the number to only from 100 to 999, maybe future can fix it
    $name = rand(100, 999).".".$extension;
    $location = "images/".$name;
    move_uploaded_file($_FILES["file"]["tmp_name"], $location);

    $image_name = file_get_contents($location);
    
    echo $location;
    
    $query = "UPDATE `users` SET `image_path`='$location'  WHERE `userId` = :id";
    $result = $conn->prepare($query);
    $result->bindValue(":id", $_SESSION["id"]);
    $result->execute();
}
?>