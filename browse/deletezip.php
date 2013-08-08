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
		// Remove file
		unlink($outputFile);
		// Read in json file
		$string = file_get_contents("../".$_SESSION['patcherConfig']);
		$patcher_json = json_decode($string, true);
		// Add spaces and remove ending, find the mod in the json
		$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_GET['fileName']);
		$filename = str_replace('_', ' ', $filename);
		// Remove from .json
		unset($patcher_json["mods"][$filename]);
		//output file
		$fp = fopen("../".$_SESSION['patcherConfig'], 'w');
		fwrite($fp, json_encode($patcher_json, JSON_PRETTY_PRINT));
		fclose($fp);
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