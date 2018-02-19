<!DOCTYPE html>
<!-- Made by Aldan Project | 2018 -->
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
        header("Location: index.php");
      }
    ?>
  </head>
  <body class="center">
    <div class="login">
      <h2>Aldan Project</h2>
      <form action="login.php" method="post" class="login-form">
        <p class="title">Usuario</p>
        <input type="text" name="username" autocomplete="off" required autofocus>
        <p class="title">Contraseña</p>
        <input type="password" name="password" required>
        <input type="submit" value="Inciar sesión">
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
            include("lib/sql.php");
            $username = $_POST['username']; //Gets username
            $password = $_POST['password']; //Gets password without MD5 encryption

            $query = $connection->prepare("SELECT username, level FROM users WHERE username = ? AND password = md5(?)"); //Prepares the query
            $query->bind_param("ss", $username, $password); //Binds all parameters
            $query->execute(); //Executes the query

            $result = $query->get_result(); //Obtains the query result
            if(!$result)
              header("Location: login.php?e=1"); //Error #1. Query error
            else
            {
              $num = mysqli_num_rows($result);
              if($num == 0)
                header("Location: login.php?e=2"); //Error #2. Either the username does not exist or password is incorrect
              else
              {
                $rows = mysqli_fetch_array($result);
                session_start();
                $_SESSION['username'] = $rows['username']; //Sets username
                $_SESSION['level'] = $rows['level']; //Sets user level

                header("Location: index.php");
              }
            }
          }
        ?>
      </form>
      <hr>
      <p class="no-user">Si no estás registrado, crea una cuenta <a href="signup.php">aquí</a>.</p>
    </div>
  </body>
</html>
