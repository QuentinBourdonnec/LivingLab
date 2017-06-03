<?php 
error_reporting(E_ALL);
 ?>

<?php

include "../conf.php";

if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
   echo "Failed";
}

// on teste si le visiteur a soumis le formulaire de connexion
function connexion($login, $pass){
	global $conn;
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {

	// on teste si une entrée de la base contient ce couple login / pass
	$sql = 'SELECT count(*) FROM USER WHERE MAIL_USER="'.$_POST['login'].'" AND PASS_USER="'.$_POST['pass'].'"';
	$req = $conn->query($sql);
	$data = $req->fetch_array();

	// si on obtient une réponse, alors l'utilisateur est un membre
	if ($data[0] == 1) {
		session_start();
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['pass'] = $_POST['pass'];
		header('Location: index.php');
		exit();
	}
	// si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
	}
}
}

function inscription(){
	//on regarde si tous les champs sont bien remplis si oui on rentre dans le if sinon on ne fait rien 
	if(isset($_POST['nom_uti']) && isset($_POST['prenom_uti']) && isset($_POST['pass_uti']) && isset($_POST['mail_uti']) && isset($_POST['nom_ref']) && isset($_POST['prenom_ref']) && isset($_POST['pass_ref']) && isset($_POST['mail_ref']) && isset($_POST['tel_ref'])){
		
		
		//On insere les données dans les différentes table de la base de données 
	$sql = "INSERT INTO USER (`LASTNAME_USER`, `FIRSTNAME_USER`, `MAIL_USER`, `PASS_USER`) VALUES ('".$_POST['nom_uti']."','".$_POST['prenom_uti']."','".$_POST['mail_uti']."','".$_POST['pass_uti']."')";
	global $conn;
	$conn->query($sql);
	
	$sql1 = "INSERT INTO CONTACT (`LASTNAME_CON`, `FIRSTNAME_CON`, `MAIL_CONTACT`, `PASS_CON`) VALUES ('".$_POST['nom_ref']."','".$_POST['prenom_ref']."','".$_POST['mail_ref']."','".$_POST['pass_ref']."')";
	global $conn;
	$conn->query($sql1);

	
	$sql2 = "INSERT INTO PHONE(`NUMBER`, `MAIL_CONTACT`) VALUES ('".$_POST['tel_ref']."','".$_POST['mail_ref']."')";
	global $conn;
	$conn->query($sql2);
	
	$sql3 = "INSERT INTO USER_CONTACT(`MAIL_USER`, `MAIL_CONTACT`) VALUES ('".$_POST['mail_uti']."','".$_POST['mail_ref']."')";
	global $conn;
	$conn->query($sql3);
	header("location: index.php");
	exit();
	}
	}

