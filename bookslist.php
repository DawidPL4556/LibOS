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
	
	if(isset($_POST['title']))
	{
		$title = $_POST['title'];
		$selectBookQuery = $database->query("SELECT * FROM `books` WHERE `bTitle` LIKE '$title'");
		unset($_POST['title']);
	} else {
		$selectBookQuery = $database->query("SELECT * FROM books");
	}
	
	$books = $selectBookQuery->fetchAll();
	
	$selectLoanQuery = $database->query("SELECT * FROM loans");
	
	$how_many_loans = $selectLoanQuery->rowCount();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Lista Książek</title>
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
		
		<center>
		<form method="post">
			<input type="text" name="title" placeholder="Tytuł">
			<input type="submit" value="Szukaj!">
		</form>
		<?php
			if(isset($_SESSION['err']))
			{
				echo '<span style="color:red;">'.$_SESSION['err'].'</span><br><br>';
				unset($_SESSION['err']);
			}
		?>
		</center>
		
		<table align="center" style="border: 2px dashed #292929; text-align: center;">
			<thead style="border: 2px dashed #292929; text-align: center;">
				<tr><th colspan="2">Łącznie książek: <?= $selectBookQuery->rowCount() ?></th></tr>
				<tr><th colspan="2">Łącznie wyporzyczonych książek: <?= $selectLoanQuery->rowCount() ?></th></tr>
				<tr><th>Tytuł</th><th>Autor</th><th>Stan</th></tr>
			</thead>
			<tbody style="border: 2px dashed #292929; text-align: center;">
				<?php
					foreach ($books as $book) 
					{
						$checkQuery = $database->query("SELECT * FROM loans WHERE lBookUID = {$book['bUID']}");
		
						$how_many = $checkQuery->rowCount();
						
						if($how_many > 0)
						{
							$state = '<span style="color: red;">Wypożyczona</span>';
						} else {
							$state = '<span style="color: green;">Dostępna</span>';
						}
						
						echo "<tr><td>{$book['bTitle']}</td><td>{$book['bAuthor']}</td><td>$state</td></tr>";
						
						if($_SESSION['uPermission'] == 1)
						{
							
						} else {
							echo '<tr><td colspan="3"><a href="delbook.php?uid='.$book['bUID'].'">Usuń</a> | <a href="editbook.php?uid='.$book['bUID'].'">Edytuj</a></td></tr>';
						}
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>