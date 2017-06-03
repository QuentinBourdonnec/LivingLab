<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../img/logo.png">
<?php
 	include "BDD.php";
	session_start();
	connexion($_SESSION['login'], $_SESSION['pass']);
	
 ?>
</head>

<body>
    <script src="../js/jquery.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
    <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	<li> LivingLab </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Accueil</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Graphes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#ici">Nombre de pas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="utilisateur.php"><i class="fa fa-table fa-fw"></i> Données utilsateurs </a>
                        </li>
                        
					</ul>
				</div>
</div>

	<div class="page-header container">
    <h2>Four<small> Historique</small></h2>
  </div>


<div id="deplacement">
	<div class="row">
                <div class="col-lg-5 col-lg-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Tableau de donnée du four
                                
                            </div>
                            <div>
                           
                            <?php
								TableauFour();
							?>
                            </div>
                        </div>
                    </div>
                </div>   </div>
 </div>
    
</body>
</html>