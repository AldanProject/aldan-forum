<?php
/* Made by Aldan Project | 2018 */
$userID = 0;

function createPost()
{
  include("lib/sql.php");

  $post = $_GET['post'];
  $query = $connection->prepare("SELECT * FROM forum_posts WHERE id_post = ?");
  if(!$query)
    die("<p class='message'>" . mysqli_error($connection) . "</p>");
  $query->bind_param("i", $post);
  $query->execute();
  if(!$query)
    echo "<p class='message'>" . mysqli_error($connection) . "</p>";
  else
  {
    $result = $query->get_result();
    $num = mysqli_num_rows($result);
    if($num > 0)
    {
      $postData = mysqli_fetch_assoc($result);
      $query = $connection->prepare("SELECT id_user, username FROM users WHERE id_user = ?");
      if(!$query)
        echo "<p class='message'>" . mysqli_error($connection) . "</p>";
      $query->bind_param("i", $postData['id_user']);
      $query->execute();
      if(!$query)
        echo "<p class='message'>" . mysqli_error($connection) . "</p>";
      else
      {
        $result = $query->get_result();
        $num = mysqli_num_rows($result);
        if($num > 0)
        {
          $userData = mysqli_fetch_assoc($result);
          $GLOBALS['userID'] = $userData['id_user'];
          $query = $connection->prepare("SELECT name FROM forums WHERE id_forum = ?");
          if(!$query)
            echo "<p class='message'>" . mysqli_error($connection) . "</p>";
          $query->bind_param("i", $_GET['id']);
          $query->execute();
          if(!$query)
            echo "<p class='message'>" . mysqli_error($connection) . "</p>";
          else
          {
            $result = $query->get_result();
            $num = mysqli_num_rows($result);
            if($num > 0)
            {
              $forumName = mysqli_fetch_assoc($result);
              /* Get results */
              $title = $postData['title'];
              $date = $postData['date'];
              $content = $postData['content'];
              $username = $userData['username'];
              $forum = $forumName['name'];
              $forumID = $_GET['id'];
              $serverURL = SERVER_URL;
              $postID = $_GET['post'];

              if(file_exists("img/users/{$userData['id_user']}.jpg"))
                $image = SERVER_URL . "img/users/{$userData['id_user']}.jpg";
              else
                $image = SERVER_URL . "img/users/no-avatar.jpg";

              print("<script>serverURL = '{$serverURL}'</script>");
              print("<script>createPost('{$title}', '{$date}', '{$content}', '{$image}', '{$username}', '{$forum}', '{$forumID}', '{$postID}')</script>");
            }
          }
        }
      }
    }
  }
}

function createComments()
{
  include("lib/sql.php");

  $post = $_GET['post'];
  $query = $connection->prepare("SELECT id_comment, content, date, id_user FROM forum_comments WHERE id_post = ? ORDER BY id_comment DESC");
  if(!$query)
    die("<p class='message'>" . mysqli_error($connection) . "</p>");
  $query->bind_param("i", $post);
  $query->execute();
  if(!$query)
    die("<p class='message'>" . mysqli_error($connection) . "</p>");
  else
  {
    $result = $query->get_result();
    $num = mysqli_num_rows($result);
    if($num > 0)
    {
      while($rows = mysqli_fetch_assoc($result))
      {
        $commentID[] = $rows['id_comment'];
        $commentContent[] = $rows['content'];
        $commentDate[] = $rows['date'];
        $creatorID[] = $rows['id_user'];

        if(file_exists("img/users/{$rows['id_user']}.jpg"))
          $image[] = SERVER_URL . "img/users/{$rows['id_user']}.jpg";
        else
          $image[] = SERVER_URL . "img/users/no-avatar.jpg";
        /* User data */
        $user = mysqli_query($connection, "SELECT username FROM users WHERE id_user = {$rows['id_user']}");
        $num = mysqli_num_rows($user);
        if($num > 0)
        {
            $user = mysqli_fetch_assoc($user);
            $commentUser[] = $user['username'];
        }
      }
      print("<script>commentID = " . json_encode($commentID) . "</script>");
      print("<script>commentContent = " . json_encode($commentContent) . "</script>");
      print("<script>commentDate = " . json_encode($commentDate) . "</script>");
      print("<script>commentCreator = " . json_encode($commentUser) . "</script>");
      print("<script>creatorAvatar = " . json_encode($image) . "</script>");
      print("<script>creatorID = " . json_encode($creatorID) . "</script>");
      print("<script>createComments();</script>");
    }
    else
    {
      print("<p class='message large'>Sin comentarios</p>");
    }
  }
}

function verifyUser()
{
  if(isset($_SESSION['username']))
  {
    print("<script>showCommentBox();</script>");
    print("<script>showOptionComments({$_SESSION['userID']});</script>");
  }
}

function verifyIfLevel()
{
  if(isset($_SESSION['userID']) && ($_SESSION['userID'] === $GLOBALS['userID'] || $_SESSION['level'] == 1 || $_SESSION['level'] == 2))
  {
    print("<script>showOptionButtons();</script>");
  }
}

function makeComment()
{
  include("lib/sql.php");
  $post = $_GET['post'];
  $user = $_SESSION['userID'];
  $comment = $_POST['comment-area'];
  $query = $connection->prepare("INSERT INTO forum_comments(id_comment, content, date, id_user, id_post) VALUES(null, ?, now(), ?, ?)");
  if(!$query)
    die("<p class='message'>" . mysqli_error($connection) . "</p>");
  $query->bind_param("sii", $comment, $user, $post);
  $query->execute();
}

function deleteComment()
{
  include("lib/sql.php");
  $comment = $_POST['delete-comment'];
  $query = $connection->prepare("DELETE FROM forum_comments WHERE id_comment = ?");
  if(!$query)
    die("<p class='message'>" . mysqli_error($connection) . "</p>");
  $query->bind_param("i", $comment);
  $query->execute();

  print("<script>alert('El comentario ha sido eliminado');</script>");
}
?>
<!-- Here is created all the post's page structure -->
<p id="forum-structure" class="forum-structure">{STRUCTURE}</p>
<table id="post" class="post-container">
  <div id="option-buttons" class="option-buttons">
    <form method="post" class="options-form">
      <input class="post-id" type="hidden" name="delete-post">
      <input class="delete" type="button" value="Eliminar publicación">
    </form>
    <form method="post" class="options-form">
      <input class="post-id" type="hidden" name="modify-post">
      <input type="button" value="Editar publicación">
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
<form id="comment-box" class="comment-box" method="post">
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
if(isset($_POST['delete-comment']))
  deleteComment();

createPost();
verifyIfLevel();
if(isset($_POST['comment-area']))
  makeComment();

createComments();
verifyUser();
?>
