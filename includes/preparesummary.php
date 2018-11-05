<?php
global $productname;
global $instname;
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

if (isset($_GET['product']))
	{
	$productname = $_GET['product'];

	// retrieve product details

	$productdeets = productlookup($productname, 'product_abbrev');
	$productnamefull = $productdeets['Product'];
	$vendornamefull = $productdeets['Vendor'];
	$vendorabbrev = $productdeets['vendor_abbrev'];
	if (isset($_GET['inst']))
		{
		$instname = $_GET['inst'];
		$instlookup = $_GET['inst'];
		}
	  else
		{
		$instlookup = "";
		}

	if (basename($_SERVER['PHP_SELF']) == "database.php")
		{
		$datesavail = datelookup($productname, DBTABLE, $instlookup);
		}
	elseif (basename($_SERVER['PHP_SELF']) == "journal.php")
		{
		$datesavail = datelookup($productname, JOURNALTABLE, $instlookup);
		}
	elseif (basename($_SERVER['PHP_SELF']) == "ebook.php")
		{
		$datesavail = datelookup($productname, EBOOKTABLE, $instlookup);
		}
	}

?>