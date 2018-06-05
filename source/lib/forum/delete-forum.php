<?php
session_start();
include_once("../config.php");
if(isset($_SESSION['username']))
{
	if($_SESSION['level'] < 3)
	{
		include_once("../functions.php");
		$forum = $_POST['id_forum'];
		deleteQuery('forums', 'id_forum', 'i', $forum);
		unlink("../../img/forum/" . $forum . ".png");
	}
}
header("Location: " . SERVER_URL);
die();
?>