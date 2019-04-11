<?php include "db_connect.php"; ?>

<?php
  
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $retailprice = $_POST['retailprice'];
    $quantity = $_POST['quantity'];
    $status = "In stock";
    
    $pdoQuery = "INSERT INTO `inventories` (`inventoryName`,`description`,`quantity`,`unitPrice`,`purchasingPrice`,`status`) VALUES (:name,:description,:quantity,:retailprice,:price,:status)";
    $pdoResult = $conn->prepare($pdoQuery);
    $pdoExecute = $pdoResult->execute(array(":name"=>$name,":description"=>$description,":quantity"=>$quantity,":retailprice"=>$retailprice,":price"=>$price,":status"=>$status));
  }
?>

<!-- Change status module -->
<?php 
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $query = "SELECT * FROM inventories";
      $data = $conn->query($query);
      $data->execute();

      foreach($data as $row)
      {
        if ($row['status'] == "In stock"){
          $update = "UPDATE inventories SET status = 'Out of stock' WHERE inventoryId = '$id'";
          $result = $conn->prepare($update);
          $execute = $result->execute();
        }

        if ($row['status'] == "Out of stock"){
          $update = "UPDATE inventories SET status = 'In stock' WHERE inventoryId = '$id'";
          $result = $conn->prepare($update);
          $execute = $result->execute();
        }
      }
    }
?>

<!-- Delete product module -->
<?php 
    if(isset($_POST['idDel'])){
      $id = $_POST['idDel'];
      $query = "SELECT * FROM inventories";
      $data = $conn->query($query);
      $data->execute();

      foreach($data as $row)
      {
        if($row['inventoryId'] == $id){
          $delete = "DELETE FROM inventories WHERE inventoryId = '$id'";
          $result = $conn->prepare($delete);
          $execute = $result->execute();
        }
      }
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
    
    <script src="script.js"></script>
  
</head>
  
<body>
    <div class="container">
        <h1>Products</h1>
      
        <!--Display inventories in tabular form -->
        <div class="col-lg-6 col-xs-6">
            <h1></h1>
        </div>
        
        <div class="col-lg-6 col-xs-6">
            <h1></h1>
        </div>
            
            <!-- Display all products -->
            <?php
              $query = "SELECT * FROM inventories";
              $data = $conn->query($query);
              $data->execute();
              
              foreach($data as $row)
              {
                $inventoryNo ++;
                $id = $row['inventoryId'];
                echo "<tr><td>" . $inventoryNo . "</td>" . "<td>" . $row['inventoryName'] . "</td>" . "<td>" . $row['description'] . "</td>" . "<td>" . $row['quantity'] . "</td>" . "<td>" . $row['unitPrice'] . "</td>" . "<td>" . $row['purchasingPrice'] . "</td>" . "<td>" . $row['status'] . "</td>" . "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'><button type='submit' class='btn btn-primary' name='id' value ='$id'>Change Status</button> " . "<button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button> ". " <button type='submit' class='btn btn-success' name='idArc' value ='$id'>Archive</button>"."</div></form></td></tr>";
              }
            ?>  
          
        </table>
    </div>
      
  
</body>
  
</html>