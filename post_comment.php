<?php 
	require "database.php";
	$author = sanitize_input($_POST['author']);
	$text = sanitize_input($_POST['text']);
	addComment(sanitize_input(intval($_POST['id'])),$author,$text);
 	 header("Location: post.php?id=".intval($_POST['id']));
 	 die();
	?>

	