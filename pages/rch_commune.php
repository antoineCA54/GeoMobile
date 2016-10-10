<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Rechercher</title>
	<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.css" />
<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.min.css" />

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	
</head>
<body>	
	<div data-role="header" data-theme="g" data-position="fixed">
		<h5><small>Diagnostic Agricole</small></h5>
	</div>
<div data-role="page=" id="consabo">

<div id="div_producteur" data-role="content">
	<input type="search" id="valide_recherche" name="valide_recherche" placeholder="Nom commune..." value="" onchange="afficher_communes()"/>				
</div>
<div id="div_liste" data-role="content">

</div>
	<script type="text/javascript">
	
	function afficher_communes(){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'liste_bati_commune',
				raisonsociale : $('#valide_recherche').val()
					},
			success : function(data){	
				buffer1='<ul data-role="listview" id="listView" data-autodividers="true" data-inset="true" data-filter-theme="g" data-theme="c" data-divider-theme="b">';
				var obj = jQuery.parseJSON(data);
				for(i=0;i<obj.length;i++){
					var tmp=obj[i];
					buffer1=buffer1 + '<li>';
					buffer1=buffer1 + '<a href="./bati_par_commune.php?codeinsee='+ tmp[0] + '" id="vers" rel="external" data-icon="star">';
					buffer1=buffer1 + ''+ tmp[1] + '';
					buffer1=buffer1 + '</a><span class="ui-li-count">'+ tmp[2] + ' Bâtiment(s)</span>';
					buffer1=buffer1 + '</li>';						
					}
				buffer1=buffer1 + '</ul>';
				$('#div_liste').html(buffer1);
				$('#div_liste').trigger('create');	
					
					
					
					
				}
				});
	}
	</script>
	
</div>
</body>
</html>