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

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

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
include dirname(dirname(__FILE__)) . "/includes/preparedates.php";

// run queries for each benchmark

foreach($bencharray as $thisbench) {
	$labelsarr = array();
	$totalsarr = array();

	// make sure a product is selected; if not, show usage summary

	if (isset($_GET['product'])) {
		$instnamecur = $thisbench;
		$productname = $_GET['product'];
		$charttype = "bar";
		$linecolor = "#ccc";
		$onclickevent = "null";
		$stmt = $pdo->prepare('SELECT Title, SUM(Requests) as totals FROM  ' . EBOOKTABLE . '  WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb AND start_date >= :startdate and start_date <= :enddate group by Title');
		$stmt->execute(['instabbrev' => $instnamecur, 'prodabb' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$results = $stmt->fetchAll();
		if ($results) {
			$totalresults[] = count($results);
			foreach($results as $row) {
				$labelsarr[] = str_replace("'", "\'", $row['Title']);
				$totalsarr[str_replace("'", "\'", $row['Title']) ] = $row['totals'];
				$datatablearr[str_replace("'", "\'", $row['Title']) ][$instnamecur] = $row['totals'];
			}

			// push all data to master array

			$chartarray[$instnamecur] = $totalsarr;
			$xlabel = 'Title';
			$ylabel = 'Uses';

			// calculate number groupings

			$groupednums = array_count_values($totalsarr);

			// sort by uses

			ksort($groupednums);
			$chartarraygrp[$instnamecur] = $groupednums;
			$xlabelgrp = 'Total Use';
			$ylabelgrp = 'Number of Titles';
			$showlegendgrp = 'false';
			$onclickeventgrp = "filtertitles";
			$autoskipgrp = 'true';
			$charttypegrp = "bar";
			$keyarraygrp = array();
			foreach($chartarraygrp as $arr) {
				foreach($arr as $arrk => $arrv) {
					$keyarraygrp[] = $arrk;
				}
			}

			$charttypedate = "line";
			$linecolordate = "#3535b2";
			$onclickeventdate = "null";
			$labelsarrdate = array();
			$totalsarrdate = array();
			$stmt = $pdo->prepare('SELECT start_date, SUM(Requests) as totals FROM  ' . EBOOKTABLE . '  WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb AND start_date >= :startdate and start_date <= :enddate group by start_date');
			$stmt->execute(['instabbrev' => $instnamecur, 'prodabb' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
			$resultsdate = $stmt->fetchAll();
			foreach($resultsdate as $row) {
				$labelsarrdate[] = $row['start_date'];
				$totalsarrdate[$row['start_date']] = $row['totals'];
				$datatablearrdate[$row['start_date']][$instnamecur] = $row['totals'];
			}

			// push all data to master array

			$chartarraydate[$instnamecur] = $totalsarrdate;
			$xlabeldate = 'Date';
			$ylabeldate = 'Uses';
			$showlegenddate = 'true';
			$autoskipdate = 'false';
		}
		//if not results, inserts zeroes for usage summary graph
		else{
			$chartarraygrp[$instnamecur] = [];
		}
	}
}

// sort totals array to find the biggest; don't display if too big

rsort($totalresults);

// make sure missing titles/packages appear in all arrays

$titlearrayfull = insertzeroes($chartarray);
$chartarray = $titlearrayfull[0];
$keyarray = $titlearrayfull[1];
$datearrayfull = insertzeroes($chartarraydate);
$chartarraydate = $datearrayfull[0];
$keyarraydate = $datearrayfull[1];
$grouparrayfull = insertzeroes($chartarraygrp);
$chartarraygrp = $grouparrayfull[0];
$keyarraygrp = $grouparrayfull[1];

function Quartile_25($Array)
{
	return Quartile($Array, 0.25);
}

function Quartile_50($Array)
{
	return Quartile($Array, 0.5);
}

function Quartile_75($Array)
{
	return Quartile($Array, 0.75);
}

function Quartile($Array, $Quartile)
{
	$pos = (count($Array) - 1) * $Quartile;
	$base = floor($pos);
	$rest = $pos - $base;
	if (isset($Array[$base + 1])) {
		return $Array[$base] + $rest * ($Array[$base + 1] - $Array[$base]);
	}
	else {
		return $Array[$base];
	}
}

$keyarraygrp = array_values($keyarraygrp);

// subtract the third from the first quartile to get IQR or summat

$iqr = Quartile_75($keyarraygrp) - Quartile_25($keyarraygrp);
$maxrange = Quartile_75($keyarraygrp) + $iqr;
$maxnum = 1;

// find nearest set value to the max range

foreach($keyarraygrp as $kgrp) {
	if ($kgrp < $maxrange) {
		$maxnum = $kgrp;
		continue;
	}
	else {
		$maxnum = $maxnum;
		break;
	}
}

$outliers = array();

// grab first elemtn in chart array, we don't know what the key (instname) is but who cares
// find values are greater than the max range (i.e. how many outliers)
foreach($chartarraygrp as $chartinst => $chartarr) {
	foreach($chartarr as $tick => $cnt) {
		if ($tick > $maxrange) {
			$outliers[$chartinst][$tick] = $cnt;
		}
	}
}

$numoutliers = count($outliers);
end($chartarraygrp);
$chartarraygrpexpanded = array();

// insert zeroes to make expanded graph

for ($i = 1; $i <= $maxnum; $i++) {
	foreach($chartarraygrp as $instgrp => $cgrp) {

		// add if not present as a key in original array

		if (!array_key_exists($i, $cgrp)) {
			$chartarraygrpexpanded[$instgrp][$i] = 0;
		}
		else {
			$chartarraygrpexpanded[$instgrp][$i] = $cgrp[$i];
		}
	}
}

// insert a blank value at the end for funsies
// or just to put a space before the outliers

reset($chartarraygrpexpanded);
$last_key = key(array_slice(current($chartarraygrpexpanded) , -1, 1, TRUE));
end($chartarraygrpexpanded);

foreach($chartarraygrpexpanded as & $cgrpex) {
	$cgrpex[$last_key + 1] = 0;
}

$keyarraygrpexpanded = array();
reset($chartarraygrpexpanded);

foreach(current($chartarraygrpexpanded) as $arrk => $arrv) {
	$keyarraygrpexpanded[] = $arrk;
}

end($chartarraygrpexpanded);
$st = count($keyarraygrpexpanded) + $numoutliers;

// add extra slots to the key array, increment by one (these labels will be hidden)

for ($i = count($keyarraygrpexpanded) + 1; $i <= $st; $i++) {
	$keyarraygrpexpanded[] = $i;
}

// merge filled in array and outliers, if there are any

if ($outliers) {
	foreach($chartarraygrpexpanded as $instk => & $cht) {
		if ($outliers[$instk]) {
			$cht = $cht + $outliers[$instk];
		}
	}
}

// get all keys again with their actual values

reset($chartarraygrpexpanded);
$realkeys = array_keys(current($chartarraygrpexpanded));
end($chartarraygrpexpanded);

// set up datatables

ksort($chartarraygrpexpanded);

foreach($chartarraygrpexpanded as $grpsint => $grpexp) {
	foreach($grpexp as $nm => $tt) {
		$grpdatatable[$nm][$grpsint] = $tt;
	}
}

// get all institutions
// $allinsts = array_keys_multi($datatablearr);

$allinsts = $bencharray;
asort($allinsts);

// insert zeroes

foreach($datatablearr as $titlekey => $arr1) {
	foreach($allinsts as $inst) {
		if (!array_key_exists($inst, $arr1)) {
			$datatablearr[$titlekey][$inst] = '0';
		}
	}
}

// sort by keys to keep in right order

foreach($datatablearr as & $datatab) {
	ksort($datatab);
}

// get all institutions
// $allinstsdate = array_keys_multi($datatablearrdate);

$allinstsdate = $bencharray;
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

?>
