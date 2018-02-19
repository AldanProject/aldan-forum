<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
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
        header("Location: index.php");
      }
    ?>
  </head>
  <body class="center">
    <div class="login signup">
      <h2>Aldan Project</h2>
      <form action="signup.php" method="post" class="login-form">
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
            default:
              echo '<p class="message">Error desconocido</p>';
              break;
          }
        }
        if(isset($_POST['username']))
        {
          include("lib/sql.php");
          $username = $_POST['username'];
          $email = $_POST['email'];
          $passwordOne = $_POST['passwordOne'];
          $passwordTwo = $_POST['passwordTwo'];

          if($passwordOne != $passwordTwo)
          {
            header("Location: signup.php?e=2&user=". $username . "&email=" . $email);
          }
          else
          {
            $check = $connection->prepare("SELECT username FROM users WHERE username = ?");
            $check->bind_param("s", $username);
            $check->execute();
            $userCheck = $check->get_result();

            if(mysqli_num_rows($userCheck) > 0) //Check if username already exists
              header("Location: signup.php?e=3&user=". $username . "&email=" . $email);
            else
            {
              $query = $connection->prepare("INSERT INTO users(id_user, username, email, password, level) VALUES(null, ?, ?, md5(?), 2)");
              $query->bind_param("sss", $username, $email, $passwordTwo);
              $query->execute();

              $result = $query->get_result();
              if(!$result)
                header("Location: signup.php?e=1");
              else
              {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 2;
                header("Location: index.php?signedup");
              }
            }
          }
        }
        ?>
      </form>
    </div>
  </body>
</html>
