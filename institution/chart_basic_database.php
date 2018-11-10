<?php
$labelsarr = array();
$totalsarr = array();
$chartarraydate = array();
$charttypedate = "line";
$linecolordate = "#3535b2";
$onclickeventdate = "null";
$stmt = $pdo->prepare('SELECT data_type, start_date, SUM(Requests) as totals FROM ' . DBTABLE . ' WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb AND start_date >= :startdate and start_date <= :enddate group by data_type,start_date');
$stmt->execute(['instabbrev' => $_GET['inst'], 'prodabb' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
$results = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

if ($results) {
	foreach($results as $datatypekey => $rowv) {
		foreach($rowv as $rowvv) {
			$keyarraydate[] = $rowvv['start_date'];
			$totalsarr[$rowvv['start_date']] = $rowvv['totals'];
		}

		$chartarraydate[$datatypekey] = $totalsarr;
		$xlabeldate = 'Date';
		$ylabeldate = 'Uses';
		$showlegenddate = 'true';
		$autoskipdate = 'false';
	}

	// make sure all dates appear in all arrays

	$chartarraydate = insertzeroes($chartarraydate)[0];
	$keyarraydate = insertzeroes($chartarraydate)[1];

	// prepare array for table display
	// flatten array

	$tablearrdate = array();
	foreach($keyarraydate as $lab) {
		foreach($results as $r2k => $r2v) {
			foreach($r2v as $r3k => $r3v) {
				if ($r3v['start_date'] === $lab) $tablearrdate[$lab][$r2k] = $r3v['totals'];
			}
		}
	}

	foreach($tablearrdate as $tabk => $tabv) {
		$tablearrdate[$tabk]['date'] = $tabk;
	}

	// sort by keys

	foreach($tablearrdate as $tabk => $tabv) {
		ksort($tabv);
		$tablearrdate[$tabk] = $tabv;
	}

	// reset array keys

	$results = array_values($tablearrdate);
	$results = insertzeroes($results)[0];

	// create vars to match name and structure of multi chart vars

	$allinstsdate = array_keys($chartarraydate);
	$groupings = 1;
	$datatablearrdate = array();
	foreach($results as $rs) {
		$datatablearrdate[$rs['date']] = $rs;
	}

	foreach($datatablearrdate as & $rs1) {
		unset($rs1['date']);
	}
}

?>
