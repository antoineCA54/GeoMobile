<?php
include("../assets/connex.inc.php");

// Recherche des utilisateurs
// NE DEPEND PAS DU MILLESIME

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_utilisateur")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT idutilisateur,idgroupe,nom_groupe FROM bdanalysegroupe.groupe ORDER BY iddepartement,nom_groupe";
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
	// RECHERCHE DES EXPLOTATIONS
	// MILLESIME EN DUR !!!!!!!!
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="rechercheExploitation")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT e.idexploitation,
CASE WHEN v.idutilisateur is not null THEN raisonsociale || ' par ' || t.login || ' (le : ' || v.date_validation || ')' ELSE raisonsociale || ' (NV) ' END as r,
CASE WHEN v.idutilisateur is not null THEN 'checked=checked' ELSE '' END as t
FROM bdanalysegroupe.vue_economique e
JOIN tacces ta USING (idexploitation)
LEFT JOIN bdanalysegroupe.moduleverif_exploitations_valides v ON v.idexploitation=e.idexploitation AND cast(v.millesime as integer)=e.millesime
LEFT JOIN tutilisateurs t ON t.idutilisateur=v.idutilisateur
WHERE e.millesime=2016 AND ta.idutilisateur='".$_POST['rowid']."'
GROUP BY e.idexploitation,raisonsociale
,v.idutilisateur,v.date_validation,t.login
ORDER BY date_validation,raisonsociale
";
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
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="cocher_case")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT e.idexploitation
FROM bdanalysegroupe.vue_economique e
JOIN bdanalysegroupe.moduleverif_exploitations_valides v ON v.idexploitation=e.idexploitation AND cast(v.millesime as integer)=e.millesime
JOIN tutilisateurs t USING (idutilisateur)
WHERE e.millesime=2016 and idutilisateur='".$_POST['rowid']."'
GROUP BY e.idexploitation,raisonsociale
,v.idutilisateur,v.date_validation,login
ORDER BY date_validation,raisonsociale;";
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
	// Recherche des utilisateurs
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="rechercheCulture")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="select v.idculture , 
CASE WHEN r.idculture is null THEN cultlibusage || ' (Absence de valeurs - Ne pas cocher !)' ELSE cultlibusage END as cultlibusage
from  bdanalysegroupe.vue_parcelles v JOIN tacces USING (idexploitation) JOIN tutilisateurs t USING (idutilisateur)
JOIN bdanalysegroupe.cultures_par_type ty USING (idculture) 
LEFT JOIN (SELECT idculture,iddepartement FROM bdanalysegroupe.moduleverif_plage_valeurs GROUP BY idculture,iddepartement) r ON r.idculture=v.idculture AND r.iddepartement=t.identite
WHERE v.millesime=2016 AND idutilisateur='".$_POST['rowid']."' AND ty.idtypeculture=1
GROUP BY cultlibusage,v.idculture,r.idculture ORDER BY v.cultlibusage";
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

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="newDemande")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="INSERT INTO bdanalysegroupe.moduleverif_demande(idutilisateur,idgroupe,millesime,liste_cultures,date_demande,etat_demande) VALUES (
		'".$_POST['idutilisateur']."',(SELECT idgroupe FROM bdanalysegroupe.groupe WHERE idutilisateur ='".$_POST['idutilisateur']."'),
		2016,'".$_POST['idculture']."',now(),1) returning iddemande";
		
		$result=pg_query($idcom,$requete);

		if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = array_map("utf8_decode", $row);
			}
			echo json_encode($myarray);
		}
	else {
		echo null;
	}
	
	pg_close($idcom);
	}

// Affectation de la validation
// ATTENTION AU MILLESIME !!!!!!!!!!!!
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="enregistrerValidation")
	{
		$idcom=connex("bdaplat","myparam");
		// ON VERIFIE SI DEJA PRESENT DANS LA TABLE
		$requete1="SELECT idexploitation FROM bdanalysegroupe.moduleverif_exploitations_valides WHERE cast(millesime as integer)=2016  and idexploitation='".$_POST['idexploitation']."'";
		$result=pg_query($idcom,$requete1);
		
		// SI OUI ALORS ON EFFACE
		if(pg_num_rows($result)>0) {
		$requete3="DELETE FROM bdanalysegroupe.moduleverif_exploitations_valides WHERE 
idexploitation='".$_POST['idexploitation']."'  and cast(millesime as integer)=2016;";
$result3=pg_query($idcom,$requete3);
		
		} else {
		// SI NON ALORS ON AJOUTE
		$requete2="INSERT INTO bdanalysegroupe.moduleverif_exploitations_valides(
            idgroupe, idutilisateur, millesime, idexploitation, date_validation) 
    VALUES ((select idgroupe from bdanalysegroupe.groupe WHERE idutilisateur='".$_POST['idutilisateur']."'),'".$_POST['idutilisateur']."',2016,'".$_POST['idexploitation']."',now());";
	$result2=pg_query($idcom,$requete2);
		
		}
		
		
	
	pg_close($idcom);
	}
?>

