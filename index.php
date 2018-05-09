
<?
    session_start();

    if (!isset($_SESSION['username'])) {
        session_destroy();
        header('Location: login.php');
    } else {
        $con = mysqli_connect('localhost', 'root', '', 'squik');
        $users = mysqli_query($con, "SELECT * FROM `friends` WHERE `me` = '" . $_SESSION['username'] . "'");

        if (isset($_SESSION['username'])) {
            $name_sql = mysqli_query($con, "SELECT * FROM `users` WHERE `Username` = '" . $_SESSION['username'] . "'");
            if ($name_query = mysqli_fetch_assoc($name_sql)) {
                $fname = $name_query['Fname'];
                $lname = $name_query['Lname'];
            }
        }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Squiky Chat</title>


        <link href="assets/img/user.png" rel="icon">
        <link href="assets/img/user.png" rel="apple-touch-icon">

        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet">
        <!--CUSTOM BASIC STYLES-->
        <link href="assets/css/basic.css" rel="stylesheet">
        <!--CUSTOM MAIN STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet">
        <!-- PAGE LEVEL STYLES -->
        <link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet">

    </head>

    <body>
        <div id="wrapper">

            <nav class="navbar-default navbar-side" role="navigation">
                <div class="row" style="width: 100%;">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php" style="color: #fff;">Squik</a>
                    </div>
                </div>

                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li>
                            <div class="user-img-div">
                                <form>
                                    <?echo "<img src=\"" . $name_query['photo'] . "\" class=\"img-thumbnail\" id=\"select\">";?>
                                    <input type="file" name="profyl" id="profyl" style="display: none;">
                                </form>

                                <div class="inner-text">
                                    <? echo  $fname. " " .  $lname; ?>
                                    <br>
                                    <a href="logout.php" style="color: red;">Log Out</a>
                                </div>
                            </div>
                        </li>
                       
                        <li>
                            <div id="stats">

                            </div>
                        </li>
                    </ul>

                    <ul class="nav nav-tabs">
                        <?
                            $dataArray = array();
                            $tabPane = "";

                            while ($guys = mysqli_fetch_array($users)) {

                                array_push($dataArray, $guys['friend']);

                                if ($guys['friend'] != $_SESSION['username']) {
                                    if ($guys['friend'] == $dataArray[0]) {
                                        echo "
                                            <li class=\"active\">
                                                <a data-toggle=\"tab\" href=\"#" . $guys['friend'] ."\">" . $guys['friend'] ."</a>
                                            </li>
                                        ";

                                        $tabPane .= "
                                            <div class=\"tab-pane fade active in\" id=\"".$guys['friend']."\">
                                                <div class=\"row\">
                                                    <div class=\"col-md-12\">
                                                        <h1 class=\"page-subhead-line\" id=\"statu\">

                                                        </h1>
                                                    </div>
                                                </div>
                                                <!-- /. ROW  -->

                                            <div class=\"panel-footer\" style=\"border: none; border-bottom: 1px solid #ddd;\">
                                                <div class=\"input-group\">
                                                    <span class=\"input-group-btn\">
                                                        <button class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal\"><i class=\"fa fa-paperclip\"></i></button>
                                                    </span>

                                                    <input type=\"text\" id=\"message\" class=\"form-control\" placeholder=\"Enter Message\" onfocus=\"displayMessage()\" data-emojiable=\"true\">

                                                    <span class=\"input-group-btn\">
                                                        <button class=\"btn btn-success\" id=\"send\" type=\"button\"><i class=\"fa fa-paper-plane\"></i></button>
                                                    </span>
                                                </div>
                                                <span><small><em id=\"typing\"></em></small></span>
                                            </div>

                                            <!--========================================
                                                    Chat body container and messages
                                            =========================================-->
                                            <div class=\"chat-widget-main\" style=\"background: url('assets/img/home-enroll-bg.jpg'); background-repeat: no-repeat; background-size: 100% 100%;\">
                                            <input type=\"hidden\" id=\"userId\" value=\"" .$guys['friend'] . "\">
                                                <div class=\"chats\">
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                            ";
                                    } else {
                                        echo "
                                            <li class=\"\">
                                                <a data-toggle=\"tab\" href=\"#" . $guys['friend'] ."\">" . $guys['friend'] ."</a>
                                            </li>
                                        ";

                                        $tabPane .= "
                                            <div class=\"tab-pane fade\" id=\"".$guys['friend']."\">
                                            <div class=\"row\">
                                                <div class=\"col-md-12\">
                                                    <h1 class=\"page-subhead-line\" id=\"statu\">

                                                    </h1>
                                                </div>
                                            </div>
                                            <!-- /. ROW  -->

                                            <div class=\"panel-footer\" style=\"border: none; border-bottom: 1px solid #ddd;\">
                                                <div class=\"input-group\">
                                                    <span class=\"input-group-btn\">
                                                        <button class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal\"><i class=\"fa fa-paperclip\"></i></button>
                                                    </span>

                                                    <input type=\"text\" id=\"message\" class=\"form-control\" placeholder=\"Enter Message\"  onfocus=\"displayMessage()\"  data-emojiable=\"true\">

                                                    <span class=\"input-group-btn\">
                                                        <button class=\"btn btn-success\" id=\"send\" type=\"button\"><i class=\"fa fa-paper-plane\"></i></button>
                                                    </span>
                                                </div>
                                                <span><small><em id=\"typing\"></em></small></span>
                                            </div>

                                            <!--========================================
                                                    Chat body container and messages
                                            =========================================-->
                                            <div class=\"chat-widget-main\" style=\"background: url('assets/img/home-enroll-bg.jpg'); background-repeat: no-repeat; background-size: 100% 100%;\">
                                            <input type=\"hidden\" id=\"userId\" value=\"" .$guys['friend'] . "\">
                                                <div class=\"chats\">
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                            ";
                                    }
                                }
                            }
                        ?>
                    </ul>
                </div>
            </nav>
            <!-- /. NAV SIDE  -->

            <div id="page-wrapper">
                <div id="page-inner">

                    <?
                        //Message sending script

                        if (isset($_POST['done'])) {
                            $message = trim($_POST['message']);
                            $userId = trim($_POST['userId']);

                            if (!empty($message)) {
                                
                                $year = date('Y', time());
                                $month = date('M', time());
                                $day = date('d', time());

                                $hour = date('H', time());
                                $minute = date('i', time());

                                $time = $hour.":".$minute;
                                $wat = date('h:i a', strtotime($time));
                                $date = $day."/".$month."/".$year;

                                $link = $_SESSION['username'];
                                $conn = $_SESSION['username']."-".$userId;

                                mysqli_query($con, "INSERT INTO `message`(`date`, `time`, `message`, `link`, `conn`) VALUES ('" . $date . "','" . $wat . "','" . mysqli_real_escape_string($con, $message) . "','" . $link . "','" . $conn . "')");
                                exit();
                            }
                        }
                    ?>


                    <!--========================================
                            Modal form for changing status
                    =========================================-->
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Change Status</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <textarea class="form-control" id="status" placeholder="Status" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="update" class="btn btn-primary">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>

                     

                    <div class="row " >
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-default" style="border: none; padding: 0;">
                                <div class="panel-body" style="padding: 0;">

                                    <!--===============================
                                        Type and send text controls
                                        <textarea rows="1" id="message" class="form-control" placeholder="Enter Message" autofocus></textarea>
                                    ================================-->

                                    <div class="tab-content">
                                        <?
                                            echo $tabPane;
                                        ?>
                                        
                                    </div>


                                    <!--========================================
                                            Modal form for sharing files
                                    =========================================-->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Send a File</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <!--========================================
                                                                Form for upload
                                                    =========================================-->
                                                    <form method='post' action='' enctype="multipart/form-data>
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-4">File Upload</label>
                                                            <div class="">
                                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                    <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                                                                    <div>
                                                                        <span class="btn btn-file btn-success"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="file" id="file"></span>
                                                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" id="share" class="btn btn-primary">Send</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="col-md-4 ">
                                        <div class="portfolio-item">
                                            <a class="preview" title="Image Title Here" href="assets/img/shared/Profile.jpg"><img src="assets/img/portfolio/g.jpg" class="img-responsive "></a>
                                        </div>
                                    </div>-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. WRAPPER  -->

        <!--<div id="footer-sec">
            &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
        </div>
         /. FOOTER  -->

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- PAGE LEVEL SCRIPTS -->
        <script src="assets/js/bootstrap-fileupload.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>

    </body>
</html>


<script type="text/javascript">

    $(document).ready(function() {

        $("#select").click(function() {
            $("#profyl").click();
        });
        

        displayMessage();
        displayStatus();
        displayStatusOther();
        //setInterval(function (){displayMessage()} , 6000);
        //setInterval(function (){isEmpty()} , 1000);
        //setInterval(function (){displayStatus()} , 2000);
        setInterval(function (){displayStatusOther()} , 2000);

        function isEmpty(){
            var userId = $("#userId").val();
            if (document.getElementById("message").value.trim()) {
                $("#typing").html(userId + ' is typing...');
            } else {
                $("#typing").html('');
            }
        }


        $("#send").click(function() {
            var message = $("#message").val();
            var userId = $("#userId").val();

            $.ajax({
                url: "index.php",
                type: "POST",
                async: false,
                data: {
                    "done": 1,
                    "userId": userId,
                    "message": message
                },
                success: function(data){
                    $("#message").val('');
                    displayMessage();
                }
            })
        });


        $('#message').keyup(function(e){
            if(e.keyCode == 13){
                var message = $("#message").val();
                var userId = $("#userId").val();

                $.ajax({
                    url: "index.php",
                    type: "POST",
                    async: false,
                    data: {
                        "done": 1,
                        "userId": userId,
                        "message": message
                    },
                    success: function(data){
                        $("#message").val('');
                        displayMessage();
                    }
                })
            }
        });


        $("#update").click(function() {
            var status = $("#status").val();

            $.ajax({
                url: "ajax.php",
                type: "POST",
                async: false,
                data: {
                    "stat": 1,
                    "status": status
                },
                success: function(data){
                    $("#status").val('');
                    $("#myModal2").modal('hide');
                    displayStatus();
                }
            })
        });


        $("#status").keyup(function(e) {
            if(e.ctrlKey && e.keyCode == 13){
                e.preventDefault();
                var status = $("#status").val();

                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    async: false,
                    data: {
                        "stat": 1,
                        "status": status
                    },
                    success: function(data){
                        $("#status").val('');
                        $("#myModal2").modal('hide');
                        displayStatus();
                    }
                })
            }
        });


        $('#share').click(function(){

                var fd = new FormData();
                var userId = $("#userId").val();
                var files = $('#file')[0].files[0];
                fd.append('file',files);
                fd.append('request',1);

                // AJAX request
                $.ajax({
                    url: 'ajaks.php',
                    type: 'post',
                    data: fd,
                    "userId": userId,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $("#myModal").modal('hide');
                        displayMessage();
                    }
                });
            });

    });


    function displayMessage() {

        //var audio = new Audio("assets/sound/definite.mp3");
        var userId = $("#userId").val();
        $.ajax({
            url: "ajax.php",
            type: "POST",
            async: false,
            data: {
                "display": 1,
                "userId": userId,
            },
            success: function(d){
                $(".chats").html(d);
            }
        });
    }


    function displayStatus() {

        $.ajax({
            url: "ajax.php",
            type: "POST",
            async: false,
            data: {
                "stato": 1,
            },
            success: function(d){
                $("#stats").html(d);
            }
        });
    }


    function displayStatusOther() {

        var userId = $("#userId").val();
        $.ajax({
            url: "ajax.php",
            type: "POST",
            async: false,
            data: {
                "statu": 1,
                "userId": userId,
            },
            success: function(d){
                $("#statu").html(d);
            }
        });
    }

</script>
<?
    }
?>