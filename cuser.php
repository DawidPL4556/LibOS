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
	
	if(isset($_POST['class']) == false)
	{
		header("Location: panel_u.php");
		exit();
	} else {
		$login = $_POST['login'];
		$name = $_POST['name'];
		$lname = $_POST['lastname'];
		$class = $_POST['class'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$name = htmlentities($name, ENT_QUOTES, "UTF-8");
		$lname = htmlentities($lname, ENT_QUOTES, "UTF-8");
		$class = htmlentities($class, ENT_QUOTES, "UTF-8");
		
		if(strlen($class) != 2)
		{
			$_SESSION['e_class'] = "Klasa nie jest napasana w poprawnym formacie. Poprawny format to cyfra + litera.";
			header("Location: createaccount.php");
			exit();
		} else {
			require_once "database.php";
			
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!$!$!$';
			$randstring = '';
			for ($i = 0; $i < 7; $i++) 
			{
				$randstring = $randstring.$characters[rand(0, strlen($characters))];
			}
			
			$password_hash = password_hash($randstring, PASSWORD_DEFAULT);
			
			$userCheckQuery = $database->query("SELECT * FROM users WHERE `uUsername` = '$login'");
			$howmany = $userCheckQuery->rowCount();
			
			if($howmany == 0)
			{
				$insertQuery = $database->prepare("INSERT INTO users VALUES (NULL, :login, :pass, :name, :lname, :class, 1, 0)");
				$insertQuery->bindValue(':login', $login, PDO::PARAM_STR);
				$insertQuery->bindValue(':pass', $password_hash, PDO::PARAM_STR);
				$insertQuery->bindValue(':name', $name, PDO::PARAM_STR);
				$insertQuery->bindValue(':lname', $lname, PDO::PARAM_STR);
				$insertQuery->bindValue(':class', $class, PDO::PARAM_STR);
				$insertQuery->execute();
				
				header("Location: newuserinfo.php?login=".$login."&pass=".$randstring);
			} else {
				$_SESSION['e_class'] = "Taki użytkownik już istnieje!";
				header("Location: createaccount.php");
				exit();
			}
		}
	}
?>