<?php
checkIfNormalUser();
print("<script>setPageTitle('Crear foro');</script>");
if(isset($_POST['title']))
{
  createForum();
}

?>
<div style="display: flex; width: 100%;">
  <form method="post" class="login-form new-forum">
    <p>Título</p>
    <input type="text" name="title" required autocomplete="off">
    <p>Descripción</p>
    <input type="text" name="description" required autocomplete="off">
    <p>Estado</p>
    <select name="status">
      <option value="0">Abierto</option>
      <option value="1">Cerrado</option>
    </select>
    <input type="submit" value="Crear foro">
  </form>
</div>
