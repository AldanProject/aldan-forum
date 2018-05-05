<!-- Here is created all the post's page structure -->
<p id="forum-structure" class="forum-structure">{STRUCTURE}</p>
<table id="post" class="post-container">
  <div id="option-buttons" class="option-buttons">
    <form method="post" class="options-form">
      <input class="post-id" type="hidden" name="delete-post">
      <input class="delete" type="submit" value="Eliminar publicación">
    </form>
    <form method="post" class="options-form">
      <input class="post-id" type="hidden" name="modify-post">
      <input type="submit" value="Editar publicación">
    </form>
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
<form id="comment-box" class="comment-box" method="post" action="<?php print(SERVER_URL); ?>create/comment">
  <textarea id="comment-area" class="comment-area" name="comment-area"></textarea>
  <div class="comment-buttons">
    <div class="buttons">
      <input type="button" value="Negritas" onclick="applyStyle(0);">
      <input type="button" value="Italica" onclick="applyStyle(1);">
      <input type="button" value="Subrayado" onclick="applyStyle(2);">
      <input type="button" value="Enlace" onclick="applyStyle(3);">
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
<?php
/* Made by Aldan Project */
if(isset($_POST['delete-comment']))
{
  $result = deleteQuery('forum_comments', 'id_comment', 'i', $_POST['delete-comment']);
}
else if(isset($_POST['comment-area']))
{
  makeComment();
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
