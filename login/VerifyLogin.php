<?php
	// If loging in
	if (isset($_POST['submit'])) {
		//if pass and username match start the session
		if ($_POST['username'] == 'admin' && $_POST['password'] == 'superuser') {
			session_start();
			$_SESSION['logged'] = TRUE;
			$_SESSION['username'] = $_POST['username'];
			// Redirect to the home pages
			header("Location: ../options");
			exit ;
		} else {
			header("Location: ./");
			exit ;
		}
	}
	else {
		header("Location: ../");
		exit ;
	}
?>