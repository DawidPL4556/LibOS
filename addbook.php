<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Dodawanie Książki</title>
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
		if(isset($_POST['title']))
		{
			$title = $_POST['title'];
			$author = $_POST['author'];
			$year = $_POST['year'];
			$bookuid = $_POST['bookuid'];
			
			$title = htmlentities($title, ENT_QUOTES, "UTF-8");
			$author = htmlentities($author, ENT_QUOTES, "UTF-8");
			$year = htmlentities($year, ENT_QUOTES, "UTF-8");
			$bookuid = htmlentities($bookuid, ENT_QUOTES, "UTF-8");
			
			if(($title != "") && ($author != "") && ($year != "") && ($bookuid != ""))
			{
				$year_int = intval($year);
				
				if((strlen($year) == 4) && ($year == $year_int))
				{
					$this_year = date("Y");
					
					if($year_int <= $this_year)
					{
						require_once "database.php";
						
						$insertQuery = $database->query("INSERT INTO books VALUES (NULL, '$title', '$author', $year_int, '$bookuid')");
						
						header("Location: addbookres.php?title=".$title."&author=".$author."&buid=".$bookuid);
					} else {
						$_SESSION['e_class'] = "Rok nie moży być większy niż obecny!";
					}
				} else {
					$_SESSION['e_class'] = "Rok jest błędny!";
				}
			} else {
				$_SESSION['e_class'] = "Dane nie mogą być puste!";
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
			<input type="text" name="title" placeholder="Tytuł">
			<input type="text" name="author" placeholder="Autor">
			<input type="number" name="year" placeholder="Rok Wydania">
			<input type="text" name="bookuid" placeholder="UID Książki">
			<input type="submit" value="Dodaj!">
		</form>
		<?php 
			if(isset($_SESSION['e_class']))
			{
				echo '<span style="color: red; font-weight: bold;">'.$_SESSION['e_class'].'</span>';
				unset($_SESSION['e_class']);
			}
		?>
		<div id="Footer">&copy; Dawid Bartniczak - Wszelkie prawa zastrzeżone!</div>
	</div>
</body>
</html>