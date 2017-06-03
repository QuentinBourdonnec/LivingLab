'use strict'
// JavaScript Document

function surligne(champ, erreur)
{
   if(erreur)
      champ.style.borderColor = "#FF0000";
   else
      champ.style.borderColor = "#3AF24B";
}
	
function verifPseudo(champ)
{
   if(champ.value.length < 2 || champ.value.length > 30)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}
function verifMail(champ)
{
   var mail = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!mail.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}
function checknum(num){
    var valide = /^0[1-7]\d{8}$/;
    if(valide.test(num)){
		
        surligne(num, false);
		return true;
    }
    else{
		surligne(num, true);
        return false;
    }
}
