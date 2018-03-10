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
	
	if(isset($_POST['bookuid']))
	{
		$name =  $_POST['login'];
		$bookuid =  $_POST['bookuid'];
		$days =  $_POST['hmanydays'];
		
		require_once "database.php";
		
		$userCheckQuery = $database->query("SELECT * FROM `users` WHERE `uUsername` = '$name'");
		$hMany = $userCheckQuery->rowCount();
		
		$user = $userCheckQuery->fetch();
		
		if($hMany > 0)
		{
			$bookCheckQuery = $database->query("SELECT * FROM `books` WHERE `bUName` = '$bookuid'");
			$hMany = $bookCheckQuery->rowCount();
			
			$book = $bookCheckQuery->fetch();
			
			if($hMany > 0)
			{
				$loanCheckQuery = $database->query("SELECT * FROM `loans` WHERE `lBookUID` = '{$book['bUID']}'");
				$hMany = $loanCheckQuery->rowCount();
				
				if(!$hMany > 0)
				{
					$daysInt = intval($days);
					if($daysInt <= 0)
					{
						$_SESSION['err'] = "Minimalna ilość dni to 1!";
					} else {
						$insertQuery = $database->query("INSERT INTO loans VALUES (NULL, '{$user['uUID']}', '{$book['bUID']}', NOW(), '$daysInt')");
						header("Location: panel_b.php");
					}
				} else {
					$_SESSION['err'] = "Ta książka jest już wypożyczona!";
				}
			} else {
				$_SESSION['err'] = "Taka książka nie istnieje!";
			}
		} else {
			$_SESSION['err'] = "Taki użytkownik nie istnieje!";
		}
	} else {
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Wypożyczanie Książki</title>
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
		<form method="post">
			<input type="text" name="login" placeholder="Nazwa użytkownika">
			<input type="text" name="bookuid" placeholder="UID Książki">
			<input type="number" name="hmanydays" placeholder="Na ile dni?">
			<input type="submit" value="Urwórz!">
		</form>
		<?php
			if(isset($_SESSION['err']))
			{
				echo $_SESSION['err'];
				unset($_SESSION['err']);
			}
		?>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>