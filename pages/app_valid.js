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
				buffer1='<select name="select_utilisateur" id="select-1" data-iconpos="left" onclick="afficherExploitations()">';
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
function afficherExploitations(){

		$.ajax({
			type: 'POST',
			url: 'ajax_verif.php',
			data: {
				action: 'rechercheExploitation',
				rowid: $('#select-1').val()
					},
				success : function(data){	
				buffer2='<legend>Listes de exploitations : </legend>';
				var obj =jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
					
					buffer2=buffer2 + '<label><input type="checkbox" name"ch" id="' + tmp[0] + '" value="' + tmp[0] +'" data-mini="true" ' + tmp[2] + '" onclick="ajoutDemande('+tmp[0]+')"/> '+ tmp[1] + '</label>';	
					}
				
					
					
				$('#pri2').html(buffer2);
				$('#pri2').trigger('create');
				// On va cocher les cases
				//cocherCase();
				}
				});
	}



function ajoutDemande(n){
$.ajax({
			type: 'POST',
			url: 'ajax_verif.php',
			data: {
				action: 'enregistrerValidation',
				idutilisateur: $('#select-1').val(),
				idexploitation: n
					},
				success : function(data){	
					var obj = jQuery.parseJSON(data);
					var row = obj[0];
						alert('Changement validé !');
				}
				});
}