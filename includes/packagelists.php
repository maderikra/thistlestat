<?php

//get all vendors
$stmtv = $pdo->query('SELECT Vendor, vendor_abbrev FROM ' . VENDORSTABLE . ' group by vendor_abbrev');
$allvendors = $stmtv->fetchAll();

//get all databases
$stmtdb = $pdo->query('SELECT Product, product_abbrev FROM ' . DBTABLE . ' group by product_abbrev ORDER BY Product');
$alldatabases = $stmtdb->fetchAll();
foreach ($alldatabases as &$alldb){
	$alldb['type'] = "database";	
}

//get all journals
$stmtj = $pdo->query('SELECT Product, product_abbrev FROM ' . JOURNALTABLE . ' group by product_abbrev ORDER BY Product');
$alljournals = $stmtj->fetchAll();
foreach ($alljournals as &$allj){
	$allj['type'] = "journal";	
}

//get all e-books
$stmtb = $pdo->query('SELECT Product, product_abbrev FROM ' . EBOOKTABLE . ' group by product_abbrev ORDER BY Product');
$allebooks = $stmtb->fetchAll();
foreach ($allebooks as &$allb){
	$allb['type'] = "ebook";	
}

$allproducts = array_merge($alldatabases,$alljournals,$allebooks);

//sort
function cmp($a, $b){
	return strcmp($a["Product"], $b["Product"]);
}
usort($allproducts, "cmp");


?>