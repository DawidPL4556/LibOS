<?php
	session_start();
	
	if((isset($_POST['login']) == false) || (isset($_POST['haslo']) == false))
	{
		$_SESSION['indexaction'] = "usernotloged";
		header("Location: index.php");
		exit();
	}
	
	$login = $_POST['login'];
	$password = $_POST['haslo'];
	
	$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	$password = htmlentities($password, ENT_QUOTES, "UTF-8");
	
	require_once "database.php";
	
	$loginQuery = $database->prepare('SELECT * FROM users WHERE uUsername = :login');
	$loginQuery->bindValue(':login', $login, PDO::PARAM_STR);
	$loginQuery->execute();
	
	$how_many_users = $loginQuery->rowCount();
	
	if($how_many_users == 1)
	{
		$row = $loginQuery->fetch();
		
		if(password_verify($password, $row['uPassword']))
		{
			$_SESSION['uUID'] = $row['uUID'];
			$_SESSION['uUsername'] = $row['uUsername'];
			$_SESSION['uName'] = $row['uName'];
			$_SESSION['uLastName'] = $row['uLastName'];
			$_SESSION['uClass'] = $row['uClass'];
			$_SESSION['uE-MAIL'] = $row['uE-MAIL'];
			$_SESSION['uPermission'] = $row['uPermission'];
			$_SESSION['uUserState'] = $row['uUserState'];
			$_SESSION['isloged'] = true;
			
			if($row['uUserState'] == 0)
			{
				header("Location: cpassstate.php");
				exit();
			}
			if($_SESSION['uPermission'] == 1)
			{
				header("Location: panel_u.php");
			}
			if($_SESSION['uPermission'] == 2)
			{
				header("Location: panel_b.php");
			}
			if($_SESSION['uPermission'] == 3)
			{
				header("Location: panel_a.php");
			}
			$result->close();
		} else {
			$_SESSION['indexaction'] = "wpass";
			header("Location: login_form.php");
		}
	} else {
		$_SESSION['indexaction'] = "wpass";
		header("Location: login_form.php");
	}
	
?>