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
  
</head>
  <!--store the added inventory to database-->
<?php
  
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $desciption = $_POST['desciption'];
    $price = $_POST['price'];
    $retailprice = $_POST['retailprice'];
    
    $statement = $conn->prepare("INSERT INTO")
  }
  
?>
<body>
    <div class="container">
        <h1>Staff Product View</h1>
        <div class="row">
            <div class="col-lg-4 product-c"><button class="addItem" onclick="openForm()"><img src="../images/add.png" alt="add-btn"></button></div>
            <?php 
                echo '<div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>'; 
            ?>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
        </div>
        
        <!-- This is the pop up form -->
        <div class="form-popup form-control" id="myForm" onsubmit="return confirm('Are you sure you want to submit this form?');">
            <form action="" method="post" class="form-container" enctype="multipart/form-data">
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
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
                    <!--<input type="submit" value="Upload Image" name="submit">-->
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
                
                <button type="submit" name="submit" class="btn" onclick="">Add</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
</body>
</html>