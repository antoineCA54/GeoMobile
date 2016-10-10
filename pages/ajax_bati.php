<?php
include("../assets/connex.inc.php");

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
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_distance_2")
	{
		$idcom=connex2("bdaplat_nt","myparam");

// MISE A JOUR DU CHAMP GEOM BUFFER DISTANCE DANS GEOM 1
		$requete="UPDATE bati.sb_geom_2 SET g=(SELECT st_buffer(g149.g,cast(".$_POST['distance']." as integer)) as g FROM bati.sb_data_1 d149,bati.sb_geom_1 g149
			WHERE  d149.rowid=g149.rowid and d149.rowid=".$_POST['rowid'].") 
			WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result=pg_query($idcom,$requete);
// Mise à jour du champ update view de la table 2
		$requete2="UPDATE bati.sb_svg_2 SET update_view=1 WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR DU CHAMP DISTANCE DANS LA TABLE 149
		$requete2="UPDATE bati.sb_data_1 SET distance=".$_POST['distance']." WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
		
		pg_close($idcom);
	}
	///////////////////////////////////////////
// Mise à jour de la distance
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_distance_3")
	{
		$idcom=connex2("bdaplat_nt","myparam");

// MISE A JOUR DU CHAMP DISTANCE DANS LA TABLE 1
		$requete2="UPDATE bati.sb_data_1 SET distance=".$_POST['distance']." WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR GLOBALE	
		// ON EFFACE TOUS
		$requete2="DELETE FROM bati.sb_geom_19";
		$result2=pg_query($idcom,$requete2);
		$requete2="DELETE FROM bati.sb_svg_19";
		$result2=pg_query($idcom,$requete2);
		$requete2="DELETE FROM bati.sb_data_19";
		$result2=pg_query($idcom,$requete2);
		// DATA
		$requete2="INSERT INTO bati.sb_data_19(insee_comm)  (SELECT a.insee_comm
FROM
bati.sb_data_1 a,bati.sb_geom_1 g
WHERE a.rowid=g.rowid AND a.distance > 0
GROUP BY a.insee_comm ORDER BY a.insee_comm)";
		$result2=pg_query($idcom,$requete2);
		// GEOM
		$requete2="INSERT INTO bati.sb_geom_19(rowid,g) (
SELECT d.rowid,st_union(st_buffer(g.g,a.distance)) as geom
FROM
bati.sb_geom_1 g,bati.sb_data_1 a
JOIN bati.sb_data_19 d USING (insee_comm)
WHERE a.rowid=g.rowid AND a.distance > 0
GROUP BY d.rowid,a.insee_comm ORDER BY a.insee_comm
)";
		$result2=pg_query($idcom,$requete2);
		// SVG
		$requete2="INSERT INTO bati.sb_svg_19(rowid,type,update_view) ( 
SELECT rowid,'P','1'
FROM bati.sb_data_19 ORDER BY insee_comm);";
		$result2=pg_query($idcom,$requete2);
		pg_close($idcom);
	}
// Mise à jour de la distance
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_distance")
	{
		$idcom=connex2("bdaplat_nt","myparam");
 
// MISE A JOUR DU CHAMP GEOM BUFFER DISTANCE DANS GEOM 1
		$requete="UPDATE bati.sb_geom_2 SET g=(
 SELECT st_union(st_buffer(g.g,distance))
 FROM bati.sb_data_1 d
 JOIN bati.sb_geom_1 g USING (rowid)
 WHERE insee_comm = (SELECT insee_comm FROM bati.sb_data_1 WHERE rowid=".$_POST['rowid'].")
 GROUP BY insee_comm)
 WHERE rowid IN (select rowid FROM bati.sb_data_2 WHERE insee_comm = ((SELECT insee_comm FROM bati.sb_data_1 WHERE rowid=".$_POST['rowid'].")));";
 
		$result=pg_query($idcom,$requete);
