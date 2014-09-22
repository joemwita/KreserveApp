
<?php
$host="localhost"; // Host name 
$username="*********"; // Mysql username 
$password="*******"; // Mysql password 
$db_name= $dbname ; // Database name  
// Connect to server and select databse.
 mysql_connect("$host", "$username", "$password")or die("cannot connect to this DB"); 
 mysql_select_db("$db_name")or die("cannot select this DB");

?>

