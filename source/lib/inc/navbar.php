<div class="navbar">
  <header>
    <a href="<?php echo SERVER_URL; ?>"><img src="<?php echo SERVER_URL; ?>img/logo/aldan-project.png" alt="Aldan Project - Logo" class="logo"></a>
    <ul>
      <li><a href="<?php echo SERVER_URL; ?>">Inicio</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Usuarios</a></li>
      <?php
      /* Made by Aldan Project | 2018 */
        session_start();
        if(isset($_GET['logout']))
        {
          session_unset();
          session_destroy(); //Destroys the session

          header("Location: ".SERVER_URL);
        }
        if(!isset($_SESSION['username']))
        {
          echo "<li><a href='".SERVER_URL."signup'>Registrarse</a></li>";
          echo "<li><a href='".SERVER_URL."login'>Iniciar sesión</a></li>";
        }
        else
        {
          echo "<li><a href='".SERVER_URL."?logout'>Cerrar sesión</a></li>";
          echo "<li><a href='".SERVER_URL."user/{$_SESSION['username']}'>{$_SESSION['username']}</a></li>";
        }
      ?>
    </ul>
  </header>
</div>
