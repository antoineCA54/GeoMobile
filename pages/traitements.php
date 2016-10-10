
<?php
include("../assets/connex.inc.php");
// Liste des départements selon les groupes présents
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="departement")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT iddepartement,nom_dept FROM bdanalysegroupe.groupe g JOIn bdanalysegroupe.departement d USING (iddepartement) GROUP BY iddepartement,nom_dept";
		
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
// Liste des types d'analyses selon les groupes présents
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="analyses")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT idculture,libelleculture || ' (' || prix_moyen || ' Euros/Q)' as l,iddepartement,prix_moyen from bdanalysegroupe.prix_moyen_cultures
where iddepartement='".$_POST['iddepartement']."' and millesime=2016 GROUP BY  idculture,libelleculture,iddepartement,prix_moyen
ORDER BY libelleculture";
		
		$result=pg_query($idcom,$requete);
		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = array_map("utf8_encode", $row) ;
			}
			echo json_encode($myarray);
		}
	else {
		echo null;
	}
		pg_close($idcom);
	}
// LES CULTURES
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_cultures")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="select idculture,cultlibusage FROM bdanalysegroupe.moduleverif_plage_valeurs JOIN bdanalysegroupe.vue_parcelles USING (idculture) WHERE iddepartement='".$_POST['iddepartement']."' GROUP BY idculture,cultlibusage ORDER BY cultlibusage ";
		
		$result=pg_query($idcom,$requete);
		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
				
  				$myarray[] = array_map("utf8_encode", $row);
			}

			echo json_encode($myarray);
		}
	else {
		echo null;
	}
		pg_close($idcom);

	}
// Les paramètres
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="parametre")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="select idculture,type_critere,type_critere || ' (' || valeur_min || ' , ' || valeur_max || ')' as type_critere2,unite,valeur_min,valeur_max,(valeur_max) + 50 as max FROM bdanalysegroupe.moduleverif_plage_valeurs val 
 WHERE iddepartement='".$_POST['iddepartement']."'
 AND idculture='".$_POST['idculture']."' ORDER BY type_critere";
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
// Les valeurs des paramètres
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="parametre_val")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="select idculture,type_critere,unite,valeur_min,valeur_max,(valeur_max) + 50 as max FROM bdanalysegroupe.moduleverif_plage_valeurs val 
 WHERE iddepartement='".$_POST['iddepartement']."'
 AND idculture='".$_POST['idculture']."' AND type_critere='".$_POST['type_critere']."' ORDER BY type_critere";
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
	// Les valeurs des paramètres2
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="parametre2_val")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="select idculture,millesime,prix_moyen,libelleculture FROM bdanalysegroupe.prix_moyen_cultures val 
 WHERE iddepartement='".$_POST['iddepartement']."'
 AND idculture='".$_POST['idculture']."' AND millesime=2014";
		$result=pg_query($idcom,$requete);
		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = array_map("utf8_encode", $row);
			}
			echo json_encode($myarray);
		}
	else {
		echo null;
	}
		pg_close($idcom);
	}
// Changement de valeur
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="UPDATE bdanalysegroupe.moduleverif_plage_valeurs SET valeur_min='".$_POST['min']."', valeur_max='".$_POST['max']."' 
 WHERE iddepartement='".$_POST['iddepartement']."' 
 AND idculture='".$_POST['idculture']."' AND type_critere='".$_POST['type_critere']."'";
		$result=pg_query($idcom,$requete);
		
		pg_close($idcom);
	}
	
// Changement de valeur
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_date")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="UPDATE bdanalysegroupe.moduleverif_plage_dates SET date_min='".$_POST['min']."', date_max='".$_POST['max']."' 
 WHERE iddepartement='".$_POST['iddepartement']."' 
 AND idculture='".$_POST['idculture']."' AND type_interv='".$_POST['type_critere']."'";
		$result=pg_query($idcom,$requete);
		
		pg_close($idcom);
	}
// Changement de valeur2
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur2")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="UPDATE bdanalysegroupe.prix_moyen_cultures SET prix_moyen='".$_POST['min']."' 
 WHERE iddepartement='".$_POST['iddepartement']."' 
 AND idculture='".$_POST['idculture']."' AND millesime=2016";
		$result=pg_query($idcom,$requete);
		
		pg_close($idcom);
	}



// Liste des utilisateurs
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_utilisateur")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT idutilisateur,login FROM bdanalysegroupe.tutilisateurs order by login";
		$result=pg_query($idcom,$requete);
		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = $row;
			}
			echo json_encode($myarray);
		}
	
		pg_close($idcom);
	}

// Liste des millésime
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_millesime_valide")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT millesime,idutilisateur FROM bdanalysegroupe.moduleverif_exploitations_valides WHERE idutilisateur='".$_POST['idutilisateur']."' GROUP BY millesime,idutilisateur order by millesime desc";
		$result=pg_query($idcom,$requete);
		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = $row;
			}
			echo json_encode($myarray);
		}
	
		pg_close($idcom);
	}

// Liste des mavlie
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_exploit_valide")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT e.idexploitation,a.raisonsociale,e.millesime,e.idutilisateur FROM bdanalysegroupe.moduleverif_exploitations_valides e JOIN bdanalysegroupe.vue_economique a USING (idexploitation)
                  WHERE e.millesime='".$_POST['millesime']."' and a.millesime='".$_POST['millesime']."' and e.idutilisateur='".$_POST['idutilisateur']."' GROUP BY e.idexploitation,a.raisonsociale,e.millesime,e.idutilisateur	 order by a.raisonsociale";
		$result=pg_query($idcom,$requete);

		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = $row;
			}
			echo json_encode($myarray);
		}
	
		pg_close($idcom);
	}
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="test")
{
	$idcom=connex("bdaplat","myparam");
	$requete="dELETE FROM bdanalysegroupe.moduleverif_exploitations_valides WHERE millesime='".$_POST['millesime']."' and idutilisateur='".$_POST['idutilisateur']."' and idexploitation='".$_POST['idep']."'";
	
	$result=pg_query($idcom,$requete);
	
	pg_close($idcom);
	
}
// DATE
// Les valeurs des paramètres
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="parametre_date")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT idculture,type_interv,date_min,date_max 
FROM bdanalysegroupe.moduleverif_plage_dates WHERE idculture='".$_POST['idculture']."' and iddepartement='".$_POST['iddepartement']."' and type_interv='".$_POST['type_critere']."'";
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