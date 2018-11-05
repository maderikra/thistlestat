<?php


//prepare dates
//if range not set, use most recent year available
	if(!isset($_GET['range'])) {
		$startdate = $defaultstart;
		$enddate = $defaultend;
	}
	else{
		
	if (($_GET['range'] == 'all') ){
		$startdate = "1900-01-01";
		$enddate = date('Y-m-d');
	}
	else if (($_GET['range'] == 'recent') or ($_GET['range'] == 'undefined')){
		$startdate = $defaultstart;
		$enddate = $defaultend;
	}
	else {
	if(isset($_GET['startdate']) and ($_GET['startdate'] <> "") and ($_GET['startdate'] <> "undefined")){
		$startdate = $_GET['startdate'];
	}
	else{
		//if start date not set, use earliest date possible
		$startdate = "1900-01-01";
	}
	if(isset($_GET['enddate']) and ($_GET['startdate'] <> "")  and ($_GET['startdate'] <> "undefined")){
		$enddate = $_GET['enddate'];
	}
	else{
		//if end date not set, use current date 
		$enddate = date('Y-m-d');
	}
	}
	}
	

?>