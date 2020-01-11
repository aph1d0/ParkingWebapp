<?php
session_start();
$nick = $_SESSION['user'];
//require 'connect.php';

?>
<!DOCTYPE html>
<html>
<title>System parkingowy</title>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
</head>
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
		<br><br>
      <span>Witaj, <strong><?php echo $nick;?></strong></span><br><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a><br><br>
	  <a href="logout.php">Wyloguj się!</a><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Panel</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Zamknij Menu</a>
    <a href="index.php" class="w3-bar-item w3-button w3-padding w3-padding"><i class="fa fa-eye fa-fw"></i>  Przegląd</a>
    <a href="menage_cars.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-car fa-fw"></i>  Zarządzanie samochodami</a>
    <a href="menage_users.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Zarządzanie użytkownikami</a>
    <a href="logs.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  Logi wjazdów na parking</a>
	<a href="work_time.php" class="w3-bar-item w3-button w3-blue"><i class="fa fa-eye fa-fw"></i>  Weryfikacja czasu pracy</a>
    <a href="settings.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Ustawienia</a><br><br>
  </div>
</nav>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>\

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Weryfikacja czasu pracy</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
		<form action="work_time.php" method="post">
		<h3>Data: <BR><input type="text" name="date" id="datepicker"> <input type="submit" name="data" value="Pokaż"></h3> 
		
    </div>
	<div class="w3-quarter">
	<h5> Wybierz pracownika <h5>
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
	</form>
	</div>
   </div>
	<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
		<?php
		if ( isset($_POST['date'])){
		if (isset($_POST['data'])){
		/* show tables */
		$dt=date_create($_POST['date']);
		$data=date_format($dt,"Y-m-d");
		$idwlaciciel = $_POST['select'];
		//echo $data;
		/*require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		echo $data;
		echo '<br>';
		echo $idwlaciciel;
		$result1 = mysqli_query($polaczenie, "SELECT wjazdy.data_czas, wlasciciele.imie, wlasciciele.nazwisko
		FROM wjazdy 
		LEFT JOIN wlasciciele ON wlasciciele.id=wjazdy.id_wlasc
		WHERE DATE(wjazdy.data_czas) = '$data' AND wjazdy.id_wlasc = '$idwlaciciel'
		ORDER BY wjazdy.data_czas ASC
		LIMIT 1" ) 
		or die('Nic tu nie ma :(');
		$pierwszy_wjazd = mysql_fetch_object($result1);
		*/
		require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			
			$rezultat1 = $con->query("SELECT wjazdy.data_czas, wlasciciele.imie, wlasciciele.nazwisko
		FROM wjazdy 
		LEFT JOIN wlasciciele ON wlasciciele.id=wjazdy.id_wlasc
		WHERE DATE(wjazdy.data_czas) = '$data' AND wjazdy.id_wlasc = '$idwlaciciel'
		ORDER BY wjazdy.data_czas ASC
		LIMIT 1");
		$pierwszy_wjazd = $rezultat1->fetch_assoc();
			/*
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$result2 = mysqli_query($polaczenie, "SELECT wyjazdy.data_czas, wlasciciele.imie, wlasciciele.nazwisko
		FROM wyjazdy 
		LEFT JOIN wlasciciele ON wlasciciele.id=wjazdy.id_wlasc
		WHERE DATE(wyjazdy.data_czas) = '$data' AND wjazdy.id_wlasc = '$idwlaciciel'
		ORDER BY wyjazdy.data_czas DESC
		LIMIT 1" ) 
		or die('Nic tu nie ma :(');
		$ostatni_wyjazd = mysql_fetch_object($result2);
		*/
		
		require_once "connect.php";
		$con = @new mysqli($host, $db_user, $db_password, $db_name);
		$con -> query ('SET NAMES utf8');
		$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			
		$rezultat2 = $con->query("SELECT wyjazdy.data_czas, wlasciciele.imie, wlasciciele.nazwisko
		FROM wyjazdy 
		LEFT JOIN wlasciciele ON wlasciciele.id=wyjazdy.id_wlasc
		WHERE DATE(wyjazdy.data_czas) = '$data' AND wyjazdy.id_wlasc = '$idwlaciciel'
		ORDER BY wyjazdy.data_czas DESC
		LIMIT 1");
		$ostatni_wyjazd = $rezultat2->fetch_assoc();
		
		if ($pierwszy_wjazd == null){
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			$sql=mysqli_query($con,"SELECT id,imie,nazwisko FROM wlasciciele WHERE id = '$idwlaciciel'");
			$dane_pracownika = $sql->fetch_assoc();
			echo 'Pracownik '.$dane_pracownika['imie'].' '.$dane_pracownika['nazwisko'].' nie przyjechał w dniu '.$data.' samochodem do pracy';
		}else{
		
		if ($ostatni_wyjazd == null){
			echo 'Pracownik '.$pierwszy_wjazd['imie'].' '.$pierwszy_wjazd['nazwisko'].' jeszcze jest w pracy';
		}else{
		
		$rozpoczecie_pracy = new DateTime($pierwszy_wjazd['data_czas']);
		$zakonczenie_pracy = new DateTime($ostatni_wyjazd['data_czas']);

		$czas_pracy = $rozpoczecie_pracy->diff($zakonczenie_pracy);
		$format_czas_pracy =$czas_pracy->format('%h')." H ".$czas_pracy->format('%i')." min";
		echo '<table class="w3-table w3-striped w3-white">';
		echo '<tr><th>Data</th><th>Czas pracy</th><th>Imię pracownika</th><th>Nazwisko pracownika</th></tr>';
		echo '<tr><td>'.$data.'</td><td>'.$format_czas_pracy.'</td><td>'.$pierwszy_wjazd['imie'].'</td><td>'.$pierwszy_wjazd['nazwisko'].'</td><td>';
		echo '</table>';
		}
		}
		}else{
			
			echo '<font color="red"> Wybierz datę </font>';
		}
		}
		
		?>
		  
    </div>
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