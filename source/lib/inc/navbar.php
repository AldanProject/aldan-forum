<div class="navbar">
  <header>
    <a href="<?php echo SERVER_URL; ?>"><img src="<?php echo SERVER_URL; ?>img/logo/aldan-project.png" alt="Aldan Project - Logo" class="logo"></a>
    <ul id='navbar'>
      <li><a class="main-bar" href="<?php echo SERVER_URL; ?>">Inicio</a></li>
      <li><a class="main-bar" href="#">Blog</a></li>
      <li><a class="main-bar" href="#">Usuarios</a></li>
      <li id="second-button" class="right-menu">
        <a class="main-bar" href="#">[ACTION]</a>
        <a id="user-link" class="user-link" href="#"><img id="user-avatar" class="user-avatar" src=""></a>
        <ul id="menu-dropdown">
          <li id="username-label" class="username-label">[USERNAME]</li>
          <li><a href="<?php echo SERVER_URL; ?>edit/profile">Editar perfil</a></li>
          <li><a href="<?php echo SERVER_URL; ?>logout">Cerrar sesión</a></li>
        </ul>
      </li>
      <li class="right-menu" id="login-button"><a class="main-bar" href="<?php echo SERVER_URL; ?>login">Iniciar sesión</a></li>
    </ul>
  </header>
</div>

<?php
/* Made by Aldan Project | 2018 */
  session_start();
  $server = SERVER_URL;
  if(isset($_GET['logout']))
  {
    setcookie("username", "", time() - 3600);
    setcookie("password", "", time() - 3600);
    session_unset();
    session_destroy(); //Destroys the session

    header("Location: ".SERVER_URL);
  }

  if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && !isset($_SESSION['username']))
  {
    include_once("lib/sql.php");
    $query = $connection->prepare("SELECT id_user, username, level, password FROM users WHERE username = ? AND password = ?");
    if(!$query)
      die("<p class='message'>" . mysqli_error($connection) . "</p>");
    $query->bind_param("ss", $_COOKIE['username'], $_COOKIE['password']);
    $query->execute();

    $result = $query->get_result();
    if(!$result)
    {
      setcookie("username", "", time() - 3600);
      setcookie("password", "", time() - 3600);
    }
    else
    {
      $nr = mysqli_num_rows($result);
      if($nr > 0)
      {
        $rows = mysqli_fetch_array($result);
        $_SESSION['username'] = $rows['username'];
        $_SESSION['userID'] = $rows['id_user'];
        $_SESSION['level'] = $rows['level'];
      }
      else
      {
        setcookie("username", "", time() - 3600);
        setcookie("password", "", time() - 3600);
      }
    }
  }

  if(!isset($_SESSION['username']))
  {
    print("<script>setMenuElements('{$server}', false, '');</script>");
  }
  else
  {
    $user = $_SESSION['username'];
    $id = $_SESSION['userID'];
    print("<script>setMenuElements('{$server}', true, '{$user}', '{$id}');</script>");
  }
?>
