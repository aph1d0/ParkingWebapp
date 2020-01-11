<?php 
require_once('db_connect.php');
if(isset($_GET['username']) && $_GET['username'] !== ''){
  $username = $_GET['username'];
  
  
  
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

/* $statement1 = mysqli_prepare($con, "SELECT rejestracja from samochody where idwlasciciel = '$wlasc_id' ");
mysqli_stmt_execute($statement1);
mysqli_stmt_bind_result($statement1,$r3);
$i=0;
while(mysqli_stmt_fetch($statement1)){
	$rejestracje[$i]=$r3;
	$i=$i+1;
} */

  
$sql = "SELECT rejestracja from samochody where idwlasciciel = '$wlasc_id' ";

//$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
$r = mysqli_query($con,$sql);
$result = array();
while($row = mysqli_fetch_array($r)){
 array_push($result,array(
'Rejestracja'=>$row['rejestracja']
    ));
}
echo json_encode(array('result'=>$result));
}else{  echo "failed";
}
mysqli_close($con);

?>