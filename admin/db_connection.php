<?php 
	// error_reporting(0);
	session_start();

	//ph time
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d G:i:s");
    
	//db connection
    // $db = mysqli_connect('localhost','root','','shop_database');
    // $con = new mysqli('localhost','root','','shop_database');
    $db = mysqli_connect('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');
    $con = new mysqli('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');

   	if(isset($_SESSION['username'])){
      	$session_username = $_SESSION['username'];

		//get user details
		$sql = "SELECT * FROM users_tbl WHERE username='$session_username' LIMIT 1";
        $query=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($query);

        if (!file_exists('assets/img/'.$row[5])) {
            $user_image="assets/img/defaultv2.png";
			// $user_image = 'assets/img/'.$row[5];
        }else{
			$user_image = 'assets/img/'.$row[5];
		}


		//get user id
		$session_user_id = $row[0];
		//get email
		$session_email = $row[1];
		//get access
		$session_access = $row[3];
		//get name
		$session_full_name = $row[7];
		//get mobile
		$session_mobile = $row[8];
		//get delivery address
		$session_user_address = $row[9];

		


    }

    if (isset($_GET['logout'])) {

		$description = "";
		$user_id = $session_user_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['user_id'] = $session_user_id;
		$data['username'] = $session_username;
		$description .= json_encode($data);
		$activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
		VALUES('$user_id', 'logout','$date','$description')";
		mysqli_query($db, $activity_sql);

		session_destroy();
		unset($_SESSION['username']);
		header("location: index.php");
	}




   
 ?>