<?php
include("../assets/connex.inc.php");

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_shape")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(p.iep_par_geom,4326)),(
SELECT st_y(st_centroid(st_transform(st_union(px.iep_par_geom),4326)))  as cc FROM parcelles_2013 px 
WHERE iep_idexploitation='".$_POST['rowid']."'
) as y,
(
SELECT st_x(st_centroid(st_transform(st_union(px.iep_par_geom),4326)))  as cc FROM parcelles_2013 px 
WHERE iep_idexploitation='".$_POST['rowid']."'
) as x,
coalesce(iep_par_rdtmoy,0) as cultid,iep_par_cultlibusage,exp_raisonsociale
FROM public.parcelles_2013 p
WHERE 
p.iep_idexploitation='".$_POST['rowid']."'";
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

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="recherche_shape_2")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(p.iep_par_geom,4326)),
st_y(st_centroid(st_transform((tc.geom),4326))) as y,
st_x(st_centroid(st_transform((tc.geom),4326))) as x,
coalesce(iep_par_rdtmoy,0)::numeric(10,2) as cultid,iep_par_cultlibusage,exp_raisonsociale,iep_par_comlib
FROM public.parcelles_2015 p
JOIN public.tcommunes tc ON idcommune=iep_par_comcode
WHERE 
tc.nom='".$_POST['rowid']."'";
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

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="afficher_une_commune")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(geom,4326)),
st_y(st_centroid(st_transform((tc.geom),4326))) as y,
st_x(st_centroid(st_transform((tc.geom),4326))) as x,nom FROM public.tcommunes tc
WHERE  tc.nom='".$_POST['idcommune']."'";

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


if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="afficher_bati_agricole")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(g.g,4326)),
st_y(st_centroid(st_transform((g.g),4326))) as y,
st_x(st_centroid(st_transform((g.g),4326))) as x,
d.nature || ', ' || d.raisonsocial as d,lien_maj as url
FROM
bati.sb_data_1 d
JOIN bati.sb_geom_1 g USING (rowid)";

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
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_sondage")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT ST_AsGeoJSON(st_transform(g.g,4326)),
st_y(st_centroid(st_transform((g.g),4326))) as y,
st_x(st_centroid(st_transform((g.g),4326))) as x,
d.classif_lo as d,nom_mat_p as url
FROM
bdaplat_nt.sb_data_158 d
JOIN bdaplat_nt.sb_geom_158 g USING (rowid) WHERE 
st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),20000)
			
			,st_setSRID(g.g,310024140))";

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
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="ac")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT nom FROM public.tcommunes tc WHERE nom like '%".$_POST['q']."%' order by nom";

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


