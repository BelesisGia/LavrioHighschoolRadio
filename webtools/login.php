<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

	<meta charset="utf-8">
	<link rel="icon" type="image/x-icon" href="favicon.ico">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

	<style type="text/css">
		label{
			font-size: 20px;
		}
	</style>
	<script type="text/javascript">
		window.onbeforeunload = function(event){
			xmlHttp = new XMLHttpRequest();
			xmlHttp.open("GET","./logout.php",true);
			xmlHttp.send();
		};
	</script>
</head>
<body>
	<div class="container" style="padding: 0 20em; position: absolute; left: 50%; top: 30%; transform: translate(-50%,-50%);">
		<h4 class="center" style="margin-bottom: 4em;">Lavrio Highschool Radio Tools</h4>
		<form action="./auth.php" method="post" autocomplete="off">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username">
			<div style="margin: 2em;"></div>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password">
			<div class="center" style="margin-top: 2em;">
				<button class="btn">Login</button>
			</div>
		</form>

		<?php 
			session_start();
			if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false){
		?>
		<h6 style="color: red;">Wrong Username or Password!</h6>
		<?php } ?>
	</div>
</body>
</html>