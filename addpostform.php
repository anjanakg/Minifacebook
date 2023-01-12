<?php
  require "session_auth.php";
  $rand=bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Post-SecAD</title>
</head>
<body>
      	<h1>Add Post</h1>
<?php

  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="addpost.php" method="POST" class="post addition">
                Title:<input type="text" class="text_field" name="title"  /> 
                <br>
                Message: <textarea name="message" class="text_field" cols="80" rows="5" required placeholder="message here">
       </textarea><br/>

                 <br>

                <button class="button" type="submit">
                  Add Post
                </button>

                <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />

          </form>

          <a href="index.php">Home Page</a>

</body>
</html>
