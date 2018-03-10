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
			} else {
				$getBookInfoQuery = $database->query("SELECT * FROM books WHERE `bUID` = $uid");
				$bookInfo = $getBookInfoQuery->fetch();
				
				$deleteBookQuery = $database->query("DELETE FROM `books` WHERE `books`.`bUID` = $uid;");
				
				header("Location: delbookres.php?title={$bookInfo['bTitle']}&author={$bookInfo['bAuthor']}");
			}
		} else {
			$_SESSION['err'] = "Ta książka jest wypożyczona!";
			header("Location: bookslist.php");
		}
	} else {
		header("Location: panel_b.php");
		exit();
	}
?>