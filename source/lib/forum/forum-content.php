<div id="option-buttons" class="option-buttons new-post">
  <form method="post" action="<?php print(SERVER_URL); ?>lib/forum/delete-forum.php" onsubmit="return confirm('Está a punto de eliminar el foro, ¿desea continuar?')">
    <input type="hidden" name="id_forum" value="<?php print($_GET['forum']); ?>">
    <input type="submit" value="Eliminar foro">
  </form>
  <a id="add-link" href=""><input type="button" value="Nueva publicación"></a>
</div>

<?php
/* Made by Aldan Project | 2018 */
print("<script>forumID = {$_GET['forum']}</script>");

include_once("lib/sql.php");
include_once("lib/config.php");
$serverURL = SERVER_URL;
$result = selectQuery('name, closed', 'forums', 'id_forum', 'i', $_GET['forum'], null);
if($result)
{
  print("<script>serverURL = '" . SERVER_URL . "'</script>");
  $name = mysqli_fetch_assoc($result);
  showNewPostButton($name['closed']);
  print("<script>newPostLink();</script>");
  print("<script>document.title = '{$name['name']} | Foro de Aldan Project';</script>");
  $result = selectQuery('*', 'forum_posts', 'id_forum', 'i', $_GET['forum'], null);
  if($result)
  {
      $nr = mysqli_num_rows($result);
      if($nr <= 0)
      {
        echo "<p class='message large'>No hay publicaciones</p>";
        echo "<p class='message large'><a href='{$serverURL}'>Regresar al inicio</a></p>";
      }
      else
      {
        while($rows = mysqli_fetch_assoc($result))
        {
          $postID[] = $rows['id_post'];
          $postTitle[] = $rows['title'];
          /* Creator username */
          $user = selectQuery('username', 'users', 'id_user', 'i', $rows['id_user'], null);
          if($user)
          {
            $count = mysqli_fetch_assoc($user);
            $postCreator[] = $count['username'];
            /* Post count */
            $comments = selectQuery('COUNT(*)', 'forum_comments', 'id_post', 'i', $rows['id_post'], null);
            if($comments)
            {
              $count = mysqli_fetch_assoc($comments);
              $postComments[] = $count['COUNT(*)'];
            }
          }
        }
        print("<script>postID = " . json_encode($postID) . "</script>");
        print("<script>postTitle = " . json_encode($postTitle) . "</script>");
        print("<script>postCreator = " . json_encode($postCreator) . "</script>");
        print("<script>postComments = " . json_encode($postComments) . "</script>");
        print("<script>addPost();</script>");
      }
  }
}

?>
