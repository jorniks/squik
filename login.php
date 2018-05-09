


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Squiky Chat</title>
        <link href="assets/img/user.png" rel="icon">
        <link href="assets/img/user.png" rel="apple-touch-icon">

        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

        <script type="text/javascript" language="javascript">
            function showPassword() {
                var passText = document.getElementById('password');
                var checkbox = document.getElementById('checkbox');

                if (passText.type == "password") {
                    passText.type = "text";
                } else {
                    passText.type = "password";
                }
            }
        </script>

        <style type="text/css">
            .panel-body {
                font-size: 1.1em;
                color: white;
                background: rgba(75, 232, 115, 0.3);
                margin-top: 30%;
                box-shadow: 0 0 25px inset rgba(255, 255, 115, 0.5)
            }

            .input-lg, .checkbox-inline {
                font-size: 16px;
            }

        </style>

    </head>

    <body style="background:url('assets/img/droplets.jpg');">
        <div class="container">

            <div class="row ">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div class="panel-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <span style="font-size: 4em;"><i class="fa fa-user fa-inverse"></i></span>
                            </div>
                        </div>
                        <form method="POST" action="login.php" role="form">

                            <?php

                                $con = mysqli_connect('localhost', 'root', '', 'squik');
                                session_start();

                                if ($_POST) {
                                    $_SESSION['username'] = trim(strtolower($_POST['username']));
                                    $_SESSION['password'] = trim($_POST['password']);
                                    $hashed_password = trim(sha1($_SESSION['password']));

                                    if ($_SESSION['username'] == "teemz") {
                                        $_SESSION['username'] = "Teemz";
                                    } else if ($_SESSION['username'] == "arjay") {
                                        $_SESSION['username'] = "ArJay";
                                    }

                                    if ($_SESSION['username']) {

                                        $sql = "SELECT * FROM `users` WHERE `Username` = '" . mysqli_real_escape_string($con, $_SESSION['username']) . "'";
                                        if ($query = mysqli_query($con, $sql)) {
                                            $query_num_rows = mysqli_num_rows($query);
                                            if ($query_num_rows == 0) {
                                                echo "<div id=\"errormessage\">Incorrect Username</div><br>";
                                                session_destroy();
                                            } else {
                                                $pas = mysqli_fetch_assoc($query);
                                                $pass = $pas['Password'];
                                                if ($pass == $hashed_password) {
                                                    header('Location: index.php');
                                                } else {
                                                    echo "<div id=\"errormessage\">Incorrect Password</div><br>";
                                                    session_destroy();
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
                            <hr>

                            <br>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                <input type="text" class="form-control input-lg" name="username" placeholder="Your Username " autofocus required>
                            </div>

                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                <input type="password" class="form-control input-lg" name="password" id="password" placeholder="Your Password" required>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="checkbox" onchange="showPassword()"> Show Password
                                </label>

                                <!--<span class="pull-right">
                                        <a href="" >Forget password? </a>
                                    </span>-->
                            </div>

                            <br>

                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block">Login Now</button>
                            </div>
                            
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </body>
</html>
