<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>

<html lang="en">
  <head>
    <title>Detail Insight for Staffs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css" type="text/css">
    
  </head>
  <body>
    <?php include "../navigationBar.php" ?>
    <div class="container dashboard-container text-center">
      <h1 class="display-4">Detail Insight for Services &amp; Products</h1>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Service</p>
            <p class="result">*Hair Cutting*</p>
            <p>INSERT PIE CHART FOR ALL SERVICES</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent</p>
            <p class="result">*Hair Consultant*</p>
            <p>INSERT PIE CHART FOR ALL SERVICES</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver</p>
            <p class="result">*Ng Chin Shu*</p>
            <p>INSERT PIE CHART FOR ALL SERVICES</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Product</p>
            <p class="result">*Karatese*</p>
            <p>INSERT PIE CHART FOR ALL PRODUCT</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent</p>
            <p class="result">*Loreal*</p>
            <p>INSERT PIE CHART FOR ALL PRODUCT</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver</p>
            <p class="result">*Botanist*</p>
            <p>INSERT PIE CHART FOR ALL PRODUCT</p>
          </div>
        </div>
      </div>
      <div class="row graph-grid">
          <div class="col-md-12 col">
            <div class="content">
             <p class="title">Most favourable products &amp; services</p>
              <div class="row rr-si">
                  <div class="col-md-8 col-c1">
                    <form class="navbar-form navbar-right" role="search">
                      <div class="form-group text-left"> 
                        <input type="text" class="form-control" size="10" placeholder="Search by services name and products name">
                        <div class="glyphicon glyphicon-search btn-search"></div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 col-c2">
                    <ul class="pagination">
                      <li class="page-item"><a class="page-link" href="#">Lifetime</a></li>
                      <li class="page-item"><a class="page-link" href="#">Yearly</a></li>
                      <li class="page-item"><a class="page-link" href="#">Monthly</a></li>
                      <li class="page-item"><a class="page-link" href="#">Daily</a></li>
                    </ul>
                  </div>
              </div>
               <p class="result">  
                    <img src="https://d33wubrfki0l68.cloudfront.net/cc541f9cbdd7e0c8f14c2fde762ff38c00e9d62b/fc921/images/angular/ng2-charts/chart-example.png" alt="example" width="100%;"/> 
                   <canvas id="product_chart" width="400" height="400"></canvas>
                </p>
              
            </div>
            
          </div>
      </div>
    </div>
  </body>
</html>