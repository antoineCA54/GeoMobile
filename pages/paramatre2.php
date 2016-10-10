
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
<a href="./accueil.php" rel="external" data-icon="bars" data-iconpos="notext" data-transition="fade" ></a>

</div>
	<div data-role="content">
	


		<div class="content-primary" id="pri">

			


		

		</div><!--/content-primary-->
		</div>
		<script type="text/javascript">
localStorage.idculture=getUrlParameter('idculture')
		afficher_menu();
function afficher_menu(){
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			data: {
				action: 'parametre2_val',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture
					},
			success : function(data){	
				buffer1='<p><strong>Bienvenue.</strong> Gestion des paramètres SigaAnalyses</p>';
				
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					buffer1=buffer1 + '<p><strong>Culture de vente : </strong>'+ tmp[3] +'</p>';
					buffer1=buffer1 + '<label for="text-min">Valeur en €/Q</label>';		
					buffer1=buffer1 + '<input type="number" data-clear-btn="true" name="text-min" id="text-min" value="'+ tmp[2] +'">';
					buffer1=buffer1 + '<a href="#" data-role="button"  data-icon="check" data-theme="a" data-inline="true" onclick="ajout_dec()" >Valider</a>';
														
					}
				buffer1=buffer1 + '</ul>';
				$('#pri').html(buffer1);
				$('#pri').trigger('create');
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
				action : 'changer_valeur2',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture,
				min : $('#text-min').val()
			},
			success : function(data){
				alert('Informations mises à jour !');
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

		<div data-role="footer" class="footer-docs" data-theme="a">
		<p>&copy; 2011-15 Chambres Agriculture Lorraine-Alsace</p>
		</div>
</div>

</body>
</html>
