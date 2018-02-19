<?php
/* Made by Aldan Project | 2018 */

$host = "localhost"; /* Only for local testing */
$username = "root";
$password = "";
$database = "aldan-project";

$connection = new mysqli($host, $username, $password, $database);

if($connection -> connect_errno)
{
  echo '<p class="message">Error de conexión</p>';
}
else
{
  mysqli_set_charset($connection, "utf8");
}

?>
