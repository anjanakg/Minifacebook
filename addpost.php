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

  if (isset($_SESSION["username"]) AND isset($_POST["title"]) AND isset($_POST["message"])) {
    if (empty($_SESSION["username"]) OR empty($_POST["title"]) OR empty($_POST["message"])){
      echo "<script>alert('INPUT MISSING');</script>";
      header("Refresh:0;url=addpostform.php");
      die;
    }

    $username = sanitize_input($_SESSION["username"]);
     
    $title=sanitize_input($_POST["title"]);
    $message=sanitize_input($_POST["message"]);

    //echo "DEBUG:changepassword.php->Got: username=$username:newpassword=$newpassword\n";
      if (addPost($title,$username,$message)) {
        echo "<h4>New Post Created.</h4>";
        }else{
          echo "<h4>Error: Failure to Create Post.</h4>";
        }
  }else{
    echo "No provided title amd message to post.";
    exit();
  }



?>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>
