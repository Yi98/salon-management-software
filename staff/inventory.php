<?php include "../db_connect.php"; ?>

<?php
  
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $retailprice = $_POST['retailprice'];
    $quantity = $_POST['quantity'];
    $status = "available";
    
    $pdoQuery = "INSERT INTO `inventories` (`inventoryName`,`description`,`quantity`,`unitPrice`,`purchasingPrice`,`status`) VALUES (:name,:description,:quantity,:retailprice,:price,:status)";
    
    $pdoResult = $conn->prepare($pdoQuery);
    $pdoExecute = $pdoResult->execute(array(":name"=>$name,":description"=>$description,":quantity"=>$quantity,":retailprice"=>$retailprice,":price"=>$price,":status"=>$status));
  }
?>

<?php 
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $query = "SELECT * FROM inventories";
              $data = $conn->query($query);
              $data->execute();
            
              foreach($data as $row)
              {
                if ($row['status']=="available"){
                  $update = "UPDATE inventories SET status = 'not available' WHERE inventoryId = '$id'";
                  $result = $conn->prepare($update);
                  $execute = $result->execute();
                }
              }
      echo "<h1>". $_POST['id'] . "</h1>";
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
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
  <!--store the added inventory to database-->

<body>
    <div class="container">
        <h1>Staff Product View</h1>
      
        <div class="row">
            <div class="col-lg-4 col-xs-4 product-c"><button class="addItem" onclick="openForm()"><img src="../images/add.png" alt="add-btn"></button></div>
            
            <!-- Display Existing Product -->
            <?php
              $query = "SELECT * FROM inventories";
              $data = $conn->query($query);
              
              $data->execute();
            

              foreach($data as $row)
              {
                $id = $row['inventoryId'];
                echo "<div class='col-lg-4 col-xs-4 product-c'>". $row['inventoryName'] . "<form method='post'><button type='submit' class='btn btn-primary' name='id' value ='$id'>Change Status</button>" . "</div></form>";
              }
            ?>
        </div>
      
      
        
        <!-- This is the pop up form -->
        <div class="form-popup form-control" id="myForm">
            <form method="post" class="form-container" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit this form?');">
                <fieldset>
                <h1>Add new product</h1>

                <div class="form-group">
                    <label for="product-name"><b>Product Name</b></label>
                    <input type="text" placeholder="Enter new product name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="product-description"><b>Product Description</b></label><br/>
                    <textarea rows="4" cols="80" name="description" placeholder="Enter product description here" class="form-control" required></textarea>
                </div>
                    
                <div class="form-group">    
                    <label for="product-image"><b>Product Image</b></label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                    <!--<input type="submit" value="Upload Image" name="submit">-->
                </div>
                    
                <div class="form-group">    
                    <label for="product-quantity"><b>Product Quantity</b></label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
                  
                <div class="form-group">    
                    <label for="product-price"><b>Product Price (RM)</b></label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                    
                <div class="form-group">
                    <label for="product-retail-price"><b>Product Retail Price (RM)</b></label>
                    <input type="number" name="retailprice" class="form-control" required>
                </div>
                </fieldset>
                
                <button type="submit" name="submit" class="btn">Add</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
  

</body>
  
</html>