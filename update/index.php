<?php
//check user login
session_start();
if (!$_SESSION['logged']) {
	header("Location: ../");
	exit ;
}

if(!isset($_GET['fileName'])){
	header("Location: ../browse/"); 
    exit; 
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Zip Manager</title>
<meta charset="UTF-8"/>
<!-- Icons -->
<link rel="shortcut icon" href="../assets/img/favicon.ico" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="../assets/img/apple-icons/apple-touch-icon-114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/img/apple-icons/apple-touch-icon-144.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/img/apple-icons/apple-touch-icon-114.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/img/apple-icons/apple-touch-icon-144.png" />
<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="../assets/css/global.css" />
<!--Javascript-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript">
function toggleDiv(divId) {
	$("#"+divId).toggle();
}
</script>
</head>
<body>
<!--Header-->
<?php $url_add="../"; require '../assets/presets/header.php'; ?>
<!--Main Body/website-->
<div class="container" style="padding-top:30px;">
  <div class="main-content">
    <h1>Soartex Fanver <small>Zip Manager Updating</small></h1>
    <hr>
    <ul class="breadcrumb">
      <li><a href="../">Home</a> <span class="divider">/</span></li>
      <li><a href="../options/">Options</a> <span class="divider">/</span></li>
      <li><a href="../browse/">Browse</a> <span class="divider">/</span></li>
      <li class="active">Update</li>
    </ul>
    <?php 
		//Require helper methods
		require './Helpers.php';
		require './Zip_Archiver.php';
		
		//master try catch
		try{
			//create temp location
			echo "<div class='page-header'><h3>Creating Temp Folder</h3></div>";
			$fileNoExt = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_GET['fileName']);	
			
			$maintempDirectory =$_SESSION['zipDirectory']."temp";
			$tempDirectory = $maintempDirectory."/".$fileNoExt;
			echo("<div class='alert alert-info'>Temp Directory: ".$tempDirectory."</div>");
			
			if (file_exists($tempDirectory)){
				rrmdir($tempDirectory);	
				mkdir($tempDirectory, 0777,TRUE);
				echo '<div class="alert alert-success">Success: Created Directory</div>';
			}else{
				mkdir($tempDirectory, 0777,TRUE);
				echo '<div class="alert alert-success">Success: Created Directory</div>';
			}
	
			//download github files
			echo "<div class='page-header'><h3>Downloading Files From Github</h3></div>";
			$apiUrl='https://api.github.com/repos/' . $_SESSION['gitUsername'] . '/' . $_SESSION['gitRepo'] . '/git/trees/'.$_SESSION['gitBranch'].'?recursive=1';
			echo "<div class='alert alert-info'>Main API Tree: ".$apiUrl."</div>";
			
			//get data
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $apiUrl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			$content = curl_exec($curl);
			curl_close($curl);

			$githubRead = json_decode($content, true);
			
			//if no github data skip everything.
			if($githubRead===null){
				throw new Exception('Unable to get JSON data from github.'); 
			}
			echo '<div class="alert alert-success">Success: Downloaded Content Data From Github </div>';
			// Raw data spoiler
			echo '<a href="javascript:toggleDiv(\'spoiler1\');" class="btn">Toggle Data</a>
    		<div id="spoiler1" class="well" style="display: none">';
			echo print_r($githubRead);
			echo '</div>
			<br>
			<br>';
			
			//if github data is default stop everything
			if($githubRead["message"]!==null){
				throw new Exception('Unable to get CONTENT data from github.'); 
			}
			//seperate all files that have the correct path
			foreach($githubRead["tree"] as &$file) {
				if (strpos($file['path'],$_SESSION['gitDirectory'].$fileNoExt) !== false && $file['type']!="tree") {
					$filesToDownload[]=$file;
				}
				else if(strpos($file['path'],$_SESSION['gitDirectory'].$fileNoExt) !== false && $file['type']==="tree"){
					$pathsToMake[]=$file;
				}
			}
			//if no mod data then don't continue
			if($filesToDownload===null){
				throw new Exception('Could not find MOD data in github data.');
			}
			
			echo '<div class="alert alert-success">Success: Seperated Mod Data from Github Data</div>';
			
			// Spoiler for mod download data
			echo '<a href="javascript:toggleDiv(\'spoiler2\');" class="btn">Toggle Data</a>
    		<div id="spoiler2" class="well" style="display: none">';
			//print files to be downloaded
			foreach($filesToDownload as &$file) {
				echo "</br>";
				print_r($file);
				echo "</br>";
			}
			echo '
			</div>
			<br>
			<br>';
			
			//create folders
			foreach ($pathsToMake as &$path) {
				mkdir($maintempDirectory."/".$path["path"], 0777,TRUE);
			}
	
			//downlaod the files
			$downloadUrl = 'https://raw.github.com/' . $_SESSION['gitUsername'] . '/' . $_SESSION['gitRepo'] . '/' .$_SESSION['gitBranch'] . '/';
			foreach ($filesToDownload as &$file) {
			// Replace all spaces with url %20
			$newDownloadUrl = str_replace(' ','%20',$downloadUrl.$file['path']);
			//download /dir/image.png to /newdir/image2.png
			if (copy($newDownloadUrl, $maintempDirectory.'/'.$file['path']))
				$success[] = "Success: ".$file['path']."<br>";
			else
				$error[] = 'Error: Unable to download- '. $file['path']."<br>";
			}
			
			//if there were files uploaded display them		
			if($success!==null){
				echo '<div class="alert alert-success">Success: Able to Upload Files</div>';
				echo '<a href="javascript:toggleDiv(\'spoiler3\');" class="btn">Toggle Data</a>
    		<div id="spoiler3" class="well" style="display: none">';
              	// Echo successfull uploads
				foreach($success as &$file) {
					echo($file);
				}
				echo '</div><br>';
			}
			//if there was an error display it
			if($error!==null){
				echo '<div class="alert alert-error">Error: Unable to Upload Some Files.</br></br>';
				foreach($error as &$file) {
					echo($file);
				}
				echo "</div>";
			}
	
			//remove old zip and zip new files
			echo "<div class='page-header'><h3>Creating Zip Archives</h3></div>";
	
			$outputFile = $_SESSION['zipDirectory'].$_GET['fileName'];
			echo("<div class='alert alert-info'>Output File: ".$outputFile."<br>");
	
			$outputDir = $_SESSION['zipDirectory'];
			echo("Output Directory: ".$outputDir."<br>");
	
			$zipFolder = $maintempDirectory."/".$fileNoExt."/";
			echo("Ziping the folder: ".$zipFolder."</div>");
	
			if (!file_exists($outputDir)){
				mkdir($outputDir, 0777,TRUE);
				echo '<div class="alert alert-success">Success: Created Directory</div>';
			}
	
			//remove old zip
			if (file_exists($outputFile)) {
				echo '<div class="alert alert-success">Success: Deleted Old Archive</div>';
				unlink($outputFile);
			}
			//Zip the file
			if (Zip_Archiver::Zip($zipFolder, $outputFile)) {
				echo '<div class="alert alert-success">Success: Outputted File</div>';
			}
			else{
				throw new Exception('Unable to outputted file.');
			}
			
			//remove temp files/folder
			rrmdir($maintempDirectory);
			echo '<div class="alert alert-success">Success: Removed Temp Directory</div>';
		}//try catch
		catch(Exception $e){
			//show error
			echo '<div class="alert alert-error">Error: '.$e->getMessage().' Exiting program.</div>';
			//delete temp file
			rrmdir($maintempDirectory);
			echo '<div class="alert alert-success">Success: Removed Temp Directory</div>';
		}
		?>
  </div>
</div>
<!-- Footer -->
<?php require '../assets/presets/footer.php'; ?>
</body>
<html>
