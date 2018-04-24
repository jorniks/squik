


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Squiky Chat</title>

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

    </head>

    <body style="background-color: #E2E2E2;">
        <div class="container">
            <div class="row text-center " style="padding-top:100px;">
                <div class="col-md-12">
                    <img src="assets/img/logo-invoice.png" />
                </div>
            </div>

            <div class="row ">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div class="panel-body">
                        <form method="POST" action="login.php" role="form">

                            <?php

                                $con = mysqli_connect('localhost', 'root', '', 'squik');
                                session_start();

                                if ($_POST) {
                                    $_SESSION['username'] = strtolower($_POST['username']);
                                    $_SESSION['password'] = $_POST['password'];
                                    $hashed_password = sha1($_SESSION['password']);
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
                                                if ($pass == $_SESSION['password']) {
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

                            <h5>Enter Details to Login</h5>
                            <br>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                <input type="text" class="form-control" name="username" placeholder="Your Username " autofocus>
                            </div>

                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Your Password">
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

                            <button class="btn btn-primary">Login Now</button>
                            <hr> 
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </body>
</html>
