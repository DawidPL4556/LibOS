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
	if(isset($_GET['uid']))
	{
		require_once "database.php";

		$uid = $_GET['uid'];

		$uid = intval($_GET['uid']);

		$checkLoanQuery = $database->query("SELECT * FROM loans WHERE `lBookUID` = $uid");
		$howMany = $checkLoanQuery->rowCount();

		if($howMany == 0)
		{
			$checkBookQuery = $database->query("SELECT * FROM books WHERE `bUID` = $uid");
			$howMany = $checkBookQuery->rowCount();

			if($howMany == 0)
			{
				$_SESSION['err'] = "Ta książka nie istnieje!";
				header("Location: bookslist.php");
        exit();
			} else {
				$bookData = $checkBookQuery->fetch();

				if(isset($_POST['title']))
				{
					if($_POST['title'] == "" || $_POST['author'] == "" || $_POST['bookuid'] == "")
					{
						$_SESSION['err'] = "Dane nie mogą być puste!";
						header("Location: bookslist.php");
		        exit();
					} else {
						$title = $_POST['title'];
						$author = $_POST['author'];
						$bookuid = $_POST['bookuid'];

						$updateQuery = $database->query("UPDATE `books` SET `bTitle` = '$title', `bAuthor` = '$author', `bUName` = '$bookuid' WHERE `books`.`bUID` = $uid");

						header("Location: bookslist.php");
					}
				}
			}
		} else {
			$_SESSION['err'] = "Ta książka jest wypożyczona!";
			header("Location: bookslist.php");
      exit();
		}
	} else {
		header("Location: panel_b.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Edytowanie Książki</title>
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
			<input type="text" name="title" placeholder="Tytuł" value="<?php echo $bookData['bTitle'] ?>">
			<input type="text" name="author" placeholder="Autor" value="<?php echo $bookData['bAuthor'] ?>">
			<input type="text" name="bookuid" placeholder="UID Książki" value="<?php echo $bookData['bUName'] ?>">
			<input type="submit" value="Edytuj!">
		</form>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>
