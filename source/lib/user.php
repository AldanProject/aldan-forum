<?php
/* Made by Aldan Project | 2018 */
include_once("sql.php");

$username = $_GET['user'];
$query = $connection->prepare("SELECT id_user, username, email FROM users WHERE username = ?");
if(!$query)
  echo "<p class='message'>" . mysqli_error($connection) . "</p>";
$query->bind_param("s", $username);
$query->execute();

$result = $query->get_result();
if(!$result)
  echo "<p class='message'>" . mysqli_error($connection) . "</p>";
else
{
  $num = mysqli_num_rows($result);
  if($num == 0)
  {
    echo "<p class='message large'>El usuario no existe</p>";
  }
  else
  {
    $user = mysqli_fetch_array($result);
    if(file_exists("img/users/{$user['id_user']}.jpg"))
      echo "<img src='".SERVER_URL."img/users/{$user['id_user']}.jpg' class='user-image'>";
    else
      echo "<img src='".SERVER_URL."img/users/no-avatar.jpg' class='user-image'>";
    echo "<user>{$user['username']}</user>";
  }
}
?>
