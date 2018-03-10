<div class="navbar">
  <header>
    <a href="<?php echo SERVER_URL; ?>"><img src="<?php echo SERVER_URL; ?>img/logo/aldan-project.png" alt="Aldan Project - Logo" class="logo"></a>
    <ul id='navbar'>
      <li><a href="<?php echo SERVER_URL; ?>">Inicio</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Usuarios</a></li>
      <li id="second-button" class="left-menu">
        <a href="#">[ACTION]</a>
        <ul id="menu-dropdown">
          <li><a href="<?php echo SERVER_URL; ?>edit/profile">Editar perfil</a></li>
          <li><a href="<?php echo SERVER_URL; ?>logout">Cerrar sesión</a></li>
        </ul>
      </li>
      <li id="login-button" class="left-menu"><a href="<?php echo SERVER_URL; ?>login">Iniciar sesión</a></li>
    </ul>
  </header>
</div>

<?php
/* Made by Aldan Project | 2018 */
  session_start();
  $server = SERVER_URL;
  if(isset($_GET['logout']))
  {
    session_unset();
    session_destroy(); //Destroys the session

    header("Location: ".SERVER_URL);
  }

  if(!isset($_SESSION['username']))
  {
    print("<script>setMenuElements('{$server}', false, '');</script>");
  }
  else
  {
    $user = $_SESSION['username'];
    print("<script>setMenuElements('{$server}', true, '{$user}');</script>");
  }
?>
