<?php
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=" . $_GET['inst'] . "_" . $_GET['product'] . ".csv");
header("Pragma: no-cache");
header("Expires: 0");
include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
$stmt = $pdo->prepare('SELECT * FROM ' . $_GET['type'] . ' WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb');
$stmt->execute(['instabbrev' => $_GET['inst'], 'prodabb' => $_GET['product']]);
$results = $stmt->fetchAll();
//get keys for column headings
$headings = array_keys($results[0]);
echo '"' . implode('","', $headings) . '"' . "\n";
foreach ($results as $r){
echo '"' . implode('","', $r) . '"' . "\n";
}
die;
?>