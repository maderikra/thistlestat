<?php

// make sure a product is selected; if not, show usage summary

if (isset($_GET['product'])) {
	$productname = $_GET['product'];
	$charttypetype = "bar";
	$linecolortype = "#ccc";
	$onclickeventtype = "null";
	$charttype = "horizontalBar";
	$linecolor = "#ccc";
	$onclickevent = "loadinstitution";
	$charttypedate = "line";
	$linecolordate = "#3535b2";
	$onclickeventdate = "drilldown";
	$onclickeventdateinst = "gotoinstitution";
	$xlabeldate = 'Date';
	$ylabeldate = 'Total Use';
	$showlegenddate = 'true';
	$autoskipdate = 'false';

	// single query

	$stmts = $pdo->prepare('SELECT Institution, Inst_type, SUM(Requests) as totals, data_type, start_date FROM ' . DBTABLE . ' WHERE product_abbrev = :product AND start_date >= :startdate and start_date <= :enddate group by Institution, data_type, start_date order by Inst_type DESC, Institution ASC');
	$stmts->execute(['product' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultssingle = $stmts->fetchAll();

	//make sure there are results
	if ($resultssingle){
	// group by institution

	$resultgrp = array();
	foreach($resultssingle as $element) {
		$resultgrp[$element['Institution']][] = $element;
	}

	$tablearr = array();
	$stackedtotals = array();
	foreach($resultgrp as $ginst => $grp) {
		$sums = array();
		$labelsarr[] = $ginst;
		$typearr[] = $grp[0]['Inst_type'];
		$abbrevarr[] = institutionlookup($ginst, "Institution") ['Inst_abbrev'];

		// loop through sub elements to sum by data type

		foreach($grp as $grpe) {
			$sums[$grpe['data_type']][] = $grpe['totals'];
		}

		$tablearr[$ginst] = array(
			"Inst_type" => $grp[0]['Inst_type']
		);
		foreach($sums as $sumtype => $sumtot) {
			$stackedtotals[$ginst][$sumtype] = array_sum($sumtot);
		}
	}

	// make sure all types appear in all arrays

	$stackedfull = insertzeroes($stackedtotals);

	// add to table

	foreach($stackedfull[0] as $stkkey => $stk) {
		foreach($stk as $sttype => $sttot) {
			$tablearr[$stkkey][$sttype] = $sttot;
		}
	}

	$datatypes = $stackedfull[1];
	foreach($stackedfull[0] as $stacktot) {
		foreach($stacktot as $totsk => $totsv) {
			$dataset[$totsk][] = $totsv;
		}
	}

	ksort($tablearr);

	// group by institution and date

	$instdatearray = array();
	foreach($resultgrp as $gin => $gdat) {
		foreach($gdat as $datedata) {
			$instdatearray[$datedata['Inst_type']][$gin][$datedata['start_date']] = $datedata['totals'];
		}
	}

	// make sure all dates show up in all arrays
	// get all possible dates

	$alldates = array();
	foreach($instdatearray as $instarr) {
		foreach($instarr as $i1) {
			foreach($i1 as $ikey => $ival) {
				$alldates[] = $ikey;
			}
		}
	}

	// dedupe and sort

	$alldates = array_unique($alldates);
	sort($alldates);

	// check if each one exists

	foreach($instdatearray as & $igroup) {
		foreach($igroup as & $thisinst) {
			foreach($alldates as $ad) {
				if (!array_key_exists($ad, $thisinst)) {
					$thisinst[$ad] = 0;
				}
			}

			// re-sort to put new ones in correct places

			ksort($thisinst);
		}
	}

	// group by institution type

	$resultgrptype = array();
	$tablearrgrp = array();
	foreach($resultssingle as $element) {
		$resultgrptype[$element['Inst_type']][] = $element;
	}

	$stackedtotalsgrp = array();
	foreach($resultgrptype as $ginst => $grp) {
		$sums = array();
		$labelsarrtype[] = $ginst;

		// $totalsarrtype[] = array_sum(array_column($grp, 'totals'));

		$typearrtype[] = $grp[0]['Inst_type'];

		// $tablearrgrp[$grp[0]['Inst_type']] = array_sum(array_column($grp, 'totals'));
		// loop through sub elements to sum by data type

		foreach($grp as $grpe) {
			$sums[$grpe['data_type']][] = $grpe['totals'];
		}

		foreach($sums as $sumtype => $sumtot) {
			$stackedtotalsgrp[$ginst][$sumtype] = array_sum($sumtot);
		}
	}

	// make sure all types appear in all arrays

	$stackedfullgrp = insertzeroes($stackedtotalsgrp);

	// add to table

	foreach($stackedfullgrp[0] as $stkkeyg => $stkg) {
		foreach($stkg as $sttypeg => $sttotg) {
			$tablearrgrp[$stkkeyg][$sttypeg] = $sttotg;
		}
	}

	$datatypesgrp = $stackedfullgrp[1];
	foreach($stackedfullgrp[0] as $stacktotgrp) {
		foreach($stacktotgrp as $totskg => $totsvg) {
			$datasetgrp[$totskg][] = $totsvg;
		}
	}

	// group by date

	$dtarr = array();
	foreach($resultgrptype as $elemk => $element1) {
		foreach($element1 as $elem1) {
			$dtarr[$elemk][$elem1['start_date']][] = $elem1;
		}
	}

	$newarr2 = array();
	foreach($dtarr as $dtinst => $dtgrp) {
		foreach($dtgrp as $dt => $dta) {
			$monthtotals = array_sum(array_column($dta, 'totals'));
			$newarr2[$dtinst][$dt] = $monthtotals;
		}
	}

	// make sure all dates show up in all arrays
	// get all possible dates

	$alldatearr = array();
	foreach($newarr2 as $new) {
		foreach((array_keys($new)) as $ky) {
			$alldatearr[] = $ky;
		}
	}

	// dedupe and sort

	$alldatearr = array_unique($alldatearr);
	sort($alldatearr);

	// check if each one exists

	foreach($newarr2 as & $nwr) {
		foreach($alldatearr as $thisdate) {
			if (!array_key_exists($thisdate, $nwr)) {
				$nwr[$thisdate] = 0;
			}
		}

		ksort($nwr);
		}
	}
}
else {
	echo "Please select an institution.";
}

?>
