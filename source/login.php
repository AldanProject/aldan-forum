<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
<?php include_once("lib/config.php"); ?>
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
        header("Location: ".SERVER_URL);
      }
    ?>
  </head>
  <body class="center">
    <div class="login">
      <a href="<?php echo SERVER_URL; ?>"><img src="img/logo/aldan-project.png" alt="Aldan Project - Logo" class="logo"></a>
      <form action="login.php" method="post" class="login-form">
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
          if(isset($_POST['username']))
          {
            include_once("lib/sql.php");
            $username = $_POST['username']; //Gets username
            $password = $_POST['password']; //Gets password without MD5 encryption

            $query = $connection->prepare("SELECT username, level, password FROM users WHERE username = ? AND password = md5(?)"); //Prepares the query
            if(!$query)
              die("<p class='message'>" . mysqli_error($connection) . "</p>");
            $query->bind_param("ss", $username, $password); //Binds all parameters
            $query->execute(); //Executes the query

            $result = $query->get_result(); //Obtains the query result
            if(!$result)
              header("Location: ".SERVER_URL."login?e=1"); //Error #1. Query error
            else
            {
              $num = mysqli_num_rows($result);
              if($num == 0)
                header("Location: ".SERVER_URL."login?e=2"); //Error #2. Either the username does not exist or password is incorrect
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
                $_SESSION['level'] = $rows['level']; //Sets user level

                header("Location: ".SERVER_URL);
              }
            }
          }
        ?>
      </form>
      <hr>
      <p class="no-user">Si no estás registrado, crea una cuenta <a href="<?php echo SERVER_URL; ?>signup">aquí</a>.</p>
    </div>
  </body>
</html>
