<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>GAMP</title>

<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.css" />
<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.min.css" />

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>
<div data-role="page">
<div data-role="header" data-theme="g" data-position="fixed">
	<h5><small>Diagnostic agricole</small></h5>
	<a href="./rch_commune.php" rel="external" data-icon="home" data-iconpos="notext" data-transition="fade" >Accueil</a>
</div> 		


	<div data-role="content"  id="infos">
		<h4>Infos exploitation</h4>
		<fieldset data-role="fieldcontain"> 
			<ul data-role="listview" data-inset="true">
				<li data-role="fieldcontain">
					<input type="search" name="siret" id="siret" value="" data-inset="true" placeholder="Saisir une commune,une raison sociale ou le siret" onchange="rech_siret()"/>
					
				</li>
				<li data-role="fieldcontain">
        				<div id="div_liste5" data-role="content"></div>
    			      </li>
				<li data-role="fieldcontain">
					<label for="rs">Raison sociale : </label>
					<input type="text" name="rs" id="rs" value="" data-inset="true" placeholder="Raison sociale..." />
					<!-- <span><a href="#" data-role="button" id="modifrs" rel="external" data-icon="refresh" data-theme="b"   data-transition="fade" data-inline="true" onclick="mise_a_jour_rs()" >Mise à jour de la raison sociale</a> -->
				<li>
				<li data-role="fieldcontain">
					<label for="infosiret">Siret </label>
					<input type="text" name="infosiret" id="infosiret" value="" data-inset="true" />
					<input type="text" name="bali" id="bali" value="" data-inset="true" class="ui-hidden-accessible"/>
					<input type="text" name="idsiret" id="idsiret" value="" data-inset="true" class="ui-hidden-accessible" />
					<input type="text" name="idexploitation" id="idexploitation" value="" data-inset="true" class="ui-hidden-accessible"/>
				</li>
				<li data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" id="f2" onchange="maj_statut_2()">
    						<legend>Type installation :</legend>
        						<input type="radio" name="radio-choice-bb" id="radio-choice-bc" value="ICPE">
        						<label for="radio-choice-bc">ICPE</label>
        						<input type="radio" name="radio-choice-bb" id="radio-choice-bd" value="RSD">
        						<label for="radio-choice-bd">RSD</label>
        						<input type="radio" name="radio-choice-bb" id="radio-choice-be" value="AUCUN">
        						<label for="radio-choice-be">AUCUN</label>
					</fieldset>
				</li>	
			</ul>
		<fieldset data-role="fieldcontain"> 
				<a href="#" data-role="button" id="modif" rel="external" data-icon="flat-plus" data-theme="b"  data-transition="fade" data-inline="true" onclick="mise_a_jour_bati()" >Enregistrer pour ce bâtiment uniquement</a>
				<a href="#popupInfo" data-rel="popup" data-role="button" class="ui-icon-alt" data-inline="true" data-transition="pop" data-icon="info" data-theme="g" data-iconpos="notext">Informations</a>
					<div data-role="popup" id="popupInfo" class="ui-content" data-theme="b" style="max-width:350px;">
  						<p>Ici il s'agit de modifier les informations concernant l'exploitation</p>
					</div>		
		</fieldset>
	</fieldset>

		<h4>Infos bâtiment</h4>		
    		<fieldset data-role="fieldcontain"> 
			<ul data-role="listview" data-inset="true">
				<li data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" id="f1" onchange="majLocalisation()">
    						<legend>Localisation du bâtiment</legend>
        						<input type="radio" name="radio-choice-b" id="radio-choice-c" value="interieur">
        						<label for="radio-choice-c">Intérieur</label>
        						<input type="radio" name="radio-choice-b" id="radio-choice-d" value="peripherique">
        						<label for="radio-choice-d">Périphérique</label>
        						<input type="radio" name="radio-choice-b" id="radio-choice-e" value="exterieur">
        						<label for="radio-choice-e">Extérieur</label>
					</fieldset>
				</li>
				<li data-role="fieldcontain">
        				<div id="b1"></div>
					<div><a href="#popupInfo2" data-rel="popup" data-role="button" class="ui-icon-alt" data-inline="true" data-transition="pop" data-icon="info" data-theme="g" data-iconpos="notext">Informations</a>
					<div data-role="popup" id="popupInfo2" class="ui-content" data-theme="b" style="max-width:350px;">
  						<p>Choisir la catégorie du bâtiment puis le type de bâtiment</p>
					</div>
    				</li>
				<li data-role="fieldcontain">
        				<div id="b3"></div>

					<input type="text" name="bati_enr" id="bati_enr" value="" data-inset="true"  />

    				</li>

				<li data-role="fieldcontain">
            				<label for="slider2">Distance en m :</label>
            				<input type="range" name="slider2" id="slider2" value="0" min="0" max="100" step="5" data-highlight="true" onchange="mise_a_jour_distance()" >
     				</li> 
				<li data-role="fieldcontain">
					<label>
					<input type="checkbox" name="photovol" id="photovoltaique" class="custom" value="0" onchange="maj_photov()">Photovoltaique
					</label>
				</li>
				<li data-role="fieldcontain">
					<label for="norme">Changement de destination ? </label>
					<select name="btDestination" id="sliderDestination" data-role="slider" data-track-theme="g" data-theme="g" onchange="maj_destination()">
						<option value="non">non</option>
						<option value="oui">oui</option>
					</select>
				</li>
				
			</ul>
    		</fieldset>
	</div>
