<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Saisie</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
</head>
<body>	

	<div data-role="header" data-theme="a">
			<h1>Choix du statut...</h1>
</div>
	<div id="div_producteur" data-role="content">
	
	</div>

<script type="text/javascript">
	
    afficher_liste_objet();
    function afficher_liste_objet(){
		$.ajax({
			type: 'POST',
			url: 'ajax_objet.php',
			data: {
				action: 'liste_test'
			},
			success : function(data){	
				buffer='<select name="a" id ="a" data-native-menu="false" data-mini="true">';
				buffer=buffer + '<option>Options...</option>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					buffer=buffer + '<option value="' + tmp[0] + '">' + tmp[0] + '</option>';
										}
				buffer=buffer + '</select>';
				buffer=buffer + '<a href="" id="d" data-role="button" data-rel="back"  data-theme="b" >Valider</a>';
				$('#div_producteur').html(buffer);
				$('#div_producteur').trigger('create');				
				$('#d').click(function(){
					ajouter_participant(getUrlParameter('idpoint'),$('select#a').val());
										});
				}
				});
	}
function ajouter_participant(idpoint,idtypeabonnement)
	{
		$.ajax({
			type: 'POST',
			url: 'ajax_objet.php',
			datatype: 'json',
			data: {
				action : 'modifier_option',
				idpoint : idpoint,
				libelle : idtypeabonnement
			},
			success : function(data){
			window.close();
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