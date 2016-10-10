<!Doctype html>
<html>
    <head>
<!-- pour spécifier au naviageteur comment afficher la page -->
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- le fichier css pour formater nos balises html -->
 <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
 <!-- importation du bibliothèque jquery et jquery pour les mobiles -->
 <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
 <script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
 <!-- importation du bibliothèque cordova ( phoneGap ) -->
 <script src="./src/src/cordova_b.js"></script>
 <script>
    function verify(){
      // code pour contrôler le login et le mot de passe
	  if ( $("#passwd").val() == "t" ) {
  alert(" welcome "+ $("#login").val() ) ;
 document.location.href="http://www.lorraine.nosterritoires.fr/analyse/pages/geoforetmobile.html";
  } else {
 // navigator.notification.vibrate(500);
  alert(" you are not welcomed ");
  
  }
     }
 </script>
 </head>
 <body>
 <!-- la page d'identification -->
 <div data-role="page" id="accueil" >
 <!-- l'entête -->
    <div data-role="header">
      <h1> Bienvenue <h1>
    </div>
 <!-- le contenu -->
    <div data-role="content">
      <p>
        <label for="login">Identifiant </label>
        <input type="text" name="login" id="login" value="" />
        <label for="login">Mot de passe </label>
        <input type="password" name="passwd" id="passwd" value="" />
     </p>
     <p>
       <input type="submit" name="submit" value="Valider" onclick="verify();" />
     </p>
   </div>
 <!-- le pied de page -->
   <div data-role="footer">
     <h3>CDA54</h3>
   </div>
 </div>
 </body>
</html>