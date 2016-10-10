var map;
// GROUPE DE COUCHES

var cities = new L.LayerGroup();
var natura = new L.LayerGroup();
var zv = new L.LayerGroup();
var ppc = new L.LayerGroup();
var batiAgricole = new L.LayerGroup();
var sondage = new L.LayerGroup();
/* Single marker cluster layer to hold all clusters */
var markers = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: false,
  showCoverageOnHover: false,
  zoomToBoundsOnClick: true,
  disableClusteringAtZoom: 14
});
var markers_Bati = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: true,
  showCoverageOnHover: false,
  zoomToBoundsOnClick: true,
  disableClusteringAtZoom: 16});
var localIcon = L.icon({
	iconUrl: 'farm-24@2x.png',
	iconSize:	[24,24] // Taille de l'icone
	
});

    

        // Create the marker controls
        var marker_controls = new L.Control.SimpleMarkers();
        map.addControl(marker_controls);

// AFFICHAGE DES COUCHES
function onLocationFound(e){

		$.ajax({
			type: 'POST',
			url: 'ajax_map.php',
			data: {
				action: 'infoCadastre',
				lat: e.latlng.lng,
				lng: e.latlng.lat
					},
			success : function(data){
	cities.clearLayers();		
var obj =jQuery.parseJSON(data);
var row = obj[0];
var obj = jQuery.parseJSON(data);
		for(i=0;i<obj.length;i++){

		var tmp=obj[i];
		
				var rs = tmp[1];
				var title = tmp[1];
				var num = tmp[2];
				var dx = tmp[4];
				var dy = tmp[3];
				
				var shape= JSON.parse(tmp[0]);
var geojsonFeature = {
   				"type": "Feature",
				"properties": { 
					"secteur": tmp[1],
					"idu": tmp[2]
				}, 
				"geometry": 
					shape
				
				};

L.geoJson(geojsonFeature, {style:  styleIlot}).bindLabel(rs).addTo(cities).openPopup();;
L.marker([dy,dx], {icon: localIcon}).bindLabel(rs).addTo(cities).openPopup();		


	}
// Après la boucle

//affichageBdParcellaire54(e);
//affichagePpc(e);
//affichageBatiAgricole(e);
//affichageNatura(e);
//affichageSondage(e);

map.stopLocate();
				}
				});
}
// AFFICHAGE DE LA BDPARCELLAIRE
function affichageBdParcellaire54(e){

		$.ajax({
			type: 'POST',
			url: 'ajax_map.php',
			data: {
				action: 'infoBdParcellaire54',
				lat: e.latlng.lng,
				lng: e.latlng.lat
					},
			success : function(data){
natura.clearLayers();	
var obj =jQuery.parseJSON(data);
var row = obj[0];
var obj = jQuery.parseJSON(data);
		for(i=0;i<obj.length;i++){
		var tmp=obj[i];		
				var nomNatura = tmp[1];
				var dx = tmp[5];
				var dy = tmp[4];
				
				var shape= JSON.parse(tmp[0]);
var geojsonNatura = {
   				"type": "Feature",
				"properties": { 
					"secteur": tmp[1],
					"nom": tmp[2]

				}, 
				"geometry": 
					shape			
				};
L.geoJson(geojsonNatura , {style: styleIlot}).bindLabel(nomNatura, {noHide: false}).addTo(natura);
}		
var geos = JSON.stringify(natura.toGeoJSON());
}});}



// GESTION DES COUCHES VECTORIELLLES
var overlayMaps = { 
	"Données ": {
	"Cadastre 88 500m": cities
	//"BD Parcellaire 54": zv
	},
	"Autres": {
	//"BD Parcellaire 54": zv
	//"Natura2000": natura,
	//"PPC": ppc
	//"Sondages IGCS": sondage
	}
};


