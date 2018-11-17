<?php

// make sure a product is selected; if not, show usage summary

if (isset($_GET['product'])) {
	$productname = $_GET['product'];

	// get title list

	$stmt = $pdo->prepare('SELECT Title, Inst_type, SUM(Requests) as totals FROM ' . EBOOKTABLE . ' WHERE product_abbrev = :product AND start_date >= :startdate and start_date <= :enddate group by Title,Inst_type');
	$stmt->execute(['product' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultstitle = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

	//make sure there are results
	if ($resultstitle){
	// get all inst types

	foreach($resultstitle as $re) {
		$itypest[] = array_column($re, 'Inst_type');
	}

	$itypesuniqt = array();
	array_walk_recursive($itypest,
	function ($v, $k) use(&$itypesuniqt)
	{
		$itypesuniqt[] = $v;
	});
	$itypesuniqt = array_unique($itypesuniqt);
	sort($itypesuniqt);

	// make sure all inst types appear in all arrays

	foreach($resultstitle as $jtitle => & $rest) {
		foreach($itypesuniqt as $itypet) {
			if (!in_array($itypet, array_column($rest, 'Inst_type'))) {
				$rest[] = array(
					'Inst_type' => $itypet,
					'totals' => 0
				);
			}
		}

		// sort to put new entries in right place

		usort($rest, "sortbykey");
	}

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

	$stmts = $pdo->prepare('SELECT Institution, Inst_type, SUM(Requests) as totals, start_date FROM ' . EBOOKTABLE . ' WHERE product_abbrev = :product AND start_date >= :startdate and start_date <= :enddate group by Institution, start_date order by Inst_type DESC, Institution ASC');
	$stmts->execute(['product' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultssingle = $stmts->fetchAll();

	// group by institution

	$resultgrp = array();
	foreach($resultssingle as $element) {
		$resultgrp[$element['Institution']][] = $element;
	}

	$tablearr = array();
	foreach($resultgrp as $ginst => $grp) {
		$labelsarr[] = $ginst;
		$totalsarr[] = array_sum(array_column($grp, 'totals'));
		$typearr[] = $grp[0]['Inst_type'];
		$abbrevarr[] = institutionlookup($ginst, "Institution") ['Inst_abbrev'];
		$tablearr[$ginst] = array(
			"Inst_type" => $grp[0]['Inst_type'],
			"Usage" => array_sum(array_column($grp, 'totals'))
		);
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

	foreach($resultgrptype as $ginst => $grp) {
		$labelsarrtype[] = $ginst;
		$totalsarrtype[] = array_sum(array_column($grp, 'totals'));
		$typearrtype[] = $grp[0]['Inst_type'];
		$tablearrgrp[$grp[0]['Inst_type']] = array_sum(array_column($grp, 'totals'));
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
