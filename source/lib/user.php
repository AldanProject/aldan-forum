<!-- Here is created all the user's page structure -->
<div id="user">
  <h2 id="user-title" class="user-title">[USERNAME]</h2>
  <p id="user-email" class="user-email">[USER EMAIL]</p>
  <table id="user-table">
    <tr>
      <td class="column-info">
        <div id="user-biography">
          <p class="title">Biografía</p>
          <p class="user-content"></p>
        </div><!--
        --><div id="user-location">
          <p class="title">Locación</p>
          <p class="user-content"></p>
        </div><!--
        --><div id="user-gender">
          <p class="title">Género</p>
          <p class="user-content"></p>
        </div>
      </td>
      <td class="column-image">
        <img id="user-image" class="user-image" src="#">
      </td>
    </tr>
  </table>
</div>

<?php
/* Made by Aldan Project | 2018 */
include_once("sql.php");

$username = $_GET['user'];
$query = $connection->prepare("SELECT id_user, username, email, biography, location, gender FROM users WHERE username = ?");
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
    $username = $user['username'];
    $email = $user['email'];
    $biography = $user['biography'];
    $location = $user['location'];
    $gender = $user['gender'];
    if(file_exists("img/users/{$user['id_user']}.jpg"))
      $image = SERVER_URL . "img/users/{$user['id_user']}.jpg";
    else
      $image = SERVER_URL . "img/users/no-avatar.jpg";
    echo "<script>setUserProfile('{$username}', '{$image}', '{$email}', '{$biography}', '{$location}', {$gender});</script>";
  }
  print("<script>document.title = 'Perfil de {$username} | Foro de Aldan Project';</script>");
}
?>
