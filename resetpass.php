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
    if(isset($_POST['login']))
    {
      $login = $_POST['login'];

			$login = htmlentities($login, ENT_QUOTES, "UTF-8");

			if($login == "")
			{
				$_SESSION['e_class'] = "Dane nie mogą być puste!";
			} else {
				require_once "database.php";

				$checkUserQuery = $database->query("SELECT * FROM users WHERE uUsername = '$login'");

				$user = $checkUserQuery->fetch();

				$howMany = $checkUserQuery->rowCount();

				if($howMany > 0)
				{
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!$!$!$';
					$randstring = '';
					for ($i = 0; $i < 7; $i++)
					{
						$randstring = $randstring.$characters[rand(0, strlen($characters))];
					}

					$password_hash = password_hash($randstring, PASSWORD_DEFAULT);

					$updateQuery = $database->query("UPDATE `users` SET `uPassword` = '$password_hash', `uUserState` = 0 WHERE `users`.`uUID` = {$user['uUID']}");

					header("Location: resetpassres.php?login=".$login."&pass=".$randstring);
				} else {
					$_SESSION['e_class'] = "Taki użytkownik nie istnieje!";
				}
			}
    }
	?>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo" style="float: left;"><a href="index.php"><- Strona główna</a>  </div>
			<div id="Logo" style="float: left; margin-left: 10px;">LibOS</div>
			<div style="clear: both;"></div>
		</div>
		<div id="Clock">12:45:33</div>
		<form method="post">
			<input type="text" name="login" placeholder="Nazwa użytkownika">
			<input type="submit" value="Zmień!">
		</form>
		<?php
			if(isset($_SESSION['e_class']))
			{
				echo '<span style="color: red; font-weight: bold;">'.$_SESSION['e_class'].'</span>';
				unset($_SESSION['e_class']);
			}
		?>
	</div>
</body>
</html>
