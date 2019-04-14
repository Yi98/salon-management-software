<?php include "db_connect.php"; ?>

<?php 
    if (!isset($_SESSION["email"])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["name"]."'s Profile" ?></title>
    
    <!-- icon css link -->
    <link rel="stylesheet" type="text/css" href="font/flaticon.css"/>
    
    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script src="script.js"></script>
  
    <style>
        .profile-container {
            border: 1px solid black;
        }
        .profile-container input {
            border: none;
            background-color: white;
            width: 50%;
        }
        .profile-container textarea {
            resize:none;
            width:100%;
            min-height: 100px;
            max-height:100px;
            overflow-y:auto;
        } 
        .profile-container .section_title {
            font-size:30px;
            font-weight: bold;
            padding: 15px 0 0 0;
            
        }
        .note_section, .profile_and_edit_section {
            margin-bottom: 10px;
        }
        .profile-container div:nth-child(1) input{
            width:auto;
        }
    </style>
</head>
  
<body>
    <div class="container profile-container">
        <div class="col-md-3 text-center">
            <figure style="margin:0 auto; width:250px; margin-top:5%;" class="profile-image-figure">
                <img style="width:100%" src="images/profile-placeholder.png"/>
            </figure>
            <p>Profile Image</p>
            
            <!-- <button>Select File (250px x 250px)</button> -->
            <input type="file" name="image" accept="image/*">
        </div>
        
        <div class="col-md-offset-1 col-md-7">
            <div class="profile_and_edit_section" style="display:flex;align-items: center;">
                <p class="section_title" style="display:inline-block;">Profile</p>
                <div class="edit-and-save-profile" style="display:inline-block; margin-left:auto;">
                    <?php 
                        if (isset($_SESSION["editprofile"])) {
                            echo "<button>Save Profile</button>";
                        } else {
                            echo "<button>Edit Profile</button>";
                        }
                    ?>
                </div>
            </div>
            <p>Name: <strong><input type="text" name="profile-name" value=<?php echo $_SESSION["name"]?> disabled /></strong></p>
            <p>Email: <strong><input type="text" name="profile-email" value=<?php echo $_SESSION["email"]?> disabled/></strong></p>
            
            
            <?php 
                if (isset($_SESSION["role"])) {
                    if ($_SESSION["role"] == "staff") {
                        echo "  <div class='note_section' style='display:flex;align-items: center;'>
                                    <p class='section_title' style='display:inline-block;'>Notes</p>";
                        if (isset($_SESSION["editnote"])) {
                            echo "<button style='display:inline-block; margin-left:auto;'>Edit Notes</button>";
                        } else {
                            echo "<button style='display:inline-block; margin-left:auto;'>Save Notes</button>";
                        }
                        echo "</div>";
                        echo "<textarea id='notes_textarea' name='Notes'></textarea>";
                    }
                }
            ?>
            
            <p class="section_title">Upcoming Appointment history</p>
            <?php
                $id = $_SESSION["id"];
                $query = "SELECT * FROM appointments WHERE userId = '$id' AND status='unfulfilled'";
                $data = $conn->query($query);
                $data->execute();
                $result = $data->fetch(PDO::FETCH_ASSOC);
        
                if ($result) {
                    echo "  <table class='ui striped table'>
                                <thead>
                                    <tr>
                                      <th>User Id</th>
                                      <th>Date</th>
                                      <th>Time</th>
                                      <th>Details</th>
                                    </tr>
                                </thead>
                            </table>";
                    foreach($data as $row)
                    {
                        echo "  <tbody>
                                    
                                </tbody>";
                    }
                } else {
                    echo "No Upcoming appointments";
                }
            ?>  
            
            <p class="section_title">Previous Appointments history</p>
            <?php
                $id = $_SESSION["id"];
                $query = "SELECT * FROM appointments WHERE userId = '$id' AND status='fulfilled'";
                $data = $conn->query($query);
                $data->execute();
                $result = $data->fetch(PDO::FETCH_ASSOC);
            
                if ($result) {
                    foreach($data as $row)
                    {
                        echo "1";
                    }
                } else {
                    echo "No Previous Appointment history";
                }
            ?>  
        </div>
    </div>
    
    <script>
        
    </script>
</body>
  
</html>