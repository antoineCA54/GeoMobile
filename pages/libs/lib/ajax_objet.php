<?php
include("../assets/connex.inc.php");
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="ajout_o")
{

	$idcom=connex2("bdaplat","myparam");

	$requete="INSERT INTO bativ2.point(geom) VALUES (POINT(".$_POST['lat'].",".$_POST['lng'].")) ";
	$result=pg_query($idcom,$requete);
	echo $requete;

	pg_close($idcom);
}


?>