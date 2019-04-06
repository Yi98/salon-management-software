<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- icon css link -->
    <link rel="stylesheet" type="text/css" href="font/flaticon.css"/>
    
    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <title>Log In</title>

    <style>
        .form-title {
            font-weight: bold;
            margin-bottom: 10%;
        }
        .log-in-container {
            border:1px solid grey;
            min-height: 50vh;
        }
        .vertical-center {
            min-height: 100%;
            min-height: 100vh;
            display:flex;
            align-items: center;
        }
        .login-image img {
            max-width:100%;
            height:400px;
        }
        .login-image {
            padding:0;    
        }
        .existing-member {
            float:right;
        }
        .login-form .form-group {
            margin: 10% 0 10% 0;
        }
        
        .form-group:nth-child(2) {
            margin:0;
        }
        .login-form .form-control {
            border:none;
            border-bottom: 1px solid grey;
        }
        .login-form .input-group-addon {
            border:none;
            border:1px solid grey;
        }
        .login-form i::before {
             margin:0;
        }
        .login-form label {
            background-color:white;
        }
        .login-form .form-control, .signin-form label {
            border-radius: 0;
        }
        .login-form .form-control {
            box-shadow: none;
        }
        .login-form input:focus {
            border-bottom:1px solid black;
        }
        input:focus::-webkit-input-placeholder {
            color:black;
        }
        #login {
            width:30%;
            padding:3%;
        }
    </style>
</head>
<body>
    <!-- Sign up form -->
    <div class="vertical-center">
        <div class="log-in-container container col-md-offset-2 col-md-8">
            <div class="row">
                <div class="login-content">
                    <div class="login-form  col-md-6">
                        <h2 class="form-title">Log In</h2>
                        <form method="POST" class="login-form" id="login-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                    <input type="text" name="email" id="email" placeholder="Your Login Email" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="pass"><i class="flaticon-lock "></i></label>
                                    <input type="password" name="password" id="password" placeholder="Password" class="form-control"/>
                                </div>
                            </div>
                            <a href="#">Forgot Password?</a>
                            <div class="form-group">
                                <input type="submit" name="login" id="login" class="btn btn-info" value="Log In"/>
                                <a  class="existing-member" href="signup.php" class="login-image-link">Not yet member?</a>
                            </div>
                        </form>
                    </div>
                    <div class="login-image col-md-6">
                    <img class="img-fluid" src="images\login-image.jpg" alt="sign up image">
                    </div>
                </div>
            </div>
        </div>    
    </div>
</body>
</html>