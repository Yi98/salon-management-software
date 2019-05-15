<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>
<?php 
    // Sales performance
    $sales_performance_query = "SELECT s.staffId, u.name, s.salesAmount as salesAmount, dateOfSales as date FROM sales s LEFT OUTER JOIN users u ON s.staffId=u.userId ORDER BY salesAmount DESC";
    $sales_performance = $conn->query($sales_performance_query);
    $sales_performance->execute();
    $sales_performance_result = $sales_performance->fetchAll(PDO::FETCH_ASSOC);

    // Getting the sum of each staff
    $sales_total_query = "SELECT u.name, COUNT(*) as salesCount, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s INNER JOIN users u ON s.staffId=u.userId GROUP BY s.staffId";
    $sales_total = $conn->query($sales_total_query);
    $sales_total->execute();
    $sales_total_result = $sales_total->fetchAll(PDO::FETCH_ASSOC);

    $highestPerformanceSales = 0;
    $highestPerformanceStaff = "";
    foreach ($sales_total_result as $results ) {
        if ($results["salesAmount"] > $highestPerformanceSales) {
            $highestPerformanceSales = $results["salesAmount"];
            $highestPerformanceStaff = $results["name"];
        }
    }
?>
    
<html lang="en">
  <head>
    <title>Detail Insight for Staffs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css" type="text/css">
    <script>
        var staffs = <?php echo json_encode($sales_performance_result) ?>;
    </script>
    </head>
    
  <body onload="loadStaffPerformanceChart(staffs, 'yearly',0);">
     
    <?php include "../navigationBar.php" ?>
      
    <div class="container dashboard-container text-center">
      <h1 class="display-4">Performance Insight for Staffs</h1>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Performance Staff</p>
            <p class="result">*<?php echo $highestPerformanceStaff ?>*</p>
            <p></p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent</p>
            <p class="result">*Steven Lau*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver</p>
            <p class="result">*Ng Chin Shu*</p>
          </div>
        </div>
      </div>
      <div class="row graph-grid">
          <div class="col-md-12 col">
            <div class="content">
             <p class="title">Performance Graph</p>
              <div class="row rr-si">
                  <div class="col-md-8 col-c1">
                    <form class="navbar-form navbar-right" role="search">
                      <div class="form-group text-left"> 
                        <input type="text" class="form-control" size="10" placeholder="Search by staff name">
                        <div class="glyphic on glyphicon-search btn-search"></div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 col-c2">
                    <ul class="pagination">
                        <li class="page-item"><button class="page-link type-alternative" id="yearly_btn" onclick="loadStaffPerformanceChart(staffs, 'yearly', 0);">Yearly</button></li>
                        <li class="page-item"><button class="page-link type-alternative" id="monthly_btn" onclick="loadStaffPerformanceChart(staffs, 'monthly', 1);">Monthly</button></li>
                        <li class="page-item"><button class="page-link type-alternative" id="weekly_btn" onclick="loadStaffPerformanceChart(staffs, 'weekly', 2);">Weekly</button></li>
                        <li class="page-item"><button class="page-link type-alternative" id="daily_btn" onclick="loadStaffPerformanceChart(staffs, 'daily', 3);">Daily</button></li>
                    </ul>
                  </div>
              </div>
                <p class="result"></p>
                    <div id="canvas_container">
                        <canvas id="performanceStaff" width="400" height="150"></canvas>
                    </div>
            </div>
          </div>
      </div>
    </div>
      
    <script src="../script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  </body>
</html>