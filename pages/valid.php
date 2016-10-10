<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIGAANALYSE</title>
<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.css" />
<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.min.css" />

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	
</head>
<body>	
<div data-role="page">
<div data-role="content">
<div id="mil" data-role="content-secondary">

</div>
<div id="div_choix_option"  data-role="content-secondary">
	
</div>
<div id="div_choix_option2"  data-role="content-secondary">
	
</div>
<div id="div_resultat" data-role="content-primary">

</div>
</div>
</div>
<script type="text/javascript">

afficher_options();


function afficher_options(){
	$.ajax({
		type: 'POST',
		url: 'traitements.php',
			data: {
			action: 'liste_utilisateur'
		},
		success : function(data){
			
			buffer= '<ul data-role="listview" data-theme="c" data-inset="true" data-dividertheme="g" >';
			buffer=buffer + '<li data-role="list-divider">Choix utilisateur</li>';
			var obj = jQuery.parseJSON(data);
			for(i=0;i<obj.length;i++){
				var tmp=obj[i];
				buffer=buffer + '<li><a href="#" data-inline="true" onclick="afficher_liste_millesime(' + tmp[0] + ')" >' + tmp[1] + '</a></li>';
				
										}
			buffer=buffer + '</ul>';
		
			$('#div_choix_option').html(buffer);
			$('#div_choix_option').trigger('create');	
			
			}
		});
}
function afficher_liste_millesime(idutilisateur){
	$.ajax({
		type: 'POST',
		url: 'traitements.php',
			data: {
			action: 'liste_millesime_valide',
			idutilisateur: idutilisateur
		},
		success : function(data){
			
			buffer= '<ul data-role="listview" data-theme="c" data-inset="true" data-dividertheme="g" >';
			buffer=buffer + '<li data-role="list-divider">Choix millésime</li>';
			var obj = jQuery.parseJSON(data);
			for(i=0;i<obj.length;i++){
				var tmp=obj[i];
				buffer=buffer + '<li><a href="#" data-inline="true" onclick="afficher_liste_idutilisateur(' + tmp[0] + ','+ tmp[1] +')" >' + tmp[0] + '</a></li>';
				
										}
			buffer=buffer + '</ul>';
		
			$('#div_choix_option2').html(buffer);
			$('#div_choix_option2').trigger('create');	
			
			}
		});
}
function afficher_liste_idutilisateur(millesime,idutilisateur)
	{
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			datatype: 'json',
			data: {
				action : 'liste_exploit_valide',
				idutilisateur: idutilisateur,
				millesime: millesime
			},
			success : function(data){
				
				
				buffer2= '<h4>Listes des exploitations : </h4>';
				buffer2=buffer2 + '<div data-role="fieldcontain" >';
				buffer2=buffer2 + '<fieldset data-role="controlgroup" data-inset="true" >';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
				var tmp=obj[i];
				buffer2=buffer2 + '<input type="checkbox" name="ch" id="ch' + tmp[0] + '" value="' + tmp[0] + '" class="custom"/>';
				buffer2=buffer2 + '<label for="ch' + tmp[0] + '">'+ tmp[1] + ' ('+ tmp[2] + ', ' + tmp[3] + ')</label>';
				}
				buffer2=buffer2 + '</fieldset>';
				buffer2=buffer2 + '</div>';
				buffer2=buffer2 +'<div data-role="fieldcontain" id="r">';
		buffer2=buffer2 + '<fieldset data-role="controlgroup" data-type="horizontal"  id="f1">';		
		buffer2=buffer2 + '<input type="radio" name="radio-view" id="radio-view-a" value="1"   />';
		buffer2=buffer2 + '<label for="radio-view-a">Ajouter</label>';
		buffer2=buffer2 + '<input type="radio" name="radio-view" id="radio-view-b" value="2"  />';
		buffer2=buffer2 + '<label for="radio-view-b">Enlever</label>';
		buffer2=buffer2 + '</fieldset>';
		buffer2=buffer2 + '</div>';		
		$('#div_resultat').html(buffer2);
		$('#div_resultat').trigger('create');
					// Définit l'evenement
		$('#r').change(function(){
		$('input[type=checkbox][name=ch]:checked').each(function(){
			
			afficher_resultat_recherche($(this).val(),millesime,idutilisateur);
			
		})
		});
		
	
			}
		});
	}

function afficher_resultat_recherche(idep,millesime,idutilisateur){
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			datatype: 'json',
			data: {
				action: 'test',
				idep : idep,
				idstatut : $('input[type=radio][name=radio-view]:checked').attr('value'),
				millesime: millesime,
				idutilisateur : idutilisateur
			},
			success : function(data){
			}
		})
	}	

				
</script>
<?php
	include_once("../inc_footer.php/footer_cda.inc.php");
?>	
</body>
</html>