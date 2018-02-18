<div class="navbar">
  <header>
    <h1>Aldan Project</h1>
    <ul>
      <li><a href="#">Inicio</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Usuarios</a></li>
      <?php
        if(!isset($_SESSION['username']))
        {
          echo '<li><a href="#">Registrarse</a></li>';
          echo '<li><a href="#">Iniciar sesión</a></li>';
        }
        else
        {
          echo '<li><a href="#">Cerrar sesión</a></li>';
          echo '<li><a href="#">Perfil</a></li>';
        }
      ?>
    </ul>
  </header>
</div>
