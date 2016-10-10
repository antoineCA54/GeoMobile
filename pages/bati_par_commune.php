<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Calendrier</title>
  <link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.css" />
<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.min.css" />

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>
<div data-role="header" data-theme="g" data-position="fixed">
<h5><small>Diagnostic agricole</small></h5>
<a href="./rch_commune.php" rel="external" data-icon="home" data-iconpos="notext" data-transition="fade" >Accueil</a>
</div>
<div id="f1" data-role="content">

</div>
<script type="text/javascript">
// Stockage en base de l'identifiant codeinsee
localStorage.codeinsee=getUrlParameter('codeinsee')


suite();


function suite(){
							$.ajax({
  type: 'POST',
  url: 'traitements2.php',
  data: {
    action2: 'batiment_commune'   ,
    codeinsee:localStorage.codeinsee
  },
  success : function(data){	;

				buffer12='<ul data-role="listview"  data-inset="true" data-mini="true" >';
			 
			var obj2 = jQuery.parseJSON(data);
				for(j=0;j<obj2.length;j++){
					var tmp2=obj2[j];
									
					buffer12=buffer12 + '<li data-role="list-divider" data-theme="b">' + tmp2[1] + '<span class="ui-li-count" data-theme="b">' + tmp2[0] + '</span></li>';				
					buffer12=buffer12 + '<li>';
					buffer12=buffer12 + '<a href="./diag_nt.php?id='+ tmp2[0] + '"  rel="external" data-inset="true" data-mini="true" data-icon="star">';
					buffer12=buffer12 + '<p><h6>'+ tmp2[2]+'</h6></p>';

					
					buffer12=buffer12 + '</a></li>';
					
					
					}
				
				buffer12=buffer12 + '</ul>';
			
				$('#f1').html(buffer12); 
				$('#f1').trigger('create');
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
<?php
	include_once("./panel_id_pac.php");
	include_once("../inc_footer.php/footer_cda.inc.php");
?>
</body>
</html>