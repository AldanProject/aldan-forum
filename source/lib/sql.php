<?php
/* Made by Aldan Project | 2018 */

$host = "localhost"; /* Only for local testing */
$username = "root";
$password = "";
$database = "aldan-project";

$connection = new mysqli($host, $username, $password, $database);

if($connection -> connect_errno)
{
  die(mysqli_error($connection));
}
else
{
  mysqli_set_charset($connection, "utf8");
}

?>
