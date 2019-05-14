<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>
<?php 
    $all_appointments_query = "SELECT hairdresser, COUNT(1) AS total, appointmentDate AS date FROM appointments GROUP BY hairdresser ORDER BY total DESC";
    $all_appointments = $conn->query($all_appointments_query);
    $all_appointments->execute();
    $staffs = $all_appointments->fetchAll(PDO::FETCH_ASSOC);

?>
    
<html lang="en">
  <head>
    <title>Detail Insight for Staffs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css" type="text/css">
    <script>
        var staffs = <?php echo json_encode($staffs) ?>;
    </script>
    </head>
    
  <body>
     
    <?php include "../navigationBar.php" ?>
    <div class="container dashboard-container text-center">
      <h1 class="display-4">Detail Insight for Staffs</h1>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Staff</p>
            <p class="result">*David Cheam*</p>
            <p>INSERT PIE CHART FOR ALL STAFF</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent</p>
            <p class="result">*Steven Lau*</p>
            <p>INSERT PIE CHART FOR ALL STAFF</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver</p>
            <p class="result">*Ng Chin Shu*</p>
            <p>INSERT PIE CHART FOR ALL STAFF</p>
          </div>
        </div>
      </div>
      <div class="row graph-grid">
          <div class="col-md-12 col">
            <div class="content">
             <p class="title">Most favourable staff</p>
              <div class="row rr-si">
                  <div class="col-md-8 col-c1">
                    <form class="navbar-form navbar-right" role="search">
                      <div class="form-group text-left"> 
                        <input type="text" class="form-control" size="10" placeholder="Search by staff name">
                        <div class="glyphicon glyphicon-search btn-search"></div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 col-c2">
                    <ul class="pagination">
                        <li class="page-item"><button class="page-link" id="lifetime_btn" onclick="loadStaffFavorableChart(staffs, 0);">Lifetime</button></li>
                        <li class="page-item"><button class="page-link" id="yearly_btn" onclick="loadStaffFavorableChart(staffs, 1);">Yearly</button></li>
                        <li class="page-item"><button class="page-link" id="monthly_btn" onclick="loadStaffFavorableChart(staffs, 2);">Monthly</button></li>
                        <li class="page-item"><button class="page-link" id="daily_btn" onclick="loadStaffFavorableChart(staffs, 3);">Daily</button></li>
                    </ul>
                  </div>
              </div>
               <p class="result">
                   <h2 id="currentToggleTime">LifeTime</h2>
                    <div class="canvas_container">
                        <canvas id="favourableStaff" width="400" height="150"></canvas>
                    </div>
                </p>
              
            </div>
            
          </div>
      </div>
    </div>
      
        <script src="../script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script>
   
            
            
        </script>
  </body>
</html>