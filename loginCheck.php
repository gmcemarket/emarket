<?php
	include("db.php");
	session_start();
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		function check_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		}

		$email=check_input($_POST['email']);
		$password=md5(check_input($_POST['password']));

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  			$_SESSION['log_msg'] = "Invalid email format";
  			header('location:login.php');
		}
		else{
			$query=mysqli_query($con,"select * from register where email='$email' and password='$password'");
			if(mysqli_num_rows($query)==0){
				$_SESSION['log_msg'] = "User not found";
  				header('location:login.php');
			}
			else{
				$row=mysqli_fetch_array($query);
				if($row['verify']==0){
					$_SESSION['log_msg'] = "User not verified. Please activate account";
  					header('location:login.php');
				}
				else {
					$_SESSION['uid']=$row['user_id'];
					$_SESSION["name"] = $row["fname"];
					$_SESSION["lastname"] = $row["lname"];
					$_SESSION["seller"] = $row["sellerOf"];
					$_SESSION["password"] = $row["password"];
					header('location:user/profile.php');
				}
                         
			}
		}

	}
?>