
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
				action: 'parametre',
				iddepartement: localStorage.iddepartement,
				idculture: localStorage.idculture

					},
			success : function(data){	
				buffer1='<p><strong>Bienvenue.</strong> Gestion des paramètres SigaAnalyses</p>';
				buffer1=buffer1 + '<ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="c">';
				buffer1=buffer1 + '<li data-role="list-divider">Paramètres</li>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					
					buffer1=buffer1 + '<li><a href="./parametre.php?type_critere='+ tmp[1] + '"  rel="external" >' + tmp[2] + '</a></li>';												
					}
				buffer1=buffer1 + '</ul>';
				$('#pri').html(buffer1);
				$('#pri').trigger('create');
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

		<div data-role="footer" data-theme="a">
		<p>&copy; 2011-16 Chambres Agriculture Lorraine-Alsace</p>
		</div>
</div>

</body>
</html>
