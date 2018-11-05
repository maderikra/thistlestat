<?php
$labelsarr = array();
$totalsarr = array();
$relativearr = array();
$instname = 'None selected';
$productname = 'None selected';

// make sure an institution is selected; if not, stop everything

if (isset($_GET['inst'])) {

	// make sure a product is selected; if not, show usage summary

	if (isset($_GET['product'])) {
		$instname = $_GET['inst'];
		$productname = $_GET['product'];
		$chartarray = array();
		$charttype = "bar";
		$linecolor = "#ccc";

		// get databases

		$onclickeventdb = "loaddatabase";
		$stmt = $pdo->prepare('SELECT Product, product_abbrev, data_type, SUM(Requests) as totals FROM  ' . DBTABLE . '  WHERE  Inst_abbrev = :instabbrev AND vendor_abbrev = :vendorabbrev AND start_date >= :startdate and start_date <= :enddate group by Product,data_type ORDER BY Product');
		$stmt->execute(['instabbrev' => $instname, 'vendorabbrev' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$resultsdb = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
		if ($resultsdb) {
			$labelsarr = array_keys($resultsdb);

			// get abbrevs

			$abbrevarrayd = array();
			foreach($resultsdb as $resdb) {
				$abbrevarrayd[] = $resdb[0]['product_abbrev'];
			}

			foreach($resultsdb as $prodnm => $row) {
				foreach($row as $r) {
					$newarr[$prodnm][$r['data_type']] = $r['totals'];
				}
			}

			$totalresults = count($labelsarr);
			$chartarray[] = $totalsarr;
			foreach($newarr as $new) {
				foreach($new as $lab => $tot) {
					$arr1[$lab][] = $tot;
				}
			}
		}

		// get databases by date

		$charttypedd = "line";
		$linecolordd = "#3535b2";
		$stmt = $pdo->prepare('SELECT Product, start_date, SUM(Requests) as totals FROM ' . DBTABLE . ' WHERE Inst_abbrev = :instabbrev AND vendor_abbrev = :vendorabbrev AND start_date >= :startdate and start_date <= :enddate group by Product,start_date ORDER BY start_date');
		$stmt->execute(['instabbrev' => $instname, 'vendorabbrev' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$resultsddate = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
		if ($resultsddate) {
			$keyarraydd = array();
			$resultsarrdd = array();
			$datearrd = array();
			foreach($resultsddate as $pname => $pdata) {

				// get all start dates

				foreach($pdata as $p) {
					$datearrd[] = $p['start_date'];
				}
			}

			// dedupe date arr

			$datearrd = array_unique($datearrd);

			// make sure all dates show up in all arrays

			foreach($datearrd as $datej) {
				foreach($resultsddate as $pname => & $pdata) {
					if (!in_array($datej, array_column($pdata, 'start_date'))) {
						$pdata[] = array(
							'start_date' => $datej,
							'totals' => '0'
						);
					}
				}
			}

			// re-sort to put new entries in correct spot

			foreach($resultsddate as & $arr) {
				asort($arr);
			}

			$chartarraydd = array();
			foreach($resultsddate as $resjdk => $resjdv) {
				$chartarraydd[$resjdk] = array();
				foreach($resjdv as $rd) {
					$chartarraydd[$resjdk][] = $rd['totals'];
				}
			}

			$showlegenddd = 'false';
			$xlabeldd = 'Packages';
			$ylabeldd = 'Uses';
			$autoskipdd = 'false';
		}

		// get journals

		$stmt = $pdo->prepare('SELECT Product, product_abbrev, SUM(Requests) as totals, COUNT(DISTINCT(Title)) as tottitles FROM ' . JOURNALTABLE . ' WHERE  Inst_abbrev = :instabbrev AND vendor_abbrev = :vendorabbrev AND start_date >= :startdate and start_date <= :enddate group by Product ORDER BY Product');
		$stmt->execute(['instabbrev' => $instname, 'vendorabbrev' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$resultsj = $stmt->fetchAll();
		if ($resultsj) {
			$keyarrayj = array();
			$resultsarrj = array();
			$abbrevarrayj = array();

			// save product names to array

			foreach($resultsj as $resj) {
				$keyarrayj[] = $resj['Product'];
				$resultsarrj[] = $resj['totals'];
				$abbrevarrayj[] = $resj['product_abbrev'];
			}

			$showlegendj = 'false';
			$onclickeventj = 'loadjournals';
			$xlabelj = 'Packages';
			$ylabelj = 'Uses';
			$autoskipj = 'false';
		}

		// get journals by date

		$charttypejd = "line";
		$linecolorjd = "#3535b2";
		$stmt = $pdo->prepare('SELECT Product, start_date, SUM(Requests) as totals FROM  ' . JOURNALTABLE . '  WHERE Inst_abbrev = :instabbrev AND vendor_abbrev = :vendorabbrev AND start_date >= :startdate and start_date <= :enddate group by Product,start_date ORDER BY start_date');
		$stmt->execute(['instabbrev' => $instname, 'vendorabbrev' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$resultsjdate = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
		if ($resultsjdate) {
			$keyarrayjd = array();
			$resultsarrjd = array();
			$datearrj = array();
			foreach($resultsjdate as $pname => $pdata) {

				// get all start dates

				foreach($pdata as $p) {
					$datearrj[] = $p['start_date'];
				}

				// $keyarrayjd[] = $resjd['start_date'];
				// $resultsarrjd[$resjd['start_date']] = $resjd['totals'];

			}

			// dedupe date arr

			$datearrj = array_unique($datearrj);

			// make sure all dates show up in all arrays

			foreach($datearrj as $datej) {
				foreach($resultsjdate as $pname => & $pdata) {
					if (!in_array($datej, array_column($pdata, 'start_date'))) {
						$pdata[] = array(
							'start_date' => $datej,
							'totals' => '0'
						);
					}
				}
			}

			// re-sort to put new entries in correct spot

			foreach($resultsjdate as & $arr) {
				asort($arr);
			}

			$chartarrayjd = array();
			foreach($resultsjdate as $resjdk => $resjdv) {
				$chartarrayjd[$resjdk] = array();
				foreach($resjdv as $rd) {
					$chartarrayjd[$resjdk][] = $rd['totals'];
				}
			}

			$showlegendjd = 'false';
			$xlabeljd = 'Packages';
			$ylabeljd = 'Uses';
			$autoskipjd = 'false';
		}

		// get ebooks

		$stmt = $pdo->prepare('SELECT Product, product_abbrev, SUM(Requests) as totals, COUNT(DISTINCT(Title)) as tottitles FROM  ' . EBOOKTABLE . '  WHERE  Inst_abbrev = :instabbrev AND vendor_abbrev = :vendorabbrev AND start_date >= :startdate and start_date <= :enddate group by Product ORDER BY Product');
		$stmt->execute(['instabbrev' => $instname, 'vendorabbrev' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$resultsb = $stmt->fetchAll();
		if ($resultsb) {
			$keyarrayb = array();
			$resultsarrb = array();
			$abbrevarrayb = array();

			// save product names to array

			foreach($resultsb as $resb) {
				$keyarrayb[] = $resb['Product'];
				$resultsarrb[] = $resb['totals'];
				$abbrevarrayb[] = $resb['product_abbrev'];
			}

			$showlegendb = 'false';
			$onclickeventb = 'loadbooks';
			$xlabelb = 'Packages';
			$ylabelb = 'Uses';
			$autoskipb = 'false';
		}

		// get ebooks by date

		$charttypebd = "line";
		$linecolorbd = "#3535b2";
		$stmt = $pdo->prepare('SELECT Product, start_date, SUM(Requests) as totals FROM  ' . EBOOKTABLE . '  WHERE Inst_abbrev = :instabbrev AND vendor_abbrev = :vendorabbrev AND start_date >= :startdate and start_date <= :enddate group by Product,start_date ORDER BY start_date');
		$stmt->execute(['instabbrev' => $instname, 'vendorabbrev' => $productname, 'startdate' => $startdate, 'enddate' => $enddate]);
		$resultsbdate = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
		if ($resultsbdate) {
			$keyarraybd = array();
			$resultsarrbd = array();
			$datearrb = array();
			foreach($resultsbdate as $pname => $pdata) {

				// get all start dates

				foreach($pdata as $p) {
					$datearrb[] = $p['start_date'];
				}

				// $keyarrayjd[] = $resjd['start_date'];
				// $resultsarrjd[$resjd['start_date']] = $resjd['totals'];

			}

			// dedupe date arr

			$datearrb = array_unique($datearrb);

			// make sure all dates show up in all arrays

			foreach($datearrb as $datej) {
				foreach($resultsbdate as $pname => & $pdata) {
					if (!in_array($datej, array_column($pdata, 'start_date'))) {
						$pdata[] = array(
							'start_date' => $datej,
							'totals' => '0'
						);
					}
				}
			}

			// re-sort to put new entries in correct spot

			foreach($resultsbdate as & $arr) {
				asort($arr);
			}

			$chartarraybd = array();
			foreach($resultsbdate as $resjdk => $resjdv) {
				$chartarraybd[$resjdk] = array();
				foreach($resjdv as $rd) {
					$chartarraybd[$resjdk][] = $rd['totals'];
				}
			}

			$showlegendbd = 'false';
			$xlabelbd = 'Packages';
			$ylabelbd = 'Uses';
			$autoskipbd = 'false';
		}

		// get all labels in all results

		$keyarray = array();
		foreach($resultsdb as $arr) {
			foreach($arr as $arrk => $arrv) {
				$keyarray[] = $arrv['data_type'];
			}
		}

		// dedupe

		$keyarray = array_unique($keyarray);

		// sort it
		// i hope this wasn't important 3-21-18
		// asort($keyarray);

	}
}
else {
	echo "Please select an institution.";
}

?>