<?php

// make sure an institution is selected; if not, stop everything

if (isset($_GET['inst'])) {
	include dirname(dirname(__FILE__)) . "/includes/preparedates.php";

	// array for datatable

	$datatablearr = array();
	$charttype = "bar";

	// get databases

	$totalsarr = array();
	$stmtx = $pdo->prepare('SELECT report_type, Product, SUM(Requests) as totals, product_abbrev, Vendor, vendor_abbrev FROM  ' . DBTABLE . '  WHERE Inst_abbrev = :instabbrev AND start_date >= :startdate and start_date <= :enddate group by Product ORDER BY Vendor, SUM(requests) DESC');
	$stmtx->execute(['instabbrev' => $_GET['inst'], 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultsx = $stmtx->fetchAll();
	foreach($resultsx as $row) {
		$totalsarr[$row['Product']] = array(
			"vendor" => $row['Vendor'],
			"vendor_abbrev" => $row['vendor_abbrev'],
			"product_abbrev" => $row['product_abbrev'],
			"totals" => $row['totals']
		);
		$datatablearr[] = array(
			"report_type" => $row['report_type'],
			"vendor" => $row['Vendor'],
			"product_abbrev" => $row['product_abbrev'],
			"product" => $row['Product'],
			"tottitles" => '',
			"totals" => $row['totals'],
			"avguse" => ''
		);
	}

	$stackedarray = array();
	$temparray = array();

	// get all vendors

	$vendorlist = array_values(array_unique(array_column($totalsarr, 'vendor')));
	$totalvendors = count($vendorlist);

	// count groups for color generator

	$totalgroups = count($resultsx);
	foreach($totalsarr as $packname => $packstats) {
		$vendorplace = array_search($packstats['vendor'], $vendorlist);

		// make array of zeroes

		$temparray = array_fill(0, $totalvendors, 0);

		// replace zero in correct place with actual value

		$temparray[$vendorplace] = $packstats['totals'];
		$stackedarray[] = array(
			"label" => $packname,
			"vendorid" => $vendorplace,
			"product_abbrev" => $packstats['vendor_abbrev'],
			"data" => $temparray,
			"backgroundColor" => $totalgroups
		);
	}

	// get journals

	$totalsarrj = array();
	$stmtj = $pdo->prepare('SELECT report_type, Product, SUM(Requests) as totals, COUNT(DISTINCT(Title)) as tottitles, product_abbrev, Vendor, Vendor_abbrev FROM  ' . JOURNALTABLE . '  WHERE Inst_abbrev = :instabbrev AND start_date >= :startdate and start_date <= :enddate group by Product ORDER BY Product');
	$stmtj->execute(['instabbrev' => $_GET['inst'], 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultsj = $stmtj->fetchAll();
	foreach($resultsj as $row) {
		$totalsarrj[$row['Product']] = array(
			"vendor" => $row['Vendor'],
			"product_abbrev" => $row['product_abbrev'],
			"totals" => $row['totals']
		);
		$datatablearr[] = array(
			"report_type" => $row['report_type'],
			"vendor" => $row['Vendor'],
			"product_abbrev" => $row['product_abbrev'],
			"product" => $row['Product'],
			"tottitles" => $row['tottitles'],
			"totals" => $row['totals'],
			"avguse" => round($row['totals'] / $row['tottitles'])
		);
	}

	// get books

	$totalsarrb = array();
	$stmtb = $pdo->prepare('SELECT report_type, Product, SUM(Requests) as totals, COUNT(DISTINCT(Title)) as tottitles, product_abbrev, Vendor, Vendor_abbrev FROM  ' . EBOOKTABLE . '  WHERE Inst_abbrev = :instabbrev AND start_date >= :startdate and start_date <= :enddate group by Product ORDER BY Product');
	$stmtb->execute(['instabbrev' => $_GET['inst'], 'startdate' => $startdate, 'enddate' => $enddate]);
	$resultsb = $stmtb->fetchAll();
	foreach($resultsb as $row) {
		$totalsarrb[$row['Product']] = array(
			"vendor" => $row['Vendor'],
			"product_abbrev" => $row['product_abbrev'],
			"totals" => $row['totals']
		);
		$datatablearr[] = array(
			"report_type" => $row['report_type'],
			"vendor" => $row['Vendor'],
			"product_abbrev" => $row['product_abbrev'],
			"product" => $row['Product'],
			"tottitles" => $row['tottitles'],
			"totals" => $row['totals'],
			"avguse" => round($row['totals'] / $row['tottitles'])
		);
	}
}

?>