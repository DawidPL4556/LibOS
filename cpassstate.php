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
	if($_SESSION['uUserState'] != 0)
	{
		header("Location: panel_u.php");
		exit();
	}
	if(isset($_POST['pass1']))
	{
		if($_POST['pass1'] == $_POST['pass2'])
		{
			require_once "database.php";
			
			$uid = $_SESSION['uUID'];
			
			$pass_hash = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
			
			$updateQuery = $database->prepare("UPDATE `users` SET `uPassword` = '$pass_hash', `uUserState` = '1' WHERE `users`.`uUID` = :uid");
			$updateQuery->bindValue(':uid', $uid, PDO::PARAM_STR);
			$updateQuery->execute();
			
			session_unset();
			
			header("Location: login_form.php");
		} else {
			$_SESSION['e_pass'] = "Hasła nie są identyczne!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Zmiana Hasła</title>
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
			<div id="Logo" style="float: left; margin-left: 10px;">LibOS</div>
			<div style="clear: both;"></div>
		</div>
		<div id="Clock">12:45:33</div>
		<span style="text-align: center;">
		<h1>Zmień hasło!</h1>
		Twoje hasło jest tymczasowe i właśnie wygasło więc musisz je zmienić.
		</span>
		<form method="post">
			<input type="password" name="pass1" placeholder="Hasło">
			<input type="password" name="pass2" placeholder="Powtórz hasło">
			<input type="submit" value="Zmień hasło!">
		</form>
		<?php
			if(isset($_SESSION['e_pass']))
			{
				echo '<span style="text-align: center;">'.$_SESSION['e_pass']."</span>";
				unset($_SESSION['e_pass']);
			}
		?>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>