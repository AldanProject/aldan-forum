<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include_once("lib/config.php"); include_once("lib/functions.php"); ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Iniciar sesión | Foro de Aldan Project</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Arimo|Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="lib/styles.css">
    <?php
      //Check if user is already logged in
      session_start();
      if(isset($_SESSION['username']))
      {
        if(isset($_GET['download']))
        {
          header("Location: ".SERVER_URL."download");
        }
        else
        {
          header("Location: ".SERVER_URL);
        }
      }
    ?>
  </head>
  <body class="center">
    <div class="login">
      <a href="<?php echo SERVER_URL; ?>"><img src="img/logo/aldan-project.png" alt="Aldan Project - Logo" class="logo"></a>
      <form action="login.php <?php if(isset($_GET['download'])) { print("?download"); } ?>" method="post" class="login-form">
        <p class="title">Usuario</p>
        <input type="text" name="username" autocomplete="off" required autofocus>
        <p class="title">Contraseña</p>
        <input type="password" name="password" required>
        <input type="checkbox" name="remind" value="1" checked> <p class="message inline">Recordarme</p>
        <input type="submit" value="Iniciar sesión">
        <?php
          if(isset($_GET['e']))
          {
            switch ($_GET['e']) {
              case 1:
                echo '<p class="message">Se ha generado un error de consulta</p>';
                break;
              case 2:
                echo '<p class="message">Usuario/contraseña incorrecto</p>';
                break;
              default:
                echo '<p class="message">Error desconocido</p>';
                break;
            }
          }
          else if(isset($_POST['username']))
          {
            $username = $_POST['username']; //Gets username
            $password = $_POST['password']; //Gets password without SHA-2 encryption
            $result = loginQuery('id_user, username, level, password', $username, $password);
            if($result)
            {
              $nr = mysqli_num_rows($result);
              if($nr == 0)
              {
                header("Location: ".SERVER_URL."login?e=2"); //Error #2. Either the username does not exist or password is incorrect
              }
              else
              {
                $rows = mysqli_fetch_array($result);
                if($_POST['remind']) //Remind 30 days
                {
                  setcookie("username", $rows['username'], time()+60*60*24*30);
                  setcookie("password", $rows['password'], time()+60*60*24*30);
                }
                session_start();
                $_SESSION['username'] = $rows['username']; //Sets username
                $_SESSION['userID'] = $rows['id_user']; //Sets user id
                $_SESSION['level'] = $rows['level']; //Sets user level
                
                if(isset($_GET['download']))
                {
                  header("Location: " . SERVER_URL . "download");
                  die();
                }
                else
                {
                  header("Location: " . SERVER_URL);
                  die();
                }
              }
            }
          }
        ?>
      </form>
      <hr>
      <p class="no-user">Si no estás registrado, crea una cuenta <a href="<?php echo SERVER_URL; ?>signup<?php if(isset($_GET['download'])) { print("?download"); } ?>">aquí</a>.</p>
    </div>
  </body>
</html>
