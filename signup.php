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

    <title>Sign Up</title>

    <style>
        .form-title {
            font-weight: bold;
            margin-bottom: 10%;
        }
        .sign-up-container {
            border:1px solid grey;
            min-height: 50vh;
        }
        .vertical-center {
            min-height: 100%;
            min-height: 100vh;
            display:flex;
            align-items: center;
        }
        .signup-image img {
            width:100%;
            height:500px;
        }
        .signup-image {
            padding:0;
                
        }
        .existing-member {
            float:right;
        }
        .signup-form .form-group {
            margin: 10% 0 10% 0;
        }
        .signup-form .form-control {
            border:none;
            border-bottom: 1px solid grey;
        }
        .signup-form .input-group-addon {
            border:none;
            border:1px solid grey;
        }
        .signup-form i::before {
             margin:0;
        }
        .signup-form label {
            background-color:white;
        }
        .signup-form .form-control, .signup-form label {
            border-radius: 0;
        }
        .signup-form .form-control {
            box-shadow: none;
        }
        .signup-form input:focus {
            border-bottom:1px solid black;
        }
        input:focus::-webkit-input-placeholder {
            color:black;
        }
        #signup {
            width:30%;
            padding:3%;
        }
    </style>
</head>
<body>
    <!-- Sign up form -->
    <div class="vertical-center">
        <div class="sign-up-container container col-md-offset-2 col-md-8">
            <div class="row">
                <div class="signup-content">
                    <div class="signup-form  col-md-6">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name"><i class="flaticon-id-card"></i></label>
                                    <input type="text" name="name" id="name" placeholder="Your Name" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email"><i class="flaticon-email"></i></label>
                                    <input type="email" name="email" id="email" placeholder="Your Email" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="pass"><i class="flaticon-lock"></i></label>
                                    <input type="password" name="pass" id="pass" placeholder="Password" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="re-pass"><i class="flaticon-lock-1"></i></label>
                                    <input type="password" name="re_pass" id="re-pass" placeholder="Repeat your password" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="signup" id="signup" class="btn btn-info" value="Register"/>
                                <a  class="existing-member" href="login.php" class="signup-image-link">I am already member</a>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image col-md-6">
                    <img src="images\signup-image.jpg" alt="sign up image">
                    </div>
                </div>
            </div>
        </div>    
    </div>
</body>
</html>