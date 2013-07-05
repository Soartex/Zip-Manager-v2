<?php
//start the session
session_start();
//file path
$outputFile = $_SESSION['zipDirectory'].$_GET['fileName'];
//remove old zip/file
if (file_exists($outputFile)) {
	if(is_dir($outputFile)){
		rrmdir($outputFile);
	}
	else{
		unlink($outputFile);
	}
}
// Redirect back
header("Location: ./");
die();

//remove recusivly everything in a directory
function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as &$object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir")
					rrmdir($dir . "/" . $object);
				else
					unlink($dir . "/" . $object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}
?>