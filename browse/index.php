<?php 
$url_add="../"; 
require '../assets/cake/cake.php';
if(!isUserLoggedIn() || !($loggedInUser->checkPermission(array(2,5)))) {
	header("Location: ../");
	die();
}
?>
<!DOCTYPE html>
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
</head>
<body>
<!--Header-->
<?php $url_add="../"; require '../assets/presets/header.php'; ?>
<!--Main Body/website-->
<div class="container" style="padding-top:30px;">
  <div class="main-content">
    <h1>Soartex Fanver <small>Zip Manager</small></h1>
    <hr>
    <ul class="breadcrumb">
      <li><a href="../">Home</a> <span class="divider">/</span></li>
      <li><a href="../options/">Options</a> <span class="divider">/</span></li>
      <li class="active">Browse</li>
    </ul>
    <!--Session Info-->
    <div class="alert alert-info"> <strong>Current Zip Manager Options</strong>
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      <br>
      <?php
		echo "[Github Username]: ".$_SESSION['gitUsername']."<br>";
		echo "[Github Repo]: ".$_SESSION['gitRepo']."<br>";
		echo "[Github Branch]: ".$_SESSION['gitBranch']."<br>";		
		echo "[Github Directory]: ".$_SESSION['gitDirectory']."<br>";
		echo "[Patcher Config]: ".$_SESSION['patcherConfig']."<br>";
		echo "[Local Zip Directory]: ".$_SESSION['zipDirectory']."<br>";
		?>
    </div>
    <!--Master Mod Table-->
    <table class="table table-hover table-bordered">
      <thead>
        <tr>
          <th>File Name</th>
          <th>Date Modified</th>
          <th>Mod Version</th>
          <th>MC Version</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <?php
		//patcher config
		// Get data
		$string = file_get_contents("../".$_SESSION['patcherConfig']);
		$patcher_json = json_decode($string, true);
		//file names data
		$filesData = array();
		if ($dir_list = opendir($_SESSION['zipDirectory'])){
			while(($filename = readdir($dir_list)) !== false){
				//add file name
				if (substr($filename, 0, 1) !== '.'){
					$filesData[]=$filename;
				}
			}
		}	
		//sort the names
		sort($filesData);
		//display in the table
		foreach($filesData as &$temp) {
			echo "<tr>";
			echo "<td>".$temp."</td>";
			echo "<td>".date("m-d-Y H:i:s", filemtime($_SESSION['zipDirectory'].$temp))."</td>";
			// Add spaces and remove ending, find the mod in the json
			$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $temp);
			$filename = str_replace('_', ' ', $filename);
			echo "<td>".$patcher_json["mods"][$filename]["version"]."</td>";
			echo "<td>".$patcher_json["mods"][$filename]["mcversion"]."</td>";
			echo '<td>
				<div class="btn-group" style="width:100%;">
					<a class="btn btn-mini btn-success" href="../update/?fileName='.$temp.'">Update Zip</a>
					<button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href=""><i class="icon-wrench"></i> Update Config</a></li>
						<li><a href="'.$_SESSION['zipDirectory'].$temp.'"><i class="icon-download-alt"></i> Download Zip</a></li>
						<li><a onclick="deleteClicked('.$temp.')" href="#"><i class="icon-trash"></i> Delete Zip</a></li>
					</ul>
				</div>
			</td>';
			echo "</tr>";
		}// End of foreach
		/*
		<td>
		<div class="btn-group"> 
		<a class="btn btn-mini btn-success" href=<?php echo "UpdateZip.php?fileName=".$temp; ?>>Update Zip</a> 
		<a class="btn btn-mini btn-danger" onclick="deleteClicked('<?php echo $temp?>')" href="#"><i class="icon-trash icon-white"></i> Delete</a> 
		<a class="btn btn-mini" href="<?php echo $_SESSION['zipDirectory'].$temp; ?>"><?php echo $temp; ?></a> 
		</div>
		</td>*/
		?>
        </tbody>
      
    </table>
    <!--Form for adding a new zip-->
    <form action="assets/AddFile.php" method="post">
      <div class="form-horizontal">
        <input type="text" name="newzip" placeholder="Filename.zip">
        <button class="btn btn-success" type="submit" name="submit">Add Zip File</button>
      </div>
    </form>
  </div>
</div>
<!-- Footer -->
<?php require '../assets/presets/footer.php'; ?>
</body>
<!-- Javascripts -->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript" src="../assets/js/bootbox.min.js"></script>
<script>
		//function for delete popup
		function deleteClicked(arg0) {
			bootbox.confirm("Do you want to delete this: <b>/"+arg0+"</b>", function(result) {
				if(result === true){
					//redirect to worker
					window.location = "assets/DeleteFile.php?fileName="+arg0;
				}				
			}); 
		}
    </script>
</html>