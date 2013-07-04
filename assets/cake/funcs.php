<?php
//Destroys a session as part of logout
function destroySession($name)
{
	if(isset($_SESSION[$name]))	{
		$_SESSION[$name] = NULL;
		unset($_SESSION[$name]);
	}
}

//Displays error and success messages
function resultBlock($errors,$successes){
	//Error block
	if(count($errors) > 0)
	{
		echo "<div class='alert alert-error'>
		Error
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<ul>";
		foreach($errors as $error)
		{
			echo "<li>".$error."</li>";
		}
		echo "</ul>";
		echo "</div>";
	}
	//Success block
	if(count($successes) > 0)
	{
		echo "<div class='alert alert-success'>
		Success
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<ul>";
		foreach($successes as $success)
		{
			echo "<li>".$success."</li>";
		}
		echo "</ul>";
		echo "</div>";
	}
}

//Completely sanitizes text
function sanitize($str)
{
	return strtolower(strip_tags(trim(($str))));
}

//Functions that interact mainly with .users table
//------------------------------------------------------------------------------
//Check if a user is logged in
function isUserLoggedIn()
{
	global $loggedInUser,$mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		id,
		password
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		AND 
		password = ? 
		AND
		active = 1
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if($loggedInUser == NULL){
		return false;
	}
	else{
		if ($num_returns > 0){
			return true;
		}
		else{
			destroySession("soartexUser");
			return false;	
		}
	}
}
?>