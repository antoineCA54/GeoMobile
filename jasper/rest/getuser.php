<?php
	require('client/JasperClient.php');
	$jc = new Jasper\JasperClient('192.168.20.13', 8080, 'jasperadmin', 's36a6euh', '/jasperserver', 'organization_1');
	$users = $jc->getUsers();
	echo json_encode($users);
?>	