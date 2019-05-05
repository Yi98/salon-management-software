<?php include "db_connect.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
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
  
</head>
  
<body>
    <!-- Include navigation bar -->
    <?php include "navigationBar.php" ?>
    
    <div class="container">
      <div class="user-inventory-container">
        <h1>Products</h1>
        <div class="row">
        <!-- Display all products -->
        <?php
          $query = "SELECT * FROM inventories WHERE archive = 'No'";
          $data = $conn->query($query);
          $data->execute();

          foreach($data as $row)
          {
             echo "<div class='col-lg-3 col-xs-3 product-list-img'><embed src='data:". $row['mime']. ";base64," . base64_encode($row['image_name']). "' width='250' height='250' /></br><span class='stock'><b>" . $row['status'] . "</b></span><span><b>RM " . $row['unitPrice'] . "</b></span>
             <p>". $row['inventoryName'] ."</p></div>";
          }
        ?>
          
        </div>
        </div>
    </div>
</body>
  
</html>