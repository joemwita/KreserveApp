
<?php
$host="localhost"; // Host name 
$username="*******"; // Mysql username 
$password="******"; // Mysql password 
$db_name="********"; // Database name  
// Connect to server and select databse.
 mysql_connect("$host", "$username", "$password")or die("cannot connect to Global DB"); 
 mysql_select_db("$db_name")or die("cannot select Global DB");

?>

