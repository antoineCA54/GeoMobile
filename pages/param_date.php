<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIGAANALYSE</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
</head>
<body>
<div data-role="page">
	<div data-role="header" data-theme="a" data-position="fixed">
		<h1>SigaAnalyses</h1>
		<a href="./cultures_dates.php" rel="external" data-icon="back"  data-transition="fade" >Liste des cultures</a>
		<a href="./accueil.php" rel="external" data-icon="bars"  data-transition="fade" >Accueil</a>
	</div>
	<div data-role="content">
		<div  id="pri">
		</div>
		<div  id="datemax">
		</div>
	</div>
	<div data-role="footer" class="footer-docs" data-theme="a">
		<p>&copy; 2011-16 Chambres Agricultures Lorraine-Alsace</p>
	</div>
</div>
<script type="text/javascript">
localStorage.idculture=getUrlParameter('idculture')
		afficher_date_semis();
		afficher_date_recolte();
function afficher_date_semis(){
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			data: {
				action: 'parametre_date',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture,
				type_critere: 'semis'
					},
			success : function(data){	
				buffer1='<p><strong>Bienvenue.</strong> Gestion des dates de semis et de récolte</p>';
				buffer1=buffer1 + '<p><strong>Critère : </strong> Dates de semis</p>';
				
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					
					buffer1=buffer1 + '<label for="text-min">Date début</label>';		
					buffer1=buffer1 + '<input type="date" data-clear-btn="true" name="text-min_1" id="text-min_1" value="'+ tmp[2] +'">';
					buffer1=buffer1 + '<label for="text-max">Date fin</label>';	
					buffer1=buffer1 + '<input type="date" data-clear-btn="true" name="text-max_2" id="text-max_2" value="'+ tmp[3] +'">';
					buffer1=buffer1 + '<a href="#" data-role="button"  data-icon="check" data-theme="a" data-inline="true" onclick="ajout_dec_1()" >Valider dates semis</a>';
														
					}
				buffer1=buffer1 + '</ul>';
				$('#pri').html(buffer1);
				$('#pri').trigger('create');
				}
				});
	}
function afficher_date_recolte(){
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			data: {
				action: 'parametre_date',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture,
				type_critere: 'recolte'
					},
			success : function(data){	
				buffer1='<p><strong>Critère :</strong> Dates de récolte</p>';
				
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					buffer1=buffer1 + '<label for="text-min">Date début</label>';		
					buffer1=buffer1 + '<input type="date" data-clear-btn="true" name="text-min" id="text-min" value="'+ tmp[2] +'">';
					buffer1=buffer1 + '<label for="text-max">Date fin</label>';	
					buffer1=buffer1 + '<input type="date" data-clear-btn="true" name="text-max" id="text-max" value="'+ tmp[3] +'">';
					buffer1=buffer1 + '<a href="#" data-role="button"  data-icon="check" data-theme="a" data-inline="true" onclick="ajout_dec()" >Valider dates récolte</a>';
														
					}
				buffer1=buffer1 + '</ul>';
				$('#datemax').html(buffer1);
				$('#datemax').trigger('create');
				}
				});
	}	
	
	function ajout_dec()
	{
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			datatype: 'json',
			data: {
				action : 'changer_valeur_date',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture,
				type_critere: 'recolte',
				min : $('#text-min').val(),
				max : $('#text-max').val()
			},
			success : function(data){
				alert('Informations recolte mises à jour !');
			}
		});
	}
	function ajout_dec_1()
	{
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			datatype: 'json',
			data: {
				action : 'changer_valeur_date',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture,
				type_critere: 'semis',
				min : $('#text-min_1').val(),
				max : $('#text-max_2').val()
			},
			success : function(data){
				alert('Informations semis mises à jour !');
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