</div>
</div>
	<script>
	
// On affiche la liste des catégories de bâtiments disponibles
	liste_categorie();
// On affecter le insee_comm 
	affecter_insee_comm(getUrlParameter('id'));
// Mise à jour des informations de l'entité ouverte
  	recupere_info(getUrlParameter('id'));
// Données cartographiques
//afficher_centre_carte(getUrlParameter('id'));
$( window ).resize(function() {
  $( "#log" ).append( "<div>Handler for .resize() called.</div>" );
});
// Déclarations de variables
 var idbati;
// Rassemble les géométries
function affecter_insee_comm(id){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'affecterInseeComm',
				rowid :id
					},
			success : function(data){


				}
				});
	}
// MISE A JOUR DE LA RAISON SOCIAL
function mise_a_jour_rs(){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'majrs',
				siret:$('#infosiret').val(),
				rs: $("#rs").val()
					},
			success : function(data){


				}
				});
	}
// CREATION DE LA LISTE DES CATEGORIES DE BATIMENTS
// DAns B1
function liste_categorie(){
$.ajax({
  type: 'POST',
  url: 'ajax_bati.php',
  data: {
    action: 'liste_des_categories'   
  },
  success : function(data){	
    buffer1='<label for="cate-1" class="select">Catégorie du bâtiment : </label>';
    buffer1=buffer1 + '<select name="cate-1" id="cate-1" data-native-menu="false" data-inline="true" data-theme="g" onchange="afficher_les_batiments()">';
                
            
  buffer1=buffer1 + '<option value="0">Catégorie du bâtiment</option>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
				
					buffer1=buffer1 + '<option value="' + tmp[0] + '">'+ tmp[1] + '</option>';
					
					
					}
buffer1=buffer1 + '</select>';

				$('#b1').html(buffer1);
				$('#b1').trigger('create');
				idbati=0;
   }
  });

}
// CREATION DE LA LISTE DES BATIMENTS SELON LA CATEGORIE
// DAns B3
function afficher_les_batiments(){
$.ajax({
  type: 'POST',
  url: 'ajax_bati.php',
  data: {
    action: 'liste_des_batiments'  ,
	categorie: $('#cate-1').val()
  },
  success : function(data){	

    buffer1='<label for="batiment-1" class="select">Nature du bâtiment : </label>';
    buffer1=buffer1 + '<select name="batiment-1" id="batiment-1" data-native-menu="false" data-inline="true" data-theme="g" onchange="afficher_la_distance_2()">';
   buffer1=buffer1 + '<option value="0">Nature du bâtiment</option>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
				
					buffer1=buffer1 + '<option value="' + tmp[1] + '">'+ tmp[0] + '</option>';
					idbati=tmp[1];
					
					}
buffer1=buffer1 + '</select>';

				$('#b3').html(buffer1);
				$('#b3').trigger('create');
   }
  });

}
// AFFICHER LA DISTANCE
// On cherche la distance en fonction du statut (#norme) et du bâtiment (idbati)
function afficher_la_distance_2(){
$.ajax({
  type: 'POST',
  url: 'ajax_bati.php',
  data: {
    action: 'quelle_distance'  ,
	idbati: $('#batiment-1').val(),
       rowid :getUrlParameter('id'),
	norme: $('input[type=radio][name=radio-choice-bb]:checked').val()
  },
  success : function(data){	
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
var tmp=obj[i];
// Mise à jour du slider de la distance qui va déclencher la création de l'objet géométrique dans sb_data_2
					$("#slider2").val(tmp[0]).slider('refresh');
					
					}
   }
  });

}  
// RECHERCHE DE L INFORMATION EXPLOITATION EN FONCTION DU SIRET OU DU NOM DE L EXPLOITATION 
// LA RECHERCHE SE FAIT DANS MESPARCELLES
function rech_siret(){
$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'recherche_siret',
				siret : $('#siret').val()
					},
			success : function(data){
					
				buffer11= '<ul data-role="listview" id="listView" data-theme="c" data-inset="true" data-mini="true">';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					buffer11=buffer11 + '<li>';
					buffer11=buffer11 + '<a href="#" id="vers"  data-inset="true"  onclick="dn(' + tmp[0] + ',' + tmp[1] +')">'+ tmp[2] +'</a>';
	                		buffer11=buffer11 + '</li>';							
					}
				buffer11=buffer11 + '</ul>';
				
				$('#div_liste5').html(buffer11);
				$('#div_liste5').trigger('create');	
				
			
				}
				});

}  
// MISE AJOUR DS CHAMPS --> OBSOLETE
function remplir_rs(r){
	$("#rs").val(r);
	$("#rs").focus();
	}
