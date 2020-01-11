<?php	
	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0) 
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		$admin = "admin";
		$user = "user";
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE login='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			
			$ilu_userow = $rezultat->num_rows;
            $wiersz = $rezultat->fetch_assoc();
            $dostep = $wiersz['typ'];
			//$pass_hash= substr($wiersz['pwd'], 0, 60 );
			$pass_hash= $wiersz['pwd'];
			if (password_verify ($haslo, $pass_hash)){
			//if ($haslo = $wiersz['pwd']){
			if($ilu_userow>0 && $dostep == "admin" )
			{
                //$wiersz = $rezultat->fetch_assoc();
				$_SESSION['zalogowany'] = true;
				$_SESSION['id'] = $wiersz['iduser'];
				$_SESSION['user'] = $wiersz['login'];
                unset($_SESSION['blad']);
    			$rezultat->free_result();
				header('Location: admin/index.php');
				exit();
			} 
            elseif($ilu_userow>0 && $dostep == "user" )
			{
                //$wiersz = $rezultat->fetch_assoc();
				$_SESSION['zalogowany2'] = true;
                $login = $_POST['login'];
                $rezultatuser = mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE login = '$login'");
                $wiersz1 = mysqli_fetch_array($rezultatuser);
				$_SESSION['id2'] = $wiersz['id'];
				$_SESSION['user2'] = $wiersz1['login'];
                unset($_SESSION['blad']);
    			$rezultat->free_result();
				header('Location: user/index.php');
				exit();
			} 
			}
            else{
                $_SESSION['blad'] = '</br><center><span style="color:red">Nieprawidłowy login lub hasło! </span></center>';
        		header('Location: index.php');
				exit();
            }
		$polaczenie->close();
		exit();
	}}
  
?>