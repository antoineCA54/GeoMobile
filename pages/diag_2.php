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
					layers: [cities],fullscreenControl: true
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

</script>
</body>
</html>