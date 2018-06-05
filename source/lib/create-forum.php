<?php
include_once("../sql.php");
include_once("../functions.php");
$title = $_POST['title'];
$description = $_POST['description'];
$status = $_POST['status'];
$image = $_FILES['icon'];

$dataArray = array(
$title,
$description,
$status,
);
$query = insertQuery('forums(id_forum, name, description, closed)', 'null, ?, ?, ?', 'ssi', $dataArray);
if($query)
{
$result = selectQuery('id_forum', 'forums', 'name', 's', $title, null);
if($result)
{
  $num = mysqli_num_rows($result);
  if($num > 0)
  {
    $data = mysqli_fetch_assoc($result);
    $id = $data['id_forum'];
    $uploadFile = SERVER_URL . "img/forum/" . $id . ".png";

    if(move_uploaded_file($image['tmp_name'], $uploadFile))
    {
      header("Location: " . SERVER_URL);
      die();
    }
  }
}
}
?>