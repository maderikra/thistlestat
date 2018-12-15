<?php

// get journals
$charttype = "bar";
$linecolor = "#ccc";
$onclickeventj = "loadjournals";
$stmt = $pdo->prepare('SELECT Product, product_abbrev, Inst_type, SUM(Requests) as totals FROM ' . JOURNALTABLE . ' WHERE start_date >= :startdate and start_date <= :enddate group by Product, Inst_type order by Product,Inst_type ');
$stmt->execute(['startdate' => $startdate, 'enddate' => $enddate]);
$results = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
$labelsarr = array_keys($results);

foreach($labelsarr as $lbl) {
	$typearr[] = productlookup($lbl, 'Product') ['product_abbrev'];
}

// get all inst types
foreach($results as $res) {
	$itypes[] = array_column($res, 'Inst_type');
}

$itypesuniq = array();
array_walk_recursive($itypes,
function ($v, $k) use(&$itypesuniq)
{
	$itypesuniq[] = $v;
});
$itypesuniq = array_unique($itypesuniq);
sort($itypesuniq);

// make sure all inst types appear in all arrays
foreach($results as $pname1 => & $res0) {
	foreach($itypesuniq as $itype) {
		if (!in_array($itype, array_column($res0, 'Inst_type'))) {
			$res0[] = array(
				'product_abbrev' => productlookup($pname1, 'Product') ['product_abbrev'],
				'Inst_type' => $itype,
				'totals' => 0
			);
		}
	}

	// sort to put new entries in right place
	usort($res0, "sortbykey");
}

$datasetsj = array();

foreach($results as $res1) {
	foreach($res1 as $r1) {
		$datasetsj[$r1['Inst_type']][] = $r1['totals'];
	}
}

// add to array for datatable
foreach($results as $pname => $result) {
	$datatablearrj[] = array(
		"report_type" => "Journal",
		"abbrev" => $result[0]['product_abbrev'],
		"Vendor" => productlookup($pname, "Product") ['Vendor'],
		"Product" => $pname
	);
}

foreach($datatablearrj as & $dtarr) {
	$sum = 0;
	foreach($results[$dtarr['Product']] as $prd) {
		$dtarr[$prd['Inst_type']] = $prd['totals'];
		$sum+= $prd['totals'];
	}

	$dtarr['combined'] = $sum;
}

// get ebooks
$charttypeb = "bar";
$linecolorb = "#ccc";
$onclickeventb = "loadbooks";
$stmt = $pdo->prepare('SELECT Product, product_abbrev, Inst_type, SUM(Requests) as totals FROM ' . EBOOKTABLE . ' WHERE start_date >= :startdate and start_date <= :enddate group by Product, Inst_type order by Product,Inst_type ');
$stmt->execute(['startdate' => $startdate, 'enddate' => $enddate]);
$resultsb = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
$labelsarrb = array_keys($resultsb);

foreach($labelsarrb as $lbl) {
	$typearrb[] = productlookup($lbl, 'Product') ['product_abbrev'];
}

// get all inst types
foreach($resultsb as $res) {
	$itypesb[] = array_column($res, 'Inst_type');
}

$itypesuniqb = array();
array_walk_recursive($itypesb,
function ($v, $k) use(&$itypesuniqb)
{
	$itypesuniqb[] = $v;
});
$itypesuniqb = array_unique($itypesuniqb);
sort($itypesuniqb);

// make sure all inst types appear in all arrays
foreach($resultsb as $pnameb => & $resb) {
	foreach($itypesuniqb as $itypeb) {
		if (!in_array($itypeb, array_column($resb, 'Inst_type'))) {
			$resb[] = array(
				'Inst_type' => $itypeb,
				'totals' => 0,
				'product_abbrev' => productlookup($pnameb, 'Product') ['product_abbrev']
			);
		}
	}

	// sort to put new entries in right place
	usort($resb, "sortbykey");
}

$datasetsb = array();

foreach($resultsb as $res1b) {
	foreach($res1b as $r1b) {
		$datasetsb[$r1b['Inst_type']][] = $r1b['totals'];
	}
}

// add to array for datatable
foreach($resultsb as $pnameb => $resultb) {
	$datatablearrb[] = array(
		"report_type" => "EBook",
		"abbrev" => $resultb[0]['product_abbrev'],
		"Vendor" => productlookup($pnameb, "Product") ['Vendor'],
		"Product" => $pnameb
	);
}

foreach($datatablearrb as & $dtarr) {
	$sum = 0;
	foreach($resultsb[$dtarr['Product']] as $prd) {
		$dtarr[$prd['Inst_type']] = $prd['totals'];
		$sum+= $prd['totals'];
	}

	$dtarr['combined'] = $sum;
}

// get databases
$charttypedb = "bar";
$linecolordb = "#ccc";
$onclickeventdb = "loaddatabases";