function data($type, $time, $room){
	$sql ="SELECT DTIME, NUM FROM  VALUE WHERE ID_ROOM = $room AND ID_SENSOR = '$type' AND DTIME > DATE_SUB(NOW(), INTERVAL $time MINUTE)";
	global $conn;
	$result = $conn->query($sql);
	return $result;
	
}
function affichRef($login){
	//on selection avec une requete SQL le mail_contact qui est lié au mail_user dans la table user_contact pour ensuite afficher les données du référent 
		$sql = "SELECT * FROM USER_CONTACT, CONTACT WHERE USER_CONTACT.MAIL_CONTACT = CONTACT.MAIL_CONTACT AND USER_CONTACT.MAIL_USER='".$login."' ";
		global $conn;
		$resultat = $conn->query($sql);
		if ($resultat->num_rows > 0) {
    echo "<table><tr><th><u>Mail<u></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom</u></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Prénom</u></th><th>&nbsp;&nbsp;&nbsp;<u>mot de passe</u></th></tr>";
    while($row = $resultat->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["MAIL_CONTACT"]."</th>";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["LASTNAME_CON"]."</th>";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["FIRSTNAME_CON"]."</th>";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["PASS_CON"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
	
}


function affichDonne($login){
	
	//On execute un requete sql pour afficher les données de l'utilisateur
		$sql ="SELECT * FROM USER WHERE MAIL_USER = '".$login."' ";
		global $conn;
		$resultat = $conn->query($sql);
		if ($resultat->num_rows > 0) {
    echo "<table><tr><th><u>Mail<u></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Nom</u></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Prénom</u></th><th>&nbsp;&nbsp;&nbsp;<u>mot de passe</u></th></tr>";
    while($row = $resultat->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["MAIL_USER"]."</th>";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["LASTNAME_USER"]."</th>";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["FIRSTNAME_USER"]."</th>";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["PASS_USER"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
	
}

function donneeCO2(){
	
	//on fait une requete sql pour afficher les seuil du co2
	$sql1 =" SELECT * FROM SENSOR WHERE ID_SENSOR ='1' AND ID_ROOM ='1'";
	global $conn;
	$resultat =$conn->query($sql1);
	if ($resultat->num_rows > 0) {
   		 while($row = $resultat->fetch_assoc()) {
        	echo "Le seuil tres important est de :".$row["THRESHOLD_HIGH"]."&nbsp;&nbsp; ppm<br>";
			echo "et le seuil important est de :".$row["THRESHOLD_LOW"]."&nbsp;&nbsp;ppm<br>";
   			 }
     		echo"</table>";
  }
	// on affiche ensuite la derniere donnée du co2 qui est arrivé dans la bdd
	$sql = "SELECT * FROM VALUE WHERE ID_SENSOR='1' AND ID_ROOM ='1' ORDER BY DTIME DESC LIMIT 1 ";
  global $conn;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
   		 while($row = $result->fetch_assoc()) {
        	echo "<tr>\n\t<th><strong>".$row["NUM"]."</strong>ppm";
   			 }
     		echo"</table>";
  }
}

function Humidity(){
	//on fait une requete sql pour afficher les seuil de l'humidité
	$sql1 =" SELECT * FROM SENSOR WHERE ID_SENSOR ='2' AND ID_ROOM ='1'";
	global $conn;
	$resultat =$conn->query($sql1);
	if ($resultat->num_rows > 0) {
   		 while($row = $resultat->fetch_assoc()) {
        	echo "Le seuil haut est de :".$row["THRESHOLD_HIGH"]."&nbsp;&nbsp;%<br>";
			echo "et le seuil minimal est de :".$row["THRESHOLD_LOW"]."&nbsp;&nbsp;%<br>";
   			 }
     		echo"</table>";
  }
  // on affiche ensuite la derniere donnée de l'humidité qui est arrivé dans la bdd
	$sql = "SELECT * FROM VALUE WHERE ID_SENSOR='3' AND ID_ROOM ='1' ORDER BY DTIME DESC LIMIT 1 ";
  global $conn;
  $resul = $conn->query($sql);
  if ($resul->num_rows > 0) {
   		 while($row = $resul->fetch_assoc()) {
        	echo "<tr>\n\t<th><strong>".$row["NUM"]."</strong>%";
   			 }
     		echo"</table>";
  }
}

function donneeTemp(){
	//on fait une requete sql pour afficher les seuil de la température
	$sql1 =" SELECT * FROM SENSOR WHERE ID_SENSOR ='3' AND ID_ROOM ='1'";
	global $conn;
	$resultat =$conn->query($sql1);
	if ($resultat->num_rows > 0) {
   		 while($row = $resultat->fetch_assoc()) {
        	echo "Le seuil haut est de :".$row["THRESHOLD_HIGH"]."&nbsp;&nbsp;degres<br>";
			echo "et le seuil minimal est de :".$row["THRESHOLD_LOW"]."&nbsp;&nbsp;degres<br>";
   			 }
     		echo"</table>";
  }
  // on affiche ensuite la derniere donnée de la température qui est arrivé dans la bdd
	$sql = "SELECT * FROM VALUE WHERE ID_SENSOR='2' AND ID_ROOM ='1' ORDER BY DTIME DESC LIMIT 1 ";
  global $conn;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
   		 while($row = $result->fetch_assoc()) {
        	echo "<tr>\n\t<th><strong>".$row["NUM"]."</strong>&nbsp;degrés";
   			 }
     		echo"</table>";
  }
}

function donneeChute(){
	// on affiche ensuite la derniere donnée de chute qui est arrivé dans la bdd
	$sql = "SELECT * FROM VALUE WHERE ID_SENSOR='4' AND ID_ROOM ='1' ORDER BY DTIME DESC LIMIT 1 ";
  global $conn;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
   		 while($row = $result->fetch_assoc()) {
			 if($row["NUM"] == 1 ){
				 echo '<br><br><br>la personne est tombé';
			 }
			 else{
				 echo'la personne est toujours debout';
				 }
  	}
  }
}

function donneeFour(){
	// on affiche ensuite la derniere donnée du four qui est arrivé dans la bdd
	$sql = "SELECT * FROM VALUE WHERE ID_SENSOR='5' AND ID_ROOM ='1' ORDER BY DTIME DESC LIMIT 1  ";
  global $conn;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
   		 while($row = $result->fetch_assoc()) {
			 if($row["NUM"] == 1){
				 echo 'le four est allumé';
			 }
			 else{
				 echo 'le four est éteint';
				 }
   		 }
	 }
}
function pas(){
	// on affiche ensuite la derniere donnée de pas qui est arrivé dans la bdd
	$sql = "SELECT * FROM VALUE WHERE ID_SENSOR='6' AND ID_ROOM ='1' ORDER BY DTIME DESC LIMIT 1  ";
  global $conn;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
   		 while($row = $result->fetch_assoc()) {
			 echo "<br>L'utilisateur a fait&nbsp;".$row["NUM"]."&nbsp;de pas la derniere heure";
   		 }
	 }
}

function ajout($login){
	// on ajoute un référent à l'utilisateur 
	if(isset($_POST['nom_']) && isset($_POST['prenom_']) && isset($_POST['mail_']) && isset($_POST['tel_'])){
			$sql = "INSERT INTO CONTACT (`LASTNAME_CON`, `FIRSTNAME_CON`, `MAIL_CONTACT`, `PASS_CON`) VALUES ('".$_POST['nom_']."','".$_POST['prenom_']."','".$_POST['mail_']."','".$_POST['pass_']."')";
			global $conn;
			$conn->query($sql);
	
			$sql1 = "INSERT INTO USER_CONTACT (`MAIL_CONTACT`, `MAIL_USER`) VALUES ('".$_POST['mail_']."', '".$login."')";
			global $conn;
			$conn->query($sql1);
			
			$sql2 = "INSERT INTO PHONE(`MAIL_CONTACT`, `NUMBER`) VALUES ('".$_POST['mail_']."','".$_POST['tel_']."')";
			global $conn;
			$conn->query($sql2);
	
	echo "<script type='text/javascript'>document.location.replace('utilisateur.php');</script>";
	
}
}
	

function AffichageHistorique($nombre){
	//on affiche les 10 dernieres données d'alerte qui sont aarivé dans la base de données
	$sql = "SELECT * FROM ALERT ORDER BY DTIME DESC LIMIT $nombre";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les détails</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["DETAIL"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}

function TableauCO2(){
	//on affiche toutes les valeurs du co2
	$sql ="SELECT * FROM VALUE WHERE ID_SENSOR = 1 AND ID_ROOM = 1 ORDER BY DTIME DESC";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les valeurs du CO2</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["NUM"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}
function TableauHumi(){
	//on affiche toutes les valeurs de l'humidité
	$sql ="SELECT * FROM VALUE WHERE ID_SENSOR = 3 AND ID_ROOM = 1 ORDER BY DTIME DESC";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les valeurs de l'humidité</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["NUM"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}
function TableauTemp(){
	//on affiche toutes les valeurs de la température
	$sql ="SELECT * FROM VALUE WHERE ID_SENSOR = 2 AND ID_ROOM = 1 ORDER BY DTIME DESC";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les valeurs de la Température</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["NUM"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}
function TableauChute(){
	//on affiche toutes les valeurs de la Chute
	$sql ="SELECT * FROM VALUE WHERE ID_SENSOR = 4 AND ID_ROOM = 1 ORDER BY DTIME DESC";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les valeurs de chute</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["NUM"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}
function TableauFour(){
	//on affiche toutes les valeurs du four
	$sql ="SELECT * FROM VALUE WHERE ID_SENSOR = 5 AND ID_ROOM = 1 ORDER BY DTIME DESC";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les valeurs du four</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["NUM"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}
function TableauPas(){
	//on affiche toutes les valeurs de pas
	$sql ="SELECT * FROM VALUE WHERE ID_SENSOR = 6 AND ID_ROOM = 1 ORDER BY DTIME DESC";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Nombre de pas</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["NUM"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
}

function Update($login){
	//on update les données de l'utilisateur(nom, prenom, mot de passe)
	if(isset($_POST['nom_new']) && isset($_POST['prenom_new'])  && isset($_POST['pass_new']) && isset($_POST['tel_new'])){
		$sql ="UPDATE USER  SET LASTNAME_USER = '".$_POST['nom_new']."', FIRSTNAME_USER ='".$_POST['prenom_new']."', PASS_USER = '".$_POST['pass_new']."' WHERE MAIL_USER = '".$login."'" ;	
	global $conn;
	$result = $conn->query($sql);
		echo "<script type='text/javascript'>document.location.replace('utilisateur.php');</script>";
		
	}
	
	
}
function deconnexion(){

	// On démarre la session
session_start ();
// On détruit les variables de notre session
session_unset ();
// On détruit notre session
session_destroy ();
// On redirige le visiteur vers la page d'accueil
header ('location: login.htm');
	
}

function Alerte($login){
	//on affiche la derniere alerte qui vient d'arriver
	$sql = "SELECT * FROM ALERT ORDER BY DTIME DESC LIMIT 1";
	global $conn;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    echo "<table><th>La date</th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Les détails</th><br>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>\n\t<th>".$row["DTIME"]."</th>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "\t<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["DETAIL"]."</th>";
    }
     echo"</table>";
     
  } else {
     echo "0 results";
  }
	
	
}

/*function UpdtadeRef($login){
	if(isset($_POST['nom_newr']) && isset($_POST['prenom_newr'])  && isset($_POST['pass_newr']) && isset($_POST['tel_newr'])){
		
		$sql = "UPDATE * FROM USER_CONTACT, CONTACT WHERE USER_CONTACT.MAIL_CONTACT = CONTACT.MAIL_CONTACT AND USER_CONTACT.MAIL_USER='".$login."' SET LASTNAME_CON = '".$_POST['nom_newr']."', FIRSTNAME_CON ='".$_POST['prenom_newr']."', PASS_CON = '".$_POST['pass_newr']."' WHERE MAIL_USER = '".$login."' ";
		echo $sql;
	global $conn;
	$result = $conn->query($sql);
		echo "<script type='text/javascript'>document.location.replace('utilisateur.php');</script>";
		
		
		
	}
	
	
}*/


 
 ?>
