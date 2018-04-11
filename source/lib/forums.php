<!--
<div id="1" class="forum-box" onclick="callForumPage(this);">
  <img class="forum-icon" src="img/forums/1.png">
  <p class="forum-title">Prueba de foro</p>
  <p class="forum-description">La descripción perrona del foro xddddd</p>
  <img class="arrow" src="img/assets/arrow.png">
</div>
-->

<?php
/* Made by Aldan Project | 2018 */
include_once("sql.php");

$query = $connection->prepare("SELECT * FROM forums");
if(!$query)
  echo "<p class='message'>" . mysqli_error($connection) . "</p>";
$query->execute();

$result = $query->get_result();
if(!$result)
  echo "<p class='message'>" . mysqli_error($connection) . "</p>";
else
{
  $num = mysqli_num_rows($result);
  if($num == 0)
    echo "<p class='message large'>No hay foros disponibles</p>";
  else
  {
    while($row = mysqli_fetch_assoc($result))
    {
      $ids[] = $row['id_forum'];
      $names[] = $row['name'];
      $descriptions[] = $row['description'];
    }
    echo "<script>forumID = " . json_encode($ids) . "</script>";
    echo "<script>forumTitle = " . json_encode($names) . "</script>";
    echo "<script>forumDescription = " . json_encode($descriptions) . "</script>";
    print("<script>addForum();</script>");
  }
}
?>
