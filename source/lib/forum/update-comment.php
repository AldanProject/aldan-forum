<?php
include_once("../config.php");
include_once("../functions.php");

$forum = $_POST['id_forum'];
$post = $_POST['id_post'];
$content = $_POST['comment-area'];
$commentID = $_POST['comment-id'];

$content = str_replace(["\r\n", "\r", "\n"], "<br/>", $content);

$result = updateQuery('content', $content, 'forum_comments', 'id_comment', 'si', $commentID);
if($result)
{
	header("Location: " . SERVER_URL . "{$forum}/post/{$post}/");
	die();
}
?>