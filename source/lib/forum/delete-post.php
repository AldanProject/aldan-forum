<?php
include_once("../config.php");
include_once("../functions.php");

$forum = $_POST['id_forum'];
$post = $_POST['id_post'];

deleteQuery('forum_posts', 'id_post', 'i', $post);

header("Location: " . SERVER_URL . "{$forum}");
die();
?>