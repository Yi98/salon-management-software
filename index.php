<?php include "db_connect.php"; ?>

<?php
    //echo "<script type='text/javascript'>","location.href='index.php#navigation-bar';","</script>";
?>

<!-- Created By: Ng Chin Shu -->
<!-- Date Created: 3/10/2019 -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
      
        <title>Smile And Style Salon</title>
      
        <link rel="stylesheet" type="text/css" href="style.css">
      
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      
        <!-- Bootstrap library -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Oswald" rel="stylesheet">
      
        <style>
          * {
            box-sizing: border-box;
          }

          body{
              width:100%;
              min-height: 100%;
              height:100%;
              padding:0;
              margin:0;
          }

          div{
              height:100%;
          }
        </style>
    </head>
    <body <?php echo "onload='directNavigationBar()'" ?>>
        <div class="main-container">
            <h1 id="indexTitle">STYLE &amp; SMILE</h1>
            
            <p id="indexSubtitle">HAIR SALON</p>
            
            <div class="columnLeft">
                <img src="images/girl.jpg" alt="model">
            </div>
            
            <div class="columnRight">
                <img src="images/guy.jpg" alt="model">
            </div>
            
            <button type="button" id="book-btn" class="btn btn-info" onclick="window.location.href = 'appointment.php';">Book Now</button>
            
            <div class="downArrow bounce">
                <img width="40" height="40" alt="downarrow" src="images/down-arrow.png" />
            </div>
        </div>
        
        <section id="navigation-bar">   
            <div class="appointment-container">
                <nav>
                    <ul>
                        <li><p><a href="index.php">HOME</a></p></li>
                        <li><p><a href="appointment.php">APPOINTMENT</a></p></li>
                        <li><p><a href="inventory.php">SHOP</a></p></li>
              
                        <?php
                            if (isset($_SESSION["id"]) && !empty($_SESSION["id"]) || isset($_SESSION["access_token"])) {
                                $query = "SELECT * FROM `users` WHERE `userId`=:id";

                                $data = $conn->prepare($query);
                                $data->bindValue(":id", $_SESSION["id"]);
                                $data->execute();

                                $currentUser = $data->fetch(PDO::FETCH_ASSOC);
                                $id = $_SESSION["id"];
                                if ($currentUser["image_path"] != NULL) {
                                    $image_path = $currentUser['image_path'];
                                    echo "<a style='color:black;text-decoration:none;' href='profile.php?id=$id'><span id='profile_image'><img style='height:auto; max-height:40px; margin-right:1%;' src='$image_path'/></span>";
                                } else {
                                    
                                    echo "<a style='color:black;text-decoration:none;' href='profile.php?id=$id'><span id='profile_image'><img id='profile_image_placeholder' style='height:auto; max-height:40px; margin-right:1%;' src='images/profile-placeholder.png'/></span>";
                                }
                                echo '<span>'.$_SESSION["name"].'</span></a>';
                            }
                        ?>
                        
                        <?php 
                            if (isset($_SESSION["access_token"])) {
                                echo '<li id="logout-button"><p id="logout-nav-btn"><a href="logout.php">LOG OUT</a></p></li>';
                            } else {
                                if (!isset($_SESSION["id"]) && empty($_SESSION["id"])) {
                                    echo '<li id="login-button" ><p id="login-nav-btn"><a href="login.php">LOG IN</a></p></li>';
                                } else {
                                    echo '<li id="logout-button"><p id="logout-nav-btn"><a href="logout.php">LOG OUT</a></p></li>';
                                }
                            }
                        ?>
                    </ul>
                </nav>
                <div class="row">
                    <div class="col-lg-7 main_column">
                        <img src="images/main_barber.jpg" title="barber"/>
                    </div>
                    <div class="col-lg-5 main2_column">
                        <h1>Tired of waiting?</h1><br/>
                        <h2>BOOK AN APPOINTMENT AND GET THE NEW LOOK.</h2><br/>
                        <p>We’re known around town for our sexy and inventive hairstyles. Our team of professionals is always ready to provide you with an experience that will leave you satisfied and projecting confidence with your new look. The full customer experience we offer will match our clients’ aspirations with proven techniques and artistry to bring wishes to reality. Providing the ultimate beauty service, we will have you shine with brilliance and perfection.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section>   
            <div class="appointment-container">
                <div class="row">
                    <div class="col-lg-5 main2_column" id="ac2">
                    <h1>What can we do?</h1>
                    <br/>
                    <h2>BASICALLY EVERYTHING. </h2>
                    <br/>
                    <p><strong>Hair basic</strong> such as cuts, relaxers, perms, colors, shampoo, conditioning, curling, reconstructing, weaving, waving. <strong>Hair treatment</strong> for different hair types such as Damaged, Normal / Dry, Very Dry &amp; Sensitized, Colour Treated,Curly / Rebellious, Thinning. <strong>Scalp treatment</strong> for different scalp problems such as Oily scalp, Sensitive scalp, Hair loss / thinning, Dandruff</p>
                    
                    <button type="button" id="appointment-btn" class="btn btn-info" onclick="window.location.href = 'appointment.php';">Book Now</button>
                </div>  
                <div class="col-lg-7 main_column">
                    <img src="images/salon_main.jpg" title="salon"/>
                </div>
                </div>
            </div>
        </section>
        
        <section>
            <div class="product-container">
                <ul class="logo">
                    <li><img src="images/eleven_logo.png" alt="elevenlogo"/></li>
                    <li><img src="images/kerastase_logo.png" alt="kerataselogo"/></li>
                    <li><img src="images/olaplex_logo.png" alt="olaplexlogo"/></li>
                    <li><img src="images/schwarzkopf_logo.png" alt="schwarzkopflogo"/>
                    </li>
                </ul>
                <ul class="product">
                    <li><img src="images/eleven_main.png" alt="elevenproduct"/></li>
                    <li><img src="images/kerastase_main.jpg" alt="kerastaseproduct"/></li>
                    <li><img src="images/olaplex_main.jpeg" alt="olaplexproduct"/></li>
                    <li><img src="images/schwarzkopf_main.jpg" alt="schwarzkopfproduct"/></li>
                </ul>
                <button type="button" id="product-btn" class="btn btn-info" onclick="window.location.href = 'inventory.php';">See More</button>      
            </div>
        </section>
    </body>
    <footer>
        <div id="firstfooter">
            <h1 id="indexTitle">STYLE &amp; SMILE</h1>
            <p id="indexSubtitle" style="margin-top:3%">HAIR SALON</p>
            <div class="columnLeft">
                <img src="images/girl.jpg" alt="model">
            </div>
            <div class="columnRight">
                <img src="images/guy.jpg" alt="model">
            </div>
        </div>
        <div id="lastfooter">
            <p> Copyright &copy; 2019 Style and Smile Salon House All Rights Reserved</p>
        </div>
    </footer>
    <script>
        function directNavigationBar() {
            window.location.href="index.php#navigation-bar";
        }
    </script>
</html>