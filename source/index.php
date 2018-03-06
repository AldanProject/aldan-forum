<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include("lib/config.php"); ?>
<html>
  <head>
    <?php
    if(isset($_GET['user']))
    {
      echo "<title>Perfil de {$_GET['user']} | Foro de Aldan Project</title>";
    }
    else
      echo "<title>Inicio | Foro de Aldan Project</title>";
    ?>
    <meta charset="utf-8">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Arimo|Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVER_URL; ?>lib/styles.css">
    <script src="<?php echo SERVER_URL; ?>lib/scripts.js"></script>
  </head>
  <body>
    <!-- Navbar -->
    <?php include_once("lib/inc/navbar.php"); ?>

    <!-- Content -->
    <div class="main-container">
      <?php
      if(isset($_GET['user']))
      {
        include_once("lib/user.php");
      }
      else
      {
        echo "<br>"; //Only for navbar and footer separation
      }
      ?>
    </div>


    <!-- Footer -->
    <?php include_once("lib/inc/footer.php"); ?>
  </body>
</html>
