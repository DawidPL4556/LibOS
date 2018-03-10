<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Tworzenie konta</title>
	<meta name="description" content="System dla bibliotek LibOS.">
	<meta name="keywords" content="biblioteka, lib, os, libos, LibOS">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="input_style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800&amp;subset=latin-ext" rel="stylesheet">

	<script src="js/hpage.js"></script>
</head>
<body>
	<?php
		session_start();

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
	?>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo" style="float: left;"><a href="index.php"><- Strona główna</a>  </div>
			<div id="Logo" style="float: left; margin-left: 10px;">LibOS</div>
			<div style="clear: both;"></div>
		</div>
		<div id="Clock">12:45:33</div>
		<form action="cuser.php" method="post">
			<input type="text" name="login" placeholder="Nazwa użytkownika">
			<input type="text" name="name" placeholder="Imię">
			<input type="text" name="lastname" placeholder="Nazwisko">
			<input type="text" name="class" placeholder="Klasa">
			<input type="submit" value="Urwórz!">
		</form>
		<?php
			if(isset($_SESSION['e_class']))
			{
				echo '<span style="color: red; font-weight: bold;">'.$_SESSION['e_class'].'</span>';
				unset($_SESSION['e_class']);
			}
		?>
		<a href="resetpass.php"><div class="Button">Reset hasła</div></a>
	</div>
</body>
</html>
