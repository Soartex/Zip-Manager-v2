<?php 
$url_add="../"; 
require '../assets/cake/cake.php';
if(!isUserLoggedIn() || !($loggedInUser->checkPermission(array(2,5)))) {
	header("Location: ../");
	die();
}
if(!isset($_GET['fileName'])){
	header("Location: ../browse/"); 
    exit; 
}

// If config form is posted
if(!empty($_POST)){
	$errors = array();
	$successes = array();
	// If create a new zip
		if(preg_match('/"/', $_POST['modVersion'])===0 && preg_match('/"/', $_POST['mcVersion'])===0){
			// Read in json file
			// Patcher config
			$string = file_get_contents("../".$_SESSION['patcherConfig']);
			$patcher_json = json_decode($string, true);
			// Add spaces and remove ending, find the mod in the json
			$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_POST['fileName']);
			$filename = str_replace('_', ' ', $filename);
			// Change config
			$patcher_json["mods"][$filename]["version"] = $_POST['modVersion'];
			$patcher_json["mods"][$filename]["mcversion"] = $_POST['mcVersion'];
			//sort
			ksort($patcher_json["mods"]);
			//output file
			$fp = fopen("../".$_SESSION['patcherConfig'], 'w');
			fwrite($fp, json_encode($patcher_json, JSON_PRETTY_PRINT));
			fclose($fp);
			//redirect
			header("Location: ../browse/"); 
   			exit;
		}
		else{
			$errors[] = "Data can not contain quotes!";
		}
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
      <li class="active">Config</li>
    </ul>
    <?php 
	// Errors/success
	echo resultBlock($errors,$successes);
	// Read in json file
	// Patcher config
	$string = file_get_contents("../".$_SESSION['patcherConfig']);
	$patcher_json = json_decode($string, true);
	// Add spaces and remove ending, find the mod in the json
	$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_GET['fileName']);
	$filename = str_replace('_', ' ', $filename);
	?>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    	<h3>Edit your config for: <?php echo $filename; ?></h3>
        <span class="help-block">Mod version</span>
        <input class="span4" type="text" value="<?php echo $patcher_json["mods"][$filename]["version"]; ?>" name="modVersion">
        <span class="help-block">Minecraft Version</span>
        <input class="span4" type="text" value="<?php echo $patcher_json["mods"][$filename]["mcversion"]; ?>" name="mcVersion">
        <input type="hidden" name="fileName" value="<?php echo $_GET['fileName'] ?>">
        <br>
        <button class="btn btn-success" type="submit" name="submit">Submit</button>
	</form>
  </div>
</div>
<!-- Footer -->
<?php require '../assets/presets/footer.php'; ?>
</body>
<html>
