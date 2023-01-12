<?php

    $lifetime = 15 * 60; //15 minutes
    $path = "/"; 
    $domain = "secad-team5.minifacebook.com"; 
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    session_start();

    $role = $_SESSION['role'];
    if($role != "superuser"){
        echo "<script>alert('You are not a superuser');</script>";
        session_destroy();
        header("Refresh:0; url=form.php");
        die();
    }

    if (isset($_POST["username"]) and isset($_POST["password"]) ){
        if(securechecklogin($_POST["username"],$_POST["password"])){

            $_SESSION["logged"] = TRUE;
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];

         }else{
            echo "<script>alert('Invalid username/password.');</script>";
            session_destroy();
            header("Refresh:0; url=form.php");
            die(); 
         }
    }

    //check the session
    if( !isset($_SESSION["logged"]) or $_SESSION["logged"] != TRUE){
  	    echo "<script>alert('You have to login first!');</script>";
    	session_destroy();
    	header("Refresh:0; url=form.php");
    	die();
    }

    if( $_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
    	//it is a session hijacking attack since it comes from a different browser
    	echo "<script>alert('Session hijacking attack is detected!');</script>";
        //echo $_SESSION["browser"];
        //echo " , ";
        //echo $_SERVER["HTTP_USER_AGENT"];
    	session_destroy();
    	header("Refresh:0; url=form.php");
    	die();
    }
?>