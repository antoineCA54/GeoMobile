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
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v0.0.2/Leaflet.fullscreen.min.js'></script>
<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v0.0.2/leaflet.fullscreen.css' rel='stylesheet' />
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-label/v0.2.1/leaflet.label.js'></script>
<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-label/v0.2.1/leaflet.label.css' rel='stylesheet' />
</head>
<body>
<div data-role="header" data-theme="g" data-position="fixed">
	<h5><small>Diagnostic agricole</small></h5>
	<a href="./rch_commune.php" rel="external" data-icon="home" data-iconpos="notext" data-transition="fade" >Accueil</a>
</div> 		


	<div data-role="collapsible" data-collapsed="false" id="infos">
		<h4>Infos exploitation</h4>
		<fieldset data-role="fieldcontain"> 
			<ul data-role="listview" data-inset="true">
				<li data-role="fieldcontain">
					<input type="search" name="siret" id="siret" value="" data-inset="true" placeholder="SIRET" onchange="rech_siret()"/>
				</li>
				<li data-role="fieldcontain">
        				<div id="div_liste5" data-role="content"></div>
    			      </li>
				<li data-role="fieldcontain">
					<input type="text" name="rs" id="rs" value="" data-inset="true" placeholder="Raison sociale..." />
					<input type="text" name="infosiret" id="infosiret" value="" data-inset="true" />
					<input type="text" name="bali" id="bali" value="" data-inset="true" />
					<input type="text" name="idexploitation" id="idexploitation" value="" data-inset="true" />
				</li>

				<li data-role="fieldcontain">

					<label for="norme">Type d'installation : </label>
					<select name="norme" id="norme" data-role="slider" data-track-theme="g" data-theme="g" onchange="maj_statut()">
						<option value="ICPE">ICPE</option>
						<option value="RSD">RSD</option>
					</select>


				</li>

		<li data-role="fieldcontain">

					<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
    <legend>Localisation du bâtiment</legend>
        <input type="radio" name="radio-choice-b" id="radio-choice-c" value="Intérieur" checked="checked">
        <label for="radio-choice-c">Intérieur</label>
        <input type="radio" name="radio-choice-b" id="radio-choice-d" value="Périphérique">
        <label for="radio-choice-d">Périphérique</label>
        <input type="radio" name="radio-choice-b" id="radio-choice-e" value="Extérieur">
        <label for="radio-choice-e">Extérieur</label>
</fieldset>
				</li>
				
			</ul>
		<fieldset data-role="fieldcontain"> 
				<a href="#" data-role="button" id="modif" rel="external" data-icon="flat-plus" data-theme="b"  data-transition="fade" data-inline="true" onclick="mise_a_jour_bati()" >Modifier</a>
		</fieldset>
		</fieldset>

		<h4>Infos bâtiment</h4>		
    		<fieldset data-role="fieldcontain"> 
			<ul data-role="listview" data-inset="true">
				
				<li data-role="fieldcontain">
        				<div id="b1"></div>
    			</li>
				<li data-role="fieldcontain">
        				<div id="b3"></div>
    			</li>

				<li data-role="fieldcontain">
            				<label for="slider2">Distance en m :</label>
            				<input type="range" name="slider2" id="slider2" value="0" min="0" max="100" step="5" data-highlight="true" onchange="mise_a_jour_distance()" >
     				</li> 

				
			</ul>
    		</fieldset>
	</div>
</div>
	<script>
	
	liste_categorie();
    //liste_orientation();
  	//recupere_info(getUrlParameter('id'));
	//afficher_centre_carte(getUrlParameter('id'));
 var idbati;
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
function afficher_la_distance_2(){
$.ajax({
  type: 'POST',
  url: 'ajax_bati.php',
  data: {
    action: 'quelle_distance'  ,
	idbati: $('#batiment-1').val(),
       rowid :getUrlParameter('id'),
	norme: $('#norme').val()
  },
  success : function(data){	
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
var tmp=obj[i];
					$("#slider2").val(tmp[0]).slider('refresh');
					
					}
   }
  });

}  
 
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
					buffer11=buffer11 + '<a href="#" id="vers"  data-inset="true"  onclick="dn(' + tmp[0] + ')">'+ tmp[2] +'</a>';
	                		buffer11=buffer11 + '</li>';							
					}
				buffer11=buffer11 + '</ul>';
				
				$('#div_liste5').html(buffer11);
				$('#div_liste5').trigger('create');	
				
			
				}
				});

}  
// MISE AJOUR DS CHAMPS
function remplir_rs(r){
	$("#rs").val(r);
	$("#rs").focus();
	}
// On renseigne les infos bali
function dn(id){
		$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'recherche_info_mesparcelles',
				idexploitation : id
					},
			success : function(data){
					
				var obj =jQuery.parseJSON(data);
				var row = obj[0];
				$("#rs").val(row[1]);
				$("#bali").val(row[0]);
				$("#infosiret").val(row[3]);
				$("#idexploitation").val(id);
				$("#norme").val(row[4]).slider('refresh');
				}
				});
	}
function maj_statut() {
$.ajax({
			type: 'POST',
			url: 'ajax_bati.php',
			data: {
				action: 'maj_statut_i',
				idexploitation : $("#idexploitation").val(),
				norme:$("#norme").val()
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
				action: 'maj_fiche_exploitation',
				rowid :getUrlParameter('id'),
				siret: $("#infosiret").val(),
				raisonsociale: $("#rs").val() ,
				idexploitation: $("#idexploitation").val(),
				norme: $('#norme').val()

				

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
				action: 'changer_valeur_distance',
				rowid :getUrlParameter('id'),
				distance :$("#slider2").val()
					},
			success : function(data){


				}
				});
	}


// FONCTION POUR RECUPERER LES INFOS DU EXPLOITATION
function recupere_info(id) {

		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'info_du_bati',
				rowid : id
					},
			success : function(data){
					var obj =jQuery.parseJSON(data);
					var row = obj[0];
						$("#rs").val(row[5]);
						$("#norme").val(row[11]).slider('refresh');

						$('#radio1').checkboxradio("refresh");
						//$('input[type=radio][id=row[8]').attr("checked",true).checkboxradio("refresh");
						$("#slider2").val(row[7]).slider('refresh');
						$('#structure').val(row[9]);
						$('#structure').selectmenu("refresh",true);
						$('#orientation').val(row[10]);
						$('#orientation').selectmenu("refresh",true);
						$('#forme').val(row[8]);
						$('#forme').selectmenu("refresh",true);
						$("#bali").val(row[13]);
						$('#bati-1').val(row[12]);
						$('#bati-1').selectmenu("refresh",true);


						

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