<!-- Include navigation bar -->
<?php // include "../navigationBar.php" ?>

<html lang="en">
  <head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css" type="text/css">
    
  </head>
  <body>
    <h1 class="display-4">Dashboard For Staff</h1>
    <a class="weatherwidget-io" href="https://forecast7.com/en/1d61110d38/kuching/" data-label_1="KUCHING" data-label_2="WEATHER" data-icons="Climacons Animated" data-days="3" data-theme="clear" >KUCHING WEATHER</a>
    <script>
    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
    </script>
    <br/>

    
    <div id="dashboard-bg">
      <div class="container dashboard-container text-center">
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
    

  </body>
  
<!--
  <footer>
  <div class="text-center bg-dark dboard">
      <p class="text-light"><small>Smile &amp; Style Salon Copyright &copy;</small></p>
    </div></footer>
-->
  
</html>