<!-- Here is created all the post's page structure -->
<p id="forum-structure" class="forum-structure">{STRUCTURE}</p>
<table id="post" class="post-container">
  <tr class="post-border">
    <td class="content">
      <h2 id="post-title" class="user-title post-title">{TITLE}</h2>
      <p id="post-date" class="date">{DATE}</p>
      <p id="post-content" class="content">{CONTENT}</p>
    </td>
    <td class="user">
      <img id="user-image" class="user-image link post-image" onclick="" src="">
      <p id="username" class="user-title link post-username" onclick="searchUser('<?php print(SERVER_URL); ?>', 'Azumi');">{USERNAME}</p>
    </td>
  </tr>
</table>

<?php
/* Made by Aldan Project | 2018 */
include_once("lib/sql.php");

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

            if(file_exists("img/users/{$userData['id_user']}.jpg"))
              $image = SERVER_URL . "img/users/{$userData['id_user']}.jpg";
            else
              $image = SERVER_URL . "img/users/no-avatar.jpg";

            print("<script>serverURL = '{$serverURL}'</script>");
            print("<script>createPost('{$title}', '{$date}', '{$content}', '{$image}', '{$username}', '{$forum}', '{$forumID}')</script>");
          }
        }
      }
    }
  }
}
?>
