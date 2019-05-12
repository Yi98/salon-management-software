<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>
<?php
    if ($_SESSION["role"] != "staff" && $_SESSION["role"] != "manager") {
        header("location: ../index.php");
    }
?>

<?php
    // FOR GETTING THE RECORDS FROM APPOINTMENT TO DETERMINE THE FAVOURABLE STAFF OR MANAGER
    $all_appointments_query = "SELECT `hairdresser`, COUNT(1) AS `total` FROM `appointments` GROUP BY `hairdresser` ORDER BY `total` DESC";
    $all_appointments = $conn->query($all_appointments_query);
    $all_appointments->execute();
    $results = $all_appointments->fetchAll(PDO::FETCH_ASSOC);
    // HERE I CAN GET THE DATA ALREADY, WHAT I NEED TO DO ARE TO SEND THE DATA INTO THE GRAPHS
    //$staffsName = array();
    //$staffsTotal = array();
    foreach ($results as $row) {
        //array_push($staffsName, $row["hairdresser"]);
        //array_push($staffsTotal, $row["total"]);
        //echo $row["hairdresser"].$row["total"];
    }
    $topFavourableStaff = $results[0]["hairdresser"];

    $most_favourable_product_query = "SELECT i.inventoryName as productName, COUNT(*) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId GROUP BY s.inventoryId";

    $most_favourable_product = $conn->query($most_favourable_product_query);
    $most_favourable_product->execute();

    $products_list = $conn->query($most_favourable_product_query);
    $products_list->execute();

    $topProduct = "None"; // most favourable product
    $topProductCount = 0;  // most favorable product number

    foreach ($most_favourable_product as $row) {
       // echo $row["productName"].$row["count"];
       if ($row["count"] > $topProductCount) {
        $topProduct = $row["productName"];
        $topProductCount = $row["count"];
       }
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
        <button id="pos_button" class="btn btn-info" onclick="window.location.href='point-of-sale.php';">Point of Sales</button>
    
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
                                    <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="add-manager-checkbox">
                                          <label class="custom-control-label" for="add-manager-checkbox">Add new manager</label>
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
              <p class="result"><?php echo $topFavourableStaff ?></p>
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
              <p class="result"><?php echo $topProduct ?></p>
            </div>
          </div>
        </div>
        <div class="row graph-grid">
          <div class="col-md-8 col">
            <div class="content">
               <p class="title">Sales for the stores (lifetime, monthly, weekly, daily)</p>
               <p class="result">  
                   <img src="https://d33wubrfki0l68.cloudfront.net/cc541f9cbdd7e0c8f14c2fde762ff38c00e9d62b/fc921/images/angular/ng2-charts/chart-example.png" alt="example" width="100%;"/>
                </p> 
            </div>
          </div>
        
          <div class="col-md-4 col">
            <div class="content container">
              <p class="title">Ranking for the top sales product and service</p>
              <ol>
                <?php
                  foreach ($products_list as $row) { 
                    if (strlen($row['productName']) > 15) {
                      $name = substr($row['productName'], 0, 20)."...";
                    }
                    else {
                      $name = $row['productName'];
                    }
                    
                    echo "<li title='$row[productName]'>$name - $row[count]</li>";
                  }
                ?>
              </ol>
            </div>
          </div>
        </div>
        <div class="row graph-grid">
          <div class="col-md-8 col">
            <div class="content">
              <p class="title">Graph for most favourable staff, most favourable services change according to user choice</p>
              <p class="result">
                  <canvas id="favourableStaff" width="400" height="400"></canvas> 
                  <!--<img src="https://d33wubrfki0l68.cloudfront.net/cc541f9cbdd7e0c8f14c2fde762ff38c00e9d62b/fc921/images/angular/ng2-charts/chart-example.png" alt="example" width="100%;"/></p>-->
            </div>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Ranking for most favourable staff</p>
              <ol>
                <?php
                    foreach ($results as $row) {
                        echo "<li>".$row["hairdresser"]." (".$row["total"]." times)</li>";
                    } 
                ?>
                <!--
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
                -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <script>
        var ctx = document.getElementById('favourableStaff').getContext('2d');
        var staffsName = [], staffsTotal = [];
        <?php
            foreach ($results as $row) {
        //array_push($staffsName, $row["hairdresser"]);
        //array_push($staffsTotal, $row["total"]);
        //echo $row["hairdresser"].$row["total"];
        ?>
            staffsName.push("<?php echo $row["hairdresser"]; ?>");
            staffsTotal.push("<?php echo $row["total"]; ?>");
        <?php  } ?>
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: staffsName,
                datasets: [{
                    label: '# of Votes',
                    data: staffsTotal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        </script>
    <script>
        $("#add_new_staff_button").on("click", function(){
            $(".add-staff-popup").addClass("add-staff-popup-active");
        });
        $("#close_new_staff_button").on("click", function(){
            $(".add-staff-popup").removeClass("add-staff-popup-active");
        });
    </script>
  </body>
  
<?php include "../footer.php"; ?>
  
</html>