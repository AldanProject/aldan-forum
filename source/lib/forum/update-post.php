<?php
include_once("../config.php");
include_once("../functions.php");

$forum = $_POST['id_forum'];
$post = $_POST['id_post'];
$title = $_POST['title'];
$content = $_POST['content'];

$content = str_replace(["\r\n", "\r", "\n"], "<br/>", $content);

$result = updateQuery('content', $content, 'forum_posts', 'id_post', 'si', $post);
if($result)
{
	$result = updateQuery('title', $title, 'forum_posts', 'id_post', 'si', $post);
	if($result)
	{
		header("Location: " . SERVER_URL . "{$forum}/post/{$post}/");
		die();
	}
}

header("Location: " . SERVER_URL);
die();
?>