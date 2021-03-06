<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include_once("lib/config.php"); include_once("lib/functions.php"); ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registo | Aldan Project</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Arimo|Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="lib/styles.css">
    <?php
      //Check if user is already logged in
      session_start();
      if(isset($_SESSION['username']))
      {
        header("Location: ".SERVER_URL);
      }
    ?>
  </head>
  <body class="center">
    <div class="login signup">
      <a href="<?php echo SERVER_URL; ?>"><img src="img/logo/aldan-project.png" alt="Aldan Project - Logo" class="logo"></a>
      <form action="signup.php<?php if(isset($_GET['download'])) { print("?download"); } ?>" method="post" class="login-form">
        <p class="title">Usuario</p>
        <input type="text" name="username" autocomplete="off" required
        <?php if(!isset($_GET['e'])) echo "autofocus"; ?>
        value="<?php if(isset($_GET['user'])) echo $_GET['user']; ?>">
        <p class="title">Correo electrónico</p>
        <input type="email" name="email" autocomplete="off" required
        value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>">
        <p class="title">Contraseña</p>
        <input type="password" name="passwordOne" required
        <?php if(isset($_GET['e'])) echo "autofocus"; ?>>
        <p class="title">Repetir contraseña</p>
        <input type="password" name="passwordTwo" required>
        <input type="submit" value="Registrarse">
        <?php
        if(isset($_GET['e']))
        {
          switch ($_GET['e']) {
            case 1:
              echo '<p class="message">Se ha generado un error de consulta</p>';
              break;
            case 2:
              echo '<p class="message">Las contraseñas no coinciden</p>';
              break;
            case 3:
              echo '<p class="message">El nombre de usuario ya existe</p>';
              break;
            case 4:
              echo '<p class="message">El nombre de usuario no debe incluir carácteres especiales y tener una longitud entre 3 y 17</p>';
              break;
            default:
              echo '<p class="message">Error desconocido</p>';
              break;
          }
        }
        if(isset($_POST['username']))
        {
          include_once("lib/sql.php");
          $username = $_POST['username'];
          $email = $_POST['email'];
          $passwordOne = $_POST['passwordOne'];
          $passwordTwo = $_POST['passwordTwo'];

          if($passwordOne != $passwordTwo)
          {
            if(isset($_GET['download']))
            {
              header("Location: ".SERVER_URL."signup?e=2&user={$username}&email={$email}&download");
              die();
            }
            else
            {
              header("Location: ".SERVER_URL."signup?e=2&user={$username}&email={$email}");
              die();
            }
          }
          else
          {

            $verifyUser = "/^[A-Za-z0-9-_]{3,12}$/";
            if(preg_match($verifyUser, $username))
            {
              $userCheck = selectQuery('username', 'users', 'username', 's', $username, null);
              if(mysqli_num_rows($userCheck) > 0) //Check if username already exists
              {
                if(isset($_GET['download']))
                {
                  header("Location: ".SERVER_URL."signup?e=3&user={$username}&email={$email}&download");
                  die();
                }
                else
                {
                  header("Location: ".SERVER_URL."signup?e=3&user={$username}&email={$email}");
                  die();
                }
              }
              else
              {
                $result = signupUser($username, $email, $passwordTwo, 3);
                if($result)
                {
                  $query = selectQuery('id_user, username, level', 'users', 'username', 's', $username, null);
                  $user = mysqli_fetch_assoc($query);
                  session_start();
                  $_SESSION['userID'] = $user['id_user'];
                  $_SESSION['username'] = $user['username'];
                  $_SESSION['level'] = $user['level'];

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
                else
                {
                  if(isset($_GET['download']))
                  {
                    header("Location: " . SERVER_URL . "signup?e=1&user={$username}&email={$email}&download");
                    die();
                  }
                  else
                  {
                    header("Location: " . SERVER_URL . "signup?e=1&user={$username}&email={$email}");
                    die();
                  }
                }
              }
            }
            else
            {
              if(isset($_GET['download']))
              {
                header("Location: ".SERVER_URL."signup?e=4&user={$username}&email={$email}&download");
                die();
              }
              else
              {
                header("Location: ".SERVER_URL."signup?e=4&user={$username}&email={$email}");
                die();
              }
            }
          }
        }
        ?>
      </form>
    </div>
  </body>
</html>