$stmt = $pdo->prepare('SELECT Product, product_abbrev, Inst_type, SUM(Requests) as totals, data_type FROM ' . DBTABLE . ' WHERE start_date >= :startdate and start_date <= :enddate group by Product, Inst_type, data_type order by Product,Inst_type,data_type ');
$stmt->execute(['startdate' => $startdate, 'enddate' => $enddate]);
$resultsdb = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

// only show "record_view"; if that doesn't exist, just pick one that has "view" or doesn't have the word "serach" in it, if possible
foreach($resultsdb as $chkpack => $chk) {
	$dtypes = array();

	// get all datatypes for this package
	foreach($chk as $chk1) {
		$dtypes[] = $chk1['data_type'];
	}

	$dtypes = array_unique($dtypes);
	if (count($dtypes) == 1) {
		$selecteddtype = $dtypes[0];
	}
	else {
		$mtchs = preg_grep("/(V|v)iew/", $dtypes);

		// reset array keys
		$mtchs = array_values($mtchs);

		// if there are any data types with the word view, use the first one
		if (!empty($mtchs)) {
			$selecteddtype = $mtchs[0];
		}
		else {

			// if no "views", use anything without "search"
			foreach($dtypes as $dt1) {
				if (stripos($dt1, 'search') === false) {
					$selecteddtype = $dt1;
				}
			}
		}
	}

	// now dump out any data that isn't the selected data_type
	foreach($chk as $ck => $cv) {
		if ($cv['data_type'] <> $selecteddtype) {
			unset($resultsdb[$chkpack][$ck]);
		}
	}
}

$labelsarrdb = array_keys($resultsdb);

foreach($labelsarrdb as $lbl) {
	$typearrdb[] = productlookup($lbl, 'Product') ['product_abbrev'];
}

// get all inst types
foreach($resultsdb as $res) {
	$itypesdb[] = array_column($res, 'Inst_type');
}

$itypesuniqdb = array();
array_walk_recursive($itypesdb,
function ($v, $k) use(&$itypesuniqdb)
{
	$itypesuniqdb[] = $v;
});
$itypesuniqdb = array_unique($itypesuniqdb);
sort($itypesuniqdb);

// make sure all inst types appear in all arrays
foreach($resultsdb as $pnamed => & $resdb) {
	foreach($itypesuniqdb as $itypedb) {
		if (!in_array($itypedb, array_column($resdb, 'Inst_type'))) {
			$resdb[] = array(
				'Inst_type' => $itypedb,
				'totals' => 0,
				'product_abbrev' => productlookup($pnamed, 'Product') ['product_abbrev']
			);
		}
	}

	// sort to put new entries in right place
	usort($resdb, "sortbykey");
}

$datasetsdb = array();

foreach($resultsdb as $res1db) {
	foreach($res1db as $r1db) {
		$datasetsdb[$r1db['Inst_type']][] = $r1db['totals'];
	}
}

// add to array for datatable
foreach($resultsdb as $pnamedb => $resultdb) {
	$datatablearrd[] = array(
		"report_type" => "Database",
		"abbrev" => $resultdb[0]['product_abbrev'],
		"Vendor" => productlookup($pnamedb, "Product") ['Vendor'],
		"Product" => $pnamedb
	);
}

foreach($datatablearrd as & $dtarr) {
	$sum = 0;
	foreach($resultsdb[$dtarr['Product']] as $prd) {
		$dtarr[$prd['Inst_type']] = $prd['totals'];
		$sum+= $prd['totals'];
	}

	$dtarr['combined'] = $sum;
}

// create master datatable array
$datatablearr = array_merge($datatablearrj, $datatablearrb, $datatablearrd);

// get all itypes
$allitypes = array_merge($itypesuniq, $itypesuniqb, $itypesuniqdb);
$allitypes = array_unique($allitypes);
sort($allitypes);

// make sure all itypes appear in all packages
foreach($datatablearr as & $dtbval) {
	foreach($allitypes as $itypedb) {
		if (!array_key_exists($itypedb, $dtbval)) {
			$dtbval[$itypedb] = 0;
		}
	}
}

// re-sort to put new entries in right order
function specialsort($a, $b)
{
	$order = ['report_type' => 0, 'abbrev' => 1, 'Vendor' => 2, 'Product' => 3, '#N/A' => 4, 'Other' => 5, 'Private Nonprofit' => 6, 'Public 2 Year' => 7, 'Public 4 Year' => 8, 'Public Doctoral' => 9, 'combined' => 10];
	return $order[$a] - $order[$b];
}

foreach($datatablearr as & $dta) {
	uksort($dta, "specialsort");
}

// count products per
$varray = array();

foreach($datatablearr as $ar) {
	if ($ar['Vendor'] <> "") {
		$varray[$ar['Vendor']][] = $ar['report_type'];
	}
}

$vendorarr = array();

foreach($varray as $vark => $varv) {
	$vendorarr[$vark] = array_count_values($varv);
}

ksort($vendorarr);
?>
