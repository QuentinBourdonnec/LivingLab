<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Document sans titre</title>
<link href="../css/bootstrap.min.css"  rel="stylesheet" type="text/css">
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="../css/inscription.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../img/logo.png">
</head>

<body>
<?php
	include "BDD.php";
	inscription();
?>
	<script src="../js/inscription.js"></script>
    <script src="../js/jquery.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
    
   <div class="container ligne" id="MOUV">
            <div class="col-md-4 col-md-offset-1 col-lg-10">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Utilisateur</h3>
                    </div>
           <form method="post" action="" target="_parent">
                    <div id="1" >
	<div>
    	
        <div class="remonté">
        <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon2">Nom</span>
 			 <input type="text" class="form-control" placeholder="quentin" aria-describedby="basic-addon2" required name="nom_uti" value="<?php if (isset($_POST['nom_uti'])); ?>" onblur="verifPseudo(this)">
         </div><br>
         <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon2">Prénom</span>
 			 <input type="text" class="form-control" placeholder="quentin" aria-describedby="basic-addon2" required name="prenom_uti" value="<?php if (isset($_POST['prenom_uti'])); ?>" onblur="verifPseudo(this)">
         </div><br><br><br><br>
         <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon3">@</span>
 			 <input type="text" class="form-control" placeholder="*********@***.**" aria-describedby="basic-addon3" required name="mail_uti" value="<?php if (isset($_POST['mail_uti'])); ?>" onblur="verifMail(this)">
         </div><br>
         <div class="input-group col-lg">
 					 <span class="input-group-addon" id="basic-addon1">Password</span>
 					 <input type="password"class="form-control" placeholder="xxxxxxxxxxxxxx" aria-describedby="basic-addon1" required name="pass_uti" value="<?php if (isset($_POST['pass_uti'])); ?>" onblur="verifPseudo(this)">
      		    </div><br>
         <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon4" pattern="[0-9]{10}" required >Téléphone</span>
 			 <input type="text" class="form-control" placeholder="0*********" aria-describedby="basic-addon4" name="tel_uti"  require value="<?php if (isset($_POST['tel_uti'])); ?>" >
         </div><br>
        
          
       </div>
       </div>	 
</div>
                </div>
            </div>
            <div class="col-md-4 col-lg-10"></div>
   
   </div> 
   
   <div class="container ligne" id="mouve">
            <div class="col-md-4 col-md-offset-6 col-lg-10 col-lg-offset-2">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Referent</h3>
                    </div>
                    <div id="2">
	<div>
 	       <div class="remonté">
  	       		<div class="input-group col-lg">
 					 <span class="input-group-addon" id="basic-addon1">Nom</span>
 					 <input type="text" class="form-control" placeholder="tritan" aria-describedby="basic-addon1" required name="nom_ref" value="<?php if (isset($_POST['nom_ref'])); ?>" onblur="verifPseudo(this)">
      		    </div><br>
         		<div class="input-group col-lg">
          			   <span class="input-group-addon" id="basic-addon2">Prénom</span>
 					   <input type="text" class="form-control" placeholder="Quentin" aria-describedby="basic-addon2" required name="prenom_ref" value="<?php if (isset($_POST['prenom_ref'])); ?>" onblur="verifPseudo(this)">
        		 </div><br><br><br>
                 <div class="input-group col-lg">
             <span class="input-group-addon" id="basic-addon3">@</span>
 			 <input type="text" class="form-control" placeholder="*********@***.**" aria-describedby="basic-addon3" required name="mail_ref" value="<?php if (isset($_POST['mail_ref'])); ?>" onblur="verifMail(this)">
         </div><br>
                <div class="input-group col-lg">
 					 <span class="input-group-addon" id="basic-addon1">Password</span>
 					 <input type="password" class="form-control" placeholder="xxxxxxxxxxxxxx" aria-describedby="basic-addon1" required name="pass_ref" value="<?php if (isset($_POST['pass_ref'])); ?>" onblur="verifPseudo(this)">
      		    </div><br>
         		 <div class="input-group col-lg">
            		 <span class="input-group-addon" id="basic-addon4" pattern="[0-9]{10}">Téléphone</span>
 					 <input type="text" class="form-control" placeholder="0*********" aria-describedby="basic-addon4" required name="tel_ref"  value="<?php if (isset($_POST['tef_ref'])); ?>" onblur="checknum(this)">
         		</div><br>
        		<br>
           </div>
    </div>
       	 
</div>
                </div>
        
   </div>
   
         <input type="submit" name="valide" ">
            
            
   </div>
   </form>

	

</body>
</html>