// Mise à jour du champ update view de la table 2
		$requete2="UPDATE bati.sb_svg_2 SET update_view=1 
 WHERE rowid IN (select rowid FROM bati.sb_data_2 WHERE insee_comm = ((SELECT insee_comm FROM bati.sb_data_1 WHERE rowid=".$_POST['rowid'].")));";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR DU CHAMP DISTANCE DANS LA TABLE 149
		$requete2="UPDATE bati.sb_data_1 SET distance=".$_POST['distance'].",datemodification=now() WHERE rowid= ".$_POST['rowid']."";
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
// MISE A JOUR PHOTOVOLATIQUE
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="maj_photov")
	{
		$idcom=connex2("bdaplat_nt","myparam");
// MISE A JOUR DU CHAMP NATURE DANS LA TABLE 149
		$requete2="UPDATE bati.sb_data_1 SET photovoltaique='".$_POST['pho']."',datemodification=now() WHERE rowid= ".$_POST['rowid']."";

		$result2=pg_query($idcom,$requete2);
		pg_close($idcom);
	}
///////////////////////////////////////////////
// MISE A JOUR DESTINATION
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="majDestination")
	{
		$idcom=connex2("bdaplat_nt","myparam");
// MISE A JOUR DU CHAMP NATURE DANS LA TABLE 1 BATI AGRICOLE
		$requete2="UPDATE bati.sb_data_1 SET destination='".$_POST['destination']."',datemodification=now() WHERE rowid= ".$_POST['rowid']."";

		$result2=pg_query($idcom,$requete2);
		pg_close($idcom);
	}
////////////////////////////////////////////////
// Récupération des infos sur un batiment agricole
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_du_bati")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete2="UPDATE bati.sb_data_2 SET insee_comm=(SELECT insee_comm FROM bati.sb_data_1 WHERE rowid =".$_POST['rowid'].") WHERE rowid_1=".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
		
		$requete="SELECT rowid,  nature,raisonsocial,localisation,statut,distance,siret,coalesce(idbali,0),idexploitation,photovoltaique,categorie,idbati,photovoltaique,destination 
  FROM bati.sb_data_1 LEFT JOIN bati_data.ref_bati ON libelle=nature
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
// affecter insee_com
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="affecterInseeComm")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete2="UPDATE bati.sb_data_2 SET insee_comm=(SELECT insee_comm FROM bati.sb_data_1 WHERE rowid =".$_POST['rowid'].") WHERE rowid_1=".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
		
		pg_close($idcom);
	}
