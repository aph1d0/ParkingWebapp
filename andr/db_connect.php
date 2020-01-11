<?php
define('DB_USER', "31547086_aph1d_parking"); // db user
define('DB_PASSWORD', "d4drA9uc"); // db password (mention your db password here)
define('DB_DATABASE', "31547086_aph1d_parking"); // database name
define('DB_SERVER', "46.242.238.216"); // db server
 
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
?>