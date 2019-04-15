<?php include "../db_connect.php"; ?>
<!-- Insert new product module -->
<?php
  if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $retailprice = $_POST['retailprice'];
  $quantity = $_POST['quantity'];
  if ($quantity <= 4){
    $status = "Limited stock";
  }
  if ($quantity >= 5){
    $status = "In stock";
  }
  if ($quantity == 0){
    $status = "Out of stock";
  }
  $archive = "No";
  $brand = $_POST['brand'];
  $manufacturer = $_POST['manufacturer'];
  $mime = $_FILES['image']['type'];
  $image_name = file_get_contents($_FILES['image']['tmp_name']);
  $pdoQuery = "INSERT INTO `inventories` (`inventoryName`,`description`,`quantity`,`unitPrice`,`purchasingPrice`,`status`,`brand`,`manufacturer`,`image_name`,`mime`, `archive`) VALUES (:name,:description,:quantity,:retailprice,:price,:status,:brand,:manufacturer,:image_name,:mime,:archive)";
  $pdoResult = $conn->prepare($pdoQuery);
  $pdoExecute = $pdoResult->execute(array(":name"=>$name,":description"=>$description,":quantity"=>$quantity,":retailprice"=>$retailprice,":price"=>$price,":status"=>$status,":brand"=>$brand,":manufacturer"=>$manufacturer,":image_name"=>$image_name,":mime"=>$mime,":archive"=>$archive));
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
  $quantity = intval($row['quantity']);
  if ($quantity <= 4){
  $update = "UPDATE inventories SET status = 'Limited stock' WHERE inventoryId = '$id'";
  $result = $conn->prepare($update);
  $execute = $result->execute();
  }
  if ($quantity >= 5){
  $update = "UPDATE inventories SET status = 'In stock' WHERE inventoryId = '$id'";
  $result = $conn->prepare($update);
  $execute = $result->execute();
  }
  if ($quantity == 0){
  $update = "UPDATE inventories SET status = 'Out of stock' WHERE inventoryId = '$id'";
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

<!-- Archive product module -->
<?php
  if(isset($_POST['idArc'])){
    $id = $_POST['idArc'];
    
    $archive = "UPDATE inventories SET archive = 'Yes' WHERE inventoryId = '$id'";
    $result = $conn->prepare($archive);
    $execute = $result->execute();
    
  }
?>

<!-- Unarchive product module -->
<?php
  if(isset($_POST['idShowArc'])){
    $id = $_POST['idShowArc'];
    
    $Showarchive = "UPDATE inventories SET archive = 'No' WHERE inventoryId = '$id'";
    $result = $conn->prepare($Showarchive);
    $execute = $result->execute();
    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product
    </title>
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
    <div class="container staff-inventory-container">
      <h1>Staff Product View
      </h1>
      <!--Display inventories in tabular form -->
      <tbody>
        <table class="table table-bordered ttb">
          <tr>
            <th>No.
            </th>
            <th>Item Name
            </th>
            <th>Brand
            </th>
            <th>Manufacturer
            </th>
            <th>Quantity
            </th>
            <th>Price (MYR)
            </th>
            <th>Retail Price (MYR)
            </th>
            <th>Status
            </th>
            <th>Actions
            </th>
            <th>Image
            </th>
          </tr>
          <!-- Display all products -->
          <?php
            $query = "SELECT * FROM inventories WHERE archive = 'No'";
            $data = $conn->query($query);
            $data->execute();
            $inventoryNo = 0;
            foreach($data as $row)
            {
              $inventoryNo ++;
              $id = $row['inventoryId'];
              echo "<tr><td>" . $inventoryNo . "</td>" . "<td>" . $row['inventoryName'] . "</td>" . "<td>" . $row['brand'] . "</td>" . "<td>" . $row['manufacturer'] . "</td>" . "<td>" . $row['quantity'] . "</td>" . "<td>" . $row['unitPrice'] . "</td>" . "<td>" . $row['purchasingPrice'] . "</td>" . "<td>" . $row['status'] . "</td>" . "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'>" . "<button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button> ". " <button type='submit' class='btn btn-success' name='idArc' value ='$id'>Archive</button>"."</div></form></td>" ."<td><embed src='data:". $row['mime']. ";base64," . base64_encode($row['image_name']). "' width='50'/></td>" . "</tr>";
            }
            ?>  
        </table>
      </tbody>
      <div class="product-c">
        <button class="addItem" onclick="openForm()">
        <img src="../images/add.png" alt="add-btn">
        </button>
        <span id="anp">Add new product
        </span>
        
        <button class="archiveItem" onclick="showArchive()">
        <img src="../images/archive.png" alt="archive-btn">
        </button>
        <span id="anp">Show archive
        </span>
      </div>
      
      <!-- This is the pop up list to show the list of archive product -->
      <div class="form-popup container" id="archiveList">
        <h1>Archive products</h1>
        
        <tbody>
        <table class="table table-bordered ttb">
          <tr>
            <th>No.
            </th>
            <th>Item Name
            </th>
            <th>Brand
            </th>
            <th>Manufacturer
            </th>
            <th>Quantity
            </th>
            <th>Price (MYR)
            </th>
            <th>Retail Price (MYR)
            </th>
            <th>Status
            </th>
            <th>Actions
            </th>
            <th>Image
            </th>
          </tr>
          
          <!-- Display all archive products -->
          <?php
            $query = "SELECT * FROM inventories WHERE archive ='Yes'";
            $data = $conn->query($query);
            $data->execute();
            $inventoryNo = 0;
            foreach($data as $row)
            {
              $inventoryNo ++;
              $id = $row['inventoryId'];
              echo "<tr><td>" . $inventoryNo . "</td>" . "<td>" . $row['inventoryName'] . "</td>" . "<td>" . $row['brand'] . "</td>" . "<td>" . $row['manufacturer'] . "</td>" . "<td>" . $row['quantity'] . "</td>" . "<td>" . $row['unitPrice'] . "</td>" . "<td>" . $row['purchasingPrice'] . "</td>" . "<td>" . $row['status'] . "</td>" . "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'>" . "<button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button> ". " <button type='submit' class='btn btn-success' name='idShowArc' value ='$id'>Show product</button>"."</div></form></td>" ."<td><embed src='data:". $row['mime']. ";base64," . base64_encode($row['image_name']). "' width='50'/></td>" . "</tr>";
            }
            ?>  
          <br/>
          
        </table>
      </tbody>
        
      <button type="button" class="btn cancel" onclick="closeArchive()">Close</button>
      <br/>
      </div>
      
      
      
      <!-- This is the pop up form to add new product -->
      <div class="form-popup container" id="myForm">
        <form method="post" class="form-container" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit this form?');">
          <h1>Add new product</h1>
          <br/>
          <div class="row">
            <div class="form-group col-lg-6 col-xs-6">
              <label for="product-name"><b>Product Name</b></label>
              <input type="text" placeholder="Enter new product name" name="name" class="form-control" required>
            </div>
            <div class="form-group col-lg-6 col-xs-6">
              <label for="product-brand"><b>Product Brand</b></label>
              <input type="text" name="brand" placeholder="Enter brand here" class="form-control" required>
            </div>
          </div>
            
          <div class="row">
            <div class="form-group col-lg-6 col-xs-6">
              <label for="product-manufacturer"><b>Product Manufacturer</b></label>
              <input type="text" name="manufacturer" placeholder="Enter manufacturer here" class="form-control" required>
            </div>
            <div class="form-group col-lg-6 col-xs-6">
              <label for="product-image"><b>Product Image</b></label>
              <input type="file" name="image" accept="image/*" class="form-control-file" required>
            </div>
          </div>
            
          <div class="row">
            <div class="form-group col-lg-4 col-xs-4">    
              <label for="product-quantity"><b>Product Quantity</b></label>
              <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="form-group col-lg-4 col-xs-4">    
              <label for="product-price"><b>Product Price (RM)</b></label>
              <input type="number" step="0.01" value="0.00" name="price" class="form-control" required>
            </div>
            <div class="form-group col-lg-4 col-xs-4">
              <label for="product-retail-price"><b>Product Retail Price (RM)</b></label>
              <input type="number" step="0.01" value="0.00" name="retailprice" class="form-control" required>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-lg-12 col-xs-12">
              <label for="product-description"><b>Product Description</b></label>
              <textarea rows="4" cols="80" name="description" placeholder="Enter product description here" class="form-control" required></textarea>
            </div>
          </div>
          
          <button type="submit" name="submit" class="btn">Add</button>
          <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
      </div>
    </div>
  </body>
</html>