////////////////////////////////////////////////
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
// récupération de la liste des catéogries de bâtiments
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="liste_des_categories")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT categorie,libelle FROM bati_data.ref_categorie";
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
	
		
			$requete="SELECT libelle,idbati FROM bati_data.ref_bati WHERE categorie=".$_POST['categorie']." ORDER BY libelle";
		
		
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
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="quelle_distance")
	{
		$idcom=connex2("bdaplat_nt","myparam");
// INSERTION DSE VALEURS
if ( $_POST['norme']=="RSD")
 
		{
$requete2="UPDATE bati.sb_data_1 SET distance=(SELECT val_rsd FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."),
nature=(SELECT libelle FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."),datemodification=now() WHERE rowid=".$_POST['rowid']."";
$result=pg_query($idcom,$requete2);
}
else {

	if ($_POST['norme']=="ICPE")
	
	{
		$requete2="UPDATE bati.sb_data_1 SET distance=(SELECT val_icpe FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."),
			nature=(SELECT libelle FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."),datemodification=now() WHERE rowid=".$_POST['rowid']."";
			$result=pg_query($idcom,$requete2);
	}
	else 
	{
		$requete2="UPDATE bati.sb_data_1 SET distance=(SELECT val_aucun FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."),
			nature=(SELECT libelle FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."),datemodification=now() WHERE rowid=".$_POST['rowid']."";
			$result=pg_query($idcom,$requete2);
	}
}

		if ( $_POST['norme']=="RSD")
 
		{
			$requete="SELECT val_rsd FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."";
}
else {
	if ( $_POST['norme']=="ICPE")
	
	{
$requete="SELECT val_icpe FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."";
}
	else 
	{
		$requete="SELECT val_aucun FROM bati_data.ref_bati WHERE idbati=".$_POST['idbati']."";
	}
}
		
		
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

// RECHERCHE INFO DANS MESPARCELLES


if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_siret")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		
			$requete="SELECT idexploitation,exp_siret,n FROM (
 SELECT idexploitation,exp_siret,exp_raisonsociale || ' [' || exp_siret || ']' || ' ' || coalesce(statut,'NR') || '(' || exp_comnom || ')'  as n 
FROM public.texploitations 
 LEFT JOIN bati_data.ref_exploitation USING (idexploitation) 
 WHERE exp_siret LIKE '%".$_POST['siret']."%' OR exp_raisonsociale LIKE upper('%".$_POST['siret']."%') 
OR exp_comnom LIKE upper('%".$_POST['siret']."%') 
UNION
 SELECT coalesce(bati.sb_data_1.idexploitation,0) as idexploitation,siret as exp_siret,
 raisonsocial || ' [' || bati.sb_data_1.siret || ']' || ' ' || coalesce(bati_data.ref_exploitation.statut,'NR') || '(' || commune || ')'  as n 
FROM bati.sb_data_1
 LEFT JOIN bati_data.ref_exploitation USING (siret) 
 WHERE bati.sb_data_1.siret LIKE '%".$_POST['siret']."%' OR bati.sb_data_1.raisonsocial LIKE upper('%".$_POST['siret']."%') OR bati.sb_data_1.commune LIKE upper('%".$_POST['siret']."%')
and raisonsocial is not null
 ) as foo";
	
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

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_info_mesparcelles")
	{
		$idcom=connex2("bdaplat_nt","myparam");
// ICI ON RECHERCHE EGALEMENT SI LE STATUT EST DEJA RENSEIGNE
		if ( $_POST['idexploitation'] > 0){
			$requete="select exp_refca,replace(exp_raisonsociale,'''',' ') as rs,idexploitation,exp_siret,statut FROM texploitations LEFT JOIN bati_data.ref_exploitation USING (idexploitation) where idexploitation=".$_POST['idexploitation']."";
			
		}
		else
			{
		$requete="select 0 as exp_refca,replace(raisonsocial,'''',' ') as rs,coalesce(d.idexploitation,0) as idexploit,d.siret,r.statut 
FROM bati.sb_data_1 d LEFT JOIN bati_data.ref_exploitation r USING (siret) where siret='".$_POST['siret']."'";
		
			}
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



if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="maj_fiche_exploitation2")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		
// Mise à jour de la table d'info 1 (couche bati)
		$requete2="UPDATE bati.sb_data_1 SET raisonsocial=upper('".$_POST['raisonsociale']."'),statut='".$_POST['norme']."' 
			 ,siret='".$_POST['siret']."' WHERE rowid= ".$_POST['rowid']."";
			
		$result2=pg_query($idcom,$requete2);
		echo $requete2;	
		pg_close($idcom);
		
	}
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="maj_fiche_exploitation")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		if(!empty($_POST['idexploitation']))
		{
// Mise à jour de la table d'info 1 (couche bati)
			$requete2="UPDATE bati.sb_data_1 SET raisonsocial=upper('".$_POST['raisonsociale']."'),statut='".$_POST['norme']."' 
			,idexploitation='".$_POST['idexploitation']."' ,siret='".$_POST['siret']."',localisation='".$_POST['localisation']."',datemodification=now()  WHERE rowid= ".$_POST['rowid']."";
			
			$result2=pg_query($idcom,$requete2);
			
// MISE A JOUR EXPLOITATION
			if($_POST['siret']==$_POST['idsiret'] )
{
// ALORS pas de changement de siret
			$requete="INSERT INTO bati_data.ref_exploitation(siret,idexploitation,statut) VALUES ('".$_POST['siret']."','".$_POST['idexploitation']."','".$_POST['norme']."')";		
			$result=pg_query($idcom,$requete);
			
			} else {
// Alors changement de siret
			$requete="UPDATE bati_data.ref_exploitation SET siret='".$_POST['siret']."'  WHERE siret='".$_POST['idsiret']."'";
		$result=pg_query($idcom,$requete);
		$requete="UPDATE bati_data.sb_data_1 SET siret='".$_POST['siret']."'  WHERE rowid= ".$_POST['rowid']."";
		$result=pg_query($idcom,$requete);
		
			}
		}
		else
		{
// Mise à jour de la table d'info 1 (couche bati)
			$requete2="UPDATE bati.sb_data_1 SET raisonsocial=upper('".$_POST['raisonsociale']."'),statut='".$_POST['norme']."' 
			,siret='".$_POST['siret']."',localisation='".$_POST['localisation']."',datemodification=now()  WHERE rowid= ".$_POST['rowid']."";
			
			$result2=pg_query($idcom,$requete2);
			
// MISE A JOUR EXPLOITATION
			if($_POST['siret']==$_POST['idsiret'] )
{
// ALORS pas de changement de siret
			$requete="INSERT INTO bati_data.ref_exploitation(siret,idexploitation,statut) VALUES ('".$_POST['siret']."','".$_POST['idexploitation']."','".$_POST['norme']."')";		
			$result=pg_query($idcom,$requete);
			//echo $requete;
			} else {
// Alors changement de siret
			$requete="UPDATE bati_data.ref_exploitation SET siret='".$_POST['siret']."'  WHERE siret='".$_POST['idsiret']."'";
		$result=pg_query($idcom,$requete);
		$requete="UPDATE bati_data.sb_data_1 SET siret='".$_POST['siret']."'  WHERE siret='".$_POST['idsiret']."'";
		$result=pg_query($idcom,$requete);
		//echo $requete;
			}
		
		}
		pg_close($idcom);
		
	}


