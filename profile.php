<?php include "db_connect.php"; ?>

<?php 
    if (!isset($_SESSION["email"]) ) {
        header("Location: index.php");
    }
    if (!isset($_GET["id"])) {
        header("Location:profile.php?id=".$_SESSION["id"]);
    }

    $userId = $_GET["id"];

    // query to get upcoming appoitnemnts
    $getUpcomingQuery = "SELECT * from appointments WHERE userId=$userId AND status='unfulfilled'";
    $upcomingApp = $conn->query($getUpcomingQuery);
    $upcomingApp->setFetchMode(PDO::FETCH_ASSOC);

    // query to get previous appoitnemnt
    $getPreviousQuery = "SELECT * from appointments WHERE userId=$userId AND status='fulfilled'";
    $previousApp = $conn->query($getPreviousQuery);
    $previousApp->setFetchMode(PDO::FETCH_ASSOC);
?>

<?php
    $urlId = $_GET["id"];
    if ($_SESSION["id"] != $urlId && $_SESSION["role"] != "staff") {
        header("Location:profile.php?id=".$_SESSION["id"]);
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>

    
    
  
    <style>
        .row {
            border: 1px solid grey;
            padding:0;
            display:flex;
            flex-wrap: wrap;
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
        .profile-container div:nth-child(1) input{
            width:auto;
        }
    </style>
</head>
  
<body>
    <!-- Include navigation bar -->
    <?php echo "<section id='navigation-bar'>   
            <div class='appointment-container'>
                <nav id='sticky-nav'>
                    <ul>" 
    ?>
    <?php 
        // Check whether the sign in user are staff
        if (isset($_SESSION["id"]) ) {
            if ($_SESSION["role"] == "staff" || $_SESSION["role"] == "manager") {
                echo "<li><p><a href='staff/dashboard.php'>DASHBOARD</a></p></li>
                <li><p><a href='staff/appointment.php'>APPOINTMENT LIST</a></p></li>
                <li><p><a href='staff/inventory.php'>INVENTORY LIST</a></p></li>
                <li><p><a href='staff/user.php'>USER LIST</a></p></li>";
            } else {
                echo "<li><p><a href='index.php'>HOME</a></p></li>
                <li><p><a href='appointment.php'>APPOINTMENT</a></p></li>
                <li><p><a href='inventory.php'>PRODUCT</a></p></li>";
            }
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
            echo '<span>'.$_SESSION["name"].'</span></a>';
        }
    ?>

    <?php 
        if (isset($_SESSION["access_token"])) {
            echo '<li id="logout-button"><p id="logout-nav-btn"><a href="logout.php">LOG OUT</a></p></li>';
        } else {
            if (!isset($_SESSION["id"])) {
                echo '<li id="login-button" ><p id="login-nav-btn"><a href="login.php">LOG IN</a></p></li>';
            } else {
                echo '<li id="logout-button"><p id="logout-nav-btn"><a href="logout.php">LOG OUT</a></p></li>';
            }
        }
    ?>

    <?php 
        echo "</ul>
                </nav>
            </div>
        </section>";
    ?>
    
    
      <h1 class="display-4 text-center"><?php echo $_SESSION["name"]?>'s Profile</h1>
    <div class="container profile-container">
        <div class="row">
        <div class="col-lg-4 col-xs-12 text-center" style="background: #D3D3D3;">
            <figure style="margin:0 auto; width:250px; margin-top:5%;" class="profile-image-figure">
                <?php
                    $query = "SELECT * FROM `users` WHERE `userId`=:id";
     
                    $data = $conn->prepare($query);
                    $data->bindValue(":id", $urlId);
                    $data->execute();
        
                    $profileOwner = $data->fetch(PDO::FETCH_ASSOC);
        
                    if ($profileOwner["image_path"] != NULL) {
                        $image_path = $profileOwner['image_path'];
                        echo "<span id='profile_image'><img  class='img-fluid img-rounded' style='width:100%' src='$image_path'/></span>";
                    } else {
                        echo "<span id='profile_image'><img class='img-fluid img-rounded' style='width:100%' src='images/profile-placeholder.png'/>";
                    }
                ?>
            </figure>
            <p>Profile Image</p>
            
            <input style="display: inline-block; margin-bottom:5%;" type="file" id="file" name="file" accept="image/*">
        </div>
        
        <div class="col-md-offset-1 col-lg-7 col-xs-12">
            <div class="profile_and_edit_section" style="display:flex;align-items: center;">
                <p class="section_title" style="display:inline-block;">Profile</p>

                <div class="edit-and-save-profile" style="display:inline-block; margin-left:auto;">
                    <button class="btn btn-success" form="profile-form"x id='save_profile_button' type='submit' name='saveProfile' >Save Profile</button>
                    <button class="btn btn-info" id='edit_profile_button' type='submit' name='editProfile'>Edit Profile</button>    
                </div>  
            </div>
            <form class="form-group form-inline" method="post" id="profile-form" name="profile-form">
                <?php
                    $profile_query = "SELECT * FROM `users` WHERE userId = :id";
                    $result = $conn->prepare($profile_query);
                    $result->bindValue(":id", $urlId);
                    $result->execute();
                    $profileOwner = $result->fetch(PDO::FETCH_ASSOC);
                ?>
                <p><label for="profile-name">Name: </label><strong><input id="profile-name" class="form-control profile-edit-input" type="text" name="profile-name" <?php echo 'value="'.htmlspecialchars($profileOwner["name"]).'"' ?> disabled/></strong></p>
                <p><label for="profile-email">Email:</label> <strong><input id="profile-email" class="form-control profile-edit-input" type="text" name="profile-email" <?php echo 'value="'.$profileOwner["email"].'"'?> disabled/></strong></p>
                <p><label for="profile-contact">Contact:</label> <strong><input id="profile-contact" class="form-control profile-edit-input" type="text" name="profile-contact" <?php echo 'value="'.$profileOwner["contact"].'"'?> disabled/></strong></p>
                
            </form>
            
            
            <?php
                if ($_SESSION["role"] == "staff" || $_SESSION["role"] == "manager" ) {
                    echo "
                        <div class='note_section' style='display:flex;align-items: center;'>
                            <p class='section_title' style='display:inline-block;'>Notes</p>
                            <div class='edit-and-save-note' style='display:inline-block; margin-left:auto;'>
                                <button class='btn btn-info' id='edit_note_button' type='submit' name='editNote' style='display:inline-block;'>Edit Notes</button>
                                <button class='btn btn-success' form='profile-form' id='save_note_button' type='submit' name='saveNote' style='display:inline-block;'>Save Notes</button>
                            </div>
                        </div>
                       <textarea id='notes_textarea' name='Notes' disabled>".(htmlspecialchars($profileOwner['note']))."</textarea>";
                }
            ?>
            
            <p class="section_title">Upcoming Appointment history</p>

            <table class="ui striped table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Service</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $upcomingApp->fetch()): ?>
                  <tr class="appRow">
                    <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
                    <td><?php echo htmlspecialchars($row['typeOfServices']); ?></td>
                    <td><a id="cancel-app-link" onclick="onUserCancelApp(<?php echo htmlspecialchars($row['appointmentId']); ?>)">Cancel appointment</a></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
            
            <p class="section_title">Previous Appointments history</p>
            <table class="ui striped table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Service</th>
                  <th>Hairdresser</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $previousApp->fetch()): ?>
                  <tr class="appRow">
                    <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
                    <td><?php echo htmlspecialchars($row['typeOfServices']); ?></td>
                    <td><?php echo htmlspecialchars($row['hairdresser']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="ui modal mini delete-app-modal">
      <i class="close icon"></i>
      <div class="header">
        Cancel appointment
      </div>
      <div class="content">
        <div class="description">
          <p>Please note that this action cannot be undone!</p>
          <p>Are you sure you want to cancel?</p>
        </div>
      </div>
      <div class="actions">
        <div class="ui deny button">
          No, I don't mean it
        </div>
        <div class="ui red ok button">
          Yes, cancel it
        </div>
      </div>
    </div>
    
    <?php include "footer.php"; ?>
    
    <script src="script.js"></script>
    <script>
        // Profile Logic
        $("#save_profile_button").hide();
        $("#edit_profile_button").click(function() {
            $(".profile-edit-input").removeAttr("disabled");
            $(this).hide();
            $("#save_profile_button").show();
            $(".profile-edit-input").css("border","2px solid #f4ad42");
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
                            window.location = "<?php echo $_SERVER['REQUEST_URI'] ?>";
                        }
                    })
                }
            });
  
            $('#save_profile_button').click(function(){
                if (confirm("Save your changes on profile?")) {
                    var name = document.getElementById("profile-name").value;
                    var email = document.getElementById("profile-email").value;
                    var contact = document.getElementById("profile-contact").value;
                    var urlId = <?php echo $urlId ?>;
                    $.ajax({
                        type: "POST",
                        url: "updateprofile.php",
                        cache:false,
                        data: {'name': name, 'email': email, 'contact': contact, 'id': urlId},
                        success:function(data) 
                        {
                            window.location = "<?php echo $_SERVER['REQUEST_URI'] ?>";
                        }
                    })
                }
            }); 
            
            $('#save_note_button').click(function(){
                if (confirm("Save your changes on note?")) {
                    var note = document.getElementById("notes_textarea").value;
                    var urlId = <?php echo $urlId ?>;
                    $.ajax({
                        type: "POST",
                        url: "updatenote.php",
                        data: {'note': note,'id':urlId},
                        success:function(data) 
                        {
                            window.location = "<?php echo $_SERVER['REQUEST_URI'] ?>";
                        }
                    })
                }
            }); 
            
        });
    </script>
    <script src="script.js"></script>
</body>
  
</html>