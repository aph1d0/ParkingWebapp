<?php
$response = array();
include 'db_connect.php';
include 'functions.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if(isset($input['username']) && isset($input['password'])){
	$username = $input['username'];
	$password = $input['password'];
	$query    = "SELECT login,pwd FROM uzytkownicy WHERE login = ?";

	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->bind_result($fullName,$pwd_DB);
		if($stmt->fetch()){
			//Validate the password
			if(password_verify ($password,$pwd_DB)){
				$response["status"] = 0;
				$response["message"] = "Zalogowano";
				$response["full_name"] = $fullName;
			}
			else{
				$response["status"] = 1;
				$response["message"] = "Niepoprawny login lub hasło";
			}
		}
		else{
			$response["status"] = 1;
			$response["message"] = "Niepoprawny login lub hasło";
		}
		
		$stmt->close();
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Podaj wszystkie dane!";
}
//Display the JSON response
echo json_encode($response);
?>