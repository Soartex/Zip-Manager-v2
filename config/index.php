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
	<h3>This is not done yet, it is a wip</h3>
  </div>
</div>
<!-- Footer -->
<?php require '../assets/presets/footer.php'; ?>
</body>
<html>
