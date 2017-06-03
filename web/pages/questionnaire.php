<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>connexion</title>

<link href="../css/bootstrap.min.css"  rel="stylesheet" type="text/css">
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="../css/inscription.css" rel="stylesheet" type="text/css">
</head>

<body>
	<script src="../js/inscription.js"></script>
    <script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
    

<div id="2">
	<div class="mouv">
		<h2>Un Référent</h2>
 	       <div class="remonté">
           <form method="post" action="accueil.php" target="_parent">
  	       		<div class="input-group col-lg-3">
 					 <span class="input-group-addon" id="basic-addon1">Nom</span>
 					 <input type="text" class="form-control" placeholder="tritan" aria-describedby="basic-addon1" name="nom_ref" onblur="verifPseudo(this)">
      		    </div><br>
         		<div class="input-group col-lg-3">
          			   <span class="input-group-addon" id="basic-addon2">Prénom</span>
 					   <input type="text" class="form-control" placeholder="Quentin" aria-describedby="basic-addon2" name="prenom_ref" onblur="verifPseudo(this)">
        		 </div><br><br><br>
                <div class="input-group col-lg-3">
 					 <span class="input-group-addon" id="basic-addon1">Password</span>
 					 <input type="text" class="form-control" placeholder="xxxxxxxxxxxxxx" aria-describedby="basic-addon1" name="pass_ref" onblur="verifPseudo(this)">
      		    </div><br>
         		 <div class="input-group col-lg-3">
             		<span class="input-group-addon" id="basic-addon3">@</span>
 					<input type="text" class="form-control" placeholder="*********@***.**" aria-describedby="basic-addon3" name="mail-ref" onblur="verifMail(this)">
        		 </div><br>
         		 <div class="input-group col-lg-3">
            		 <span class="input-group-addon" id="basic-addon4">Téléphone</span>
 					 <input type="text" class="form-control" placeholder="0*********" aria-describedby="basic-addon4" name="tel_ref" onblur="verifNum(this)">
         		</div><br>
        		<br>
                <input type="hidden" name="validation">
                <button type="submit" class="btn btn-default" class="button" id="switch3" >valider</button>
                	</form>
           </div>
    </div>
       	 
</div> 

<div id="1" >
	<div class="mouv">
		<h2>Utilisateur</h2>
        <div class="remonté">
       <form  action="accueil.php" target="_parent" method="post">
        <div class="input-group col-lg-3" class="remonté">
 			 <span class="input-group-addon" id="basic-addon1">Nom</span>
 			 <input type="text" class="form-control" placeholder="tritan" aria-describedby="basic-addon1" name="nom_uti" onblur="verifPseudo(this)">
         </div><br>
         <div class="input-group col-lg-3">
             <span class="input-group-addon" id="basic-addon2">Prénom</span>
 			 <input type="text" class="form-control" placeholder="quentin" aria-describedby="basic-addon2" name="prenom_uti" onblur="verifPseudo(this)">
         </div><br>
         <div class="input-group col-lg-3">
             <span class="input-group-addon" id="basic-addon3">@</span>
 			 <input type="text" class="form-control" placeholder="*********@***.**" aria-describedby="basic-addon3" name="mail_uti" onblur="verifMail(this)">
         </div><br>
         <div class="input-group col-lg-3">
 					 <span class="input-group-addon" id="basic-addon1">Password</span>
 					 <input type="text" class="form-control" placeholder="xxxxxxxxxxxxxx" aria-describedby="basic-addon1" name="pass_uti" onblur="verifPseudo(this)">
      		    </div><br>
         <div class="input-group col-lg-3">
             <span class="input-group-addon" id="basic-addon4">Téléphone</span>
 			 <input type="text" class="form-control" placeholder="0*********" aria-describedby="basic-addon4" name="tel_uti" onblur="checknum(this)">
         </div><br>
         <div class="input-group col-lg-3">
         	<span class="input-group-addon" id="basic-addon5 age" onblur="verifDest(this)">Age</span>
       			<select name="age_uti" id="age">
                	   <option value="age">xxxx</option>
        			   <option value="age">1980</option>
         			   <option value="age">1981</option>
          			   <option value="age">1982</option>
           			   <option value="age">1983</option>
			           <option value="age">1984</option>
			           <option value="age">1985</option>
			           <option value="age">1986</option>
			           <option value="age">1987</option>
                       <option value="age">1988</option>
         			   <option value="age">1989</option>
          			   <option value="age">1990</option>
           			   <option value="age">1991</option>
			           <option value="age">1992</option>
			           <option value="age">1993</option>
			           <option value="age">1994</option>
			           <option value="age">1995</option>
                       <option value="age">1996</option>
         			   <option value="age">1997</option>
          			   <option value="age">1998</option>
           			   <option value="age">1999</option>
			           <option value="age">2000</option>
			           <option value="age">2001</option>
			           <option value="age">2002</option>
			           <option value="age">2003</option>
                       <option value="age">2004</option>
         			   <option value="age">2005</option>
          			   <option value="age">2006</option>
           			   <option value="age">2007</option>
			           <option value="age">2008</option>
			           <option value="age">2009</option>
			           <option value="age">2010</option>
			           <option value="age">2011</option>
                       <option value="age">2012</option>
                       <option value="age">2013</option>
         			   <option value="age">2014</option>
          			   <option value="age">2015</option>
           			   <option value="age">2016</option>
			           <option value="age">2017</option>
       			</select>
         </div><br>

         <div class="input-group col-lg-3">
         		<span class="input-group-addon" id="basic-addon6">Sexe</span>
       			<select name="sexe_uti" id="sexe">
        			   <option value="age">Homme</option>
                       <option value="age">Femme</option>
                </select>
         
         </div>
         <input type="hidden" value="true" name="loginB">
         <br><button type="button" class="btn btn-default" class="button" id="switch1">Continuer</button>
         </form>
       </div>
       </div>	 
</div>

</body>
</html>