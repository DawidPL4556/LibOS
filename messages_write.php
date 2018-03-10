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

  if(isset($_POST['users']))
  {
    $senduid = $_POST['users'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if($senduid == "" || $title == "" || $content == "")
    {
      $_SESSION['err'] = "Dane nie mogą być puste!";
    } else {
      $senduid = intval($senduid);
      $title = htmlentities($title, ENT_QUOTES, "UTF-8");
      $content = htmlentities($content, ENT_QUOTES, "UTF-8");

      if(strlen($title) > 100)
      {
        $_SESSION['err'] = "Dane są za długie!";
      } else {
        $insertQuery = $database->query("INSERT INTO messages VALUES (NULL, {$_SESSION['uUID']}, $senduid, '$title', '$content', 0, now())");

        header("Location: messages.php");
      }
    }
  }

  $selectUsersQuery = $database->query("SELECT * FROM users");
  $users = $selectUsersQuery->fetchAll();
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
	<link rel="stylesheet" type="text/css" href="input_style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800&amp;subset=latin-ext" rel="stylesheet">
	<script src="js/hpage.js"></script>
</head>
<body>
	<div id="Content">
		<div id="TopBar">
			<div id="Logo" style="float: left;"><a href="messages.php"><- Wiadomośći</a>  </div>
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>
		<center>
      <form method="post">
        <select name="users">
          <?php
            foreach($users as $user)
            {
              echo '<option value="'.$user['uUID'].'">'.$user['uName'].' '.$user['uLastName'].'</option>';
            }
          ?>
        </select>
        <input type="text" name="title" placeholder="Tytuł">
        <textarea cols="48" rows="5" name="content" placeholder="Treść"></textarea>
        <input type="submit" value="Wyślij!">
        <span style="color: red; font-weight: bold">
          <?php
            if(isset($_SESSION['err']))
            {
              echo $_SESSION['err'];
              unset($_SESSION['err']);
            }
          ?>
        </span>
      </form>
		</center>
	</div>
</body>
</html>
