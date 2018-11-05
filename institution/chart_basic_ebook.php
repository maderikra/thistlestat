<?php
$labelsarr = array();
$totalsarr = array();
$chartarray = array();
$charttype = "bar";
$linecolor = "#ccc";
$onclickevent = "null";
$stmt = $pdo->prepare('SELECT Title, SUM(Requests) as totals FROM ' . EBOOKTABLE . ' WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb AND start_date >= :startdate and start_date <= :enddate group by Title');
$stmt->execute(['instabbrev' => $_GET['inst'], 'prodabb' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
$results = $stmt->fetchAll();

if ($results) {
	foreach($results as $row) {
		$labelsarr[] = str_replace("'", "\'", $row['Title']);
		$totalsarr[str_replace("'", "\'", $row['Title']) ] = $row['totals'];
	}

	$totalresults = count($labelsarr);

	// set up var to match benchmarked variable

	$allinsts[0] = $_GET['inst'];
	foreach($results as $dk => $da) {
		$datatablearr[$da['Title']][$_GET['inst']] = $da['totals'];
	}

	$chartarray[$_GET['inst']] = $totalsarr;
	$xlabel = 'Title';
	$ylabel = 'Total Use';
	$showlegend = 'true';
	$autoskip = 'false';

	// get all labels in all results

	$keyarray = array();
	foreach($chartarray as $arr) {
		foreach($arr as $arrk => $arrv) {
			$keyarray[] = $arrk;
		}
	}

	// calculate number groupings

	$groupednums = array_count_values($totalsarr);

	// sort by uses

	ksort($groupednums);
	$chartarraygrp[] = $groupednums;
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

	// subtract the third from the first quartile to get IQR or summat

	$iqr = Quartile_75($keyarraygrp) - Quartile_25($keyarraygrp);
	$maxrange = Quartile_75($keyarraygrp) + $iqr;
	$maxnum = 1;

	// find nearest set value to the max range

	foreach($keyarraygrp as $kgrp) {
		if ($kgrp <= $maxrange) {
			$maxnum = $kgrp;
			continue;
		}
		else {
			$maxnum = $maxnum;
			break;
		}
	}

	// count how many values are greater than the max range (i.e. how many outliers)
	// $numoutliers = array_reduce($keyarraygrp, function ($a, $b)use($maxrange) { return ($b > $maxrange) ? ++$a : $a; });

	$outliers = array();

	// find values are greater than the max range (i.e. how many outliers)

	reset($chartarraygrp);
	foreach(current($chartarraygrp) as $tick => $cnt) {
		if ($tick > $maxrange) {
			$outliers[$tick] = $cnt;
		}
	}

	$numoutliers = count($outliers);
	end($chartarraygrp);
	$chartarraygrpexpanded = array();

	// insert zeroes to make expanded graph; start at lowest number rather than 0

	for ($i = $keyarraygrp[0]; $i <= $maxnum; $i++) {

		// add if not present as a key in original array

		if (!array_key_exists($i, $chartarraygrp[0])) {
			$chartarraygrpexpanded[0][$i] = 0;
		}
		else {
			$chartarraygrpexpanded[0][$i] = $chartarraygrp[0][$i];
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

	// merge filled in array and outliers

	$chartarraygrpexpanded[0] = $chartarraygrpexpanded[0] + $outliers;

	// get all keys again with their actual values

	reset($chartarraygrpexpanded);
	$realkeys = array_keys(current($chartarraygrpexpanded));
	end($chartarraygrpexpanded);
	foreach($chartarraygrpexpanded[0] as $grpnm => $grpexp) {
		$grpdatatable[$grpnm][$_GET['inst']] = $grpexp;
	}

	$charttypedate = "line";
	$linecolordate = "#3535b2";
	$onclickeventdate = "null";
	$stmtdate = $pdo->prepare('SELECT start_date, SUM(Requests) as totals FROM ' . EBOOKTABLE . ' WHERE Inst_abbrev = :instabbrev AND product_abbrev = :prodabb AND start_date >= :startdate and start_date <= :enddate group by start_date ORDER BY start_date asc');
	$stmtdate->execute(['instabbrev' => $_GET['inst'], 'prodabb' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultsdate = $stmtdate->fetchAll();
	foreach($resultsdate as $row) {
		$labelsarrdate[] = $row['start_date'];
		$totalsarrdate[$row['start_date']] = $row['totals'];
	}

	// set up var to match benchmarked variable

	$allinstsdate[0] = $_GET['inst'];
	foreach($totalsarrdate as $dk => $da) {
		$datatablearrdate[$dk][$_GET['inst']] = $da;
	}

	$totalresultsdate = count($labelsarrdate);
	$chartarraydate[$_GET['inst']] = $totalsarrdate;
	$xlabeldate = 'Date';
	$ylabeldate = 'Total Use';
	$showlegenddate = 'true';
	$autoskipdate = 'false';
	$keyarraydate = array();
	foreach($chartarraydate as $arr) {
		foreach($arr as $arrk => $arrv) {
			$keyarraydate[] = $arrk;
		}
	}

	// dedupe

	$keyarray = array_unique($keyarray);
	$keyarraydate = array_unique($keyarraydate);
	$keyarraygrp = array_unique($keyarraygrp);

	// sort it
	// i hope this wasn't important 3-21-18
	// asort($keyarray);

}

?>