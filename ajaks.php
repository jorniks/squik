

<?
    $con = mysqli_connect('localhost', 'root', '', 'squik');
    session_start();

// file name
        $image = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $location = "assets/img/shared/" . $image;
        $type = $_FILES['file']['type'];

// file extension
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);

// Valid image extensions
$image_ext = array("jpg","png","jpeg","gif");

$response = 0;
if(in_array($file_extension,$image_ext)){
    // Upload file
    if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                $year = date('Y', time());
                $month = date('M', time());
                $day = date('d', time());

                $hour = date('h', time()) - 1;
                $minute = date('i a', time());

                $time = $hour.":".$minute;
                $date = $day."/".$month."/".$year;

                $link = $_SESSION['username'];

                $message = "<div class=\"col-md-4\">
                    <div class=\"portfolio-item\">
                        <a class=\"preview\" title=\"Shared by: " . $_SESSION['username'] . "\" href=\"". $location ."\"><img src=\"". $location ."\" class=\"img-responsive\"></a>
                    </div>
                </div>";

                //$message = "<a href=\"". $location ."\"><img src=\"". $location ."\" class\"img-thumbnail\"></a>";

                mysqli_query($con, "INSERT INTO `message`(`date`, `time`, `message`, `link`) VALUES ('" . $date . "','" . $time . "','" . $message . "','" . $link . "')");
    }
}
	/*===============================================
				File sharing script
                mysqli_real_escape_string($con, "<a href=\"". $location ."\"><img src=\"". $location ."\" class\"img-thumbnail\"></a>");
	===============================================*/
?> 
                
