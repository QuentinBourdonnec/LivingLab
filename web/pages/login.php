<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../img/logo.png">

</head>

<body>
<?php
 	include "BDD.php";
	session_start();
	connexion($_SESSION['login'], $_SESSION['pass']);
	
 ?>


	<h1> LivingLab</h1>
    

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4"> 
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Connectez-vous</h3>
                    </div>
                    <div class="panel-body">
                        <form action="login.php" method="post" target="_parent">
				
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="login" type="email" autofocus value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="pass" type="password" <?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>" >
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <div class="btn-group" role="group">
                                	<input type="hidden" name="" value="true" id="log">
    								<button type="submit" class="btn btn-default panel-green" name="connexion" value="Connexion">Login</button>
  								</div>
                             </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    	<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inscrivez-vous </h3>
                    </div>
                    <div class="panel-body">
                    <form role="form" target="_parent" action="inscription.php">
                    <fieldset>
                                <div class="form-group">
                                <label> Venez vous inscrire ici </label>
                                    <input type="submit" name="inscription"  onclick="{window.open('inscription.php','_parent');}">
                     </fieldset>
                     </form>
                     </div>
                     </div>
                </div>
            </div>
       </div>
   </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>