<?php
    $lifetime = 15 * 60; //15 minutes
    $path = "/"; // "/" . Need to change this for the team project
    $domain = "secad-team5.minifacebook.com"; //IP address or host name. Need to change this for the team project
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    session_start();
    $rand = bin2hex(openssl_random_pseudo_bytes(16));

    $mysqli = new mysqli('localhost','team5','team5','secad_team5');
    if($mysqli->connect_error){
         printf("database connection failed: %s\n",
         $mysqli->connect_error);
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
        regeXCheckFail();
      }


      if(securechecklogin($_POST["username"],$_POST["password"])){
        $_SESSION["logged"] = TRUE;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
        $_SESSION["nocsrftoken"] = $rand;

        // Session variable for superuser
        $_SESSION["role"] = "superuser";

      }else{
        echo "<script>alert('Invalid username/password.');</script>";
        //session_destroy();
        //header("Refresh:0; url=form.php");
		    //die(); 
	    }
    }

    if (!isset($_SESSION["logged"]) or $_SESSION["logged"] !=TRUE ){
      echo "<script>alert('Please login first.');</script>";
      header("Refresh:0; url=form.php");
      die(); 
    }

    if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
      echo "<script>alert('Session hijacking is detected!');</script>";
      session_destroy();
      header("Refresh:0; url=form.php");
      die(); 
    }

    function regeXCheckFail(){
      echo "<script>alert('INPUT data isnt in correct format.Redirecting now.');</script>";
      header("Refresh:0;url=form.php");
      die;
    }

    function sanitize_input($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2> 
<a href="viewusers.php">View Users</a>
<a href="logout.php">logout</a>
<?php

function securechecklogin($username, $password){
    global $mysqli;
    $prepared_sql = "SELECT * FROM superusers WHERE username= ? AND password=password(?);";
    if(!$stmt = $mysqli->prepare($prepared_sql)){
       echo "Prepared Statement Error";
    }
    $stmt->bind_param("ss", $username,$password);
    if(!$stmt->execute())  echo "Execute Error";
    if(!$stmt->store_result()) echo "Store_result error";
    $result = $stmt;
    if($result->num_rows ==1)
      return TRUE;
    echo "$username, $password";
    return FALSE;
}

?>