if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="maj_statut_i")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		
// Mise à jour de la table d'info 1 (couche bati)
		$requete2="UPDATE bati.sb_data_1 SET statut='".$_POST['norme']."',datemodification=now()  WHERE rowid='".$_POST['rowid']."'";
		$result2=pg_query($idcom,$requete2);

// MISE A JOUR EXPLOITATION
	$requete="UPDATE bati_data.ref_exploitation SET statut='".$_POST['norme']."'  WHERE siret='".$_POST['siret']."'";
	$result=pg_query($idcom,$requete);
echo  $requete;
		pg_close($idcom);
	}
	// MAJ de la localisation
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="majLocalisation")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		
// Mise à jour de la table d'info 1 (couche bati)
		$requete2="UPDATE bati.sb_data_1 SET localisation='".$_POST['localisation']."',datemodification=now()  WHERE rowid='".$_POST['rowid']."'";
		$result2=pg_query($idcom,$requete2);

		pg_close($idcom);
	}
// MISE A JOUR RAISONS SOCIAL
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="majrs")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		
// Mise à jour de la table d'info 1 (couche bati)
		$requete2="UPDATE bati.sb_data_1 SET raisonsocial='".$_POST['rs']."',datemodification=now()  WHERE siret='".$_POST['siret']."'";
		$result2=pg_query($idcom,$requete2);
