<?php
    $mysqli = new mysqli('localhost','team5','team5','secad_team5');
    if($mysqli->connect_errno){
         printf("Database connection failed: %s\n", $mysqli->connect_error);
         exit();
    }

    function activation($username, $active){
    	global $mysqli;
    	$prepared_sql = "UPDATE users SET active=? WHERE username = ?";
	    echo "DEBUG>prepared_sql= $prepared_sql\n";

        if(!$stmt = $mysqli ->prepare($prepared_sql)) return FALSE;
        $stmt->bind_param("ss",$active,$username);
        if(!$stmt->execute()) return FALSE;
        return TRUE;
    }

?>