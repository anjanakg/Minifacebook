<?php
  require 'database.php';
  #require 'session_auth.php'; commented this out cause anyone should be able to register

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

  	  if (empty($_POST["username"]) OR empty($_POST["email"]) OR empty($_POST["password"]) OR empty($_POST["fname"]) OR empty($_POST["lname"]) OR empty($_POST["phonenumber"]) OR empty($_POST["DOB"]) OR empty($_POST["gender"])) {

  		echo "<script>alert('INPUT MISSING');</script>";
		header("Refresh:0;url=registrationform.php");
		die;
    }

	$username = sanitize_input($_POST["username"]);
	if (!preg_match("/[A-Za-z]{3,20}/",$username)) {
      regeXCheckFail();
    }

	$email = sanitize_input($_POST["email"]);
		if (!preg_match("/^[\w.-]+@[\w-]+(.[\w-]+)*$/",$email)) {
      regeXCheckFail();
    }

	$password = sanitize_input($_POST["password"]);

	if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/",$password)) {
      regeXCheckFail();
    }
	
	$fname = sanitize_input($_POST["fname"]);
	if (!preg_match("/[A-Za-z]{3,20}/",$fname)) {
      regeXCheckFail();
    }	

    $lname = sanitize_input($_POST["lname"]);
    if (!preg_match("/[A-Za-z]{3,20}/",$lname)) {
      regeXCheckFail();
    }	

    $phonenumber = sanitize_input($_POST["phonenumber"]);
    if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phonenumber)) {
   	  regeXCheckFail();
    }

    $DOB = sanitize_input($_POST["DOB"]);
	
	$gender = sanitize_input($_POST["gender"]);		

	if(addUser($username,$email,$password,$fname,$lname,$phonenumber,$DOB,$gender)){
    echo "<script>alert('User account created successfully');</script>";
      header("Refresh:0;url=form.php");
    die;
	}else{
    echo "<script>alert('Error:Cannot create account.');</script>";
      header("Refresh:0;url=registrationform.php");
    die;
	}
	}else{
  	  	echo "<script>alert('Bad Request');</script>";
		header("Refresh:0;url=registrationform.php");
		die;

  } 


	
?>

<a href="form.php">Home</a> 