echo $requete2;
		pg_close($idcom);
	}
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="changer_valeur_distance_old")
{
$idcom=connex2("bdaplat_nt","myparam");
// ON REGARDE SI L OBJET INTERSECTE D AUTRE OBJET
$requete1=" SELECT count(d2.rowid) as n
 FROM bati.sb_data_1 d1
,bati.sb_geom_1 g1,
bati.sb_data_1 d2,bati.sb_geom_1 g2 
WHERE d1.rowid=g1.rowid AND d2.rowid=g2.rowid AND  
st_intersects(st_buffer(g1.g,d1.distance),st_buffer(g2.g,d2.distance)) and d1.rowid= ".$_POST['rowid']."";

 // On récupère le numéro
	$result=pg_query($idcom,$requete1);	
		if($result !==false ){
		 
		$lire=pg_fetch_row($result);
		
			if($lire[0] == 1) {
			// Cas ou aire ne croise rien
			// v0
			// Mise à jour de la distance
// MISE A JOUR DU CHAMP GEOM BUFFER DISTANCE DANS GEOM 1
		$requete="UPDATE bati.sb_geom_2 SET g=(SELECT st_buffer(g149.g,cast(".$_POST['distance']." as integer)) as g FROM bati.sb_data_1 d149,bati.sb_geom_1 g149
			WHERE  d149.rowid=g149.rowid and d149.rowid=".$_POST['rowid'].") 
			WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result=pg_query($idcom,$requete);
// Mise à jour du champ update view de la table 2
		$requete2="UPDATE bati.sb_svg_2 SET update_view=1 WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR DU CHAMP DISTANCE DANS LA TABLE 149
		$requete2="UPDATE bati.sb_data_1 SET distance=".$_POST['distance']." WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
/////////////////////////////		
		$requete3="UPDATE bati.sb_geom_2 b SET g = (
 SELECT st_union(st_buffer(g1.g,a.distance)) as the_geom FROM bati.sb_data_1 a
 JOIN bati.sb_geom_1 g1 ON g1.rowid=a.rowid
 JOIN bati.sb_data_2 d2 ON d2.rowid_1=a.rowid
 WHERE d2.rowid IN (
 SELECT b1.rowid FROM bati.sb_data_2 d1,bati.sb_geom_2 b1 
  JOIN bati.sb_geom_2 b2 ON ST_Intersects(b1.g,b2.g) 
  JOIN bati.sb_data_2 d2 ON d2.rowid=b2.rowid 
  JOIN bati.sb_data_1 a ON a.rowid=d2.rowid_1 AND a.distance > 0 
  WHERE  d1.rowid=d2.rowid AND d1.rowid_1=".$_POST['rowid']."AND b1.rowid != d1.rowid ) )
 WHERE b.rowid IN  (  SELECT d3.rowid
  FROM bati.sb_data_1 d1,bati.sb_geom_1 g1 ,bati.sb_geom_1 g2 ,bati.sb_data_1 d2,bati.sb_data_2 d3
  WHERE St_intersects(st_buffer(g1.g,d1.distance),st_buffer(g2.g,d2.distance)) AND
  d1.rowid=".$_POST['rowid']." AND d1.rowid != d2.rowid and d3.rowid_1=d2.rowid
  GROUP BY d3.rowid)";
	$result3=pg_query($idcom,$requete3);
	
	$requete3="UPDATE bati.sb_svg_2 SET update_view=1 WHERE rowid IN
  (SELECT d3.rowid 
  FROM bati.sb_data_1 d1,bati.sb_geom_1 g1 ,bati.sb_geom_1 g2 ,bati.sb_data_1 d2,bati.sb_data_2 d3
  WHERE St_intersects(st_buffer(g1.g,d1.distance),st_buffer(g2.g,d2.distance)) AND
  d1.rowid=".$_POST['rowid']." AND d1.rowid != d2.rowid and d3.rowid_1=d2.rowid
  GROUP BY d3.rowid)";
  
	$result3=pg_query($idcom,$requete3);
	}  elseif ($lire[0] == 0)
{ 
// MISE A JOUR DU CHAMP GEOM BUFFER DISTANCE DANS GEOM 1
		$requete="UPDATE bati.sb_geom_2 SET g=(SELECT st_buffer(g149.g,cast(".$_POST['distance']." as integer)) as g FROM bati.sb_data_1 d149,bati.sb_geom_1 g149
			WHERE  d149.rowid=g149.rowid and d149.rowid=".$_POST['rowid'].") 
			WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result=pg_query($idcom,$requete);
