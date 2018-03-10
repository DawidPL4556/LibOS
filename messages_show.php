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
  if(isset($_GET['uid']))
  {
    $uid = $_GET['uid'];

    $uid = intval($uid);

  	require_once "database.php";

    $selectMessageQuery = $database->query("SELECT * FROM messages WHERE `mUID` = $uid");
    $howMany = $selectMessageQuery->rowCount();

    if($howMany > 0)
    {
      $message = $selectMessageQuery->fetch();
      if($message['mSendTo'] == $_SESSION['uUID'])
      {
        if($message['mRead'] == 0)
        {
          $readQuery = $database->query("UPDATE `messages` SET `mRead` = '1' WHERE `messages`.`mUID` = $uid");
        }
        $senderQuery = $database->query("SELECT * FROM users WHERE uUID = {$message['mSender']}");

        $sender = $senderQuery->fetch();
      } else {
        header("Location: messages.php");
    		exit();
      }
    } else {
      header("Location: messages.php");
  		exit();
    }
  } else {
    header("Location: messages.php");
		exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LibOS - Wiadomość</title>
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
			<div id="Logo" style="float: left;"><a href="messages_get.php"><- Skrzynka odbiorcza</a>  </div>
			<div id="Logo">LibOS</div>
		</div>
		<div id="Clock">12:45:33</div>
			<?php
        echo '<span style="margin-left: 20px;"><b>Wysyłający:</b> <i>'.$sender['uName'].' '.$sender['uLastName'].'</i></span><br><br>';
				echo '<span style="border-bottom: 2px dashed #292929; margin-left: 20px;"><b>Tytuł:</b> <i>'.$message['mTitle'].'</i></span><br><br>';
        echo '<center>';
        echo '<span style="margin-left: 10px; margin-right: 10px;"><b>Treść:</b> '.nl2br($message['mMessage']."");
        echo '</center>';
				echo '<span style="border-top: 2px dashed #292929; margin-left: 20px;"><a href="delmessage.php?uid='.$uid.'"><div class="Button">Usuń wiadomość</div></a></span>';
			?>
	</div>
</body>
</html>
