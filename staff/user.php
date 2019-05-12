<?php include "../db_connect.php"; ?>
<?php
    if ($_SESSION["role"] != "staff" && $_SESSION["role"] != "manager") {
        header("location: ../index.php");
    }
?>
<!-- Edit user module -->
<?php 
  if(isset($_POST['idEdit'])){
    $idEdit = $_POST['idEdit'];
    $query = "SELECT * FROM users WHERE userId = '$idEdit'";
    $data = $conn->query($query);
    $data->execute();
    
    foreach($data as $row){
      $email = $row['email'];
      $note = $row['note'];
      $name = $row['name'];
      $contact = $row['contact'];
    
    echo "<div class='container' id='userForm'><form method='post' class='editUser container'>
    <h1>Edit user here</h1>
    <div class='form-group col-lg-6 col-xs-6'>
      <label for='email'><b>Email</b></label>
      <input type='email' name='email' class='form-control' value='$email'>
    </div>
    
    <div class='form-group col-lg-6 col-xs-6'>
      <label for='name'><b>Name</b></label>
      <input type='text' name='name' class='form-control' value='$name'>
    </div>
    
    <div class='form-group col-lg-6 col-xs-6'>
      <label for='name'><b>Contact</b></label>
      <input type='text' name='name' class='form-control' value='$contact'>
    </div>
    
    
    <div class='form-group col-lg-12 col-xs-12'>
      <label for='Note'><b>Note</b></label>
      <textarea class='form-control' rows='4' cols='80' name='note' value='$note'></textarea>
    </div>
    
    <div class='form-group col-lg-12 col-xs-12'>
    <button type='submit' name='uesubmit' value='$idEdit' class='btn user-btn btn btn-primary'>Edit</button><button type='button' class='btn user-cancel btn btn-danger user-btn' onclick='closeUserEdit()'>Close</button></div>
    </form></div>";
    }
  }
?>

