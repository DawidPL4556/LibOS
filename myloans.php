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
	
	$uid = $_SESSION['uUID'];
	
	$selectLoanQuery = $database->query("SELECT * FROM loans WHERE lLoanerUID = $uid");
	
	$myloans = $selectLoanQuery->fetchAll();
	
	$how_many_loans = $selectLoanQuery->rowCount();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Moje Wypożyczenia</title>
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
		
		<center><h1>Moje wypożyczenia</h1></center>
		
		<table align="center" style="border: 2px dashed #292929; text-align: center;">
			<thead style="border: 2px dashed #292929; text-align: center;">
				<tr><th>Tytuł</th><th>Autor</th><th>Data oddania</th></tr>
			</thead>
			<tbody style="border: 2px dashed #292929; text-align: center;">
				<?php
					foreach ($myloans as $loan) 
					{
						$checkQuery = $database->query("SELECT * FROM books WHERE bUID = {$loan['lBookUID']}");
						
						$thisbook = $checkQuery->fetch();
						
						$loantime = new DateTime($loan['lLoanDate']);
						
						$loantime->add(new DateInterval("P{$loan['lLoanDays']}D"));
						
						$dateresult = $loantime->format('Y-m-d');
						
						echo "<tr><td>{$thisbook['bTitle']}</td><td>{$thisbook['bAuthor']}</td><td>$dateresult</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>