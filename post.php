<?php 
	require "database.php";
	renderPost(intval($_GET['id']));
	
	?>
      <form method="POST" action="post_comment.php"> 
        Author: <input type="text" name="author" / ><br/>
        Text: <textarea name="text" cols="80" rows="5">
        </textarea><br/>
        <input type="hidden" name="id" value="<?php echo htmlentities($_GET['id']); ?>" />
        <input type="submit" name="submit" / >
      </form> 
	<?php renderAllComments(intval($_GET['id'])); ?>
	<a href="index.php">home</a>
<a href="logout.php">logout</a>