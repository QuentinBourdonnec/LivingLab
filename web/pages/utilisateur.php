<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LivingLab</title>
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/utilisateur.css" rel="stylesheet">
<link rel="shortcut icon" href="../img/logo.png">
<?php
	 include "BDD.php";
	 session_start();
?>
</head>

<body>
<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	<li> <button type="submit" class="btn btn-default" name="deconnexion" value="deconnexion" onClick="{window.open('deconnexion.php','_parent');}">Se deconnecter</button> </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Accueil</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Graphes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a  onclick="{window.open('index.php','_parent');}">Nombre de pas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="utilisateur.php"><i class="fa fa-table fa-fw"></i> Données utilsateurs </a>
                        </li>
                        
					</ul>
				</div>
</div>
<div id="page-wrapper">
<h1>Votre profil</h1>
				<div class="container" >
						<div class="col-md-4 col-md-offset-1 col-lg-8">
              				  <div class="login-panel panel panel-default">
                    				<div class="panel-heading">
                       					 <h3 class="panel-title">Données personnelles </h3>
                    				</div>
                   			 		<div class="disp" id="perso">
                   						<?php
                                        affichDonne($_SESSION['login']);
										
										?>
                                     <img src="../img/crayon.png" class="crayon" onClick="{window.open('update.php','_parent');}" style="width:5%;">
                    				
               		 			</div>
       			 		</div>
				</div>
				<div class="container" >
						<div class="col-md-4 col-md-offset-1 col-lg-8">
              				  <div class="login-panel panel panel-default">
                    				<div class="panel-heading">
                       					 <h3 class="panel-title">Mes référents</h3>
                    				</div>
                   			 		<div class="disp" >
                   					<?php
										 affichRef($_SESSION['login']);
									?>
                                    <img src="../img/ajout.png" class="crayon" onClick="{window.open('Ajout.php','_parent');}" style="width:5%;">
                    				</div>
               		 			</div>
       			 		</div>
					</div>


				<div class="container" id="histo">
	      			 <div class="col-md-4 col-md-offset-1 col-lg-11">
               			 <div class="login-panel panel panel-default">
                   			 <div class="panel-heading">
                     			   <h3 class="panel-title">Historique des problèmes</h3>
                   			 </div>
                   			 <div>
                     		<?php 
								AffichageHistorique($nombre);
						    ?>
                   			 </div>
                 		 </div>
           			</div>
				</div>
		</div>
        
        <script>
  	$(document).ready(function() {
  // Appliquer un rafrachissement toute les 10 sec
  setInterval(function() {
    $('#histo').load('index.php #histo');
  }, 10000);
});
	</script>
</body>
</html>