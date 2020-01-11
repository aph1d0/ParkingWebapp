<?php
# Fill our vars and run on cli
# $ php -f db-connect-test.php
$dbname = '31547086_aph1d_parking';
$dbuser = '31547086_aph1d_parking';
$dbpass = 'd4drA9uc';
$dbhost = '46.242.238.216';
$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
mysql_select_db($dbname) or die("Could not open the db '$dbname'");
$test_query = "SHOW TABLES FROM $dbname";
$result = mysql_query($test_query);
$tblCnt = 0;
while($tbl = mysql_fetch_array($result)) {
  $tblCnt++;
  #echo $tbl[0]."<br />\n";
}
if (!$tblCnt) {
  echo "There are no tables<br />\n";
} else {
  echo "There are $tblCnt tables<br />\n";
}