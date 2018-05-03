<?php
function createPost()
{
  include_once("lib/sql.php");
  $title = $_POST['title'];
  $description = $_POST['description'];
  $status = $_POST['status'];

  $query = $connection->prepare("INSERT INTO forums(id_forum, name, description, closed) VALUES(null, ?, ?, ?)");
  if(!$query)
  {
    $error = mysqli_error($connection);
    print("<script>alert('{$error}');</script>");
    header("Location: " . SERVER_URL);
    die();
  }
  $query->bind_param("ssi", $title, $description, $status);
  $query->execute();
  header("Location: " . SERVER_URL);
  die();
}

print("<script>setPageTitle('Crear foro');</script>");
if(isset($_POST['title']))
{
  createPost();
}

if(!isset($_SESSION['level']) && !$_SESSION['level'] == 3)
{
  header("Location: " . SERVER_URL);
  die();
}
?>
<div style="display: flex; width: 100%;">
  <form method="post" class="login-form new-forum">
    <p>Título</p>
    <input type="text" name="title" required>
    <p>Descripción</p>
    <input type="text" name="description" required>
    <p>Estado</p>
    <select name="status">
      <option value="0">Abierto</option>
      <option value="1">Cerrado</option>
    </select>
    <input type="submit" value="Crear foro">
  </form>
</div>
