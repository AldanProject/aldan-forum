<!-- Here is created all the post's page structure -->
<p id="forum-structure" class="forum-structure">{STRUCTURE}</p>
<table id="post" class="post-container">
  <div id="option-buttons" class="option-buttons">
    <form method="post" class="options-form" action="<?php print(SERVER_URL); ?>delete/post" onsubmit="return confirm('Está a punto de eliminar la publicación, ¿desea continuar?')">
      <input type="hidden" name="id_forum" value="<?php print($_GET['forum']); ?>">
      <input type="hidden" name="id_post" value="<?php print($_GET['post']); ?>">
      <input class="delete" type="submit" value="Eliminar publicación">
    </form>
      <input id="edit-post" type="submit" value="Editar publicación">
  </div>
  <tr class="post-border">
    <td class="content">
      <h2 id="post-title" class="user-title post-title">{TITLE}</h2>
      <p id="post-date" class="date">{DATE}</p>
      <p id="post-content" class="content">{CONTENT}</p>
    </td>
    <td class="user">
      <img id="user-image" class="user-image link post-image" onclick="" src="">
      <p id="username" class="user-title link post-username" onclick="">{USERNAME}</p>
    </td>
  </tr>
</table>
<hr>
<p class="comment-title">Comentarios</p>
<form id="comment-box" class="comment-box" method="post" action="<?php print(SERVER_URL); ?>new/comment">
  <input type="hidden" name="id_forum" value="<?php print($_GET['forum']); ?>">
  <input type="hidden" name="id_post" value="<?php print($_GET['post']); ?>">
  <textarea id="comment-area" class="comment-area" name="comment-area" required></textarea>
  <div class="comment-buttons">
    <div class="buttons">
      <input type="button" value="Negritas" onclick="applyStyle(0, 'comment-area');">
      <input type="button" value="Italica" onclick="applyStyle(1, 'comment-area');">
      <input type="button" value="Subrayado" onclick="applyStyle(2, 'comment-area');">
      <input type="button" value="Enlace" onclick="applyStyle(3, 'comment-area');">
      <input type="button" value="Salto de línea" onclick="applyStyle(4, 'comment-area');">
      <input type="submit" value="Comentar">
    </div>
  </div>
  <hr>
</form>
<div id="user-comments" class="comment-section">
<!--
  <table class="post-container user-comment">
    <tr class="post-border">
      <td class="content">
        <p class="date">{DATE}</p>
        <p class="content">{CONTENT}</p>
      </td>
      <td class="user">
        <img class="user-image link post-image" onclick="" src="">
        <p class="user-title link post-username" onclick="">{USERNAME}</p>
      </td>
    </tr>
  </table>
-->
</div>
<div id="black-screen" class="edit-comment">
  <form class="comment-box" method="post" action="<?php print(SERVER_URL); ?>save/comment">
    <input type="hidden" name="id_forum" value="<?php print($_GET['forum']); ?>">
    <input type="hidden" name="id_post" value="<?php print($_GET['post']); ?>">
    <input type="hidden" name="comment-id" id="comment-id">
    <p>Editar comentario</p>
    <textarea id="comment-area-edit" class="comment-area" name="comment-area" required></textarea>
    <div class="comment-buttons">
      <div class="buttons">
        <input type="button" value="Negritas" onclick="applyStyle(0, 'comment-area-edit');">
        <input type="button" value="Italica" onclick="applyStyle(1, 'comment-area-edit');">
        <input type="button" value="Subrayado" onclick="applyStyle(2, 'comment-area-edit');">
        <input type="button" value="Enlace" onclick="applyStyle(3, 'comment-area-edit');">
        <input type="button" value="Salto de línea" onclick="applyStyle(4, 'comment-area-edit');">
        <input type="button" value="Cancelar" class="cancel" onclick="hideBlackScreen(<?php print($_GET['forum']); ?>, <?php print($_GET['post']); ?>);">
        <input type="submit" value="Guardar cambios" class="save-changes">
      </div>
    </div>
  </form>
</div>
<!-- -->
<div id="black-screen-post" class="edit-comment">
  <form class="login-form post-form comment-box" method="post" action="<?php print(SERVER_URL); ?>save/post">
    <input type="hidden" name="id_forum" value="<?php print($_GET['forum']); ?>">
    <input type="hidden" name="id_post" value="<?php print($_GET['post']); ?>">
    <p>Editar publicación</p>
    <p class="title">Título</p>
    <input id="title-edit" type="text" name="title" required autocomplete="off">
    <p class="title">Contenido</p>
    <textarea name="content" id="comment-area-edit-post" required></textarea>
    <div class="comment-buttons">
      <div class="buttons">
        <input type="button" value="Negritas" onclick="applyStyle(0, 'comment-area-edit-post');">
        <input type="button" value="Italica" onclick="applyStyle(1, 'comment-area-edit-post');">
        <input type="button" value="Subrayado" onclick="applyStyle(2, 'comment-area-edit-post');">
        <input type="button" value="Enlace" onclick="applyStyle(3, 'comment-area-edit-post');">
        <input type="button" value="Salto de línea" onclick="applyStyle(4, 'comment-area-edit-post');">
        <input type="button" value="Centrado" onclick="applyStyle(5, 'comment-area-edit-post');">
        <input type="button" value="Subtítulo" onclick="applyStyle(6, 'comment-area-edit-post');">
        <input type="button" value="Cancelar" class="cancel" onclick="hideBlackScreen(<?php print($_GET['forum']); ?>, <?php print($_GET['post']); ?>);">
        <input type="submit" value="Guardar cambios" class="post-button">
      </div>
    </div>
  </form>
</div>
  <?php
/* Made by Aldan Project */
if(isset($_POST['delete-comment']))
{
  deleteQuery('forum_comments', 'id_comment', 'i', $_POST['delete-comment']);
}
else if(isset($_GET['edit']))
{
  $result = selectQuery('id_comment, content, id_user', 'forum_comments', 'id_comment', 'i', $_GET['edit'], null);
  if($result)
  {
    $num = mysqli_num_rows($result);
    if($num > 0)
    {
      $rows = mysqli_fetch_assoc($result);
      if(!isset($_SESSION['username']) || ($_SESSION['level'] >= 3 && $rows['id_user'] != $_SESSION['userID']))
      {
        header("Location: " . SERVER_URL);
        die();
      }
      else
      {
        $commentID = $rows['id_comment'];
        $commentContent = $rows['content'];
        print("<script>showEditComment({$commentID}, '{$commentContent}');</script>");
      }
    }
  }
}
else if(isset($_GET['edit-post']))
{
  $result = selectQuery('id_post, title, content, id_user', 'forum_posts', 'id_post', 'i', $_GET['edit-post'], null);
  if($result)
  {
    $num = mysqli_num_rows($result);
    if($num > 0)
    {
      $rows = mysqli_fetch_assoc($result);
      if(!isset($_SESSION['username']) || ($_SESSION['level'] >= 3 && $rows['id_user'] != $_SESSION['userID']))
      {
        header("Location: " . SERVER_URL);
        die();
      }
      else
      {
        $postID = $rows['id_post'];
        $title = $rows['title'];
        $postContent = $rows['content'];
        print("<script>showEditPost({$postID}, '{$title}', '{$postContent}');</script>");
      }
    }
  }
}
/* Put the post information */
createPost($_GET['post'], $_GET['forum']);
/* Check if there is user logged in */
verifyIfLevel();
/* Put the post's comment(s) */
createComments($_GET['post']);
/* Verify if actual user is the post's owner */
verifyUser();
?>
</div>
