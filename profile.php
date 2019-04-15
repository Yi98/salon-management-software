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
                <?php
                    $query = "SELECT * FROM `users` WHERE `userId`=:id";
     
                    $data = $conn->prepare($query);
                    $data->bindValue(":id", $_SESSION["id"]);
                    $data->execute();
        
                    $currentUser = $data->fetch(PDO::FETCH_ASSOC);
        
                    if ($currentUser["image_path"] != NULL) {
                        $image_path = $currentUser['image_path'];
                        echo "<span id='profile_image'><img style='width:100%' src='$image_path'/></span>";
                    } else {
                        echo "<span id='profile_image'><img style='width:100%' src='images/profile-placeholder.png'/>";
                    }
                ?>
            </figure>
            <p>Profile Image</p>
            
            <input type="file" id="file" name="file" accept="image/*">
        </div>
        
        <div class="col-md-offset-1 col-md-7">
            <div class="profile_and_edit_section" style="display:flex;align-items: center;">
                <p class="section_title" style="display:inline-block;">Profile</p>
                <div class="edit-and-save-profile" style="display:inline-block; margin-left:auto;">
                    <button form="profile-form" id='save_profile_button' type='submit' name='saveProfile' >Save Profile</button>
                    <button id='edit_profile_button' type='submit' name='editProfile'>Edit Profile</button>    
                </div>  
            </div>
            <form method="post" id="profile-form" name="profile-form">
                <?php
                    $profile_query = "SELECT * FROM `users` WHERE userId = :id";
                    $result = $conn->prepare($profile_query);
                    $result->bindValue(":id", $_SESSION["id"]);
                    $result->execute();
                    $currentUser = $result->fetch(PDO::FETCH_ASSOC);
                ?>
                <p>Name: <strong><input id="profile-name" class="profile-edit-input" type="text" name="profile-name" value=<?php echo  htmlspecialchars($currentUser["name"]); ?> disabled/></strong></p>
                <p>Email: <strong><input id="profile-email" class="profile-edit-input" type="text" name="profile-email" value=<?php echo $currentUser["email"]?> disabled/></strong></p>
                
            </form>
            
            
            <div class='note_section' style='display:flex;align-items: center;'>
                <p class='section_title' style='display:inline-block;'>Notes</p>
                <div class="edit-and-save-note" style="display:inline-block; margin-left:auto;">
                    <button id="edit_note_button" type='submit' name='editNote' style='display:inline-block;'>Edit Notes</button>
                    <button form="profile-form" id="save_note_button" type='submit' name='saveNote' style='display:inline-block;'>Save Notes</button>
                </div>
            </div>
           <textarea id='notes_textarea' name='Notes' disabled><?php echo htmlspecialchars($currentUser["note"]); ?></textarea>

            
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
        // Profile Logic
        $("#save_profile_button").hide();
        $("#edit_profile_button").click(function() {
            $(".profile-edit-input").removeAttr("disabled");
            $(this).hide();
            $("#save_profile_button").show();
        }) 
        $("#save_profile_button").click(function() {
            $(".profile-edit-input").attr("disabled", true);
            $(this).hide();
            $("#edit_profile_button").show();
        })
        
        // Note Logic
        $("#save_note_button").hide();
        $("#edit_note_button").click(function() {
            $("#notes_textarea").removeAttr("disabled");
            $(this).hide();
            $("#save_note_button").show();
        }) 
        $("#save_note_button").click(function() {
            $("#notes_textarea").attr("disabled", true);
            $(this).hide();
            $("#edit_note_button").show();
        })
        
        $(document).ready(function() {
            $(document).on("change", "#file", function () {
                var property = document.getElementById("file").files[0];
                var image_name = property.name;
                var image_extension = image_name.split(".").pop().toLowerCase();
                if (jQuery.inArray(image_extension, ["gif", "png", "jpg", "jpeg"]) == -1) {
                    alert("Invalid Image File");
                }
                var image_size = property.size;
                if (image_size > 2000000) {
                    alert("Image File Size is very big");
                } else {
                    var form_data = new FormData();
                    form_data.append("file", property);
                    $.ajax({
                        url: "uploadprofileimage.php",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache:false,
                        processData:false,
                        success:function(data) 
                        {
                            $("#profile_image").html(data);    
                        }
                    })
                }
            });
            $('#save_profile_button').click(function(){
                if (confirm("Save your changes on profile?")) {
                    var name = document.getElementById("profile-name").value;
                    var email = document.getElementById("profile-email").value;
                    $.ajax({
                    type: "POST",
                    url: "updateprofile.php",
                    data: {'name': name, 'email': email},
                    dataType:'json',
                    success:function(data) 
                    {
                        location.reload();
                    }
                    });
                }
            }); 
            $('#save_note_button').click(function(){
                if (confirm("Save your changes on note?")) {
                    var note = document.getElementById("notes_textarea").value;
                    $.ajax({
                        type: "POST",
                        url: "updatenote.php",
                        data: {'note': note},
                        dataType:'json',
                        success:function(data) 
                        {
                            location.reload();
                        }
                    });
                }
            }); 
            
        });

    </script>
</body>
  
</html>