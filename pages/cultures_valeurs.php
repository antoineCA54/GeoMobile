
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
</div>
	<div data-role="content">
	


		<div class="content-primary" id="pri">


		</div><!--/content-primary-->
		</div>
		<script type="text/javascript">
		afficher_menu();
function afficher_menu(){
		$.ajax({
			type: 'POST',
			url: 'traitements.php',
			data: {
				action: 'analyses',
				iddepartement: localStorage.iddepartement
					},
			success : function(data){	
				buffer1='<p><strong>Bienvenue.</strong> Gestion des paramètres SigaAnalyses</p>';
				buffer1=buffer1 + '<ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">';
				buffer1=buffer1 + '<li data-role="list-divider">Liste des cultures</li>';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					
					buffer1=buffer1 + '<li><a href="./paramatre2.php?idculture='+ tmp[0] + '"  rel="external" >' + tmp[1] + '</a></li>';												
					}
				buffer1=buffer1 + '</ul>';
				$('#pri').html(buffer1);
				$('#pri').trigger('create');
				}
				});
	}
</script>

		<div data-role="footer" data-theme="a">
		<p>&copy; 2011-15 Chambres Agriculture Lorraine-Alsace</p>
		</div>
</div>

</body>
</html>