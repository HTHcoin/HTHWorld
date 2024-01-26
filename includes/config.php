<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','hth_admin');
define('DB_PASS','1223@Cale');
define('DB_NAME','HTHWorld');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
