<?php
	session_start();
		
	if(isset($_SESSION['isloged']))
	{
		if($_SESSION['isloged'] == true)
		{
			header("Location: panel_u.php");
			exit();
		}
	}
	
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		
		if($id == 1)
		{
			$message = "Aby się zarejestrować spytaj bibliotekarza o utworzenie konta.";
		} else if($id == 2)
		{
			$message = "Aby zresetować hasło spytaj bibliotekarza o reset hasła.";
		} else {
			header("Location: index.php");
			exit();
		}
	} else {
		header("Location: index.php");
		exit();
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Informacja</title>
	<meta name="description" content="System dla bibliotek LibOS.">
	<meta name="keywords" content="biblioteka, lib, os, libos, LibOS">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800&amp;subset=latin-ext" rel="stylesheet">
	
	

	<script src="js/hpage.js"></script>
</head>
<body>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo" style="float: left;"><a href="index.php"><- Strona główna</a>  </div>
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>
		<center>
			<div style="width: 350px; font-weight: bold; border: 2px dashed #292929; border-radius: 3px;">
				<?php
					echo $message;
				?>
			</div>
		</center>
		
	</div>
</body>
</html>