<?php include "../db_connect.php"; ?>
<?php
    if ($_SESSION["role"] != "staff" && $_SESSION["role"] != "manager") {
        header("location: ../index.php");
    }
?>
<!-- Insert new product module -->
<?php
  if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $retailprice = $_POST['retailprice'];
  $quantity = $_POST['quantity'];
  $gender = $_POST['gender'];
  $categories = $_POST['categories'];
    
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
  $pdoQuery = "INSERT INTO `inventories` (`inventoryName`,`description`,`quantity`,`unitPrice`,`purchasingPrice`,`status`,`brand`,`manufacturer`,`image_name`,`mime`, `archive`,`gender`,`categories`) VALUES (:name,:description,:quantity,:retailprice,:price,:status,:brand,:manufacturer,:image_name,:mime,:archive,:gender,:categories)";
  $pdoResult = $conn->prepare($pdoQuery);
  $pdoExecute = $pdoResult->execute(array(":name"=>$name,":description"=>$description,":quantity"=>$quantity,":retailprice"=>$retailprice,":price"=>$price,":status"=>$status,":brand"=>$brand,":manufacturer"=>$manufacturer,":image_name"=>$image_name,":mime"=>$mime,":archive"=>$archive,":gender"=>$gender,":categories"=>$categories));
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

<!-- Edit product module -->
<?php
  if(isset($_POST['idEdit'])){
    $idEdit = $_POST['idEdit'];
    $query = "SELECT * FROM inventories WHERE inventoryId = '$idEdit'";
    $data = $conn->query($query);
    $data->execute();

    foreach($data as $row){
      $name = $row['inventoryName'];
      $desc = $row['description'];
      $quantity = $row['quantity'];
      $price = $row['purchasingPrice'];
      $retailprice = $row['unitPrice'];
      $brand = $row['brand'];
      $manufacturer = $row['manufacturer'];  

      echo "<div class='container' id='userForm'><form method='post' class='editUser container' enctype='multipart/form-data'>
      <h1>Edit product here</h1>
      <div class='row'>
        <div class='form-group col-lg-6 col-xs-6'>
          <label for='name'><b>Product name</b></label>
          <input type='text' name='name' class='form-control' value='$name'>
        </div>

        <div class='form-group col-lg-6 col-xs-6'>
          <label for='brand'><b>Product brand</b></label>
          <input type='text' name='brand' class='form-control' value='$brand'>
        </div>
      </div>
      
      <div class='row'>
        <div class='form-group col-lg-6 col-xs-6'>
          <label for='manufacturer'><b>Product manufacturer</b></label>
          <input type='text' name='manufacturer' class='form-control' value='$manufacturer'>
        </div>

        <div class='form-group col-lg-6 col-xs-6'>
          <label for='product-image'><b>Product Image</b></label>
          <input type='file' name='editimage' accept='image/*' class='form-control-file' required>
        </div>
      </div>
      
      <div class='row'>
            <div class='form-group col-lg-4 col-xs-4'>    
              <label for='product-quantity'><b>Product Quantity</b></label>
              <input type='number' name='quantity' value='$quantity' class='form-control' required>
            </div>
            <div class='form-group col-lg-4 col-xs-4'>    
              <label for='product-price'><b>Product Price (RM)</b></label>
              <input type='number' step='0.01' value='$price' name='price' class='form-control' required>
            </div>
            <div class='form-group col-lg-4 col-xs-4'>
              <label for='product-retail-price'><b>Product Retail Price (RM)</b></label>
              <input type='number' step='0.01' value='$retailprice' name='retailprice' class='form-control' required>
            </div>
      </div> 
      <div class='row'>
            <div class='form-group col-lg-12 col-xs-12'>
              <label for='product-description'><b>Product Description</b></label>
              <textarea rows='4' cols='80' name='description' placeholder='Enter product description here' class='form-control' required>$desc</textarea>
            </div>
      </div>

      <div class='row'>
      <div class='form-group'>
      <button type='submit' name='iesubmit' value='$idEdit' class='btn user-btn btn btn-primary col-lg-6 col-xs-6'>Edit</button><button type='button' class='btn user-cancel btn btn-danger user-btn col-lg-6 col-xs-6' onclick='closeUserEdit()'>Close</button></div>
      </div></form></div>";
    }
  }
