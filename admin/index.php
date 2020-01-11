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
      <span>Witaj, <strong><?php echo $nick;?></strong></span><br><br>
	  <a href="logout.php">Wyloguj się!</a><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Panel</h5>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-eye fa-fw"></i>  Przegląd</a>
    <a href="menage_cars.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-car fa-fw"></i>  Zarządzanie samochodami</a>
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
  <br>
    <h5><b><i class="fa fa-dashboard"></i> Przegląd parkingu</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fas fa-parking w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$rezultat = mysqli_query($polaczenie, "SELECT * FROM zajetosc" );
		$wiersz = mysqli_fetch_array($rezultat);
		$text = $wiersz [1];
		echo $text;
		  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Ilość wolnych miejsc</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php
		$dt = new DateTime();
		$date = $dt->format('Y-m-d');
		//echo $date;
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$result = mysqli_query($polaczenie, "SELECT COUNT(*) AS total FROM wjazdy WHERE DATE(data_czas)='$date'" );
		$data=mysqli_fetch_assoc($result);
		echo $data['total'];
		  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Ilość wjazdów dzisiaj</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fas fa-id-card-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php
		$dt = new DateTime();
		$date = $dt->format('Y-m-d');
		//echo $date;
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$result = mysqli_query($polaczenie, "SELECT COUNT(*) AS total FROM identyfikacje WHERE DATE(data_czas)='$date' AND wynik='udana'" );
		$data=mysqli_fetch_assoc($result);
		echo $data['total'];
		  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Udane identyfikacje dzisiaj</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fas fa-exclamation-triangle w3-xxxlarge"></i>
        <div class="w3-right">
          <h3><?php
		$dt = new DateTime();
		$date = $dt->format('Y-m-d');
		//echo $date;
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$result = mysqli_query($polaczenie, "SELECT COUNT(*) AS total FROM identyfikacje WHERE DATE(data_czas)='$date' AND wynik='nieudana'" );
		$data=mysqli_fetch_assoc($result);
		echo $data['total'];
		  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Nieudane identyfikacje dzisiaj</h4>
      </div>
    </div>
  </div>

  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h3>Sterowanie szlabanem</h3>
		
		<?php
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$rezultat = mysqli_query($polaczenie, "SELECT stan,otwierajacy FROM szlaban" );
		$wiersz = mysqli_fetch_array($rezultat);
		$stan = $wiersz [0];
		$otwierajacy = $wiersz [1];
		echo "<br>";
		echo "Stan szlabanu: ";
		if ($stan==0){ 
		echo "zamknięty"; 
		}else
		{
		echo "otwarty";
		}
		echo "<br>";
		echo "Ostatni otwierający: ";
		echo $otwierajacy;
		echo "<br><br>";
		?>
		<form action="index.php" method="post">
		<input type="submit" name="opengate" value="Otwórz szlaban" class="button">
        </form>
		<br><br>
		
		<?php
		if(isset($_POST['opengate']))
		{
        func();
		echo '<meta http-equiv="refresh" content="0">';
		}
		function func()
		{
		require "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$nick = $_SESSION['user'];
		$sql = "UPDATE szlaban SET stan='1',otwierajacy='$nick' WHERE id=1";
		$sql1 = "UPDATE zajetosc SET wolne_miejsca=wolne_miejsca-1 WHERE id=1;";
		if (mysqli_query($polaczenie, $sql) === TRUE) {
		} else {
		echo "Error: " . $polaczenie->error;
		}
		if (mysqli_query($polaczenie, $sql1) === TRUE) {
		} else {
		echo "Error: " . $polaczenie->error;
		}
		$_POST = array();
		}	
		echo '<br>';
	?>
	</div>
      <div class="w3-twothird">
        <h5>Ostatnie wjzady</h5>
		<?php
		/* show tables */
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$rezultat = mysqli_query($polaczenie, "SELECT wjazdy.data_czas,samochody.rejestracja,wlasciciele.imie, wlasciciele.nazwisko
		FROM wjazdy 
		LEFT JOIN samochody ON wjazdy.id_samochodu=samochody.id
        LEFT JOIN wlasciciele ON wjazdy.id_wlasc=wlasciciele.id
		ORDER BY wjazdy.id DESC limit 10" ) or die('Nic tu nie ma :(');
		echo '<table class="w3-table w3-striped w3-white">';
		echo '<tr><th>Data i czas</th><th>Rejestracja</th><th>Imie własciciela</th><th>Nazwisko własciciela</th></tr>';
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
  



  <!-- End page content -->
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
