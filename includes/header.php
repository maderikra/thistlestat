<?php

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, USERN, PASWD, $opt);


//get all institutions
$stmt0 = $pdo->query('SELECT Institution, Inst_abbrev, inst_type FROM ' . INSTITUTIONSTABLE . ' group by Inst_abbrev');
$allinstitutions = $stmt0->fetchAll();


//get earliest and latest date in db
$stmtdtj = $pdo->query('SELECT Min(start_date) as earliest, Max(start_date) as latest FROM ' . JOURNALTABLE);
$firstlastdatej = $stmtdtj->fetchAll();

$stmtdtb = $pdo->query('SELECT Min(start_date) as earliest, Max(start_date) as latest FROM ' . EBOOKTABLE);
$firstlastdateb = $stmtdtb->fetchAll();

$stmtdtd = $pdo->query('SELECT Min(start_date) as earliest, Max(start_date) as latest FROM ' . DBTABLE);
$firstlastdated = $stmtdtd->fetchAll();

$firstlastdatemerge = array_merge($firstlastdatej,$firstlastdateb,$firstlastdated);
$ear = "3000-01-01";
$lat = "1900-01-01";

foreach ($firstlastdatemerge as $mrg){
	if ($mrg['earliest'] < $ear){$ear = $mrg['earliest'];}
	if ($mrg['latest'] > $lat){$lat = $mrg['latest'];}
}

$firstlastdate = array("earliest" => $ear,"latest" => $lat);

$tmpdate = new DateTime($firstlastdate['latest']);
$tmpmonth = $tmpdate->format('n');
$tmpyear = $tmpdate->format('Y');

//get default start date (jul 1 of most recent year avail)
$defaultstart = ($tmpmonth < 7 ? ($tmpyear-1).'-07-01' : $tmpyear . '-07-01');
$defaultend = $firstlastdate['latest'];

//match vendor abbreviation to name, and vice versa
function vendorlookup($searchterm,$searchtype,$resulttype) {
	global $pdo,$dsn, $user, $pass, $opt;
	$stmtp = $pdo->prepare('SELECT ' . $resulttype . ' FROM ' . VENDORSTABLE . ' WHERE ' . $searchtype . '  = :searchterm');
	$stmtp->execute(['searchterm' => $searchterm]);
	$productresult = $stmtp->fetch();
	return $productresult;
}

//match product abbreviation to name, and vice versa
function productlookup($searchterm,$searchtype) {
	global $pdo,$dsn, $user, $pass, $opt;
	$stmtp = $pdo->prepare('SELECT Product, product_abbrev, ' . PRODUCTSTABLE . '.vendor_abbrev, Vendor FROM ' . PRODUCTSTABLE . ' LEFT JOIN ' . VENDORSTABLE . ' on ' . PRODUCTSTABLE . '.vendor_abbrev = ' . VENDORSTABLE . '.vendor_abbrev WHERE ' . $searchtype . '  = :searchterm');
	$stmtp->execute(['searchterm' => $searchterm]);
	$productresult = $stmtp->fetch();
	return $productresult;
}

//get available dates for a product/institution
function datelookup($searchterm,$prodtype,$instabbrev) {
	global $pdo,$dsn, $user, $pass, $opt;
	if ($instabbrev <> ""){
		$stmtp = $pdo->prepare('SELECT max(start_date) as lastdate, min(start_date) as firstdate FROM ' . $prodtype . ' WHERE product_abbrev = :searchterm AND Inst_abbrev  = :instabbrev');
		$stmtp->execute(['searchterm' => $searchterm, 'instabbrev' => $instabbrev]);
		$productresult = $stmtp->fetch();
	}
	else{
		$stmtp = $pdo->prepare('SELECT max(start_date) as lastdate, min(start_date) as firstdate FROM ' . $prodtype . ' WHERE product_abbrev = :searchterm');
		$stmtp->execute(['searchterm' => $searchterm]);
		$productresult = $stmtp->fetch();	
	}
	return $productresult;
}

function sortbykey($a, $b)
{
    return strcmp($a["Inst_type"], $b["Inst_type"]);
}

function insertzeroes($dataarray){
	//get all labels in all results
	$keyarray = array();
	foreach ($dataarray as $arrmg){
		foreach ($arrmg as $arrk => $arrv){
			$keyarray[] = $arrk;
		}	
	}
	//dedupe
	$keyarray = array_unique($keyarray);
	//sort it
	asort($keyarray);
	//make sure all products appear in each institution array; if not, add as zero
	foreach ($dataarray as $arrinst => $arrtitles){
		foreach ($keyarray as $curtitle){
			if (!array_key_exists($curtitle, $arrtitles)) {
			$dataarray[$arrinst][$curtitle] = 0;
			}
		}		
	}
	//sort each array to make sure they're in the right order
	foreach ($dataarray as &$arr){
		ksort($arr);
	}	
    return array($dataarray, $keyarray);
}

$reporttypearray = array(
//FIXME! 
"CR1" => array('name' => "Journal", 'page' => 'journal.php'),
"JR1" => array('name' => "Journal", 'page' => 'journal.php'),
"BR2" => array('name' => "E-Book", 'page' => 'ebook.php'),
"DB1" => array('name' => "Database", 'page' => 'database.php'),
"MR1" => array('name' => "Database", 'page' => 'database.php'),
"non-COUNTER" => array('name' => "Database", 'page' => 'database.php'),
"Non-COUNTER" => array('name' => "Database", 'page' => 'database.php'),
);


//match institution abbreviation to name, and vice versa

//convert things using this function to pull directly from array generated below FIXME
function institutionlookup($searchterm,$searchtype){
	global $pdo,$dsn, $user, $pass, $opt;
	$stmtp = $pdo->prepare('SELECT Institution, Inst_abbrev FROM ' . INSTITUTIONSTABLE . '  WHERE ' . $searchtype . '  = :searchterm');
	$stmtp->execute(['searchterm' => $searchterm]);
	$instresult = $stmtp->fetch();
	return $instresult;
}

$stmtinst = $pdo->prepare('SELECT Inst_abbrev, Institution FROM ' . INSTITUTIONSTABLE);
$stmtinst->execute();
$institutionarrayres = $stmtinst->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
$institutionarray = array();
foreach ($institutionarrayres as $inkey => $inv){
	$institutionarray[$inkey] = $inv['Institution'];
}

//count titles in package
function counttitles($searchterm,$prodtype) {
	global $pdo,$dsn, $user, $pass, $opt;
	$stmt = $pdo->prepare('SELECT count(DISTINCT(Title)) as tottitles FROM ' . $prodtype . ' WHERE product_abbrev = :prodabb');
	$stmt->execute(['prodabb' => $searchterm]);
	$resultstot = $stmt->fetch();
	return $resultstot['tottitles'];
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

//check IP to determine home institution
$userip = $_SERVER['REMOTE_ADDR'];
function cidr_match($ip, $cidr)
{
    list($subnet, $mask) = explode('/', $cidr);
    if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1) ) == ip2long($subnet))
    { 
        return true;
    }
    return false;
}

?>
