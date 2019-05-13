<?php include "db_connect.php"; ?>
<?php
    if (isset($_SESSION["role"]) && $_SESSION["role"] == "staff" || isset($_SESSION["role"]) && $_SESSION["role"] == "manager") {
        header("location: staff/dashboard.php");
    }
?>
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
</head>
  
<body>
    <!-- Include navigation bar -->
    <?php include "navigationBar.php" ?>
    
    <div class="container">
    <h1 class="display-4 text-center">Products</h1>
      <div class="user-inventory-container">
        <div class="row">
        <!-- Display all products -->
        <?php
          $record_per_page = 8;
          $page = '';
          if(isset($_GET['page'])){
            $page = $_GET['page'];
          } else {
            $page = 1;
          }
  
          $start_from = ($page-1)*$record_per_page;
  
          $query = "SELECT * FROM inventories WHERE archive = 'No' ORDER BY inventoryId ASC LIMIT $start_from, $record_per_page";
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
      <div class="page-links">
        <ul class="pagination">
          <?php 
            $page_query = "SELECT COUNT(*) FROM inventories WHERE archive = 'No'";
            $data = $conn->query($page_query);
            $data->execute();
            $num_rows = $data->fetchColumn();
            $total_pages = ceil($num_rows/$record_per_page);
            for($i=1; $i<=$total_pages; $i++){
              echo '<li><a href="inventory.php?page='. $i . '">' . $i . '</a></li>'; 
            }
          ?>
          </ul>
        </div>
    </div>
    
<?php include "footer.php"; ?>
    
     <script src="script.js"></script>
</body>
  
</html>