<?php include "../db_connect.php"; ?>

<!-- Delete product module -->
<?php 
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
    <div class="container">
      <h1>User management</h1>
      <input type="text" id="userInput" onkeyup="searchUser()" placeholder="Search for names..">
      
      <button type="button" onclick="filterUsers()" class="btn btn-light">Users</button> <button type="button" onclick="filterStaffs()" class="btn btn-light">Staffs</button> <button type="button" onclick="filterAll()" class="btn btn-light">All</button>
      <!--Display all user in tabular form -->
      <tbody>
        <table class="table table-bordered ttb" id="userTable">
          <caption>Users</caption>
          <tr>
            <th>No.
            </th>
            <th>Email
            </th>
            <th>Name
            </th>
            <th>Note
            </th>
            <th>Last Online
            </th>
            <th>Role
            </th>
            <th>Actions
            </th>
          </tr>
          
          <!-- Display all users by retrieving the users from database -->
          <?php
            $query = "SELECT * FROM users";
            $data = $conn->query($query);
            $data->execute();
            $userNo = 0;
            foreach($data as $row)
            {
              $userNo ++;
              $id = $row['userId'];
              echo "<tr><td>" . $userNo . "</td><td>" . $row['email'] . "</td><td>" . $row['name'] . "</td><td>" . $row ['note'] . "</td><td>" . $row['lastSignIn'] . "</td><td>" . $row['role'] . "</td><td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'>" . "<button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button>" . "</td></tr>";
            }
            ?>  
        </table>
      </tbody>
    </div>
  </body>
</html>