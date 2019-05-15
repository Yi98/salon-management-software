<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>
<?php
    // if ($_SESSION["role"] != "staff" && $_SESSION["role"] != "manager") {
    //     header("location: ../index.php");
    // }
?>

<?php
    // Sales performance
    $sales_performance_query = "SELECT u.name, COUNT(*) as salesCount, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s INNER JOIN users u ON s.staffId=u.userId GROUP BY s.staffId ORDER BY salesAmount DESC";
    $sales_performance = $conn->query($sales_performance_query);
    $sales_performance->execute();
    $sales_performance_result = $sales_performance->fetchAll(PDO::FETCH_ASSOC);

    $highestPerformanceSales = 0;
    $highestPerformanceStaff = "";
    foreach ($sales_performance_result as $results ) {
        if ($results["salesAmount"] > $highestPerformanceSales) {
            $highestPerformanceSales = $results["salesAmount"];
            $highestPerformanceStaff = $results["name"];
        }
    }

    // query to get all products and their total sales
    $most_favourable_product_query = "SELECT i.inventoryName as productName, SUM(s.itemAmount) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories != 'Service' GROUP BY s.inventoryId";

    $most_favourable_product = $conn->query($most_favourable_product_query);
    $most_favourable_product->execute();
    $products = $most_favourable_product->fetchAll(PDO::FETCH_ASSOC);

    $topProduct = "None"; // most favourable product
    $topProductCount = 0;  // most favorable product count


    // query to get all services and their total sales
    $most_favourable_service_query = "SELECT i.inventoryName as serviceName, SUM(s.itemAmount) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories = 'Service' GROUP BY s.inventoryId";

    $most_favourable_service = $conn->query($most_favourable_service_query);
    $most_favourable_service->execute();
    $services = $most_favourable_service->fetchAll(PDO::FETCH_ASSOC);

    $topService = "None"; // most favourable product
    $topServiceCount = 0;  // most favorable product count

    // Sort max to min
    for($i=0; $i<sizeof($products); $i++) {
      for($j=0; $j<sizeof($products)-$i-1; $j++) {
        if ($products[$j]['count'] < $products[$j + 1]['count']) {
          $temp = $products[$j];
          $products[$j] = $products[$j+1];
          $products[$j+1] = $temp;
        }
      }
    }

    foreach ($products as $row) {
       if ($row["count"] > $topProductCount) {
        $topProduct = $row["productName"];
        $topProductCount = $row["count"];
       }
    }

    foreach ($services as $row) {
       if ($row["count"] > $topServiceCount) {
        $topService = $row["serviceName"];
        $topServiceCount = $row["count"];
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
    <script>
        var products = <?php echo json_encode($products); ?>;
        var staffs_performance = <?php echo json_encode($sales_performance_result); ?>
    </script>
  </head>
  <body onload="loadChart(products); loadStaffPerformanceSimpleChart(staffs_performance)">
      
    <?php include "../navigationBar.php" ?>
      
    <div id="dashboard-bg">
      <div class="container dashboard-container text-center">
    
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
          <br/>
          <!-- Add new staff button -->
        <button id="add_new_staff_button" class="btn btn-info">Add new staff</button>
        <button id="pos_button" class="btn btn-info" onclick="window.location.href='point-of-sale.php';">Point of Sales</button>
        <br/>
        <br/>
        
        <a class="weatherwidget-io" href="https://forecast7.com/en/1d61110d38/kuching/" data-label_1="KUCHING" data-label_2="WEATHER" data-icons="Climacons Animated" data-days="3" data-theme="clear" >KUCHING WEATHER</a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>
        <br/>
          
        <div class="row">
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Highest Performance Staff</p>
              <p class="result">*<?php echo $highestPerformanceStaff ?>*</p>
            </div>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Most favourable service</p>
              <p class="result">*<?php echo $topService ?>*</p>
            </div>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Most favourable product</p>
              <p class="result">*<?php echo $topProduct ?>*</p>
            </div>
          </div>
        </div>
        <div class="row graph-grid">
          <div class="col-md-8 col col-zoom">
            <a href="sales_insight.php" class="insight">
              <div class="content">
                 <p class="title">Products' sales of the stores (All time)</p>
                 <p class="result">  
                     <canvas id="product_chart" width="400" height="400"></canvas>
                  </p> 
              </div>
            </a>
          </div>
          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Ranking for the top sales product and service</p>
              <ol>
                <?php
                  foreach ($products as $row) {
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
          <div class="col-md-8 col col-zoom">
            <a href="performance_insight.php" class="insight">
              <div class="content">
              <p class="title">Graph for displaying staff's performance (All time)</p>
              <p class="result">
                  <div id="canvas_container">
                        <canvas id="performanceStaff" width="400" height="200"></canvas>
                    </div>
              </div>    
            </a>
            </div>

          <div class="col-md-4 col">
            <div class="content">
              <p class="title">Ranking for staff according to performance</p>
              <ol>
                <?php
                    foreach ($sales_performance_result as $row) {
                        echo "<li>".$row["name"]." (RM ".$row["salesAmount"]." total sales)</li>";
                    } 
                ?>
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
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
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