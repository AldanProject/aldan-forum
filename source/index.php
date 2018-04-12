<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include("lib/config.php"); ?>
<html>
  <head>
    <title>Foro de Aldan Project</title>
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
    <div id="main-container" class="main-container">
      <?php
      if(isset($_GET['user']))
      {
        include_once("lib/user.php");
      }
      else if(isset($_GET['edit-profile']))
      {
        //include_once("lib/config/edit-profile.php");
      }
      else if(isset($_GET['forum']))
      {
        include_once("lib/forum/forum-content.php");
      }
      else
      {
        print("<script>document.title = 'Inicio | Foro de Aldan Project';</script>");
        include_once("lib/forums.php");
        //include_once("lib/right-bar.php");
      }
      ?>
    </div>

    <!-- Footer -->
    <?php include_once("lib/inc/footer.php"); ?>
  </body>
</html>
