<!--
<div id="1" class="forum-box post" onclick="callPostPage(this);">
  <p class="forum-title">Título del primer post</p>
  <p class="post-creator">por Azumi</p>
  <p class="num-post"><b>Número de respuestas: </b>15</p>
  <img class="arrow" src="../img/assets/arrow.png">
</div>
-->
<div id="option-buttons" class="option-buttons new-post">
  <input type="button" value="Nueva publicación">
</div>
<?php
/* Made by Aldan Project | 2018 */
function showNewPostButton($closed)
{
  if(isset($_SESSION['username']) && $closed == 0)
    print("<script>showNewPost();</script>");
  else if(isset($_SESSION['level']) && $_SESSION['level'] < 3)
    print("<script>showNewPost();</script>");
}
print("<script>forumID = {$_GET['forum']}</script>");

include_once("lib/sql.php");
include_once("lib/config.php");
$serverURL = SERVER_URL;

$nameQuery = $connection->prepare("SELECT name, closed FROM forums WHERE id_forum = ?");
if(!$nameQuery)
  echo "<p class='message'>" . mysqli_error($connection) . "</p>";
$nameQuery->bind_param("i", $_GET['forum']);
$nameQuery->execute();
$result = $nameQuery->get_result();
if(!$result)
  echo "<p class='message'>" . mysqli_error($connection) . "</p>";
else
{
  $name = mysqli_fetch_assoc($result);
  showNewPostButton($name['closed']);
  print("<script>document.title = '{$name['name']} | Foro de Aldan Project';</script>");

  $query = $connection->prepare("SELECT * FROM forum_posts WHERE id_forum = ?");
  if(!$query)
    echo "<p class='message'>" . mysqli_error($connection) . "</p>";
  $query->bind_param("i", $_GET['forum']);
  $query->execute();
  $result = $query->get_result();
  if(!$result)
    echo "<p class='message'>" . mysqli_error($connection) . "</p>";
  else
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
        $query = $connection->prepare("SELECT username FROM users WHERE id_user = ?");
        if(!$query)
          echo "<p class='message'>" . mysqli_error($connection) . "</p>";
        $query->bind_param("i", $rows['id_user']);
        $query->execute();
        $result = $query->get_result();
        if(!$result)
          die("<p class='message'>" . mysqli_error($connection) . "</p>");
        else
        {
          $count = mysqli_fetch_assoc($result);
          $postCreator[] = $count['username'];
        }

        /* Post count */
        $query = $connection->prepare("SELECT COUNT(*) FROM forum_comments WHERE id_post = ?");
        if(!$query)
          echo "<p class='message'>" . mysqli_error($connection) . "</p>";
        $query->bind_param("i", $rows['id_post']);
        $query->execute();
        $result = $query->get_result();
        if(!$result)
          die("<p class='message'>" . mysqli_error($connection) . "</p>");
        else
        {
          $count = mysqli_fetch_assoc($result);
          $postComments[] = $count['COUNT(*)'];
        }
        $num++;
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
