<?php
include("../assets/connex.inc.php");
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="ajout_o")
{

	$idcom=connex2("bdaplat","myparam");

	$requete="INSERT INTO bativ2.point(geom,datecreation) VALUES (st_transform(st_setsrid(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),2154),now()) returning idpoint";
	$result=pg_query($idcom,$requete);
	// On récupère le numéro
	$result=pg_query($idcom,$requete);	
		if($result!==false){
		$lire=pg_fetch_row($result);
echo json_encode($lire);
		
	}	
	pg_close($idcom);
}
	// Liste des valeurs pour les statuts des abonnements
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_test")
	{
		$idcom=connex2("bdaplat","myparam");
		$requete="SELECT libelle FROM bativ2.liste_test";
		$result=pg_query($idcom,$requete);
		//echo $requete;
		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = $row;
			}
			echo json_encode($myarray);
		}
	
		pg_close($idcom);
	}
// Modification du changement de statut de la facture
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="modifier_option")
{
	$idcom=connex2("bdaplat","myparam");
	$requete="UPDATE bativ2.point SET option='".$_POST['libelle']."' WHERE idpoint='".$_POST['idpoint']."'";
	
	echo $requete;
	$result=pg_query($idcom,$requete);	
	pg_close($idcom);
	
}

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_point")
	{
		$idcom=connex2("bdaplat","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(g.geom,4326)),
st_y(st_centroid(st_transform((g.geom),4326))) as y,
st_x(st_centroid(st_transform((g.geom),4326))) as x,
option as d,'1' as url
FROM
bativ2.point g";

		$result=pg_query($idcom,$requete);

		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = $row;
			}
			echo json_encode($myarray);
		}
	else {
		echo null;
	}
		pg_close($idcom);
	}
?>