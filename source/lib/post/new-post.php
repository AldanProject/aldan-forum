<?php
if(isset($_POST['title']))
{
	$title = $_POST['title'];
	$content = $_POST['content'];
	$forum = $_GET['forum'];
	$userID = $_SESSION['userID'];

	$content = str_replace(["\r\n", "\r", "\n"], "<br/>", $content);
	$values = array(
		$title,
		$content,
		$forum,
		$userID);

	$result = insertQuery('forum_posts(id_post, title, content, date, id_forum, id_user)', 'null, ?, ?, now(), ?, ?', 'ssii', $values);
	if($result)
	{
		$search = selectQuery('id_post', 'forum_posts', 'title', 's', $title, null);
		if($search)
		{
			$num = mysqli_num_rows($search);
			if($num > 0)
			{
				$data = mysqli_fetch_assoc($search);
				header("Location: " . SERVER_URL . "{$forum}/post/{$data['id_post']}/");
				die();
			}
		}
	}
}
?>
<form class="login-form post-form" method="post">
	<p class="title">Título</p>
	<input type="text" name="title" required autocomplete="off" maxlength="45">
	<p class="title">Contenido</p>
	<textarea name="content" id="content" required></textarea>
	<div class="comment-buttons">
    <div class="buttons">
      <input type="button" value="Negritas" onclick="applyStyle(0, 'content');">
      <input type="button" value="Italica" onclick="applyStyle(1, 'content');">
      <input type="button" value="Subrayado" onclick="applyStyle(2, 'content');">
      <input type="button" value="Enlace" onclick="applyStyle(3, 'content');">
      <input type="button" value="Salto de línea" onclick="applyStyle(4, 'content');">
      <input type="button" value="Centrado" onclick="applyStyle(5, 'content');">
      <input type="button" value="Subtítulo" onclick="applyStyle(6, 'content');">
      <input type="submit" value="Publicar" class="post-button">
    </div>
  </div>
</form>