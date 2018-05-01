<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include_once("lib/config.php"); ?>
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
          include_once("lib/sql.php");
          $username = $_POST['username'];
          $email = $_POST['email'];
          $passwordOne = $_POST['passwordOne'];
          $passwordTwo = $_POST['passwordTwo'];

          if($passwordOne != $passwordTwo)
          {
            header("Location: ".SERVER_URL."signup?e=2&user={$username}&email={$email}");
          }
          else
          {
            $check = $connection->prepare("SELECT username FROM users WHERE username = ?");
            if(!$check)
              die("<p class='message'>" . mysqli_error($connection) . "</p>");
            $check->bind_param("s", $username);
            $check->execute();
            $userCheck = $check->get_result();

            if(mysqli_num_rows($userCheck) > 0) //Check if username already exists
              header("Location: ".SERVER_URL."signup?e=3&user={$username}&email={$email}");
            else
            {
              $userLevel = 3;
              $query = $connection->prepare("INSERT INTO users(id_user, username, email, password, level, biography, location) VALUES(null, ?, ?, md5(?), ?, '[NONE]', '[NONE]')");
              if(!$query)
                die("<p class='message'>" . mysqli_error($connection) . "</p>");
              $query->bind_param("sssi", $username, $email, $passwordTwo, $userLevel);
              $query->execute();

              if($query)
              {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 3;
                header("Location: ".SERVER_URL);
              }
              else
                header("Location: ".SERVER_URL."signup?e=1&user={$username}&email={$email}");
            }
          }
        }
        ?>
      </form>
    </div>
  </body>
</html>
