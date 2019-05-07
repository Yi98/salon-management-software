<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>
<?php
    if ($_SESSION["role"] != "staff") {
        header("location: ../index.php");
    }
?>
<?php
    $add_staff_email = "";
    $add_staff_success_message = "";
    $add_staff_error_message = "";  
?>

<html lang="en">
  <head>
    <title>Dashboard</title>
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css" type="text/css">
    
  </head>
  <body>
    <?php include "../navigationBar.php" ?>
      
    <div id="dashboard-bg">
      <div class="container dashboard-container text-center">
        <!-- Add new staff button -->
        <button id="add_new_staff_button" class="btn btn-info">Add new staff</button>
    
        <div class="vertical-center add-staff-popup">
            <div class="add-staff-container container col-md-offset-2 col-md-8">
                <div class="row equal">
                    <div class="add-staff-content">
                        <div class="add-staff-form  col-md-6 col-md-offset-3">
                            <button id="close_new_staff_button">
                                &times;
                            </button>

                            <h2 class="form-title">Add new staff</h2>
                            <p class="add-staff-instruction">Enter new staff email (new staff required to signed up as a existing user before this action can be proceed)</p>
                            <form method="POST" class="add-staff-form-inner" id="add-staff-form" onSubmit="return addStaffValidation()">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                        <input type="text" name="add-staff-email" id="add-staff-email" placeholder="New staff email" class="form-control" value="<?php echo str_replace(array("'", '"'), "",$add_staff_email) ?>"/>
                                    </div>
                                    <span id="add-staff-email-alert"></span>
                                    <?php echo "<span style='color:green'>$add_staff_success_message</span>" ?>
                                    <?php echo "<span style='color:red'>$add_staff_error_message</span>" ?>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="addstaff" id="addstaff" class="btn btn-info" value="Add Staff"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
          
          
        <h1 class="display-4">Dashboard For Staff</h1>
        <a class="weatherwidget-io" href="https://forecast7.com/en/1d61110d38/kuching/" data-label_1="KUCHING" data-label_2="WEATHER" data-icons="Climacons Animated" data-days="3" data-theme="clear" >KUCHING WEATHER</a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>
        <br/>
          
        <div class="row">
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Most favourable staff</p>
              <p class="result">Steven Lau</p>
            </div>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Most favourable service</p>
              <p class="result">Haircutting</p>
            </div>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Most favourable product</p>
              <p class="result">Loreal</p>
            </div>
          </div>
        </div>
        <div class="row graph-grid">
          <div class="col-md-8 col">
            <div class="content">
               <p class="title">Sales for the stores (lifetime, monthly, weekly, daily)</p>
               <p class="result"><img src="https://d33wubrfki0l68.cloudfront.net/cc541f9cbdd7e0c8f14c2fde762ff38c00e9d62b/fc921/images/angular/ng2-charts/chart-example.png" alt="example" width="100%;"/></p> 
            </div>
          </div>
        
          <div class="col-md-4 col">
            <div class="content container">
              <p class="title">Ranking for the top sales product and service</p>
              <ol>
                <li>Haircutting RM9999</li>
                <li>Hairwashing RM8888</li>
                <li>Haircoloring RM7777</li>
                <li>Loreal Paris RM6666</li>
                <li>Pantene RM5555</li>
                <li>HAHA RM4444</li>
                <li>Haircutting RM9999</li>
                <li>Hairwashing RM8888</li>
                <li>Haircoloring RM7777</li>
                <li>Loreal Paris RM6666</li>
                <li>Pantene RM5555</li>
                <li>HAHA RM4444</li>
              </ol>
            </div>
          </div>
        </div>
        <div class="row graph-grid">
          <div class="col-md-8 col">
            <div class="content">
              <p class="title">Graph for most favourable staff, most favourable services change according to user choice</p>
              <p class="result"><img src="https://d33wubrfki0l68.cloudfront.net/cc541f9cbdd7e0c8f14c2fde762ff38c00e9d62b/fc921/images/angular/ng2-charts/chart-example.png" alt="example" width="100%;"/></p>
            </div>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Ranking for most favourable staff</p>
              <ol>
                <li>Steven Lau</li>
                <li>Steven Wong</li>
                <li>Steven Ng</li>
                <li>Steven Chong</li>
                <li>Steven Tan</li>
                <li>Steven Lim</li>
                <li>Steven Kong</li>
                <li>Steven Son</li>
                <li>Steven Dan</li>
                <li>Steven Heng</li>
              </ol>
            </div>
          </div>
        </div>
      </div>  
    </div>
    
    
         
    <!-- Bootstrap, jQuery-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    
    <script src="../script.js"></script>
    <script>
        $("#add_new_staff_button").on("click", function(){
            $(".add-staff-popup").addClass("add-staff-popup-active");
        });
        $("#close_new_staff_button").on("click", function(){
            $(".add-staff-popup").removeClass("add-staff-popup-active");
        });
    </script>
  </body>
  
<!--
  <footer>
  <div class="text-center bg-dark dboard">
      <p class="text-light"><small>Smile &amp; Style Salon Copyright &copy;</small></p>
    </div></footer>
-->
  
</html>