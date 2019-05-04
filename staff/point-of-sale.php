<?php include '../db_connect.php'; ?>
<?php 
// if (!isset($_SESSION["id"]) && empty($_SESSION["id"])) 
//     {
//         header('location: login.php');
//     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Point of Sale</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
  <script src="../script.js"></script>
</head>
<body>
  <div class="container pt-5" id="pos-container">
    <h1 class="text-center">Point of sale</h1>
    <p class="sub-content">Items <i class="fas fa-store"></i></p>
    <div class="input-group">
      <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
        <option selected>Choose...</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
      <div class="input-group-append">
        <button class="btn btn-primary" type="button">Add</button>
      </div>
    </div>

    <div class="pos-contain mt-5">
      <p class="sub-content">Carts <i class="fas fa-shopping-cart"></i></p>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center cart-list mb-2">
          <img class="cart-img" src="../images/schwarzkopf_main.jpg" alt="Product item">
          <p class="cart-product-title m-0 cart-product-text">LadBad Hair Wax</p>
          <p class="cart-product-price m-0 cart-product-text" id="<%= product.title %>-price">RM 99</p>
          <div class="row">
              <div class="col 5">
                  <i class="fas fa-minus" onclick="onModifyNum('<%= product.title %>', -1)"></i>
              </div>
              <dv class="col-2 cart-badge-num" style="padding: 0;">
                  <span class="badge badge-primary badge-pill" id="<%= product.title %>-num">5</span>
              </dv>
              <div class="col-5">
                  <i class="fas fa-plus" onclick="onModifyNum('<%= product.title %>', 1)"></i>
              </div>
          </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center cart-list mb-2">
          <img class="cart-img" src="../images/olaplex_main.jpeg" alt="Product item">
          <p class="cart-product-title m-0 cart-product-text">LadBad Hair Wax</p>
          <p class="cart-product-price m-0 cart-product-text" id="<%= product.title %>-price">RM 99</p>
          <div class="row">
              <div class="col 5">
                  <i class="fas fa-minus" onclick="onModifyNum('<%= product.title %>', -1)"></i>
              </div>
              <dv class="col-2 cart-badge-num" style="padding: 0;">
                  <span class="badge badge-primary badge-pill" id="<%= product.title %>-num">5</span>
              </dv>
              <div class="col-5">
                  <i class="fas fa-plus" onclick="onModifyNum('<%= product.title %>', 1)"></i>
              </div>
          </div>
        </li>
      </ul>

      <div class="price-summary">
        <p class="summary-title">Price Summary</p>
        <div class="row">
          <div class="col-md-12"><p id="cart-total">Total: RM100</p></div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <button class="btn btn-success w-100 h-50 mt-5" onclick="onPayCart()">Pay</button>
          </div>
        </div>
      </div>
    </div>

<!--     <div class="ui basic modal modal-container" id="pay-cart-modal">
      <div class="ui icon header">
        <i class="calendar minus icon"></i>
        Totaal Amount: RM100
      </div>
      <div class="content">
        <input type="text" name="staffId">
        <input type="number" name="cashPaid">
        <p class="modal-message">This timeslot has already been taken!</p>
      </div>
      <div class="actions">
        <div class="ui red ok inverted button okay-button-modal">
          <i class="checkmark icon"></i>
          Okay
        </div>
      </div>
    </div> -->

    <div class="ui tiny modal text-center" id="pay-cart-modal">
      <i class="close icon"></i>
      <div class="header">
        Total Amount: RM100
      </div>
      <div class="content">
        <div class="description">
          <!-- <form> -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 text-left font-weight-bold"><label for="staffId">Staff ID</label></div>
              </div>
              <input type="text" class="form-control mb-4" id="staffId" aria-describedby="emailHelp" placeholder="Enter staff ID">
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 text-left font-weight-bold"><label for="cashPaid">Cash Paid</label></div>
              </div>
              <input type="number" class="form-control mb-4" id="cashPaid" placeholder="Enter cash paid">
            </div>
            <div class="form-group">
              <p class="font-weight-bold changes-price">Changes: RM 5.90</p>
            </div>
        </div>
      </div>
      <div class="actions">
        <div class="ui black deny button">
          Back
        </div>
        <div class="ui positive right labeled icon button">
          Confirm payment
          <i class="checkmark icon"></i>
        </div>
      </div>
    </div>
    


  </div>
</body>
</html>

