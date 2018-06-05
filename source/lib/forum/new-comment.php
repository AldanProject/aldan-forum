<?php
include_once("../config.php");
include_once("../functions.php");
session_start();

if(isset($_SESSION['username']))
{
	$comment = $_POST['comment-area'];
	$forum = $_POST['id_forum'];
	$post = $_POST['id_post'];

	$comment = str_replace(["\r\n", "\r", "\n"], "<br/>", $comment);

	if(!empty($forum) && !empty($post) && !empty($comment))
	{
		if(makeComment($post, $_SESSION['userID'], $comment))
		{
			header("Location: " . SERVER_URL . "{$forum}/post/{$post}/");
			die();
		}
		else
		{
			header("Location: " . SERVER_URL . "{$forum}/post/{$post}/?error");
			die();
		}
	}
	else
	{
		header("Location: " . SERVER_URL);
		die();
	}
}
else
{
	header("Location: " . SERVER_URL);
	die();
}
?>