<?php

    session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: admin');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>System zarządzania parkingiem</title>
	<link rel="stylesheet" href="styleindex.css">
	</head>

<body>

	<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
	?>
<div class="login">
  <div class="login-header">
    <h1>Zaloguj się</h1>
	<h3>do panelu zarządzania systemem parkingowym</h3>
  </div>
  <div class="login-form">
	<form action="zaloguj.php" method="post">
      <input type="text" class="form-control" name="login" placeholder="Login" required="" autofocus="" />
      <input type="password" class="form-control" name="haslo" placeholder="Hasło" required=""/>      
	<br>
      <button class="login-button" type="submit">Zaloguj</button>   
	</form>


</body>
  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <p>Autor: <a href="https://www.linkedin.com/in/filip-smoli%C5%84ski-385041144/" target="_blank">Filip Smoliński</a></p>
  </footer>
  	</div>
</div>
</html>
