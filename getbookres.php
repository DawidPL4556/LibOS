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
		exit();
	}
	if($_SESSION['isloged'] == false)
	{
		$_SESSION['indexaction'] = "usernotloged";
		header("Location: login_form.php");
		exit();
	}
	if($_SESSION['uPermission'] == 1)
	{
		header("Location: panel_u.php");
		exit();
	}
	
	if(isset($_GET['login']) == false && isset($_GET['book']) == false)
	{
		header("Location: panel_b.php");
		exit();
	} else {
		$login = $_GET['login'];
		$book = $_GET['book'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Rezultat</title>
	<meta name="description" content="System dla bibliotek LibOS.">
	<meta name="keywords" content="biblioteka, lib, os, libos, LibOS">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="input_style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800&amp;subset=latin-ext" rel="stylesheet">

	<script src="js/hpage.js"></script>
</head>
<body>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo" style="float: left;"><a href="index.php"><- Strona główna</a>  </div>
			<div id="Logo" style="float: left; margin-left: 10px;">LibOS</div>
			<div style="clear: both;"></div>
		</div>
		<div id="Clock">12:45:33</div>
		<span style="text-align: center;">
		<h1>Odpięto książkę!</h1>
		<?php
			echo 'Książka o tytule "'.$book.'" została odpięta od konta użytkownika '.$login." i odzyskała możliwość przypięcia do innego konta.";
		?>
		</span>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>