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
      exit();
		}
		if($_SESSION['isloged'] == false)
		{
			$_SESSION['indexaction'] = "usernotloged";
			header("Location: login_form.php");
      exit();
		}

    require_once "database.php";

    $messagesQuery = $database->query("SELECT * FROM messages WHERE `mSendTo` = {$_SESSION['uUID']} AND `mRead` = 0");
    $howMany = $messagesQuery->rowCount();
	?>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>
		<a href="messages_get.php"><div class="Button">Skrzynka odbiorcza(<?php echo $howMany; ?>)</div></a>
		<a href="messages_send.php"><div class="Button">Wysłane</div></a>
		<a href="messages_write.php"><div class="Button">Napisz wiadomość</div></a>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>
