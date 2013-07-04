<?php 
// Test for addon for url
if(!isset($url_add)){
	$url_add="";
}
// Default Profile string
$profile_string=
'<li class="dropdown closed"> <a class="dropdown-toggle" data-toggle="dropdown" id="1"><i class="icon-user"></i><b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li> <a href="http://soartex.net/staff/user/sign_in/">Sign In</a> </li>
		<li> <a href="http://soartex.net/staff/user/sign_up/">Register</a> </li>
	</ul>
</li>';

// If the server file exist then we are goign to use perms
if (isset($loggedInUser)) {
	// If the user is logged in then have a new profile dropdown
	if(isUserLoggedIn()) {
		$profile_string=
		'<li class="dropdown closed"> <a class="dropdown-toggle" data-toggle="dropdown" id="1">'.$loggedInUser->displayname.'  <i class="icon-user"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li> <a href="http://soartex.net/staff/user/">Profile</a> </li>
            <li> <a href="http://soartex.net/staff/user/sign_out/">Logout</a> </li>
          </ul>
        </li>';
	}
}
?>

<div class="header"> 
  <!-- Logo --> 
  <img src="<?php echo $url_add;?>assets/img/logo.png" alt="Soartex Fanver Forums"> 
  <!-- Nav Bar -->
  <nav class="navbar navbar-static-top">
    <div class="navbar-inner"> <a class="brand" href="http://soartex.net/"> <img src="<?php echo $url_add;?>assets/img/soar32.png"> Soartex</a> 
      <!--Menu List-->
      <ul class="nav">
        <li> <a href="http://soartex.net/"><i class="icon-home"></i> Home </a> </li>
        <li> <a href="http://soartex.net/community/forum/"><i class="icon-pencil"></i> Forums </a> </li>
        <li> <a href="http://soartex.net/downloads/"><i class="icon-download"></i> Downloads </a> </li>
        <li> <a href="http://customizer.soartex.net/"><i class = "icon-list"></i> Customizer</a> </li>
        <li> <a href="http://files.soartex.net/"><i class="icon-file"></i> File Server </a> </li>
        <!--List for tools/extra stuff-->
        <li class="dropdown closed"> <a class="dropdown-toggle" data-toggle="dropdown" ><i class="icon-wrench"></i> Tools <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li> <a href="http://soartex.net/texture-patcher/"><i class = "icon-cog"></i> Texture-Patcher</a> </li>
            <li> <a href="https://github.com/Soartex-Fanver/"><i class = "icon-globe"></i> Our Github</a> </li>
            <li> <a href="http://files.soartex.net/zip-manager/"><i class = "icon-hdd"></i> Zip Manager</a> </li>
            <li> <a href="http://soartex.net/tools/"><i class = "icon-info-sign"></i> About Our Tools</a> </li>
          </ul>
        </li>
      </ul>
      <!-- User Login -->
      <ul class="nav pull-right">
		<?php echo $profile_string; ?>
      </ul>
    </div>
  </nav>
</div>
<!-- End of Header -->