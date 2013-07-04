<?php 
session_start();
if(isset($_POST['submitCustom'])){ 
	// Updated session from form
	$_SESSION['gitUsername']=$_POST['gitUsername'];
	$_SESSION['gitRepo']=$_POST['gitRepo'];
	$_SESSION['gitBranch']=$_POST['gitBranch'];		
	$_SESSION['gitDirectory']=$_POST['gitDirectory'];
	$_SESSION['patcherConfig']=$_POST['patcherConfig'];
	$_SESSION['zipDirectory']="../../".$_POST['zipDirectory'];
	//Redirect
    header("Location: ../browse/");
}
else if(isset($_POST['submitPreset'])){
	// Get data
	$string = file_get_contents("../data/options.json");
	$json = json_decode($string, true);
	// Update Session from json
	$_SESSION['gitUsername']=$json[$_POST['profile']]["GithubUsername"];
	$_SESSION['gitRepo']=$json[$_POST['profile']]["GithubRepo"];
	$_SESSION['gitBranch']=$json[$_POST['profile']]["RepoBranch"];		
	$_SESSION['gitDirectory']=$json[$_POST['profile']]["GithubDir"];
	$_SESSION['patcherConfig']=$json[$_POST['profile']]["PatcherConfig"];
	$_SESSION['zipDirectory']="../../".$json[$_POST['profile']]["ServerLocation"];
	//redirect
	header("Location: ../browse/");
}
else{
    header("Location: ./");     
    exit; 
} 
?>