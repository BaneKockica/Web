<?php
try{
$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_baza = "rezervacijekarata";
$db = new PDO('mysql:host='.$db_server.';dbname='.$db_baza, $db_user, $db_password);
$db->exec ("SET NAMES utf8");
$db->exec ("SET CHARACTER SET utf8");
$db->exec ("SET COLLATION_CONNECTION='utf8_unicode_ci'");
} catch (PDOException $e){
echo "<p>Neuspešno povezivanje sa bazom!</p>".$e;
exit();
}
?>
