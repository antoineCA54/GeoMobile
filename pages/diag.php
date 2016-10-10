
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NOSTERRITOIRES</title>


<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.css" />
<link rel="stylesheet" href="../assets/mobile_flat/generated/jquery.mobile.flatui.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
</head>
<body>
<div data-role="page">
<div data-role="header" data-theme="g" data-position="fixed">
<h1>RPG2011</h1>
</div>
	<div data-role="content">
	<div class="content-primary" id="pri">


		</div><!--/content-primary-->
		<h3> Identifiant de l'exploitation</h3>
		<fieldset data-role="fieldcontain" > 
				<input  type="search" id="valide_recherche" name="valide_recherche" placeholder="Commune..." data-mini="true" value="" onchange="afficher_commune($('#valide_recherche').val())"/>				
		</fieldset>
		
		
		
		</div>
<div id="div_liste2" data-role="content">

</div>


		<script type="text/javascript">
		
		$(document).ready(function(){

  			
$("#valide_recherche").val(getUrlParameter('idexpl'));
afficher_commune($('#valide_recherche').val());
$("#idexpl2").focus();
		});

		function afficher_commune(rs){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'recherche_bali',
				commune : rs
					},
			success : function(data){
				var obj =jQuery.parseJSON(data);
				var row = obj[0];
					
				$("#idexpl2").val(row[1]);
				$("#idbali").val(row[2]);

				buffer1='<a href="#' + row[0] + ',' + row[1] + ',' + row[2] + '" data-role="button" rel="external" data-icon="flat-plus" data-theme="b"  data-transition="fade" data-inline="true" onclick="ajout_dec()" >Modifier</a>';

				$('#div_liste2').html(buffer1);
				$('#div_liste2').trigger('create');	
			
				}
				});
	}

	function ajout_dec(id_expl,rs,idbali){
		$.ajax({
			type: 'POST',
			url: 'traitements2.php',
			data: {
				action: 'changer_valeur',
				rs :$('#idexpl2').val(),
				idexpl :$('#valide_recherche').val(),
				idbali:$('#idbali').val()
					},
			success : function(data){
					alert('Saisie ' + $('#valide_recherche').val() +'  validée !');
	
				}
				});
	}
	afficher_graphe_2();
function afficher_graphe_2(){
	$.ajax({
  type: 'POST',
  url: 'traitements2.php',
  data: {
    action: 'tx_confirmation'   
  },
  success : function(data){	
  
					var obj = jQuery.parseJSON(data);
    			var row = obj[0];
				var u1= parseInt(row[0]);
				var c1="#33CC33";
				var u2= parseInt(row[1]);
				var c2="#ff0000";
				var t1='Effectué ' + Math.round(((u1/(u1+u2))*100),0) +"%";
				var t2='Restant ' + Math.round(((u2/(u1+u2))*100),0) +"%";
					graph(u1,u2,c1,c2);
					var c=document.getElementById("myCanvas2");
var ctx=c.getContext("2d");
ctx.fillStyle=c1;
ctx.fillRect(0,0,Math.round(((u1/(u1+u2))*100),0),20);
ctx.font="10px Arial";
ctx.fillText(t1,0,37);
//var c=document.getElementById("myCanvas2");
//var ctx=c.getContext("2d");
ctx.fillStyle=c2;
ctx.fillRect(Math.round(((u1/(u1+u2))*100),0),0,Math.round(((u2/(u1+u2))*100),0),20);
ctx.font="10px Arial";
ctx.fillText(t2,100,37);

var pieData = [
				{
					value: u1,
					color: c1
				},
				{
					value : u2,
					color : c2
				}
			
			];
					var myPie = new Chart(document.getElementById("canvas2").getContext("2d")).Pie(pieData);
   }
  });
}
function graph(u,uu,c1,c2){

					
					
				
			

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

		<div data-role="footer" data-theme="g">
		<p>&copy; 2011-13 Chambres Agriculture Lorraine-Alsace</p>
		</div>
</div>

</body>
</html>
