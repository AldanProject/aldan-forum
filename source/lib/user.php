<!-- Here is created all the user's page structure -->
<div id="user">
  <h2 id="user-title" class="user-title">[USERNAME]</h2>
  <p id="user-email" class="user-email">[USER EMAIL]</p>
  <table id="user-table">
    <tr>
      <td class="column-info">
        <div id="user-biography" class="user-data">
          <p class="title">Biografía</p>
          <p class="user-content"></p>
        </div><!--
        --><div id="user-location" class="user-data">
          <p class="title">Locación</p>
          <p class="user-content"></p>
        </div><!--
        --><div id="user-gender" class="user-data">
          <p class="title">Género</p>
          <p class="user-content"></p>
        </div><!--
        --><div id="user-score" class="user-data">
          <p class="title">Puntuación</p>
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
$username = $_GET['user'];
$result = getUser($username);
if($result)
{
  $num = mysqli_num_rows($result);
  if($num == 0)
  {
    echo "<p class='message large'>El usuario no existe</p>";
  }
  else
  {
    $user = mysqli_fetch_assoc($result);
    $username = $user['username'];
    $email = $user['email'];
    $biography = $user['biography'];
    $location = $user['location'];
    $gender = $user['gender'];
    $image = checkAvatar($user['id_user']);
    $score = $user['score'];
    print("<script>setUserProfile('{$username}', '{$image}', '{$email}', '{$biography}', '{$location}', {$gender}, {$score});</script>");
  }
}
?>
