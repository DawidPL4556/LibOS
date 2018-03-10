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
		
		if($_SESSION['uUserState'] == 0)
		{
			header("Location: cpassstate.php");
			exit();
		}
		if(isset($_SESSION['isloged']) == false)
		{
			$_SESSION['indexaction'] = "sessionerr";
			header("Location: login_form.php");
		}
		if($_SESSION['isloged'] == false)
		{
			$_SESSION['indexaction'] = "usernotloged";
			header("Location: login_form.php");
		}
		if($_SESSION['uPermission'] == 2)
		{
			header("Location: panel_b.php");
		}
		if($_SESSION['uPermission'] == 3)
		{
			header("Location: panel_a.php");
		}
	?>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>
		<a href="myloans.php"><div class="Button">Moje wypożyczenia</div></a>
		<a href="bookslist.php"><div class="Button">Lista książek</div></a>
		<a href="bookdemage.php"><div class="Button">Zgłoś zniszczenie</div></a>
		<a href="rbook.php"><div class="Button">Zarezerwój książkę</div></a>
		<a href="messages.php"><div class="Button">Wiadomości</div></a>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>