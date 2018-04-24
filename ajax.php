
<?
    $con = mysqli_connect('localhost', 'root', '', 'squik');
    session_start();

	/*================================================
		Fetch and display messages from the database
		 style=\"background: url('assets/img/droplets.jpg'); background-repeat: no-repeat; background-size: 100% 100%;\"
	=================================================*/
	if (isset($_POST['display'])) {

		$result = mysqli_query($con, "SELECT * FROM `message` WHERE 1 ORDER BY `id` DESC");

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
				} elseif ($row['link'] != $_SESSION['username']) {
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
				Change profile photo
	============================================*/
	if (isset($_POST['profyl'])) {
		$filename = $_FILES(['profyl']['name']);
		$location = "assets/img/profile/" . $filename;

		if (move_uploaded_file($_FILES(['profyl'], ['tmp_name']), $location)) {
			$response['status'] = 'ok';
		} else {
			$response['status'] = 'error';
		}

		echo json_encode($response);
	}
                    

	/*===========================================
				Update status for user
				<div class=\"chat-widget-right\">".$row['message']."</div>
	============================================*/
	if (isset($_POST['stat'])) {
		$status = $_POST['status'];

		mysqli_query($con, "UPDATE `users` SET `status` = '" . $status . "' WHERE `username` = '" . $_SESSION['username'] . "'");
		exit();
	}



	/*============================================
			Fetch and display status for user
	============================================*/
	if (isset($_POST['stato'])) {
		$name_sql = mysqli_query($con, "SELECT `status` FROM `users` WHERE `Username` = '" . $_SESSION['username'] . "'");
		$name_query = mysqli_fetch_assoc($name_sql);
		if ($name_query['status'] == "") {
			echo "Here there, i am new to squik.<br>";
			echo "
				<a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal2\">
					<i class=\"fa fa-edit\"></i>
				</a>
			";
		} else {
			echo $name_query['status'];
			echo "<br>
				<a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal2\">
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
		$name_sql = mysqli_query($con, "SELECT `status` FROM `users` WHERE NOT `Username` = '" . $_SESSION['username'] . "'");
		$name_query = mysqli_fetch_assoc($name_sql);
		if ($name_query['status'] == "") {
			echo "Here there, i am new to squik.";
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