// Mise à jour du champ update view de la table 2
		$requete2="UPDATE bati.sb_svg_2 SET update_view=1 WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result2=pg_query($idcom,$requete2);
// MISE A JOUR DU CHAMP DISTANCE DANS LA TABLE 149
		$requete2="UPDATE bati.sb_data_1 SET distance=".$_POST['distance']." WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
} else
	{
		$requete="UPDATE bati.sb_geom_2 SET g=(SELECT st_buffer(g149.g,cast(".$_POST['distance']." as integer)) as g FROM bati.sb_data_1 d149,bati.sb_geom_1 g149
			WHERE  d149.rowid=g149.rowid and d149.rowid=".$_POST['rowid'].") 
			WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result=pg_query($idcom,$requete);
		$requete2="UPDATE bati.sb_svg_2 SET update_view=1 WHERE rowid = (SELECT rowid FROM bati.sb_data_2 WHERE rowid_1= ".$_POST['rowid'].")";
		$result2=pg_query($idcom,$requete2);
				$requete2="UPDATE bati.sb_data_1 SET distance=".$_POST['distance']." WHERE rowid= ".$_POST['rowid']."";
		$result2=pg_query($idcom,$requete2);
				$requete3="UPDATE bati.sb_geom_2 b SET g = (
 SELECT st_Union(b1.g) as the_geom FROM bati.sb_data_2 d1,bati.sb_geom_2 b1 
  JOIN bati.sb_geom_2 b2 ON ST_Intersects(b1.g,b2.g) 
  JOIN bati.sb_data_2 d2 ON d2.rowid=b2.rowid 
  JOIN bati.sb_data_1 a ON a.rowid=d2.rowid_1 AND a.distance > 0 
  WHERE  d1.rowid=d2.rowid AND d1.rowid_1=".$_POST['rowid']."
 )
 WHERE b.rowid IN 
 (
 SELECT b1.rowid FROM bati.sb_data_2 d1,bati.sb_geom_2 b1 
  JOIN bati.sb_geom_2 b2 ON ST_Intersects(b1.g,b2.g) 
  JOIN bati.sb_data_2 d2 ON d2.rowid=b2.rowid 
  JOIN bati.sb_data_1 a ON a.rowid=d2.rowid_1 AND a.distance > 0 
  WHERE  d1.rowid=d2.rowid AND d1.rowid_1=".$_POST['rowid']."
 )";
				$result3=pg_query($idcom,$requete3);
		
				$requete3="UPDATE bati.sb_svg_2 SET update_view=1 WHERE rowid IN
  (
 SELECT b1.rowid FROM bati.sb_data_2 d1,bati.sb_geom_2 b1 
  JOIN bati.sb_geom_2 b2 ON ST_Intersects(b1.g,b2.g) 
  JOIN bati.sb_data_2 d2 ON d2.rowid=b2.rowid 
  JOIN bati.sb_data_1 a ON a.rowid=d2.rowid_1 AND a.distance > 0 
  WHERE  d1.rowid=d2.rowid AND d1.rowid_1=".$_POST['rowid']."
 )";
				$result3=pg_query($idcom,$requete3);
				
				}
		}

echo $lire[0];
	
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
//RECHERCHE COORDONNEES GEOGRAPHIQUES POUR LA LOCALISATION DE L objet
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_coor")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_X(st_centroid(st_transform(g,4326))) as lat,
ST_Y(st_centroid(st_transform(g,4326))) as long,'(Id : ' || rowid || ') ' || nature as rowid 
FROM bati.sb_geom_1 JOIN bati.sb_data_1 USING (rowid) WHERE rowid = ".$_POST['rowid']." LIMIT 1";
		
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

