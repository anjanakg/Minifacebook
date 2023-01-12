<?php
  require "session_auth.php";
  require 'database.php';

  $nocsrftoken = $_POST["nocsrftoken"]; 

  if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION["nocsrftoken"])){
    echo "<script>alert('Cross-site request forgery is detected');</script>";
    header("Refresh:0; url=logout.php");
    die();
  }
    $nocsrftoken = $_POST["nocsrftoken"]; 

  /*if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
    echo "<script>alert('Cross-site request forgery is detected');</script>";
    header("Refresh:0; url=logout.php");
    die();
  }*/

  if (isset($_POST["title"]) AND isset($_POST["message"])) {
    if (empty($_POST["title"]) OR empty($_POST["message"])){
      echo "<script>alert('INPUT MISSING');</script>";
      header("Refresh:0;url=index.php");
      die();
    }
    $id=sanitize_input($_POST["id"]);  
    $title=sanitize_input($_POST["title"]);
    $message=sanitize_input($_POST["message"]);

      if (editPost($id,$title,$message)) {
        header("Refresh:0;url=editform.php?id=$id");
       die;
        }else{
          echo "<h4>Error: Failure to Create Post.</h4>";
        }
  }else{
    echo "No provided title and message to post.";
    //header("Refresh:0;url=index.php");
    die();
  }



?>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>
