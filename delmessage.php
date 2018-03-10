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
        $deleteQuery = $database->query("DELETE FROM `messages` WHERE `messages`.`mUID` = $uid;");

        header("Location: messages_get.php");
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
