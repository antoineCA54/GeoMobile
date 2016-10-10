<?php
include("../assets/connex.inc.php");

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="maj")
	{
		$idcom=connex2("siga_territoire","myparam");
		$requete="INSERT INTO test_1(geom) VALUES (ST_Transform(ST_SetSRID(ST_MakePoint(".$_POST['lng'].",".$_POST['lat']."),4326),2154))";

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