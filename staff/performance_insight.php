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

    // Get Top Consistency - Have consistency in 3 month --------------------------------------------------------------------------------
    $currentMonth = date("m");
    $previousMonth = $currentMonth - 1;
    $previous2Month = $currentMonth - 2;

    $all_staffs_query = "SELECT userId as id, name FROM users WHERE role = 'staff' OR role = 'manager' ";
    $all_staffs = $conn->query($all_staffs_query);
    $all_staffs->execute();
    $all_staffs_result = $all_staffs->fetchAll(PDO::FETCH_ASSOC);

    $all_staffs_array = [];
    foreach ($all_staffs_result as $staff_results) {
        $obj = array("id" => $staff_results["id"], "name" => $staff_results["name"], "months" => array("one" => 0, "two" => 0, "three" => 0));
        array_push($all_staffs_array, $obj);
    }

    $current_month_query = "SELECT s.staffId, u.name, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s LEFT OUTER JOIN users u ON s.staffId=u.userId WHERE MONTH(dateOfSales) = $currentMonth GROUP BY s.staffId";
    $current_month = $conn->query($current_month_query);
    $current_month->execute();
    $current_month_result = $current_month->fetchAll(PDO::FETCH_ASSOC);


    $previous_month_query = "SELECT s.staffId, u.name, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s LEFT OUTER JOIN users u ON s.staffId=u.userId WHERE MONTH(dateOfSales) = $previousMonth GROUP BY s.staffId";
    $previous_month = $conn->query($previous_month_query);
    $previous_month->execute();
    $previous_month_result = $previous_month->fetchAll(PDO::FETCH_ASSOC);

    $previous2_month_query = "SELECT s.staffId, u.name, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s LEFT OUTER JOIN users u ON s.staffId=u.userId WHERE MONTH(dateOfSales) = $previous2Month GROUP BY s.staffId";
    $previous2_month = $conn->query($previous2_month_query);
    $previous2_month->execute();
    $previous2_month_result = $previous2_month->fetchAll(PDO::FETCH_ASSOC);

    // Get Top Improver - Better than last month -----------------------------------------------------------------------------------------
    
    // Get current month and previous month
    $currentMonth = date("m");
    $previousMonth = $currentMonth - 1;
    
    // select current month
    // I NEED TO MAKE IT ENABLE TO SEARCH FOR PREVIOUS YEAR MONTH
    $current_month_query = "SELECT s.staffId, u.name, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s LEFT OUTER JOIN users u ON s.staffId=u.userId WHERE MONTH(dateOfSales) = $currentMonth GROUP BY s.staffId";
    $current_month = $conn->query($current_month_query);
    $current_month->execute();
    $current_month_result = $current_month->fetchAll(PDO::FETCH_ASSOC);

    // select previous month
    $previous_month_query = "SELECT s.staffId, u.name, SUM(s.salesAmount) as salesAmount, dateOfSales as date FROM sales s LEFT OUTER JOIN users u ON s.staffId=u.userId WHERE MONTH(dateOfSales) = $previousMonth GROUP BY s.staffId";
    $previous_month = $conn->query($previous_month_query);
    $previous_month->execute();
    $previous_month_result = $previous_month->fetchAll(PDO::FETCH_ASSOC);

    $topImproverStaff = "";
    $topImproveScore = 0;
    foreach ($current_month_result as $current_results) {
        foreach($previous_month_result as $previous_results) {
            if ($current_results["staffId"] == $previous_results["staffId"]) {
                $diff = $current_results["salesAmount"] - $previous_results["salesAmount"];
                if ($diff >= $topImproveScore) {
                    $topImproverStaff = $current_results["name"];
                }
            }
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
            <p class="result">*<span id="topConsistentStaff"></span>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver</p>
            <p class="result">*<?php echo $topImproverStaff ?>*</p>
          </div>
        </div>
      </div>
      <div class="row graph-grid">
          <div class="col-md-12 col">
            <div class="content">
             <p class="title">Performance Graph</p>
              <div class="row rr-si">
                  <div class="col-md-8 col-c1">
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
      <script>
        var allstaffs = <?php echo json_encode($all_staffs_result) ?>;
        var firstmonth = <?php echo json_encode($current_month_result) ?>;
        var secondmonth = <?php echo json_encode($previous_month_result) ?>;
        var thirdmonth = <?php echo json_encode($previous2_month_result) ?>;
        
        // id, name, months
        var staffRecord = [];
        allstaffs.forEach(function(staff) {
            staffRecord.push({id:staff.id, name: staff.name, months: [0, 0, 0]});
        });
          
        var firstMonthRecord = [];
        firstmonth.forEach(function(month) {
            firstMonthRecord.push({id:month.staffId, name: month.name, salesAmount: month.salesAmount});
        });
          
        for (let j = 0; j < firstMonthRecord.length; j++) {
            for (let i = 0; i < staffRecord.length; i++) {
                if (staffRecord[i].id == firstMonthRecord[j].id) {
                    staffRecord[i].months[0] = firstMonthRecord[j].salesAmount;
                }
            }
        }
        
        var secondMonthRecord = [];
        secondmonth.forEach(function(month) {
            secondMonthRecord.push({id:month.staffId, name: month.name, salesAmount: month.salesAmount});
        });
          
        for (let j = 0; j < secondMonthRecord.length; j++) {
            for (let i = 0; i < staffRecord.length; i++) {
                if (staffRecord[i].id == secondMonthRecord[j].id) {
                    staffRecord[i].months[1] = secondMonthRecord[j].salesAmount;
                }
            }
        }
          
        var thirdMonthRecord = [];
        thirdmonth.forEach(function(month) {
            thirdMonthRecord.push({id:month.staffId, name: month.name, salesAmount: month.salesAmount});
        });
          
        for (let j = 0; j < thirdMonthRecord.length; j++) {
            for (let i = 0; i < staffRecord.length; i++) {
                if (staffRecord[i].id == thirdMonthRecord[j].id) {
                    staffRecord[i].months[1] = thirdMonthRecord[j].salesAmount;
                }
            }
        }
        
        var result;
        var diff = [];
        for (let i = 0; i < staffRecord.length; i++) {
            diff.push(changeToPositive(staffRecord[i].months[0] - staffRecord[i].months[1]) + changeToPositive(staffRecord[i].months[1] - staffRecord[i].months[2])) / 2;
        }
          
        function changeToPositive(value) {
            if (value < 0) {
                return (value*-1);
            }
            return value;
        }

        var topConsistentStaff = staffRecord[0].name;
        var topConsistentDiff = diff[0];
        for (let i = 1; i <= diff.length; i++) {
            if (diff[i] < topConsistentDiff) {
                topConsistentStaff = staffRecord[i].name;
                topConsistentDiff = diff[i];
                console.log(topConsistentDiff)
            }
        }
          
        document.getElementById("topConsistentStaff").innerHTML = topConsistentStaff;
      </script>
  </body>
</html>