
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
<a href="./accueil.php" rel="external" data-icon="bars"  data-transition="fade" >Accueil</a>
</div>
	<div data-role="content">
	


		<div class="content-primary" id="pri">
			<p><strong>Bienvenue.</strong> Gestion des paramètres SigaAnalyses</p>
			<ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="b">
				<li data-role="list-divider">Type</li>

					<li><a href="./cultures.php"  rel="external" >Plages de valeurs</a></li>
					<li><a href="./cultures_dates.php"  rel="external" >Plages de dates</a></li>
			</ul>
		

		</div><!--/content-primary-->
		</div>
		<script type="text/javascript">
localStorage.iddepartement=getUrlParameter('iddepartement')
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
		<p>&copy; 2011-15 Chambres Agricultures Lorraine-Alsace</p>
		</div>
</div>

</body>
</html>