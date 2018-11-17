<?php

function array_keys_multi(array $array)
{
	$keys = array();
	foreach($array as $value) {
		foreach($value as $key => $val) {
			if (!in_array($key, $keys)) {
				$keys[] = $key;
			}
		}
	}

	return $keys;
}

// get all benchmarks

$bencharray = array();
$bencharray['inst'] = $_GET['inst'];

foreach($_GET as $key => $value) {
	if (strpos($key, 'benchmark') === 0) {
		$bencharray[$key] = $value;
	}
}

// dedupe benchmarks, in case the same one got added twice

$bencharray = array_unique($bencharray);
$instnamecur = 'None selected';
$productname = 'None selected';
$i = 0;
$chartarray = array();
$results = false;
// run queries for each benchmark

foreach($bencharray as $thisbench) {
	$labelsarrdate = array();

	// make sure a product is selected; if not, show usage summary

	if (isset($_GET['product'])) {
		$instnamecur = $thisbench;
		$productname = $_GET['product'];
		$charttypedate = "line";
		$linecolordate = "#3535b2";
		$onclickeventdate = "null";
		$stmt = $pdo->prepare('SELECT start_date, data_type, SUM(Requests) as totals FROM ' . DBTABLE . ' WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb AND start_date >= :startdate and start_date <= :enddate group by start_date, data_type');
		$stmt->execute(['instabbrev' => $instnamecur, 'prodabb' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$results1 = $stmt->fetchAll();
		if($results1){
		$results = $results1;
		foreach($results as $row) {
			$labelsarrdate[] = $row['start_date'];
			$totalsarrdate[$instnamecur . ": " . $row['data_type']][$row['start_date']] = $row['totals'];
			$datatablearrdate[$row['start_date']][$instnamecur . ": " . $row['data_type']] = $row['totals'];
		}

		// push all data to master array

		foreach($totalsarrdate as $totk => $totv) {
			$chartarraydate[$totk] = $totv;
		}

		$xlabeldate = 'Date';
		$ylabeldate = 'Uses';
	}
	}
	$i++;
}

//only proceed if there is at least one set of results
if ($results){
	// make sure missing titles/packages appear in all arrays

	$datearrayfull = insertzeroes($chartarraydate);
	$chartarraydate = $datearrayfull[0];
	$keyarraydate = $datearrayfull[1];

	// set up datatables
	// get all institutions

	$allinsts = array_keys_multi($datatablearrdate);
	asort($allinsts);

	// insert zeroes

	foreach($datatablearrdate as $titlekey => $arr1) {
		foreach($allinsts as $inst) {
			if (!array_key_exists($inst, $arr1)) {
				$datatablearrdate[$titlekey][$inst] = '0';
			}
		}
	}

	// sort by keys to keep in right order

	foreach($datatablearrdate as & $datatab) {
		ksort($datatab);
	}

	// get all institutions

	$allinstsdate = array_keys_multi($datatablearrdate);
	asort($allinstsdate);

	// insert zeroes

	foreach($datatablearrdate as $titlekey => $arr1) {
		foreach($allinstsdate as $inst) {
			if (!array_key_exists($inst, $arr1)) {
				$datatablearrdate[$titlekey][$inst] = '0';
			}
		}
	}

	// sort by keys to keep in right order

	foreach($datatablearrdate as & $datatab) {
		ksort($datatab);
	}

	// count number of groups so we can cycle through the dashed formats accurately

	$groupings = count($chartarraydate) / $i;
}
?>
