<?php
    $lifetime = 15 * 60; //15 minutes
    $path = "/";
    $domain = "secad-team5.minifacebook.com"; 
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    session_start();

    $mysqli = new mysqli('localhost','team5','team5','secad_team5');   
    if($mysqli ->connect_errno){
        printf("Database connection failed: %s\n", $mysqli ->connect_error);
        exit();
    }

    if(isset($_POST["username"]) and isset($_POST["password"])){   
        if (secureCheckLogin($_POST["username"],$_POST["password"])) {
            $_SESSION["logged"] = TRUE;
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
                
        }else{
            echo "<script>alert('Invalid username/password');</script>";
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