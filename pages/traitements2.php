<?php
include("../assets/connex.inc.php");
// Liste des départements selon les groupes présents
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_rpg")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT id_expl,exploitation,coalesce(idbali,0) FROM bdaplat_nt.sb_data_94 WHERE id_expl='".$_POST['commune']."' GROUP BY id_expl,exploitation,idbali";
		
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

// Changement de valeur
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="UPDATE bdaplat_nt.sb_data_94 SET exploitation='".$_POST['rs']."', idbali='".$_POST['idbali']."' WHERE  id_expl='".$_POST['idexpl']."'";
		
		$result=pg_query($idcom,$requete);
		pg_close($idcom);
	}

/// Graphe
	// Info sur la disponiblilte
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="tx_confirmation")
  {
	$idcom=connex2("bdaplat_nt","myparam");
	$requete="SELECT sum(f.n_conf) as nconf,(sum(f.total))-(sum(f.n_conf)) as nonconfirme FROM
(
SELECT count(*) as n_conf,0 as total
FROM bdaplat_nt.sb_data_94 WHERE exploitation is not null
UNION
SELECT 0 as nconf,count(*) as total
FROM bdaplat_nt.sb_data_94) as f";

	$result=pg_query($idcom,$requete);
	if(pg_num_rows($result)>0) {
			$myarray = array();
			while ($row = pg_fetch_row($result)) {
  				$myarray[] = array_map("utf8_encode", $row);
			}
			echo json_encode($myarray);
		}
		else {
			echo json_encode(0);
		}	
	pg_close($idcom);
	
}

// Liste des départements selon les groupes présents
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_bali")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="select identifiant,nom_commer || ', ' || commune as cherche ,nom_commer FROM bdaplat_nt_data.bali WHERE commune LIKE upper('".$_POST['commune']."%') ORDER BY commune,nom_commer";
		
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

// Recherche des nature de bati
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_bati")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="select idtypebati,type_bati FROM bdaplat_nt_data.type_bati WHERE disponible=1 ORDER BY idregroupementbati,ordre";
		
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
// Recherche BALI
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_bali_2")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="select identifiant,nom_commer || ', ' || commune as cherche ,nom_commer FROM bdaplat_nt_data.bali WHERE nom_commer LIKE upper('%".$_POST['nom']."%') ORDER BY nom_commer";
		
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
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_info_bali")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="select identifiant,nom_commer,adress_voie_1,CASE WHEN portable is null THEN telephone else portable END as n,courriel,commune FROM bdaplat_nt_data.bali WHERE identifiant=".$_POST['identifiant']." ORDER BY nom_commer";
		
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
//

// Changement de valeur bati
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_bati")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		
// Mise à jour de la table d'info 149 (couche bati)
		$requete2="UPDATE bdaplat_nt.sb_data_149 SET structure='".$_POST['structure']."',raisonsociale='".$_POST['raisonsociale']."',orientation='".$_POST['orientation']."',norme='".$_POST['norme']."' 
		,idbali=".$_POST['idbali'].",url_bali='http://intranet54/APCA/?page=Exp_Fiche&id=".$_POST['idbali']."',forme_juridique='".$_POST['forme']."' WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR EXPLOITATION
	$requete="UPDATE bdaplat_nt.sb_data_149 SET forme_juridique='".$_POST['forme']."',norme='".$_POST['norme']."',orientation='".$_POST['orientation']."',structure='".$_POST['structure']."' WHERE idbali=".$_POST['idbali']."";
	$result=pg_query($idcom,$requete);
// MISE A JOUR INFO COMMUNE
	$requete="UPDATE bdaplat_nt.sb_data_149 d SET insee_comm=(SELECT insee_comm FROM bdaplat_nt.sb_data_74 c,bdaplat_nt.sb_geom_74 gc,bdaplat_nt.sb_geom_149 g WHERE st_intersects(g.g,gc.g) and gc.rowid=c.rowid and g.rowid=".$_POST['rowid']."),
	nom_comm=(SELECT nom_comm FROM bdaplat_nt.sb_data_74 c,bdaplat_nt.sb_geom_74 gc,bdaplat_nt.sb_geom_149 g WHERE st_intersects(g.g,gc.g) and gc.rowid=c.rowid and g.rowid=".$_POST['rowid'].") WHERE d.rowid=".$_POST['rowid']."";
	$result=pg_query($idcom,$requete);
		pg_close($idcom);
	}
