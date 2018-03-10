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

  $selectMessageQuery = $database->query("SELECT * FROM messages WHERE `mSendTo` = {$_SESSION['uUID']}");

	$messages = $selectMessageQuery->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Lista Wiadomości</title>
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
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>

		<table align="center" style="border: 2px dashed #292929; text-align: center;">
			<thead style="border: 2px dashed #292929; text-align: center;">
				<tr><th colspan="2">Łącznie wiadomośći: <?= $selectMessageQuery->rowCount() ?></th></tr>
				<tr><th>Wysyłający</th><th>Tytuł</th><th>Data Wysłania</th></tr>
			</thead>
			<tbody style="border: 2px dashed #292929; text-align: center;">
				<?php
					foreach ($messages as $message)
					{
						$checkQuery = $database->query("SELECT * FROM messages WHERE mUID = {$message['mUID']} AND mRead = 0");

						$how_many = $checkQuery->rowCount();

						$senderQuery = $database->query("SELECT * FROM users WHERE uUID = {$message['mSender']}");

						$sender = $senderQuery->fetch();

						if($how_many > 0)
						{
							echo "<tr><td>{$sender['uName']} {$sender['uLastName']}</td><td><span style=\"cursor: pointer;\"><b><a href=\"messages_show.php?uid={$message['mUID']}\">{$message['mTitle']}</a></b></span></td><td>{$message['mSendDate']}</td></tr>";
						} else {
							echo "<tr><td>{$sender['uName']} {$sender['uLastName']}</td><td><span style=\"cursor: pointer;\"><a href=\"messages_show.php?uid={$message['mUID']}\">{$message['mTitle']}</a></span></td><td>{$message['mSendDate']}</td></tr>";
						}
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>
