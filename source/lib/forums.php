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