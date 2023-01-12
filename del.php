<?php 

  
   $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrf"] = $rand;

?>
   <form action="index.php" method="POST" enctype="multipart/form-data">
   <input type ="hidden" name= "id" value = "<?php echo htmlentities($_GET['id']);?>" />
     <input type ="hidden" name= "nocsrf" value = "<?php echo $rand ?>" />
    <input type="submit" name="Are you sure delete" value="delete">

  </form>
