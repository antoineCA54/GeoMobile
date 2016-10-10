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
<script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet' />
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v0.0.2/Leaflet.fullscreen.min.js'></script>
<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v0.0.2/leaflet.fullscreen.css' rel='stylesheet' />
<link rel='stylesheet' href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.2/leaflet.draw.css' />
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.2/leaflet.draw.js'></script>
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-label/v0.2.1/leaflet.label.js'></script>
<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-label/v0.2.1/leaflet.label.css' rel='stylesheet' />
</head>
<body>
<div data-role="header" data-theme="g" data-position="fixed">
	<h5><small>Diagnostic agricole</small></h5>
	<a href="./rch_commune.php" rel="external" data-icon="home" data-iconpos="notext" data-transition="fade" >Accueil</a>
</div>
<div data-role="page=" id="page1">
	<div data-role="content" >
 <input type="text" name="rs" id="rs" value="" data-inset="true" placeholder="Raison sociale..."  />
		<h4>Afficher la carte</h4>
			<div id="map" style="width: 100%; height: 500px" > 

	</div>  		


	
</div>
	<script>

	afficher_centre_carte(1);
 


  
  
	function afficher_centre_carte(id){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'recherche_shape',
				rowid: id
					},
			success : function(data){
// Variable CARTE
				var mapId = "map" ;
// GROUPE DE COUCHES
     var cities = new L.LayerGroup();
// ORTHOS
var orthosWmtsUrl	= "http://gpp3-wxs.ign.fr/aa7rfg79gayebugx3yhpxul6/wmts?LAYER=ORTHOIMAGERY.ORTHOPHOTOS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;
var ORTHOS= L.tileLayer(orthosWmtsUrl, {attribution: '&copy; <a href="http://www.ign.fr/">IGN</a>'}); 	
//SCAN25				 	
// IGN Topo Scan Express Standard
var scanWmtsUrl	= "http://gpp3-wxs.ign.fr/aa7rfg79gayebugx3yhpxul6/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS.SCAN-EXPRESS.STANDARD&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;
var SCAN25= L.tileLayer(scanWmtsUrl, {attribution: '&copy; <a href="http://www.ign.fr/">IGN</a>'});
// OPENSTREETMAP  			       
var OSM = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a>'});

var obj =jQuery.parseJSON(data);
var row = obj[0];
var obj = jQuery.parseJSON(data);
		for(i=0;i<obj.length;i++){
		var tmp=obj[i];
				
				var shape= JSON.parse(tmp[0]);
var geojsonFeature = {
   				"type": "Feature",
				"properties": { 
					"popupContent": "Est fait"
				}, 
				"geometry": 
					shape
				
				};
L.geoJson(geojsonFeature).addTo(cities);
}
var map = L.map(mapId, {
					center: new L.LatLng(48.88,6.23),
					zoom: 15,
					layers: [ORTHOS,cities],fullscreenControl: true
				});
	
			
var featureGroup = L.featureGroup().addTo(map);
 var drawControl = new L.Control.Draw({
    edit: {
      featureGroup: featureGroup
    }
  }).addTo(map);
 map.on('draw:created', function(e) {
      featureGroup.addLayer(e.layer);
  });
var geos = JSON.stringify(cities.toGeoJSON());

alert
		

// GESTION DES COUCHES
var overlayMaps = {
    "Bâti agricole": cities
};

var baseMap = {"Photos aériennes":ORTHOS,"Ign Topo Express":SCAN25,"OpenStreetMap":OSM,"Zones vulnérables":ZV};
L.control.layers(overlayMaps).addTo(map);
				}
				});
L.control.fullscreen().addTo(map);
	}

function recupere_info(id) {
// FONCTION POUR RECUPERER LES INFOS DU BATIMENT
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
	
function afficher_bali(rs2){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'recherche_bali_2',
				nom : rs2
					},
			success : function(data){
					
				buffer1= '<ul data-role="listview" id="listView" data-theme="c" data-inset="true" data-mini="true">';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					buffer1=buffer1 + '<li>';
					buffer1=buffer1 + '<a href="#" id="vers"  data-inset="true"  onclick="dn(' + tmp[0] + ')">'+ tmp[1] +'</a>';
	                buffer1=buffer1 + '</li>';							
					}
				buffer1=buffer1 + '</ul>';
				
				$('#div_liste4').html(buffer1);
				$('#div_liste4').trigger('create');	
				
			
				}
				});
	}
function remplir_rs(r){
	$("#rs").val(r);
	$("#rs").focus();
	}
	function dn(id){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'recherche_info_bali',
				identifiant : id
					},
			success : function(data){
					
				var obj =jQuery.parseJSON(data);
				var row = obj[0];
				$("#rs").val(row[1]);
				$("#bali").val(row[0]);
				}
				});
	}
// CREATION DE LA LISTE DES ORIENTATIONS
// DANS CETTE VERSION PAS D IDENTIFIANT
function liste_orientation(){
$.ajax({
  type: 'POST',
  url: 'traitements2.php',
  data: {
    action: 'liste_des_orientations'   
  },
  success : function(data){	
    buffer1='<label for="orientation" class="select">Orientation technico-économique : </label>';
    buffer1=buffer1 + '<select name="orientation" id="orientation" data-native-menu="false" data-inline="true" data-theme="g">';
                
            
  buffer1=buffer1 + '<option value="0">Type orientation</option>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
				
					buffer1=buffer1 + '<option value="' + tmp[1] + '">'+ tmp[1] + '</option>';
					
					
					}
buffer1=buffer1 + '</select>';

				$('#b2').html(buffer1);
				$('#b2').trigger('create');
				
   }
  });

}
// CREATION DE LA LISTE DES NATURE DE BATIMENTS
function liste_batiment(){
$.ajax({
  type: 'POST',
  url: 'traitements2.php',
  data: {
    action: 'liste_des_batiments'   
  },
  success : function(data){	
    buffer1='<label for="bati-1" class="select">Nature du bâtiment : </label>';
    buffer1=buffer1 + '<select name="bati-1" id="bati-1" data-native-menu="false" data-inline="true" data-theme="g" onchange="mise_a_jour_nature()">';
                
            
  buffer1=buffer1 + '<option value="0">Nature du bâtiment</option>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];	
				
					buffer1=buffer1 + '<option value="' + tmp[0] + '">'+ tmp[1] + '</option>';
					
					
					}
buffer1=buffer1 + '</select>';

				$('#b1').html(buffer1);
				$('#b1').trigger('create');
				
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
// FONCTION DE MISE A JOUR DE LA FICHE
function mise_a_jour_bati(){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'changer_valeur_bati',
				rowid :getUrlParameter('id'),
				distance :$("#slider2").val(),
				structure: $("#structure").val(),
				raisonsociale: $("#rs").val() ,
				idbali: $("#bali").val(),
				orientation: $('#orientation option:selected').text(),
				norme: $('#norme').val(),
				forme: $('#forme').val(),
				

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
			url: 'traitements2.php',
			data: {
				action: 'changer_valeur_distance',
				rowid :getUrlParameter('id'),
				distance :$("#slider2").val()
					},
			success : function(data){


				}
				});
	}
// MISE A JOUR DE LA NATURE
function mise_a_jour_nature(){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'changer_valeur_nature',
				rowid :getUrlParameter('id'),
				type_bati: $('#bati-1').val(),
				bati: $('#bati-1 option:selected').text()
					},
			success : function(data){


				}
				});
	}
</script>
</body>
</html>