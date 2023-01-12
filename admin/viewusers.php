<!DOCTYPE html>
<?php
    require "session_auth.php";
    $nocsrftoken = $_SESSION["nocsrftoken"];
    $rand = bin2hex(openssl_random_pseudo_bytes(16));

    $mysqli = new mysqli('localhost','team5','team5','secad_team5');
    if($mysqli->connect_error){
      printf("database connection failed: %s\n",
      $mysqli->connect_error);
      exit();
    }
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>View Users-Admin</title>
</head>
<body>
  <h2> Welcome <?php echo htmlentities($_SESSION["username"]); ?> </h2>
<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa");
?>
    <table id="users" style="width:40%" align:"center">
      <tr><th>Current Users</th></tr>
        <?php
          $_SESSION["nocsrftoken"] = $rand;
          global $mysqli;
          $prepared_sql = "SELECT username, active FROM users;";
          if(!$stmt = $mysqli->prepare($prepared_sql)){
             echo "Prepared Statement Error";
          }
          if(!$stmt->execute()){
            echo "Execute stmt error";
          }
          $username=NULL;
          $active=NULL;
          if(!$stmt->bind_result($username,$active)) echo "Binding Failed";
          while($stmt->fetch()){
            if($active == 1){
              $flag = 0;
        ?>
              <tr><td><?php echo htmlentities($username) ?></td>
                  <td><form action="active.php" method="POST" class="active">
                      <button class="button" type="submit">Deactivate</button>
                      <input type="hidden" name="username" value="<?php echo $username; ?>" />
                      <input type="hidden" name="actvalue" value="<?php echo $flag; ?>" />
                      <input type="hidden" name="nocrsftoken" value="<?php echo $rand; ?>" />
                    </form>
                  </td>
                </tr>
        <?php
            }else{
              $flag = 1;
        ?>
              <tr><td><?php echo htmlentities($username) ?></td>
                  <td><form action="active.php" method="POST" class="active">
                      <button class="button" type="submit">Activate</button>
                      <input type="hidden" name="username" value="<?php echo $username; ?>" />
                      <input type="hidden" name="actvalue" value="<?php echo $flag; ?>" />
                      <input type="hidden" name="nocrsftoken" value="<?php echo $rand; ?>" />
                    </form>
                  </td>
              </tr>
        <?php     
            }
          }
        ?>
    </table>
    <a href="index.php">Home</a>
    <a href="logout.php">logout</a>
</body>
</html>