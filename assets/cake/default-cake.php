<?php 
// Test for addon for url
if(!isset($url_add)){
	$url_add="";
}

//Functions
require_once($url_add."assets/cake/funcs.php");
require_once($url_add."assets/cake/class.user.php");

// Database Information
$db_host = ""; //Host address (most likely localhost)
$db_name = ""; //Name of Database
$db_user = ""; //Name of database user
$db_pass = ""; //Password for database user
$db_table_prefix = "uc_";

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli, $loggedInUser;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

// Start the session
session_start();

// If user us logged in then log him/her in
// loggedInUser can be used globally if constructed
if(isset($_SESSION["soartexUser"]) && is_object($_SESSION["soartexUser"])){
	$loggedInUser = $_SESSION["soartexUser"];
}
// If user has a cookie then use that
else if (isset($_COOKIE["soartexUser"])){
	$loggedInUser = unserialize($_COOKIE['soartexUser']);
}
?>