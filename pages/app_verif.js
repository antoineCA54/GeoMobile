// AFFICHAGE DES COUCHES

listeUtilisateur();
function listeUtilisateur(){

		$.ajax({
			type: 'POST',
			url: 'ajax_verif.php',
			data: {
				action: 'recherche_utilisateur'
					},
				success : function(data){	
				buffer1='<select name="select_utilisateur" id="select-1" data-iconpos="left" onclick="afficherCulture()">';
				var obj =jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
					buffer1=buffer1 + '<option value="'+ tmp[0] + '">' + tmp[2] + '</option>';												
					}
				buffer1=buffer1 + '</select>';
				$('#pri').html(buffer1);
				$('#pri').trigger('create');
				}
				});
	}
function afficherCulture(){

		$.ajax({
			type: 'POST',
			url: 'ajax_verif.php',
			data: {
				action: 'rechercheCulture',
				rowid: $('#select-1').val()
					},
				success : function(data){	
				buffer2='<legend>Choix des cultures pour 2015 : </legend>';
				var obj =jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
					
					buffer2=buffer2 + '<label><input type="checkbox" name"ch" id="' + tmp[0] + '" value="' + tmp[0] +'" data-mini="true" onclick="afficherBouton()"/> '+ tmp[1] + '</label>';	
					}
				
					
				$('#pri2').html(buffer2);
				$('#pri2').trigger('create');
				}
				});
	}
	
function afficherBouton() {
buffer3='<button class="ui-shadow ui-btn ui-corner-all" onclick="newDemande()">Faire la demande</button>';
$('#pri3').html(buffer3);
$('#pri3').trigger('create');
}

function newDemande() {
var itemsCulture = new Array();
var resCulture;
$("input[type='checkbox']:checked").each(
		function() {
		itemsCulture += $(this).attr('id') + "|"

	});
resCulture =itemsCulture.substring(0,itemsCulture.length-1);
ajoutDemande(resCulture);
	}
function ajoutDemande(n){
$.ajax({
			type: 'POST',
			url: 'ajax_verif.php',
			data: {
				action: 'newDemande',
				idutilisateur: $('#select-1').val(),
				idculture: n
					},
				success : function(data){	
					var obj = jQuery.parseJSON(data);
					var row = obj[0];
						alert('Demande : '+row[0]+' Attendre deux minutes ');
				}
				});
}