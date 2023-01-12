<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  session_start();
  session_destroy();
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login page-Admin</title>
  <link rel="stylesheet" href="adminform.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="wrapper">
      <div class="title">Admin Login </div>
        <div class="time">
          <?php
            echo "Current time: " . date("Y-m-d h:i:sa")
          ?>
        </div>
          <form action="index.php" method="POST" class="form login">
            <div class="field">   
              <input type="text" class="text_field" name="username" required
              pattern="[A-Za-z]{3,20}"
              title="Please enter a valid username" 
              placeholder="Your username"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> 
              <br>
            </div>
            <div class="field">
              <input type="password" class="text_field" name="password" required
              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
              placeholder="Your password"
              title="Password needs at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"/>
              <br>
            </div>
            <div class="field">
              <input type="submit" value="Login">
            </div>
          </form>
        </div>
  </body>
</html>