?>

<!-- Update value to database -->
<?php 
  if(isset($_POST['iesubmit'])){
    $editid = $_POST['iesubmit'];
    $editname = $_POST['name'];
    $editdesc = $_POST['description'];
    $editquantity = $_POST['quantity'];
    $editprice = $_POST['price'];
    $editretailprice = $_POST['retailprice'];
    $editbrand = $_POST['brand'];
    $editmanufacturer = $_POST['manufacturer'];
    
    $editmime = $_FILES['editimage']['type'];
    $editimage_name = file_get_contents($_FILES['editimage']['tmp_name']);
    
    $query = "UPDATE inventories SET inventoryName = :editname , description = :editdesc, quantity = :editquantity, unitPrice = :editretailprice, purchasingPrice = :editprice, brand = :editbrand, manufacturer = :editmanufacturer, image_name = :editimage_name, mime = :editmime WHERE inventoryId = :editid;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':editname',$editname);
    $stmt->bindParam(':editdesc',$editdesc);
    $stmt->bindParam(':editquantity',$editquantity);
    $stmt->bindParam(':editretailprice',$editretailprice);
    $stmt->bindParam(':editprice',$editprice);
    $stmt->bindParam(':editbrand',$editbrand);
    $stmt->bindParam(':editmanufacturer',$editmanufacturer);
    $stmt->bindParam(':editimage_name',$editimage_name, PDO::PARAM_LOB);
    $stmt->bindParam(':editmime',$editmime);
    $stmt->bindParam(':editid',$editid);
    $stmt->execute();
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
    <!-- Include navigation bar -->
    <?php include "../navigationBar.php" ?>
      
    <div class="container staff-inventory-container">
      <h1 class="display-4 text-center">Staff Product View
      </h1>
      
      <br/>
      <div class="product-c">
        <button class="addItem" onclick="openForm()">
        <img src="../images/add.png" alt="add-btn">
        </button>
        <span id="anp">Add new product
        </span>
        
        <button class="archiveItem" onclick="showArchive()" id="archiveButton">
        <img src="../images/archive.png" alt="archive-btn">
        </button>
        <span id="anp">Show archive products
        </span>
        <br/><br/>
        <input type="text" id="userInput" onkeyup="searchItem()" placeholder="Search for item names..">
        <span id="anp" class="archiveItem"><b>Gender Filters</b> </span>
		<select onchange="genderFilter(this)">
			<option value="all" selected>-</option>
			<option value="male">Male</option>  
			<option value="female">Female</option>  
			<option value="unisex">Unisex</option>  
		</select>
        <span id="anp" class="archiveItem"><b>Category Filters</b> </span>
        <select onchange="categoryFilter(this)">
			<option value="all" selected>-</option>
			<option value="hs">Hair Shampoo</option>  
			<option value="cd">Conditioner</option>  
			<option value="ho">Hair Oils</option>  
			<option value="hw">Hair Wax</option>  
		</select> 
      </div>
      <!-- This is the pop up list to show the list of archive product -->
      <div class="form-popup container" id="archiveList">
        <h1>Archive products</h1>
        
        <tbody>
        <table class="table table-bordered ttb" id='archiveTable'>
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
            $record_per_page = 5;
            $page = '';
            if(isset($_GET['page'])){
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
  
            $start_from = ($page-1)*$record_per_page;
    
            $query = "SELECT * FROM inventories WHERE archive ='Yes' ORDER BY inventoryId ASC LIMIT $start_from, $record_per_page";
            $data = $conn->query($query);
            $data->execute();
            $inventoryNo = 0;
            foreach($data as $row)
            {
              $inventoryNo ++;
              $id = $row['inventoryId'];
              echo "<tr><td>" . $inventoryNo . "</td>" . "<td class='product-wctrl'>" . $row['inventoryName'] . "</td>" . "<td class='product-wctrl'>" . $row['brand'] . "</td>" . "<td class='product-wctrl'>" . $row['manufacturer'] . "</td>" . "<td>" . $row['quantity'] . "</td>" . "<td>" . $row['unitPrice'] . "</td>" . "<td>" . $row['purchasingPrice'] . "</td>" . "<td>" . $row['status'] . "</td>" . "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'>" . "<button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button> " . " <button type='submit' class='btn btn-success' name='idShowArc' value ='$id'>Show product</button>"."</div></form></td>" ."<td><embed src='data:" . $row['mime']. ";base64," . base64_encode($row['image_name']). "' width='50' class='zoom'/></td>" . "<td id='gender'>".$row['gender']."</td><td id='categories'>". $row['categories']. "</td></tr>";
            }
            ?>  
          <br/>
          
        </table>
      </tbody>
      <br/>
        <div class="page-links">
        <ul class="pagination">
          <?php 
            $page_query = "SELECT COUNT(*) FROM inventories WHERE archive = 'Yes'";
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
      <br/>
      

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
            <div class="form-group col-lg-6 col-xs-6">
              <label for="product-gender"><b>Suitable for</b></label><br/>
              <label for="male" class="radio-inline"><b>Male</b></label> <input type="radio" name="gender" value="Male" required> 
              <label for="female" class="radio-inline"><b>Female</b></label> <input type="radio" name="gender" value="Female" required> 
              <label for="male" class="radio-inline"><b>Unisex</b></label> <input type="radio" name="gender" value="Unisex" required> 
            </div>
            <div class="form-group col-lg-6 col-xs-6">
              <label for="product-categories"><b>Product Categories</b></label><br/>
              <label for="shampoo" class="radio-inline"><b>Hair Shampoo</b></label> <input type="radio" name="categories" value="Hair Shampoo" required>
              <label for="conditioner" class="radio-inline"><b>Conditioner</b></label> <input type="radio" name="categories" value="Conditioner" required>
              <label for="oils" class="radio-inline"><b>Hair Oils</b></label> <input type="radio" name="categories" value="Hair Oils" required>
              <label for="wax" class="radio-inline"><b>Hair Wax</b></label> <input type="radio" name="categories" value="Hair Wax" required>
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
      <br/>
      <!--Display inventories in tabular form -->
      <tbody>
        <table class="table table-bordered ttb" id="itemTable">
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
            $record_per_page = 5;
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
              $id = $row['inventoryId'];
              echo "<tr><td>" . $row['inventoryId'] . "</td>" . "<td class='product-wctrl'>" . $row['inventoryName'] . "</td>" . "<td class='product-wctrl'>" . $row['brand'] . "</td>" . "<td class='product-wctrl'>" . $row['manufacturer'] . "</td>" . "<td>" . $row['quantity'] . "</td>" . "<td>" . $row['unitPrice'] . "</td>" . "<td>" . $row['purchasingPrice'] . "</td>" . "<td>" . $row['status'] . "</td>" . "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'>" . " <button type='submit' class='btn btn-primary' name='idEdit' value ='$id' onclick='openUserEdit()'>Edit</button>" . " <button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button> " . " <button type='submit' class='btn btn-success' name='idArc' value ='$id'>Archive</button>" . "</div></form></td>" ."<td><embed src='data:". $row['mime']. ";base64," . base64_encode($row['image_name']). "' width='50' class='zoom' /></td>" . "<td id='gender'>".$row['gender']."</td><td id='categories'>". $row['categories']. "</td></tr>";
            }
            ?>  
        </table>
      </tbody>
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
      <?php include "../footer.php"; ?>
          <script src="../script.js"></script>
  </body>
</html>