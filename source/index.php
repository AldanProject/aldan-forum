<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include_once("lib/config.php"); include_once("lib/functions.php"); ?>
<html>
  <head>
    <title>Foro de Aldan Project</title>
    <meta charset="utf-8">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Arimo|Nunito|Lato" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVER_URL; ?>lib/styles.css">
    <link rel="shortcut icon" type="image/png" href="<?php echo SERVER_URL; ?>img/favicon.png"/>
    <script src="<?php echo SERVER_URL; ?>lib/scripts.js"></script>
  </head>
  <body>
    <!-- Navbar -->
    <?php include_once("lib/inc/navbar.php"); ?>
    <!-- Content -->
    <div class="backgroungImage">
      <div id="main-container" class="main-container">
        <?php
        if(isset($_GET['user']))
        {
          include_once("lib/user.php");
        }
        else if(isset($_GET['edit-profile']))
        {
          print("<script>setPageTitle('Editar perfil');</script>");
          include_once("lib/config/edit-profile.php");
        }
        else if(isset($_GET['new-post']))
        {
          print("<script>setPageTitle('Crear publicación');</script>");
          include_once("lib/post/new-post.php");
        }
        else if(isset($_GET['post']))
        {
          include_once("lib/forum/post-content.php");
        }
        else if(isset($_GET['forum']))
        {
          include_once("lib/forum/forum-content.php");
        }
        else if(isset($_GET['new-forum']))
        {
          include_once("lib/forum/new-forum.php");
        }
        else if(isset($_GET['leaderboards']))
        {
          print("<script>setPageTitle('Tabla de puntuaciones');</script>");
          include_once("lib/leaderboards.php");
        }
        else if(isset($_GET['download']))
        {
          print("<script>setPageTitle('Descargar Medal of Darkness');</script>");
          include_once("download.php");
        }
        else
        {
          print("<script>document.title = 'Inicio | Foro de Aldan Project';</script>");
          include_once("lib/forums.php");
        }
        ?>
      </div>
    </div>
    <!-- Footer -->
    <?php include_once("lib/inc/footer.php"); ?>
  </body>
</html>