// RESULTAT ET AFFICHAGE DU RESULTAT DE LA RECHERCHE DES INFOS EXPLOITATIONS DEPUIS MESPARCELLES
function dn(id,s){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'recherche_info_mesparcelles',
				idexploitation : id,
				siret: s
					},
			success : function(data){
					
				var obj =jQuery.parseJSON(data);
				var row = obj[0];
				$("#rs").val(row[1]);
				$("#bali").val(row[0]);
				$("#infosiret").val(row[3]);
				$("#idexploitation").val(row[2]);
				$("#idsiret").val(row[3]);
				$('input[type=radio][name=radio-choice-bb][value=' + row[4] + ']').attr("checked",true).checkboxradio("refresh");
				}
				});
	}
// MAJ DES TABLES REF_EXPLOITATION DES QUE L ON CHANGE LE STATUT
// CECI POUR ETENDRE L INFO
function maj_statut() {
$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'maj_statut_i',
				idexploitation : $("#idexploitation").val(),
				siret : $("#infosiret").val(),
				norme:$("#norme").val()
					},
			success : function(data){
					

				}
				});
}
function maj_statut_2() {
$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'maj_statut_i',
				idexploitation : $("#idexploitation").val(),
				siret : $("#infosiret").val(),
				norme:$('input[type=radio][name=radio-choice-bb]:checked').val()
					},
			success : function(data){
					

				}
				});
}
// MISE A JOUR DE LA DESTINATION DU BATIMENT
function maj_destination() {
$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'majDestination',
				rowid :getUrlParameter('id'),
				destination:$("#sliderDestination").val()
					},
			success : function(data){
					

				}
				});
}
// FONCTION DE MISE A JOUR DE PHOTOVOLTAIQUE
function maj_photov() {
$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'maj_photov',
				rowid :getUrlParameter('id'),
				pho: $('#photovoltaique').is(':checked')
},
			success : function(data){
					

				}
				});
}
// FONCTION MAJ localisation
function majLocalisation()
{
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'majLocalisation',
				rowid :getUrlParameter('id'),
				localisation: $('input[type=radio][name=radio-choice-b]:checked').val()

					},
			success : function(data){

				}
				});
	}
