<?php
/* Made by Aldan Project | 2018 */

$hostDB = "localhost"; /* Only for local testing */
$usernameDB = "root";
$passwordDB = "";
$database = "aldan-project";

$connection = new mysqli($hostDB, $usernameDB, $passwordDB, $database);

if($connection -> connect_errno)
{
  die(mysqli_error($connection));
}
else
{
  mysqli_set_charset($connection, "utf8");
}

?>
