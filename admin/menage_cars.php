<?php
session_start();
$nick = $_SESSION['user'];
//require 'connect.php';

?>
<!DOCTYPE html>
<html>
<title>System parkingowy</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

.button {
  display: inline-block;
  padding: 15px 25px;
  font-size: 24px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;
}

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}

</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-left">Zarządzanie systemem parkingowym</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">

    <div class="w3-col s8 w3-bar">

      <span>Witaj, <strong><?php echo $nick;?></strong></span><br><br>
	  <a href="logout.php">Wyloguj się!</a><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Panel</h5>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" class="w3-bar-item w3-button w3-padding w3-padding"><i class="fa fa-eye fa-fw"></i>  Przegląd</a>
    <a href="menage_cars.php" class="w3-bar-item w3-button w3-blue"><i class="fa fa-car fa-fw"></i>  Zarządzanie samochodami</a>
    <a href="menage_users.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Zarządzanie użytkownikami</a>
    <a href="logs.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  Logi wjazdów na parking</a>
	<a href="work_time.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Weryfikacja czasu pracy</a>
    <a href="settings.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Ustawienia</a><br><br>
  </div>
</nav>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Zarządzanie samochodami</b></h5>
  </header>
    
	<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h3> Dodaj Samochód </h3>
		<form action="menage_cars.php" method="post">
		<table>
		<tr>
		<th>Rejestracja</td>
		<th>Marka</td>
		<th>Model</td>
		</tr>
		<tr>
		<td><input type="text" name="rejestracja" ></td>
		<td><input type="text" name="marka" ></td>
		<td width="30"><input type="text" name="model" ></td>
		</tr>
		</table><br>
		<h5> Wybierz właściciela <h5>
		<?php
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			$sql=mysqli_query($con,"SELECT id,imie,nazwisko FROM wlasciciele");
			if(mysqli_num_rows($sql)){
			$select= '<select name="select">';
			while($rs=mysqli_fetch_array($sql)){
			$select.='<option value="'.$rs['id'].'">'.$rs['imie'].' '.$rs['nazwisko'].'</option>';
				}
			}
			$select.='</select>';
			echo $select;
		?>
		<br><br>
		<input type="submit" name="dodaj_samochod" value="Dodaj samochód" class="button">
		</form>
		
		<?php
		if ( isset($_POST['dodaj_samochod']))
		{
		if (isset($_POST['rejestracja']) && isset($_POST['marka']) && isset($_POST['model']))
		{
			$rejestracja = $_POST['rejestracja'];
			$marka = $_POST['marka'];
			$model = $_POST['model'];
			$idwlaciciel = $_POST['select'];
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			
			$sql = "INSERT INTO samochody (rejestracja, marka, model, idwlasciciel) VALUES ('$rejestracja', '$marka', '$model', '$idwlaciciel')";
			
			if (mysqli_query($con,$sql)) {
			echo "Dodano pomyślnie";
			} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			}

			mysqli_close($con);
			
		}else{
			echo "<br>";
			echo '<font color="red"> Brak danych w polach </font>';
		}
		}
		?>
		
		</div>
</div>
		<div class="w3-twothird">
        <h3> Usuń Samochód </h3>
		<form action="menage_cars.php" method="post">
		<br>
		<h5> Wybierz rejestrację <h5>
		<?php
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			$sql=mysqli_query($con,"SELECT id,rejestracja FROM samochody");
			if(mysqli_num_rows($sql)){
			$select= '<select name="select">';
			while($rs=mysqli_fetch_array($sql)){
			$select.='<option value="'.$rs['id'].'">'.$rs['rejestracja'].' </option>';
				}
			}
			$select.='</select>';
			echo $select;
		?>
		<br><br>
		<input type="submit" name="usun_samochod" value="Usuń samochód" class="button">
		</form>
		
		<?php
		if ( isset($_POST['usun_samochod']))
		{

			$id = $_POST['select'];
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			mysqli_query($con,"SET sql_safe_updates=0");
			$sql = "DELETE FROM samochody WHERE id = '$id'";
			
			if (mysqli_query($con,$sql)) {
					mysqli_query($con,"SET sql_safe_updates=1");
					echo "Usunięto pomyślnie";
			} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			}

			mysqli_close($con);
			

		}
		
		?>
		
		</div>
  
  
    </div>
    
	
      <div class="w3-row-padding" style="margin:0 -4px">

      
        <h3>Rejestr samochodów</h3>
		<?php
		/* show tables */
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$rezultat = mysqli_query($polaczenie, "SELECT samochody.rejestracja,samochody.marka,samochody.model, wlasciciele.imie , wlasciciele.nazwisko, wlasciciele.data_urodzenia, wlasciciele.telefon, wlasciciele.adres
		FROM samochody INNER JOIN wlasciciele ON wlasciciele.id=samochody.idwlasciciel ORDER BY samochody.id ASC" ) or die('Nic tu nie ma :(');
		echo '<table class="w3-table w3-striped w3-white">';
		echo '<tr><th>Rejestracja</th><th>Marka</th><th>Model</th><th>Imię właściciela</th><th>Nazwisko właściciela</th><th>Data urodzenia właściciela</th><th>Telefon właściciela</th><th>Adres właściciela</th></tr>';
		while($wiersz = mysqli_fetch_assoc($rezultat)) {
		
			echo '<tr>';
			foreach($wiersz as $value) {
				echo '<td>',$value,'</td>';
			}
			echo '</tr>';
		
		
	}
		echo '</table>';
		
		?>
		    
  
  </div>
	
</div>

	<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>