// FONCTION DE MISE A JOUR DE LA FICHE
function mise_a_jour_bati(){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'maj_fiche_exploitation2',
				rowid :getUrlParameter('id'),
				siret: $("#infosiret").val(),
				raisonsociale: $("#rs").val() ,
				idexploitation: $("#idexploitation").val(),
				idsiret: $("#idsiret").val(),
				norme: $('input[type=radio][name=radio-choice-bb]:checked').val(),
				localisation: $('input[type=radio][name=radio-choice-b]:checked').val()


				

					},
			success : function(data){

	$('#modif').attr("data-theme", "g").removeClass("ui-btn-up-e").addClass("ui-btn-up-c");
				}
				});
	}
// MISE A JOUR DE LA DISTANCE
function mise_a_jour_distance(){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'changer_valeur_distance_3',
				rowid :getUrlParameter('id'),
				distance :$("#slider2").val()
					},
			success : function(data){


				}
				});
	}
// Rassemble les géométries
function rassemblerGeom(){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'rassemblerGeometrie',
				rowid :getUrlParameter('id')
					},
			success : function(data){


				}
				});
	}
// FONCTION POUR RECUPERER LES INFOS DU EXPLOITATION
function recupere_info(id) {

		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'info_du_bati',
				rowid : id
					},
			success : function(data){
					var obj =jQuery.parseJSON(data);
					var row = obj[0];
			// Raison sociale 
						$("#rs").val(row[2]);
			// STATUT ICPE OU RSD
						//$("#norme").val(row[4]).slider('refresh');
						$('input[type=radio][name=radio-choice-bb][value=' + row[4] + ']').attr("checked",true).checkboxradio("refresh");
			// DISTANCE
						$("#slider2").val(row[5]).slider('refresh');
			// CATEGORIE DE BATIMENT
						$('#cate-1').val(row[10]);
						$('#cate-1').selectmenu("refresh",true);
			// NATURE
						$('#batiment-1').val(row[1]);
						$('#batiment-1').selectmenu("refresh",true);
						$("#bati_enr").val(row[1]);

			//SIRET
						$("#infosiret").val(row[6]);
						$("#idsiret").val(row[6]);
			// SITUATION
			//bali
						$("#bali").val(row[7]);
			//idexploitation MP
						$("#idexploitation").val(row[8]);
			// LOCALISATION
						$('input[type=radio][name=radio-choice-b][value=' + row[3] + ']').attr("checked",true).checkboxradio("refresh");
			//DESTINATION
						$("#sliderDestination").val(row[13]).slider('refresh');
			// PHOTOVOLTAIQUE

				if (row[12] == 'true') {
						$('input[type=checkbox][id=photovoltaique]').attr("checked",true).checkboxradio("refresh");
							}
else { $('input[type=checkbox][id=photovoltaique]').attr("checked",false).checkboxradio("refresh");
}




						

					}
				});
			}

function getUrlParameter(name) 
{
     var searchString = location.search.substring(1).split('&');
 
    for (var i = 0; i < searchString.length; i++) {
 
        var parameter = searchString[i].split('=');
        if(name == parameter[0])    return parameter[1];
 
    }
 
    return false;
}
</script>
</body>
</html>