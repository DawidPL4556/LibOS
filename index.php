<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS</title>
	<meta name="description" content="System dla bibliotek LibOS.">
	<meta name="keywords" content="biblioteka, lib, os, libos, LibOS">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800&amp;subset=latin-ext" rel="stylesheet">

	<script src="js/hpage.js"></script>
</head>
<body>
	<?php
		session_start();
		if(isset($_SESSION['isloged']))
		{
			if($_SESSION['isloged'] == true)
			{
				header("Location: panel_u.php");
				exit();
			}
		}
	?>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>
		<a href="login_form.php"><div class="Button">Zaloguj</div></a>
		<a href="info.php?id=1"><div class="Button">Zarejestruj</div></a>
		<a href="info.php?id=2"><div class="Button">Zresetuj hasło</div></a>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>