// ORTHOS
var orthosWmtsUrl	= "http://gpp3-wxs.ign.fr/aa7rfg79gayebugx3yhpxul6/wmts?LAYER=ORTHOIMAGERY.ORTHOPHOTOS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;
var ORTHOS= L.tileLayer(orthosWmtsUrl, {attribution: '&copy; <a href="http://www.ign.fr/">IGN</a>'}); 	
//SCAN25				 	
// IGN Topo Scan Express Standard
var scanWmtsUrl	= "http://gpp3-wxs.ign.fr/aa7rfg79gayebugx3yhpxul6/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS.SCAN-EXPRESS.STANDARD&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;
var SCAN25= L.tileLayer(scanWmtsUrl, {attribution: '&copy; <a href="http://www.ign.fr/">IGN</a>'});
// OPENSTREETMAP  			       
var OSM = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a>'});

// GESTION DSE COUCHES RASTER
var baseMap = {"OpenStreetMap":OSM,"Photos aériennes":ORTHOS,"Ign Topo Express":SCAN25};
/* L'écran de la légende s'affiche sur grand écran*/
if (document.body.clientWidth <= 767) {
  var isCollapsed = true;
  var estPleinEcran = false;
} else {
  var isCollapsed = false;
  var estPleinEcran = true;
}
map = L.map("map", {
	zoom: 16,
	layers: [OSM,cities],
	zoomControl: false,
	attributionControl: false,
	fullscreenControl: estPleinEcran
});
L.Control.Fullscreen
map.locate({
    setView: true,
    maxZoom: 19,
    watch: true,
    enableHighAccuracy: true,
    maximumAge: 10000,
    timeout: 10000,
	animate: true
  });


var layerControl = L.control.groupedLayers(baseMap,overlayMaps, {collapsed: isCollapsed }).addTo(map);




var zoomControl = L.control.zoom({
  position: "bottomright"
}).addTo(map);


// LANCEMENT DES TRAITEMENTS EN CAS DE LOCALISATION
map.on('locationfound',onLocationFound);


map.on('click', function(e) {
//map.clearLayers(ppc);

});




/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({
  position: "bottomright",
  drawCircle: false,
  follow: false,
  setView: true,
  keepCurrentZoomLevel: true,
  markerStyle: {
    weight: 1,
    opacity: 0.8,
    fillOpacity: 0.8
  },
  circleStyle: {
    weight: 1,
    clickable: false
  },
  icon: "icon-direction",
  metric: false,
  strings: {
    title: "My location",
    popup: "Vous êtes à moins de {distance} {unit} de ce point",
    outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
  },
  locateOptions: {
    maxZoom: 18,
    watch: false,
    enableHighAccuracy: true,
    maximumAge: 10000,
    timeout: 10000
  }
}).addTo(map);














// GESTION DSE STYLES
function getColorPpc(de) {
return 		de == 'RAPPROCHE' ? 	'red' :
	 	de == 'ELOIGNE' ? 	'blue' : 
				'white';
}


function style(feature) {
    return {
        fillColor: getColor(feature.properties.cultid),
        weight: 1.5,
        opacity: 1,
        color: getColor(feature.properties.cultid),
        fillOpacity:0.7
    };
}
function styleBati(feature) {
    return {
        fillColor: 'black',
        weight: 1.5,
        opacity: 1,
        color: 'white',
        fillOpacity:0.7
    };
}
function stylePpc(feature) {
    return {
        fillColor: getColorPpc(feature.properties.perimetre),
        weight: 3,
        opacity: 1,
        color: getColorPpc(feature.properties.perimetre),
	dashArray: '3',
        fillOpacity:0.1
    };
}
function style_com(feature) {
    return {
        fillColor: 'yellow',
        weight: 4,
        opacity: 1,
        color: 'yellow',
        dashArray: '3',
        fillOpacity:0.1
    };
}
function styleZv(feature) {
    return {
        fillColor: 'green',
        weight: 4,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity:0.3
    };
}
function onLocationError(e) {
    alert(e.message);
}

map.on('locationerror', onLocationError);
function styleIlot(feature) {
    return {
        fillColor: 'white',
        weight: 2,
        opacity: 1,
        color: 'black',
        dashArray: '2',
        fillOpacity:0.3
    };
}