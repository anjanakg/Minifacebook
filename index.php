  
  <link rel="stylesheet" href="index.css">

<?php
require "database.php";
    $lifetime = 15 * 60; //15 minutes
    $path = "/"; 
    $domain = "secad-team5.minifacebook.com"; 
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    session_start();

    $mysqli = new mysqli('localhost','team5','team5','secad_team5');
      if($mysqli->connect_error){
         printf("database connection failed: %s\n", $mysqli->connect_error);
         exit();
      }
    if (isset($_POST["username"]) and isset($_POST["password"]) ){
      if (empty($_POST["username"]) OR empty($_POST["password"])) {
        echo "<script>alert('INPUT MISSING');</script>";
        session_destroy();
        header("Refresh:0;url=form.php");
        die;
      } 

      $username = sanitize_input($_POST["username"]);
      if (!preg_match("/[A-Za-z]{3,20}/",$username)) {
        regeXCheckFail($username);
      }

      $password=sanitize_input($_POST["password"]);
      
      if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/",$password)) {
        regeXCheckFail($password);
      }


      if(securechecklogin($_POST["username"],$_POST["password"])){
        $_SESSION["logged"] = TRUE;
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];

        //if(!isset($_SESSION["username"]))
          $_SESSION["username"] = $username;

      }else{
        echo "<script>alert('Invalid username/password.');</script>";
        session_destroy();
        header("Refresh:0; url=form.php");
		    die(); 
	    }
    }

    if (!isset($_SESSION["logged"]) or $_SESSION["logged"] !=TRUE ){
      echo "<script>alert('Please login first.');</script>";
      session_destroy();
      header("Refresh:0; url=form.php");
      die(); 
    }

    if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
      echo "<script>alert('Session hijacking is detected!');</script>";
      session_destroy();
      header("Refresh:0; url=form.php");
      die(); 
    }
    if (isset($_POST['id'])) {
     /*$csrftoken = $_POST["nocsrf"];
    if(!isset($csrftoken) or
     ($csrftoken!=$_SESSION['nocsrf'])) {
    echo "A CSRF attack detected ";
    die();
    }*/
    delPost((int)($_POST["id"]), $_SESSION["username"]);
   }

    function regeXCheckFail($input){
      echo $input;
      echo "<script>alert('INPUT data isnt in correct format.Redirecting now.". $input."');</script>";
      //header("Refresh:0;url=form.php");
     // die;
    }

?>
  <head>
    <meta charset="utf-8">
    <title>Home page - SecAD</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="wrapper">
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2> 
<a href="changepasswordform.php">change password</a>
<a href="addpostform.php">add post</a>
<a href="logout.php">logout</a>
<div class="content">  
 <?php
   echo renderAllPosts();
 ?>
</div>
</div>
</body>

<?php

  function securechecklogin($username, $password){
    global $mysqli;
    $flag=1;
    $prepared_sql = "SELECT * FROM users WHERE username= ? AND password=password(?) AND active=?;";
    if(!$stmt = $mysqli->prepare($prepared_sql)){
       echo "Prepared Statement Error";
    }
    $stmt->bind_param("sss", $username,$password,$flag);
    if(!$stmt->execute())  echo "Execute Error";
    if(!$stmt->store_result()) echo "Store_result error";
    $result = $stmt;
    if($result->num_rows ==1)
      return TRUE;
    return FALSE;
  }
  function renderAllPosts(){
    global $mysqli;
    $prepared_sql = "SELECT post_id,post_msg,username FROM posts";
    if(!$stmt = $mysqli->prepare($prepared_sql)){
       echo "Prepared Statement Error";
    }
    if(!$stmt->execute())  echo "Execute Error";
    $post_id = NULL;
    $post_msg = NULL;
    $username = NULL;
    if(!$stmt->bind_result($post_id,$post_msg,$username)) echo "Store_result error";
    while ($stmt->fetch()) {
        echo "<style> .wrap-flex { display:flex; } </style> <div class = \"wrap-flex\"> Post:";
        echo  $post_msg;
        echo "<form method=\"GET\" action=\"post.php?id=\"?\">" ;
        echo "<input type=\"hidden\" name=\"id\" value=\""; 
        echo  $post_id;
        echo "\"/ >";
        echo " <button class=\button\ type=\submit\>
                  View
                </button>
      </form> ";
        
        if($username == $_SESSION["username"]){
          echo "<form method=\"GET\" action=\"editform.php?id=\"?\">" ;
        echo "<input type=\"hidden\" name=\"id\" value=\""; 
        echo  $post_id;
        echo "\"/ >";
        echo " <button class=\button\ type=\submit\>
                  Edit
                </button>
      </form> ";
        echo "<form method=\"GET\" action=\"del.php?id=\"?\">" ;
        echo "<input type=\"hidden\" name=\"id\" value=\""; 
        echo  $post_id;
        echo "\"/ >";
        echo " <button class=\button\ type=\submit\>
                  Delete
                </button>
      </form> ";
        }
        echo "</div>";
        
      }
  }



?>