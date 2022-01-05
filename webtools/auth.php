<?php
	if (!isset($_POST['username']) || !isset($_POST['password'])){
		echo "Bad Request.";
		die();
	}

	session_start();

	$ops_file = fopen('ops.json', 'r');
	$ops = json_decode(fread($ops_file, filesize('ops.json')));

	$authorized = false;
	foreach ($ops as $user) {
		if ($user->username == $_POST['username'] && $user->password == $_POST['password']){
			$authorized = true;
		}
	}

	if ($authorized){
		$_SESSION['loggedIn'] = true;
		//echo "Logged In";
		header('Location: tools.php');
		die();
	}
	else{
		$_SESSION['loggedIn'] = false;
		header('Location: login.php');
		die();
	}
?>