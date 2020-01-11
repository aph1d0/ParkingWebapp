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
select{
 width:170px;   
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
	  <a href="logout.php">Wyloguj się!</a><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Panel</h5>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" class="w3-bar-item w3-button w3-padding w3-padding"><i class="fa fa-eye fa-fw"></i>  Przegląd</a>
    <a href="menage_cars.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-car fa-fw"></i>  Zarządzanie samochodami</a>
    <a href="menage_users.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Zarządzanie użytkownikami</a>
    <a href="logs.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  Logi wjazdów na parking</a>
	<a href="work_time.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Weryfikacja czasu pracy</a>
    <a href="settings.php" class="w3-bar-item w3-button w3-blue"><i class="fa fa-cog fa-fw"></i>  Ustawienia</a><br><br>
  </div>
</nav>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Ustawienia</b></h5>
  </header>
    
	<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h3> Zmień hasło użytkownika </h3>
		<form action="settings.php" method="post">
		<br>
		<table>
		<tr>
		<td><h5> Wybierz używkonika <h5></td>	
		<td style="margin: 10px; padding: 10px;"></td> 
		<td><h5>Nowe hasło<h5></td>	
		</tr>
		<tr>
		<td>
				<?php
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			$sql=mysqli_query($con,"SELECT id,login FROM uzytkownicy");
			if(mysqli_num_rows($sql)){
			$select= '<select name="select">';
			while($rs=mysqli_fetch_array($sql)){
			$select.='<option value="'.$rs['id'].'">'.$rs['login'].' </option>';
				}
			}
			$select.='</select>';
			echo $select;
		?>
		</td>
		<td style="margin: 10px; padding: 10px;"></td> 
		<td><input type="password" name="nowe_haslo"></td>
		</tr>
		</table><br>
		<br><br>
		<input type="submit" name="zmien_haslo" value="Zmień hasło" class="button">
		</form>
		
		<?php
		if ( isset($_POST['zmien_haslo']))
		{
		if (isset($_POST['nowe_haslo']) )
		{
			$nowe_haslo = $_POST['nowe_haslo'];
			$pass_hash = password_hash( $nowe_haslo, PASSWORD_DEFAULT );
			$iduser = $_POST['select'];
			require_once "connect.php";
			$con = @new mysqli($host, $db_user, $db_password, $db_name);
			$con -> query ('SET NAMES utf8');
			$con -> query ('SET CHARACTER_SET utf8_unicode_ci');
			
			$sql = "UPDATE uzytkownicy SET pwd='$pass_hash' WHERE id='$iduser' ";
			
			if (mysqli_query($con,$sql)) {
			echo "<br><br>Zmieniono hasło pomyślnie";
			//echo "<br>". $iduser;
			//echo "<br>". $pass_hash;
			} else {
			echo "<br><br>Error: " . $sql . "<br>" . $conn->error;
			}

			mysqli_close($con);
			
		}else{
			echo "<br>";
			echo '<font color="red"> Brak danych w polach </font>';
		}
		}
		?>
		
		</div>
      		<div class="w3-twothird">
        <h3>Rejestr użytkowników</h3>
		<?php
		/* show tables */
		require_once "connect.php";
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie -> query ('SET NAMES utf8');
		$polaczenie -> query ('SET CHARACTER_SET utf8_unicode_ci');
		$rezultat3 = mysqli_query($polaczenie, "SELECT uzytkownicy.login,wlasciciele.imie,wlasciciele.nazwisko, wlasciciele.adres , wlasciciele.telefon
		FROM uzytkownicy INNER JOIN wlasciciele ON wlasciciele.id=uzytkownicy.wlasciciele_id
		ORDER BY uzytkownicy.id ASC" ) or die('Nic tu nie ma :(');
		echo '<table class="w3-table w3-striped w3-white">';
		echo '<tr><th>Nickname</th><th>Imie</th><th>Nazwisko</th><th>Adres właściciela</th><th>Telefon do właściciela</th>';
		while($wiersz3 = mysqli_fetch_assoc($rezultat3)) {
		
			echo '<tr>';
			foreach($wiersz3 as $value) {
				echo '<td>',$value,'</td>';
			}
			echo '</tr>';
		
		
	}
		echo '</table>';
		
		?>
		    </div>
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