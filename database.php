<?php
    $mysqli = new mysqli('localhost','team5','team5','secad_team5');
    if($mysqli->connect_errno){
         printf("Database connection failed: %s\n", $mysqli->connect_error);
         exit();
    }

    function changepassword($username, $newpassword){
        global $mysqli;
        $prepared_sql = "UPDATE users SET password=password(?) WHERE username= ?;";
        //echo "DEBUG>prepared_sql= $prepared_sql\n";

        if(!$stmt = $mysqli ->prepare($prepared_sql)) return FALSE;
        $stmt->bind_param("ss",$newpassword,$username);
        if(!$stmt->execute()) return FALSE;
        return TRUE;
    }

    function addUser($username, $email, $password, $fname, $lname, $phonenumber, $DOB, $gender) {

        global $mysqli;
        $active=1;
        #$prepared_sql = "INSERT INTO users(username,email,password,fname,lname,phonenumber,DOB,gender) VALUES(?,?, password(?),?,?,?,?,?);";
        $prepared_sql = "INSERT INTO users VALUE (?,?,password(?),?,?,?,?,?,current_date,?);";
        //echo "DEBUG>prepared_sql= $prepared_sql\n";

        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
            return FALSE;
        }
        $stmt->bind_param("sssssssss", $username,$email,$password,$fname,$lname,$phonenumber,$DOB,$gender,$active);
        if(!$stmt->execute()) {
            echo "Execute Error";
            return FALSE;
        }
        return TRUE;
        
     } 
     function renderPost($id)
     {
        global $mysqli;
        $prepared_sql = "SELECT post_title,post_msg,username,date_posted FROM posts WHERE post_id=?;";
        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
        }
        $stmt->bind_param("s",$id);
        if(!$stmt->execute()) {
            echo "Execute Error";
        }
        $posttitle= NULL;
        $postmsg= NULL;
        $userID= NULL;
        $postDate= NULL;
        if(!$stmt->bind_result($posttitle,$postmsg,$userID,$postDate)) echo "Store_result error";
        //$str = "";
        //$str .= "<h1>" . $postmsg ."</h1> \n <h2>by:".getUser($userID)."</h2>";
        //return $str;
        $stmt->fetch();
        echo "<h1>";
        echo $posttitle;
        echo "</h1> \n <h2>by:" ;
        //echo getUser($userID);
        echo "on: ";
        echo $postDate;
        echo "</h2> \n";
        echo $postmsg;

     }
     function getPost($id){

    global $mysqli;
        $prepared_sql = "SELECT post_title,post_msg,username,date_posted FROM posts WHERE post_id=?;";
        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
        }
        $stmt->bind_param("s",$id);
        if(!$stmt->execute()) {
            echo "Execute Error";
        }
        $posttitle= NULL;
        $postmsg= NULL;
        $userID= NULL;
        $postDate= NULL;
        if(!$stmt->bind_result($posttitle,$postmsg,$userID,$postDate)) echo "Store_result error";
        $stmt->fetch();
        return array($posttitle,$postmsg,$userID,$postDate);
     }

     function getUser($id)
     {
        global $mysqli;
        $prepared_sql = "SELECT username FROM users WHERE user_id=?;";
        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
        }
        $stmt->bind_param("s",$id);
        if(!$stmt->execute()) {
            echo "Execute Error";
        }
        $username= NULL;
        if(!$stmt->bind_result($username)) {
            echo "Store_result error";
        }
        return $username;
     }
    function addComment($id,$author, $text) {
        global $mysqli;
    $prepared_sql  = "INSERT INTO comments VALUE (default,?,?,?,current_date);";
        //$prepared_sql  = "INSERT INTO comments(post_id,post_msg,username,date_posted) VALUE (?,?,?,current_date);";

    if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
            return FALSE;
        }
        $stmt->bind_param("sss", $id,$text,$author);
        if(!$stmt->execute()) {
            echo "Execute Error";
            return FALSE;
        }
        return TRUE;

  } 
function addPost($title,$author, $text) {
        global $mysqli;
    $prepared_sql  = "INSERT INTO posts VALUE (default,?,?,?,current_date);";

    if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
            return FALSE;
        }
        $stmt->bind_param("sss", $title,$text,$author);
        if(!$stmt->execute()) {
            echo "Execute Error";
            return FALSE;
        }
        return TRUE;

  } 
  # This function works and sanitizes input into the database
    function sanitize_input($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    function editPost($id,$title,$text){
        global $mysqli;
    list($posttitle,$postmsg,$userID,$postDate) = getPost($id);
    if($userID != $_SESSION["username"]){
      echo "<script>alert('dont have permission');</script>";
      header("Refresh:0; url=index.php");
      die();
    }
    $prepared_sql = "UPDATE  posts SET post_title = ?, post_msg = ? WHERE post_id=?;";

        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
        }
        $stmt->bind_param("sss",$title, $text,$id);
        if(!$stmt->execute()) {
            echo "Execute Error";
                    return FALSE;
        }
        return TRUE;

    }
    function delPost($id,$user){
    global $mysqli;
    list($posttitle,$postmsg,$userID,$postDate) = getPost($id);
    if($userID != $user){
      echo "<script>alert('dont have permission');</script>";
      header("Refresh:0; url=index.php");
      die();
    }
    $prepared_sql = "DELETE FROM posts WHERE post_id=?;";

        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
        }
        $stmt->bind_param("s",$id);
        if(!$stmt->execute()) {
            echo "Execute Error";
        }
    $prepared_sql = "DELETE FROM comments WHERE post_id = ?;";
        if(!$stmt = $mysqli ->prepare($prepared_sql)) {
            echo "Prepared Statement Error";
        }
        $stmt->bind_param("s",$id);
        if(!$stmt->execute()) {
            echo "Execute Error";
        }
  }
  function renderAllComments($id){
    global $mysqli;
    $prepared_sql = "SELECT comment_msg,username FROM comments WHERE post_id= ?;";
    if(!$stmt = $mysqli->prepare($prepared_sql)){
       echo "Prepared Statement Error";
    }
    $stmt->bind_param("s",$id);
    if(!$stmt->execute())  echo "Execute Error";
    $comment_msg = NULL;
    $username = NULL;
    if(!$stmt->bind_result($comment_msg,$username)) echo "Store_result error";
    while ($stmt->fetch()) {
        ?>
        <div class="comment"> 
        <h4> "User: <?php echo $username;?> Comment: <?php echo $comment_msg;?></h4>
        <div>
        <?php
      }
  }
    

?>