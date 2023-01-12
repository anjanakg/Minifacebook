<?php 
  require "database.php";
  require "session_auth.php";
  $id =NULL;
  if(isset($_GET['id'])){
    $id =intval($_GET['id']);
    list($title,$text,$name,$date) = getPost(intval($_GET['id']));
  }
  $rand=bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>
  
  <form action="edit.php" method="POST" class ="post edit">
    Title: 
    <input type="text" class="text_field" name="title" value="<?php echo htmlentities($title); ?>" /> <br>
    Text: 
      <textarea name="message" cols="80" rows="5">
        <?php echo htmlentities($text); ?> 
       </textarea><br/>

    <button class="button" type="submit">
      Update
    </button>
      <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
     <input type ="hidden" name= "id" value = "<?php echo $id ?>" />
  </form>
           

  <a href="index.php">Home Page</a>
