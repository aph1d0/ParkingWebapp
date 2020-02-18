Aby połączyć aplikację z bazą danych należy:

- w katalogu głównym oraz w folderze admin utworzyć plik connect.php o nastepującej strukturze

<?php

    $host = "$ip_severa:$port";
	$db_user = "$nazwa_uzytkownika";
	$db_password = "$haslo";
	$db_name = "$nazwa_bazy_danych";
	
?>

- w katalogu w folderze andr utworzyć plik db_connect.php o nastepującej strukturze

<?php
define('DB_USER', "$nazwa_uzytkownika"); 
define('DB_PASSWORD', "$haslo"); 
define('DB_DATABASE', "$nazwa_bazy_danych"); 
define('DB_SERVER', "$ip_severa"); 
 
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
?>