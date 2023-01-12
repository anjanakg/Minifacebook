<?php
	require "session_auth.php";
	require 'database.php';

	$user= $_POST["username"]; //$_REQUEST["username"];
	$act = $_POST["actvalue"];
	$nocsrftoken = $_POST["nocrsftoken"]; 

	if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
		echo "<script>alert('Cross-site request forgery is detected');</script>";
		header("Refresh:0; url=logout.php");
		die();
	}

	if (isset($user) or isset($act)) {
    	if (activation($user,$act)) {
    		echo "<script>alert('The profile has been updated.');</script>";
    		header("Refresh:0; url=viewusers.php");
       	}else{
       		echo "<script>alert('Error: Cannot update the profile.');</script>";
       		header("Refresh:0; url=viewusers.php");
       		die();
        }
	}else{
		echo "<script>alert('Invalid info!!');</script>";
		header("Refresh:0; url=viewusers.php");
		exit();
	}

?>