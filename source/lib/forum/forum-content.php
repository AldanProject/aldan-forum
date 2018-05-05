<div id="option-buttons" class="option-buttons new-post">
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
  $name = mysqli_fetch_assoc($result);
  showNewPostButton($name['closed']);
  print("<script>document.title = '{$name['name']} | Foro de Aldan Project';</script>");
  $result = selectQuery('*', 'forum_posts', 'id_forum', 'i', $_GET['forum'], null);
  if($result)
  {
      $nr = mysqli_num_rows($result);
      if($nr == 0)
      {
        echo "<p class='message large'>No hay publicaciones</p>";
        echo "<p class='message large'><a href='{$serverURL}'>Regresar al inicio</a></p>";
      }
      else
      {
        $num = 0;
        while($rows = mysqli_fetch_assoc($result))
        {
          $postID[] = $rows['id_post'];
          $postTitle[] = $rows['title'];
          /* Creator username */
          $result = selectQuery('username', 'users', 'id_user', 'i', $rows['id_user'], null);
          if($result)
          {
            $count = mysqli_fetch_assoc($result);
            $postCreator[] = $count['username'];
            /* Post count */
            $comments = selectQuery('COUNT(*)', 'forum_comments', 'id_post', 'i', $rows['id_post'], null);
            if($comments)
            {
              $count = mysqli_fetch_assoc($comments);
              $postComments[] = $count['COUNT(*)'];
              $num++;
            }
          }
        }
        print("<script>serverURL = '" . SERVER_URL . "'</script>");
        print("<script>postID = " . json_encode($postID) . "</script>");
        print("<script>postTitle = " . json_encode($postTitle) . "</script>");
        print("<script>postCreator = " . json_encode($postCreator) . "</script>");
        print("<script>postComments = " . json_encode($postComments) . "</script>");
        print("<script>addPost();</script>");
      }
  }
}

?>
