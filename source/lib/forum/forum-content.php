<!--
<div id="1" class="forum-box post" onclick="callPostPage(this);">
  <p class="forum-title">Título del primer post</p>
  <p class="post-creator">por Azumi</p>
  <p class="num-post"><b>Número de respuestas: </b>15</p>
  <img class="arrow" src="../img/assets/arrow.png">
</div>
-->

<?php
/* Made by Aldan Project | 2018 */
print("<script>forumID = {$_GET['forum']}</script>");

include_once("lib/sql.php");
$nameQuery = $connection->prepare("SELECT name FROM forums WHERE id_forum = ?");
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
      echo "<p class='message large'>No hay publicaciones</p>";
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
        $query->bind_param("i", $postID[$num]);
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
      echo "<script>postID = " . json_encode($postID) . "</script>";
      echo "<script>postTitle = " . json_encode($postTitle) . "</script>";
      echo "<script>postCreator = " . json_encode($postCreator) . "</script>";
      echo "<script>postComments = " . json_encode($postComments) . "</script>";
      print("<script>addPost();</script>");
    }
  }
}

?>
