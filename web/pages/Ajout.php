<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>livinglab</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../img/logo.png">
<?php
 	include "BDD.php";
	session_start();
	ajout($_SESSION['login']);
	
 ?>
</head>

<body>
    <script src="../js/jquery.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
    
    
    <div class="col-md-4 col-md-offset-1 col-lg-4">
    <div class="login-panel panel panel-default">
             <div class="panel-heading">
                     <h3 class="panel-title">Ajouter un nouveau reférent </h3>
                </div>
             <form method="post" action="" target="_parent">
    		<div class="input-group col-lg">

             <span class="input-group-addon" id="basic-addon2">Nom</span>
 			 <input type="text" class="form-control" placeholder="quentin" aria-describedby="basic-addon2" name="nom_" value="<?php if (isset($_POST['nom_'])); ?>" onblur="verifPseudo(this)">
         </div><br>
         <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon2">Prénom</span>
 			 <input type="text" class="form-control" placeholder="quentin" aria-describedby="basic-addon2" name="prenom_" value="<?php if (isset($_POST['prenom_'])); ?>" onblur="verifPseudo(this)">
         </div><br><br><br><br>
         <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon3">@</span>
 			 <input type="text" class="form-control" placeholder="*********@***.**" aria-describedby="basic-addon3" name="mail_" value="<?php if (isset($_POST['mail_'])); ?>" onblur="verifMail(this)">
         </div><br>
         <div class="input-group col-lg">
 					 <span class="input-group-addon" id="basic-addon1">Password</span>
 					 <input type="password"class="form-control" placeholder="xxxxxxxxxxxxxx" aria-describedby="basic-addon1" name="pass_" value="<?php if (isset($_POST['pass_'])); ?>" onblur="verifPseudo(this)">
      		    </div><br>
         <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon4" pattern="[0-9]{10}" required >Téléphone</span>
 			 <input type="text" class="form-control" placeholder="0*********" aria-describedby="basic-addon4" name="tel_" value="<?php if (isset($_POST['tel_'])); ?>" >
         </div><br>
         <button type="submit" class="btn btn-default" name="ajout" value="ajout">Valider</button>
        
          </form>
       </div>
       </div>
    
</body>
</html>