///////////////////////////////////////////
// Mise à jour de la distance
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_distance")
	{
		$idcom=connex2("bdaplat_nt","myparam");
// MISE A JOUR DE LA DISTANCE DANS LA TABLE DATA 153
		$requete2="UPDATE bdaplat_nt.sb_data_153 SET distance=".$_POST['distance']." WHERE rowid = (SELECT rowid FROM bdaplat_nt.sb_data_153 WHERE id_rowid= ".$_POST['rowid'].")";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR DU CHAMP GEOM BUFFER DISTANCE DANS GEOM 153
		$requete="UPDATE bdaplat_nt.sb_geom_153 SET g=(SELECT st_buffer(g149.g,cast(".$_POST['distance']." as integer)) as g FROM bdaplat_nt.sb_data_149 d149,bdaplat_nt.sb_geom_149 g149
			WHERE  d149.rowid=g149.rowid and d149.rowid=".$_POST['rowid'].") 
			WHERE rowid = (SELECT rowid FROM bdaplat_nt.sb_data_153 WHERE id_rowid= ".$_POST['rowid'].")";
		$result=pg_query($idcom,$requete);
// Mise à jour du champ update view de la table 153
		$requete2="UPDATE bdaplat_nt.sb_svg_153 SET update_view=1 WHERE rowid = (SELECT rowid FROM bdaplat_nt.sb_data_153 WHERE id_rowid= ".$_POST['rowid'].")";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR DU CHAMP DISTANCE DANS LA TABLE 149
		$requete2="UPDATE bdaplat_nt.sb_data_149 SET distance=".$_POST['distance']." WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
		pg_close($idcom);
	}
////////////////////////////////////////////////
// MISE A JOUR NATURE
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_nature")
	{
		$idcom=connex2("bdaplat_nt","myparam");
// MISE A JOUR DU CHAMP NATURE DANS LA TABLE 149
		$requete2="UPDATE bdaplat_nt.sb_data_149 SET nature='".$_POST['bati']."',idtypebati=".$_POST['type_bati']." WHERE rowid= ".$_POST['rowid']."";

		$result2=pg_query($idcom,$requete2);
		pg_close($idcom);
	}
////////////////////////////////////////////////
// Récupération des infos sur un batiment agricole
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_du_bati")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT rowid,  id, origin_bat, nature, hauteur, raisonsociale, type_bati,distance, forme_juridique, structure, orientation, norme,idtypebati,idbali
  FROM bdaplat_nt.sb_data_149
  WHERE rowid = ".$_POST['rowid']." ORDER BY rowid limit 1";
		
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
////////////////////////////////////////////////
// Récupération des infos sur un batiment agricole
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_du_bati_2")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT rowid,  id, origin_bat, nature, hauteur, raisonsociale, type_bati,distance, forme_juridique, structure, orientation, norme,idtypebati,idbali
  FROM bdaplat_nt.sb_data_149
  WHERE idbali = ".$_POST['idbali']." limit 1";
		
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
// récupération de la liste des types de bâtiments
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_des_batiments")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT idtypebati,type_bati FROM bdaplat_nt_data.type_bati WHERE disponible=1 ORDER BY ordre";
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
// LISTE DES ORIENTATIONS 
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_des_orientations")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT idorientation,orientation FROM bdaplat_nt_data.dorientation";
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
//RECHERCHE COOR
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_coor")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_X(st_centroid(st_transform(g,4326))) as lat,ST_Y(st_centroid(st_transform(g,4326))) as long,'(Id : ' || rowid || ') ' || nature as rowid FROM bdaplat_nt.sb_geom_149 JOIN bdaplat_nt.sb_data_149 USING (rowid) WHERE rowid = ".$_POST['rowid']." LIMIT 1";
		
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
///////////////////////////////////////////
//RECHERCHE shape
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_shape")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(g2.g,4326))
FROM bdaplat_nt.sb_geom_149 g1,bdaplat_nt.sb_geom_1 g2
WHERE 
st_intersects(g2.g,g1.g) AND 
g1.rowid=5";
		
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
//////////////////////////
// Affichage de la liste des communes ou l'on a des batiments
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_bati_commune")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="select insee_comm,nom_comm,count(rowid) as n_bat from bdaplat_nt.sb_data_149 WHERE nom_comm like upper('%".$_POST['raisonsociale']."%') GROUP BY insee_comm,nom_comm ORDER BY nom_comm";
		
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

//SELECT rowid,raisonsociale,nature FROM bdaplat_nt.sb_data_149 WHERE insee_comm='".$_POST['raisonsociale']."'";
if(isset($_POST['action2']) && !empty($_POST['action2']) && $_POST['action2']=="batiment_commune")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT rowid,raisonsociale,nature FROM bdaplat_nt.sb_data_149 WHERE insee_comm='".$_POST['codeinsee']."' ORDER BY raisonsociale";
		
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
?>

