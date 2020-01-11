<?php
include 'db_connect.php';
$username = $_POST["sz_username"];
$rejestracja = $_POST["rejestracja"];
//echo $rejestracja;

$statement7 = mysqli_prepare($con, "SELECT stan from szlaban where id=1");
mysqli_stmt_execute($statement7);
mysqli_stmt_bind_result($statement7,$r4);
while(mysqli_stmt_fetch($statement7)){
	$szlab=$r4;
}

if ($szlab == 0)
{
$statement3 = mysqli_prepare($con, "SELECT wlasciciele_id from uzytkownicy where login = ?");
mysqli_stmt_bind_param($statement3, "s", $username);
mysqli_stmt_execute($statement3);
mysqli_stmt_bind_result($statement3,$r1);
while(mysqli_stmt_fetch($statement3)){
	$user_id=$r1;
}

$statement4 = mysqli_prepare($con, "SELECT id from wlasciciele where id = '$user_id' ");
mysqli_stmt_execute($statement4);
mysqli_stmt_bind_result($statement4,$r2);
while(mysqli_stmt_fetch($statement4)){
	$wlasc_id=$r2;
}
/* 
$statement5 = mysqli_prepare($con, "SELECT rejestracja from samochody where idwlasciciel = 'wlasc_id' ");
mysqli_stmt_execute($statement5);
mysqli_stmt_bind_result($statement5,$r3);
$i=0;
while(mysqli_stmt_fetch($statement5)){
	$rejestracje[$i]=$r3;
	$i=$i+1;
}
 */

	
$statement9 = mysqli_prepare($con, "SELECT rejestracja from obecnosc_na_parkingu where rejestracja = '$rejestracja' ");
mysqli_stmt_execute($statement9);
mysqli_stmt_bind_result($statement9,$r14);
if(mysqli_stmt_fetch($statement9)){ 
//while(mysqli_stmt_fetch($statement9)){
$rejestracja_ob=$r14;     
echo 'obecny: '.$rejestracja_ob.'';      
//if(isset($rejestracja_ob)){  
include "db_connect.php";
$statement16 = mysqli_prepare($con, "SELECT id from samochody where rejestracja='$rejestracja_ob'");
mysqli_stmt_execute($statement16);
mysqli_stmt_bind_result($statement16,$r26);
while(mysqli_stmt_fetch($statement16)){
	$id_samoch=$r26;
}

$statement26 = mysqli_prepare($con, "INSERT into wyjazdy (id_wlasc,id_samochodu) values ('$wlasc_id', '$id_samoch')");
mysqli_stmt_execute($statement26);

$statement112 = mysqli_prepare($con, "DELETE from obecnosc_na_parkingu WHERE rejestracja = '$rejestracja_ob'");
mysqli_stmt_execute($statement112);

$statement2 = mysqli_prepare($con, "UPDATE zajetosc SET wolne_miejsca = wolne_miejsca+1 where id=1");
mysqli_stmt_execute($statement2);

	
}else{
include "db_connect.php";
echo $rejestracja_ob;
echo $rejestracja;

$statement11 = mysqli_prepare($con, "SELECT id from samochody where rejestracja = '$rejestracja' ");
mysqli_stmt_execute($statement11);
mysqli_stmt_bind_result($statement11,$r6);
while(mysqli_stmt_fetch($statement11)){
	$id_samoch=$r6;
}

$statement28 = mysqli_prepare($con, "INSERT into wjazdy (id_wlasc,id_samochodu) values ('$wlasc_id', '$id_samoch')");
mysqli_stmt_execute($statement28);

$statement12 = mysqli_prepare($con, "INSERT into obecnosc_na_parkingu (rejestracja) VALUES ('$rejestracja')");
mysqli_stmt_execute($statement12);

$statement2 = mysqli_prepare($con, "UPDATE zajetosc SET wolne_miejsca = wolne_miejsca-1 where id=1");
mysqli_stmt_execute($statement2);	
	
}

	
/* $statement8 = mysqli_prepare($con, "SELECT id from wlasciciele where id = '$user_id' ");
mysqli_stmt_execute($statement4);
mysqli_stmt_bind_result($statement4,$r2);
while(mysqli_stmt_fetch($statement4)){
	$wlasc_id=$r2; 
*/

/* $statement6 = mysqli_prepare($con, "INSERT into wjazdy (id_wlasc) values ('$wlasc_id')");
mysqli_stmt_execute($statement6);

$statement2 = mysqli_prepare($con, "UPDATE zajetosc SET wolne_miejsca = wolne_miejsca-1 where id=1");
mysqli_stmt_execute($statement2);

} */

$statement = mysqli_prepare($con, "UPDATE szlaban SET stan = 1, otwierajacy = ?");
mysqli_stmt_bind_param($statement, "s", $username);
mysqli_stmt_execute($statement);

$response = array();
$response["success"] = true; 
echo json_encode($response);
}
mysqli_close($con);
?>