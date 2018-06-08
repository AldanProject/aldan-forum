<?php
checkIfNormalUser();
print("<script>setPageTitle('Crear foro');</script>");
if(isset($_FILES['icon']))
{
  createForum();
}

?>
<div style="display: flex; width: 100%;">
  <form method="post" class="login-form new-forum" action="<?php print(SERVER_URL); ?>new/forum" enctype="multipart/form-data">
    <p>Título</p>
    <input type="text" name="title" required autocomplete="off">
    <p>Descripción</p>
    <input type="text" name="description" required autocomplete="off">
    <p>Icono</p>
    <input type="file" name="icon" accept=".png" required>
    <p>Estado</p>
    <select name="status">
      <option value="0">Abierto</option>
      <option value="1">Cerrado</option>
    </select>
    <input type="submit" value="Crear foro">
  </form>
</div>
