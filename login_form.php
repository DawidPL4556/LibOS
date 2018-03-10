<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS</title>
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
		<form action="login.php" method="post">
			<input type="text" name="login" placeholder="Nazwa użytkownika">
			<input type="password" name="haslo" placeholder="Hasło">
			<input type="submit" value="Zaloguj!">
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
			if(isset($_SESSION['indexaction'])) 
			{
				$message = "";
				if($_SESSION['indexaction'] == "sessionerr")
				{
					$message = "Sesja wygasła! Proszę się ponownie zalogować.";
				}
				if($_SESSION['indexaction'] == "usernotloged")
				{
					$message = "Nie jesteś zalogowany! Proszę się zalogować aby uzyskać dostęp do systemu.";
				}
				if($_SESSION['indexaction'] == "wpass")
				{
					$message = "Błędny login lub hasło!";
				}
				unset($_SESSION['indexaction']);
				echo '<span style="margin: 20px; font-weight: bold; color: red;">'.$message.'</span>';
			}
			?>
		</form>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>