if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="afficher_contrats")
	{
		$idcom=connex("bdaplat","myparam");
		$requete="SELECT
con_mesurelib || ' ' || exp_raisonsociale as n,iep_ilo_numero as numilot,con_numero as numelt,surface,idmesurecontrat,geom,x,y
FROM
(
SELECT con_mesurelib,ti.taux_couverture_parcelle_par_contrat as tx1,p.exp_raisonsociale,iep_ilo_numero,cast(con_numero as integer) as con_numero,con_dimension::numeric(10,2) as surface,idmesurecontrat,
max(ti2.taux_couverture_parcelle_par_contrat) as txmax,ST_AsGeoJSON(st_transform(c.geom,4326)) as geom,st_y(st_centroid(st_transform((c.geom),4326))) as y,
st_x(st_centroid(st_transform((c.geom),4326))) as x
FROM contrats_2014_polygone c
JOIN tindic_contrats_2014_polygone ti USING (idmesurecontrat)
JOIN tindic_contrats_2014_polygone ti2 USING (idmesurecontrat)
JOIN parcelles_2014 p ON p.iep_idparcelleculturale=ti.idparcelleculturale
WHERE con_mesurelib LIKE 'LO_VEZO%'
AND ti.taux_couverture_parcelle_par_contrat > 0 
GROUP BY con_mesurelib,ti.taux_couverture_parcelle_par_contrat,p.exp_raisonsociale,iep_ilo_numero,con_numero,con_dimension,c.idmesurecontrat,c.geom
ORDER BY p.exp_raisonsociale,cast(con_numero as integer)

) as r
WHERE tx1=txmax";

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
//RECHERCHE DE PARCELLES CULTURALES

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_parcelle")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(p.iep_par_geom,4326)) as g,p.exp_raisonsociale || ' (' || coalesce(iep_par_cultcoderpg,'NR') || ')' as t ,iep_ilo_numero,coalesce(iep_par_cultlibusage,'NR') as culture,iep_ilo_millesime as millesime,exp_adresse || ', ' || exp_comcodepostal || ' ' || te.exp_comnom as adresse,
(
st_distance(st_transform 
		(st_setSRID(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140)
			
			,p.iep_par_geom))::numeric(10) as dist,st_y(st_centroid(st_transform((p.iep_par_geom),4326))) as y,
st_x(st_centroid(st_transform((p.iep_par_geom),4326))) as x,iep_par_culttypelib 
FROM 
public.parcelles_2014 p 
JOIN texploitations te ON te.idexploitation=p.iep_idexploitation 
WHERE 
st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),5000)
			
			,p.iep_par_geom)";


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
// RECHERCHE ILOTS
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_ilots")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(p.ilo_geom,4326)) as g,p.exp_raisonsociale || ' (N° ' || ilo_numero || '/ ' || ilo_surfacesaisie || ' ha )' as t, 'Num : ' || ilo_numero as numero
,st_y(st_centroid(st_transform((p.ilo_geom),4326))) as y,
st_x(st_centroid(st_transform((p.ilo_geom),4326))) as x 
FROM  
public.ilots_2015 p 
WHERE 
st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),2154),5000)
			
			,p.ilo_geom)";


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
// RECHERCHE BATI AGRICOLE
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_agricole")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(g.g,4326)) as g,p.nature || ' (' || raisonsocial || ')' as t, lien_maj as url
,st_y(st_centroid(st_transform((g.g),4326))) as y,
st_x(st_centroid(st_transform((g.g),4326))) as x 
FROM  
bati.sb_data_1 p 
JOIN bati.sb_geom_1 g USING (rowid)
WHERE 
st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),1000)
			
			,st_setSRID(g.g,310024140))";


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
// RECHERCHE DES ZONES NATURA 2000 habitats dans un rayon de 5000m
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_natura")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="
SELECT St_AsGeoJSON(st_transform(p.g,4326)) as g,
d.minom ,
-- Distance
(
st_distance(st_transform 
		(st_setSRID(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140)
			
			,st_setSRID(p.g,310024140)))::numeric(10) as dist,st_y(st_centroid(st_transform((p.g),4326))) as y,
st_x(st_centroid(st_transform((p.g),4326))) as x
FROM
bdaplat_nt.sb_geom_9 p
JOIN bdaplat_nt.sb_data_9 d USING (rowid)
WHERE


st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),10000)
			
			,st_setSRID(p.g,310024140)) ";


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
// RECHERCHE DES PPC habitats dans un rayon de 5000m
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_ppc")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="
SELECT St_AsGeoJSON(st_transform(p.g,4326)) as g,
d.nom_captag || ' / ' || d.nom_uge as nom, type_peri as perimetre,
(
st_distance(st_transform 
		(st_setSRID(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140)
			
			,st_setSRID(p.g,310024140)))::numeric(10) as dist,st_y(st_centroid(st_transform((p.g),4326))) as y,
st_x(st_centroid(st_transform((p.g),4326))) as x
FROM 
bdaplat_nt.sb_geom_196 p 
JOIN bdaplat_nt.sb_data_196 d USING (rowid) 
WHERE 
st_isvalid(p.g) and type_peri IN ('RAPPROCHE','ELOIGNE') AND

st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),5000)
			
			,st_setSRID(p.g,310024140)) ";


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
// AFFICHAGE DES ZONES VULNERABLES

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_zv")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(st_simplify(p.g,50),4326)) as g,d.bassin FROM
bdaplat_nt.sb_geom_148 p 
JOIN bdaplat_nt.sb_data_148 d USING (rowid)";


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
// VERSION ALLEGE AVEC SEULEMENT INTERSECTION
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_zv2")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(st_union(p.g),4326)) as g,
'Zone Vulnérable' as bassin
			
		,st_y(st_centroid(st_transform((st_union(p.g)),4326))) as y,
st_x(st_centroid(st_transform((st_union(p.g)),4326))) as x
FROM 
bdaplat_nt_data.grid_zv p 
WHERE 
st_isvalid(p.g) and

st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),20000)
			
			,st_setSRID(p.g,310024140)) ;";


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
	
	// RECHERCHE CADASTRE 88
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="infoCadastre")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(p.g,4326)) as g,
d.sect_nun as secteur, idu as idu,
(
st_distance(st_transform 
		(st_setSRID(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140)
			
			,st_setSRID(p.g,310024140)))::numeric(10) as dist,st_y(st_centroid(st_transform((p.g),4326))) as y,
st_x(st_centroid(st_transform((p.g),4326))) as x
FROM 
bdaplat_nt.sb_geom_156 p 
JOIN bdaplat_nt.sb_data_156 d USING (rowid) 
WHERE 
st_isvalid(p.g) and

st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),500)
			
			,st_setSRID(p.g,310024140)) ";


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
		
	// RECHERCHE BD PARCELLAIRE 54
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="infoBdParcellaire54")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(p.g,4326)) as g,
d.section || d.numero as secteur, nom_com as idu,
(
st_distance(st_transform 
		(st_setSRID(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140)
			
			,st_setSRID(p.g,310024140)))::numeric(10) as dist,st_y(st_centroid(st_transform((p.g),4326))) as y,
st_x(st_centroid(st_transform((p.g),4326))) as x
FROM 
bdaplat_nt.sb_geom_199 p 
JOIN bdaplat_nt.sb_data_199 d USING (rowid) 
WHERE 
st_isvalid(p.g) and

st_intersects( 
		st_buffer( st_transform 
		(st_setSRID
			(st_makepoint(".$_POST['lat'].",".$_POST['lng']."),4326),310024140),200)
			
			,st_setSRID(p.g,310024140)) ";


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
	
	// RECHERCHE POINT OBSERVATION

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=="info_obs")
	{
		$idcom=connex2("bdaplat_nt","myparam");
		$requete="SELECT St_AsGeoJSON(st_transform(geom,4326)) as g,soustypepnctueleau || ' (' || info || ')' as t, typeinformation as url
,st_y(st_centroid(st_transform((geom),4326))) as y,
st_x(st_centroid(st_transform((geom),4326))) as x 
FROM  
environnement.ponctueletudeeau";


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