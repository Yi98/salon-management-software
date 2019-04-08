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
    
    <script>
        function openForm() {
          document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
          document.getElementById("myForm").style.display = "none";
        }
    </script>
    
    <style>
        /* Button used to open the contact form - fixed at the bottom of the page */
        .open-button {
          background-color: #555;
          color: white;
          padding: 16px 20px;
          border: none;
          cursor: pointer;
          opacity: 0.8;
          position: fixed;
        }

        /* The popup form - hidden by default */
        .form-popup {
          display: none;
          position: fixed;
          border: 3px solid #f1f1f1;
          z-index: 9;
          top:0;
          bottom:0;
        }

        /* Add styles to the form container */
        .form-container {
          max-width: 80%;
          padding: 10px;
          background-color: white;
        }

        /* Full-width input fields */
        .form-container input[type=text], .form-container input[type=password] {
          width: 100%;
          padding: 15px;
          margin: 5px 0 22px 0;
          border: none;
          background: #f1f1f1;
        }

        /* When the inputs get focus, do something */
        .form-container input[type=text]:focus, .form-container input[type=password]:focus {
          background-color: #ddd;
          outline: none;
        }

        /* Set a style for the submit/login button */
        .form-container .btn {
          background-color: #4CAF50;
          color: white;
          padding: 16px 20px;
          border: none;
          cursor: pointer;
          width: 100%;
          margin-bottom:10px;
          opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
          background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
          opacity: 1;
        }
        
        /*Add style to addItem*/
        
        
        /* Set image size for each product */
        .product-c img{
            width:100%;
        }
    </style>

</head>
<body>
    <div class="container">
        <h1>Staff Product View</h1>
        <div class="row">
            <div class="col-lg-4 product-c"><button class="addItem" onclick="openForm()"><img src="../images/add.png" alt="add-btn"></button></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p><p></p></div>
        </div>
        <div class="row">
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
        </div>
        <div class="row">
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
        </div>
        <div class="row">
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
            <div class="col-lg-4 product-c"><img src="" alt="productimg"><p></p></div>
        </div>
        
        <!-- This is the pop up form -->
        <div class="form-popup form-group" id="myForm" onsubmit="return confirm('Are you sure you want to submit this form?');">
            <form action="" method="post" class="form-container" enctype="multipart/form-data">
                <h1>Add new product</h1>

                <label for="product-name"><b>Product Name</b></label>
                <input type="text" placeholder="Enter new product name" name="email" required>

                <label for="product-description"><b>Product Description</b></label><br/>
                <textarea rows="4" cols="80" name="description" placeholder="Enter product description here" required></textarea>
                
                <label for="product-image"><b>Product Image</b></label>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
                <!--<input type="submit" value="Upload Image" name="submit">-->
                
                <label for="product-price"><b>Product Price</b></label><br/>
                RM <input type="number" name="price" required>
 
                <button type="submit" class="btn" onclick="">Add</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    
    </div>
</body>
</html>