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
		$buid = $_POST['bookuid'];
		
		$buid = htmlentities($buid, ENT_QUOTES, "UTF-8");
		
		if($buid != "")
		{
			require_once "database.php";
			
			$checkBook = $database->query("SELECT * FROM books WHERE `bUName` = '$buid'");
			$howMany = $checkBook->rowCount();
			
			$book = $checkBook->fetch();
			
			if($howMany > 0)
			{
				$checkLoan = $database->query("SELECT * FROM loans WHERE `lBookUID` = '{$book['bUID']}'");
				$howMany = $checkLoan->rowCount();
				
				$loan = $checkLoan->fetch();
				
				if($howMany > 0)
				{
					$selectLoan = $database->query("SELECT * FROM users WHERE `uUID` = {$loan['lLoanerUID']}");
					
					$howMany = $selectLoan->rowCount();
					
					$user = $selectLoan->fetch();
					
					if($howMany > 0)
					{
						$deleteLoan = $database->query("DELETE FROM `loans` WHERE `loans`.`lBookUID` = '{$book['bUID']}'");
						
						header('Location: getbookres.php?login='.$user['uUsername'].'&book='.$book['bTitle']);
					} else {
						$_SESSION['err'] = "Nie można ukończyć tej akcji!";
					}
					
					
				} else {
					$_SESSION['err'] = "Ta książka nie jest wypożyczona!";
				}
			} else {
				$_SESSION['err'] = "Taka książka nie istnieje!";
			}
		} else {
			$_SESSION['err'] = "UID nie może być puste!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Odbieranie Książki</title>
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
			<input type="text" name="bookuid" placeholder="UID Książki">
			<input type="submit" value="Odbierz!">
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