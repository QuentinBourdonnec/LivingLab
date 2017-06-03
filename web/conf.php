<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "livinglab";

$conn = new mysqli($servername, $username, $password, $dbname);

$nombre = "10"; //nombre d'evenements dans notre historique page utilisateur
$time="10";		// time en minute de l'affichage des graphes
$room="1";	// id de la room
 
?>
