<?php 
$url_add="../"; 
require '../assets/cake/cake.php';
if(!isUserLoggedIn() || !($loggedInUser->checkPermission(array(2,5)))) {
	header("Location: ../");
	die();
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
</head>
<body>
<!--Header-->
<?php $url_add="../"; require '../assets/presets/header.php'; ?>
<!--Main Body/website-->
<div class="container" style="padding-top:30px;">
  <div class="main-content">
    <h1>Soartex Fanver <small>Zip Manager Options</small></h1>
    <hr>
    <ul class="breadcrumb">
      <li><a href="../">Home</a> <span class="divider">/</span></li>
      <li class="active">Options</li>
    </ul>
    <?php
	// Get data
	$string = file_get_contents("./options.json");
	$json = json_decode($string, true);
	// Get the keys/presets
	$preset_array = array_keys($json);
	?>
    <table class='table table-bordered'>
      <colgroup>
      <col span='1' style='width: 40%;'>
      <col span='1' style='width: 60%;'>
      </colgroup>
      <tbody>
        <tr>
          <th> 
          <h3>Preset Profile</h3>
          <hr>
          <form action="assets/UpdateSession.php" method="post">
              <!--Presets--> 
              <span class="help-block">Profile Presets</span>
              <select name="profile">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$profile."</option>";
			  }
			  ?>
              </select>
              </br>
              <button class="btn btn-success" type="submit" name="submitPreset"> Submit Preset </button>
            </form>
          </th>
          <th> 
          <h3>Custom Profile</h3>
          <hr>
          <form action="assets/UpdateSession.php" method="post">
              <!--Github Username--> 
              <span class="help-block">Github Username</span>
              <select name="gitUsername">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$json[$profile]["GithubUsername"]."</option>";
			  }
			  ?>
              </select>
              </br>
              <!--Github Repo--> 
              <span class="help-block">Github Repository</span>
              <select name="gitRepo">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$json[$profile]["GithubRepo"]."</option>";
			  }
			  ?>
              </select>
              </br>
              <!--Repo Branch--> 
              <span class="help-block">Repository Branch</span>
              <select name="gitBranch">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$json[$profile]["RepoBranch"]."</option>";
			  }
			  ?>
              </select>
              </br>
              <!--Github Dir--> 
              <span class="help-block">Github Directory to Mod Folders</span>
              <select name="gitDirectory">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$json[$profile]["GithubDir"]."</option>";
			  }
			  ?>
              </select>
              </br>
              <!--Patcher Config--> 
              <span class="help-block">Patcher Config</span>
              <select name="patcherConfig">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$json[$profile]["PatcherConfig"]."</option>";
			  }
			  ?>
              </select>
              </br>
              <!--Local Dir--> 
              <span class="help-block">Server Location of Mod Directory</span>
              <select name="zipDirectory">
              <?php
			  foreach($preset_array as &$profile) {
                echo "<option>".$json[$profile]["ServerLocation"]."</option>";
			  }
			  ?>
              </select>
              </br>
              <button class="btn btn-success" type="submit" name="submitCustom"> Submit Custom </button>
            </form>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- Footer -->
<?php require 'assets/presets/footer.php'; ?>
</body>
<!-- Javascripts -->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<html>
