function afficher_centre_carte(id){
		$.ajax({
			type: 'POST',
			url: 'ajax_map.php',
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
var geos = JSON.stringify(cities.toGeoJSON());


		

// GESTION DES COUCHES
var overlayMaps = {
    "Bâti agricole": cities
};

L.control.layers(overlayMaps).addTo(map);
				}
				});

	}
