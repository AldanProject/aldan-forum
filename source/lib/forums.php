<div id="option-buttons" class="option-buttons new-post">
  <a href="<?php print(SERVER_URL); ?>new/forum"><input type="button" value="Nuevo foro"></a>
</div>
<?php
/* Made by Aldan Project | 2018 */
checkIfLevel();
$result = selectQuery('*', 'forums', null, null, null, null);
if($result)
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
