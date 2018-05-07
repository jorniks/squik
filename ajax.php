
<?
    $con = mysqli_connect('localhost', 'root', '', 'squik');
    session_start();

    $users = mysqli_query($con, "SELECT * FROM `friends` WHERE `me` = '" . $_SESSION['username'] . "'");
    $guys = mysqli_fetch_array($users);



	/*================================================
		Fetch and display messages from the database
	=================================================*/
	if (isset($_POST['display'])) {
		$userId = $_POST['userId'];

		$result = mysqli_query($con, "SELECT * FROM `message` WHERE `conn` = '" . $_SESSION['username']."-". $userId  . "' OR  `conn` = '" . $userId ."-". $_SESSION['username'] . "' ORDER BY `id` DESC");

		if (mysqli_num_rows($result) == 0) {
			echo "<label>You currently have no message to display.</label>";
		} else {
			while ($row = mysqli_fetch_array($result)) {
				if ($row['link'] == $_SESSION['username']) {
					echo "<div class=\"by-me\" id=\"li\">
	                      <div class=\"chat-content\">
	                        <div class=\"chat-meta\">".$row['link']."<span class=\"pull-right\">".$row['time']. " <span>| " .$row['date']."</span></span></div>
	                        ".$row['message']."
	                        <div class=\"clearfix\"></div>
	                      </div>
	                    </div>
					";
				} elseif ($row['link'] == $userId) {
					echo "<div class=\"by-other\" id=\"li\">
	                      <div class=\"chat-content\">
	                        <div class=\"chat-meta\">".$row['link']."<span class=\"pull-right\">".$row['time']. " <span>| " .$row['date']."</span></span></div>
	                        ".$row['message']."
	                        <div class=\"clearfix\"></div>
	                      </div>
	                    </div>
					";
				}
			}
		}
	}



	/*===========================================
				Update status for user
	============================================*/
	if (isset($_POST['stat'])) {
		$status = $_POST['status'];

		mysqli_query($con, "UPDATE `users` SET `status` = '" . mysqli_real_escape_string($con, $status) . "' WHERE `username` = '" . $_SESSION['username'] . "'");
		exit();
	}



	/*============================================
			Fetch and display status for user
	============================================*/
	if (isset($_POST['stato'])) {
		$name_sql = mysqli_query($con, "SELECT `status` FROM `users` WHERE `Username` = '" . $_SESSION['username'] . "'");
		$name_query = mysqli_fetch_assoc($name_sql);
		if ($name_query['status'] == "") {
			echo "Hey there, i am new to squik.<br>";
			echo "
				<a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\">
					<i class=\"fa fa-edit\"></i>
				</a>
			";
		} else {
			echo $name_query['status'];
			echo "<br>
				<a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\">
					<i class=\"fa fa-edit\"></i>
				</a>
			";
		}
		exit();
	}



	/*===================================================
			Fetch and display status for the other user
	===================================================*/
	if (isset($_POST['statu'])) {
		$userId = $_POST['userId'];
		$name_sql = mysqli_query($con, "SELECT `status` FROM `users` WHERE `Username` = '" . $userId . "'");
		$name_query = mysqli_fetch_assoc($name_sql);
		if ($name_query['status'] == "") {
			echo "Hey there, i am new to squik.";
		} else {
			echo $name_query['status'];
		}
		exit();
	}

	/*===============================================
				File sharing script
	===============================================*/
	if (isset($_POST['shar'])) {
		//$item = $_POST['image'];
		$image = $_FILES['image']['name'];
		$tmp_name = $_FILES['image']['tmp_name'];
		$location = "assets/img/" . $image;
		$type = $_FILES['image']['type'];

		if ($type == 'image/jpeg') {
			if (copy($tmp_name, $location)) {
                $year = date('Y', time());
                $month = date('M', time());
                $day = date('d', time());

                $hour = date('h', time()) - 1;
                $minute = date('i a', time());

                $time = $hour.":".$minute;
                $date = $day."/".$month."/".$year;

                $link = $_SESSION['username'];

                $message = "<img src=\"". $location ."\" class\"img-thumbnail\">";

				mysqli_query($con, "INSERT INTO `message`(`date`, `time`, `message`, `link`) VALUES ('" . $date . "','" . $time . "','" . $message . "','" . $link . "')");
			}
		}
	}
?>