<!-- Update the edited value to database -->
<?php
  if(isset($_POST['uesubmit'])){
    $id = $_POST['uesubmit'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $note = $_POST['note'];
    
    $query = "UPDATE users SET name = '$name', email = '$email', note = '$note' WHERE userId = '$id'";
    $data = $conn->query($query);
    $data->execute();
  }
?>

<!-- Banned user module -->
<?php 
  if(isset($_POST['idBan'])){
    $idBan = $_POST['idBan'];
    
    echo "<div class='container' id='userForm'><form method='post' class='editUser container' onsubmit='return confirm(\"Ban this user?\");'>
    <h1>Banned user report</h1>
    <div class='form-group col-lg-6 col-xs-6'>
      <label for='reason'><b>Banned reason</b></label>
      <input type='text' name='reason' class='form-control' required>
    </div>
    
    <div class='form-group col-lg-6 col-xs-6'>
      <label for='duration'><b>Banned duration (days)</b></label>
      <select name='duration' class='form-control' required>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='5'>5</option>
        <option value='10'>10</option>
        <option value='15'>15</option>
        <option value='30'>30</option>
      </select>
    </div>
    
    <div class='form-group col-lg-12 col-xs-12'>
    <button type='submit' name='busubmit' value='$idBan' class='btn user-btn btn btn-danger'>Ban</button><button type='button' class='btn user-cancel btn btn-danger user-btn' onclick='closeUserEdit()'>Close</button></div>
    </form></div>";
  }
?>

<!-- Update banned user information to database -->
<?php
  if(isset($_POST['busubmit'])){
    $idBan = $_POST['busubmit'];
    $reason = $_POST['reason'];
    $duration = $_POST['duration'];
    $date = date("Y-m-d");
    $query = "UPDATE users SET banned = 'Yes', bannedDate = '$date', bannedReason = '$reason', bannedDuration = '$duration' WHERE userId = '$idBan'";
    $data = $conn->query($query);
    $data->execute();
  }

?>

<!-- Update unbanned user -->
<?php
  if(isset($_POST['idUnban'])){
    $id = $_POST['idUnban'];
    $query = "UPDATE users SET banned = NULL, bannedDate = NULL, bannedReason = NULL, bannedDuration = NULL WHERE userId = '$id'";
    $data = $conn->query($query);
    $data->execute(); 
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <!-- icon css link -->
    <link rel="stylesheet" type="text/css" href="../font/flaticon.css"/>
    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="../script.js"></script>
  </head>
  <body>
      <!-- Include navigation bar -->
      <?php include "../navigationBar.php" ?>
      
    <div class="container">
      <h1 class="display-4 text-center">User management</h1>
      <input type="text" id="userInput" onkeyup="searchUser()" placeholder="Search for names..">
      
      <div class="col-lg-6 col-xs-6">Filters <button type="button" onclick="filterUsers()" class="btn btn-light">Users</button> <button type="button" onclick="filterStaffs()" class="btn btn-light">Staffs</button> <button type="button" onclick="filterAll()" class="btn btn-light">All</button></div>
        <div class="col-lg-6 col-xs-6"> Tabs <button type="button" onclick="showBannedUser()" class="btn btn-danger">Banned User</button> <button type="button" onclick="hideBannedUser()" class="btn btn-danger">Close Banned User</button></div>
      
     <!--Display all banned user in tabular form (Hide) -->
      <tbody>
        <table class="table table-bordered ttb" id="bannedUserTable">
          <caption>Banned users</caption>
          
          <tr>
            <th>No.
            </th>
            <th>Email
            </th>
              <th>Contact
            </th>
            <th>Name
            </th>
            <th>Reason being banned
            </th>
            <th>Banned days left
            </th>
            <th colspan="2">Actions
            </th>
          </tr>
          
          <!-- Display all banned users by retrieving the users from database -->
          <?php
            $record_per_page = 10;
            $page = '';
            if(isset($_GET['page'])){
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
            $start_from = ($page-1)*$record_per_page;
    
            $query = "SELECT * FROM users WHERE banned = 'Yes' ORDER BY userId ASC LIMIT $start_from, $record_per_page";
            $data = $conn->query($query);
            $data->execute();
            foreach($data as $row)
            {
              $id = $row['userId'];
              $today = date("Y-m-d");
              $duration = "+" . $row['bannedDuration'] . "days";
              $banEnd = date('Y-m-d', strtotime($today . $duration));
              
              $dateToday = strtotime("$today");
              $dateEnd = strtotime("$banEnd");
              
              $days = ($dateEnd - $dateToday)/60/60/24;
              if($days > 1){
                $days = $days . " days";
              }
              
              if($days == 1){
                $days = $days . " day";
              }

              if($days == 0){
                $update = "UPDATE users SET banned = NULL, bannedDate = NULL, bannedReason = NULL, bannedDuration = NULL WHERE userId = '$id'";
                $result = $conn->query($update);
                $result->execute();
              }
              
              echo "<tr><td>" . $row['userId'] . "</td><td>" . $row['email'] . "</td><td>" . $row['contact'] . "</td><td>" . $row['name'] . "</td><td>" . $row ['bannedReason'] . "</td><td><b>" . $days . "</b></td><td><form method='post' onsubmit='return confirm(\"Are you sure you want to unban this user?\");'>" . "<button type='submit' class='btn btn-primary' name='idUnban' value ='$id'>Unban</button></form></td></tr>";
            }
            echo "<div class='page-links'><ul class='pagination'>";
            $page_query = "SELECT COUNT(*) FROM users WHERE banned = 'Yes'";
            $data = $conn->query($page_query);
            $data->execute();
            $num_rows = $data->fetchColumn();
            $total_pages = ceil($num_rows/$record_per_page);
            for($i=1; $i<=$total_pages; $i++){
              echo '<li><a href="user.php?page='. $i . '">' . $i . '</a></li>'; 
            }
            echo "</ul></div>";
          
            ?> 
          
          
        </table>
      </tbody> 
      
      
      <!--Display all user in tabular form -->
      <tbody>
        <table class="table table-bordered ttb" id="userTable">
          <caption>Users</caption>
          <tr>
            <th>No.
            </th>
            <th>Email
            </th>
            <th>Contact
            </th>
            <th>Name
            </th>
            <th>Note
            </th>
            <th>Status
            </th>
            <th>Last Online
            </th>
            <th>Role
            </th>
            <th colspan="2">Actions
            </th>
          </tr>
          
          <!-- Display all users by retrieving the users from database -->
          <?php
            $record_per_page = 10;
            $page = '';
            if(isset($_GET['page'])){
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
            $start_from = ($page-1)*$record_per_page;

            $query = "SELECT * FROM users WHERE banned IS NULL ORDER BY userId ASC LIMIT $start_from, $record_per_page";
            $data = $conn->query($query);
            $data->execute();
            foreach($data as $row)
            {
              $lastSignIn = $row['lastSignIn'];
              $today = date("Y-m-d");
              $dateToday = strtotime("$today");
              $dateLastSignIn = strtotime("$lastSignIn"); 
              $days = ($dateToday - $dateLastSignIn)/60/60/24;
              if ($days <= 30){
                $src = "../images/active-icon.png";
              }
              
              if ($days > 30){
                $src = "../images/inactive-icon.png";
              }
          
              if($days < 1){
                $show = "today";
              }
              
              if($days == 1){
                $show = $days . " day ago";
              }
              if($days > 1){
                $show = $days . " days ago";
              }
              
              $id = $row['userId'];
              echo "<tr><td>" . $row['userId'] . "</td><td>" . $row['email'] . "</td><td>" . $row['contact'] . "</td><td>" . $row['name'] . "</td><td>" . $row ['note'] . "</td><td>" . "<img src='$src' alt='$src'/>" . "</td><td>" . "active <b>" . $show . "</b>" . "</td><td>" . $row['role'] . "</td><td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'>" . "<button type='submit' class='btn btn-primary' name='idEdit' onclick='openUserEdit()' value ='$id'>Edit</button></form></td><td><form method='post' onsubmit='return confirm(\"Ban this user?\");'><button type='submit' class='btn btn-danger' name='idBan' value ='$id'>Ban</button></form></td>" . "</tr>";
            }
            ?>  
        </table>
      </tbody>
      <div class="page-links">
        <ul class="pagination">
          <?php 
            $page_query = "SELECT COUNT(*) FROM users WHERE banned IS NULL";
            $data = $conn->query($page_query);
            $data->execute();
            $num_rows = $data->fetchColumn();
            $total_pages = ceil($num_rows/$record_per_page);
            for($i=1; $i<=$total_pages; $i++){
              echo '<li><a href="user.php?page='. $i . '">' . $i . '</a></li>'; 
            }
          ?>
          </ul>
        </div>
    </div>
          <script src="../script.js"></script>
  </body>
</html>