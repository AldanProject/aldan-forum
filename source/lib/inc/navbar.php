<div class="navbar">
  <header>
    <h1><a href="index.pgp">Aldan Project</a></h1>
    <ul>
      <li><a href="#">Inicio</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Usuarios</a></li>
      <?php
      /* Made by Aldan Project | 2018 */
        session_start();
        if(isset($_GET['logout']))
        {
          session_unset();
          session_destroy(); //Destroys the session

          header("Location: index.php");
        }
        if(!isset($_SESSION['username']))
        {
          echo '<li><a href="signup.php">Registrarse</a></li>';
          echo '<li><a href="login.php">Iniciar sesión</a></li>';
        }
        else
        {
          echo '<li><a href="?logout">Cerrar sesión</a></li>';
          echo '<li><a href="#">'.$_SESSION['username'].'</a></li>';
        }
      ?>
    </ul>
  </header>
</div>
