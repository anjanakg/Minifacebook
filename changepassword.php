<?php
	require "session_auth.php";
	require 'database.php';

	$username= $_SESSION["username"]; //$_REQUEST["username"];
	//$newpassword = $_POST["newpassword"];
	$nocsrftoken = $_POST["nocsrftoken"]; 

	if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
		echo "<script>alert('Cross-site request forgery is detected');</script>";
		header("Refresh:0; url=logout.php");
		die();
	}

	if (isset($_SESSION["username"]) AND isset($_POST["newpassword"])) {
		if (empty($_SESSION["username"]) OR empty($_POST["newpassword"])){
			echo "<script>alert('INPUT MISSING');</script>";
			header("Refresh:0;url=logout.php");
			die;
		}

		$username = sanitize_input($_SESSION["username"]);
	   
		$newpassword=sanitize_input($_POST["newpassword"]);
		if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/",$newpassword)) {
	  			regeXCheckFail();
		}

		//echo "DEBUG:changepassword.php->Got: username=$username:newpassword=$newpassword\n";
    	if (changepassword($username,$newpassword)) {
    		echo "<h4>The new password has been set.</h4>";
       	}else{
       		echo "<h4>Error: Cannot change the password.</h4>";
        }
	}else{
		echo "No provided username/password to change.";
		exit();
	}

	function regeXCheckFail(){
	  echo "<script>alert('Password  isnt in correct format.Redirecting now.');</script>";
	  header("Refresh:0;url=changepasswordform.php");
	  die;
	}


?>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>
