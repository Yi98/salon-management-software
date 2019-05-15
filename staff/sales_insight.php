<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>

<?php
    // query to get all products and their total sales
    $most_favourable_product_query = "SELECT i.inventoryName as productName, SUM(s.itemAmount) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories != 'Service' GROUP BY s.inventoryId";

    $most_favourable_product = $conn->query($most_favourable_product_query);
    $most_favourable_product->execute();
    $products = $most_favourable_product->fetchAll(PDO::FETCH_ASSOC);

    $topProduct = "None"; // most favourable product
    $topProductCount = 0;  // most favorable product count
    

    // get top product
    foreach ($products as $row) {
       if ($row["count"] > $topProductCount) {
        $topProduct = $row["productName"];
        $topProductCount = $row["count"];
       }
    }


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

    // get top service
    foreach ($services as $row) {
       if ($row["count"] > $topServiceCount) {
        $topService = $row["serviceName"];
        $topServiceCount = $row["count"];
       }
    }


    // query to get the sales count of products
    $most_frequent_product_query = "SELECT i.inventoryName as productName, COUNT(*) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories != 'Service' GROUP BY s.inventoryId";

    // $most_frequent_product_query = "SELECT i.inventoryName as productName, s.dateOfSales as saleDate, d.itemAmount as amount FROM sales s LEFT OUTER JOIN salesdetails d ON s.salesId = d.salesId LEFT OUTER JOIN inventories i ON i.inventoryId = d.inventoryId WHERE i.categories != 'Service'";

    $most_frequent_product = $conn->query($most_frequent_product_query);
    $most_frequent_product->execute();
    $frequentProducts = $most_frequent_product->fetchAll(PDO::FETCH_ASSOC);

    $frequentProduct = "None";
    $frequentProductNum = 0;

    foreach ($frequentProducts as $row) {
       if ($row["count"] > $frequentProductNum) {
        $frequentProduct = $row["productName"];
        $frequentProductNum = $row["count"];
       }
    }

    // query to get the sales count of services
    $most_frequent_service_query = "SELECT i.inventoryName as productName, COUNT(*) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories = 'Service' GROUP BY s.inventoryId";

    $most_frequent_service = $conn->query($most_frequent_service_query);
    $most_frequent_service->execute();
    $frequentServices = $most_frequent_service->fetchAll(PDO::FETCH_ASSOC);

    $frequentService = "None";
    $frequentServiceNum = 0;

    foreach ($frequentServices as $row) {
       if ($row["count"] > $frequentServiceNum) {
        $frequentService = $row["productName"];
        $frequentServiceNum = $row["count"];
       }
    }


    // get all the sales
    $allSalesQuery = "SELECT * from sales";
    $allSalesData = $conn->query($allSalesQuery);
    $allSalesData->execute();
    $sales = $allSalesData->fetchAll(PDO::FETCH_ASSOC);


    //query to get top improved product
    $most_improved_product_query = "SELECT i.inventoryName as productName, s.dateOfSales as saleDate, d.itemAmount as amount FROM sales s LEFT OUTER JOIN salesdetails d ON s.salesId = d.salesId LEFT OUTER JOIN inventories i ON i.inventoryId = d.inventoryId WHERE i.categories != 'Service'";

    $most_improved_product = $conn->query($most_improved_product_query);
    $most_improved_product->execute();
    $improvedProducts = $most_improved_product->fetchAll(PDO::FETCH_ASSOC);


    $most_improved_service_query = "SELECT i.inventoryName as productName, s.dateOfSales as saleDate, d.itemAmount as amount FROM sales s LEFT OUTER JOIN salesdetails d ON s.salesId = d.salesId LEFT OUTER JOIN inventories i ON i.inventoryId = d.inventoryId WHERE i.categories = 'Service'";

    $most_improved_service = $conn->query($most_improved_service_query);
    $most_improved_service->execute();
    $improvedServices = $most_improved_service->fetchAll(PDO::FETCH_ASSOC);

?>

<html lang="en">
  <head>
    <title>Detail Insight for Staffs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script>
      var products = <?php echo json_encode($products); ?>;
      var sales = <?php echo json_encode($sales); ?>;
      var improvedProducts = <?php echo json_encode($improvedProducts); ?>;
      var improvedServices = <?php echo json_encode($improvedServices); ?>;
    </script>
    
  </head>
  <body onload="loadDetailsChart(sales, 'daily', 3); loadRanking(improvedProducts, improvedServices);">
    <?php include "../navigationBar.php" ?>
    <div class="container dashboard-container text-center">
      <h1 class="display-4">Detail Insight for Services &amp; Products</h1>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Service (All time)</p>
            <p class="result">*<?php echo $topService ?>*<br/>Total sales: <?php echo $topServiceCount ?></p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent Service (<span class="current-few-month"></span>)</p>
            <p class="result">*<?php echo $frequentService ?>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improved Service (<span class="current-month"></span>)</p>
            <p class="result">*<span id="top_improved_service"></span>*<br/><span id="top_improved_service_score"></span></p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Product (All time)</p>
            <p class="result">*<?php echo $topProduct ?>*<br/>Total sales: <?php echo $topProductCount ?></p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent Product (<span class="current-few-month"></span>)</p>
            <p class="result">*<span id="top_consistent_product"></span>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improved Product (<span class="current-month"></span>)</p>
            <p class="result">*<span id="top_improved_product"></span>*<br/><span id="top_improved_product_score"></span></p>
          </div>
        </div>
      </div>
      <div class="row graph-grid">
          <div class="col-md-12 col">
            <div class="content">
             <p class="title">Total sales</p>
              <div class="row rr-si">
                  <div class="col-md-8 col-c1"></div>
                  <div class="col-md-4 col-c2">
                    <ul class="pagination"> 
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'yearly', 0)">Yearly</button></li>
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'monthly', 1)">Monthly</button></li>
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'weekly', 2)">Weekly</button></li>
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'daily', 3)">Daily</button></li>
                    </ul>
                  </div>
              </div>
              <div id="canvas-container">
                 <canvas id="product_details_chart" width="400" height="200"></canvas>              
              </div>
            </div>
            
          </div>
      </div>
    </div>

    <script src="../script.js"></script>
  </body>
</html>