<!DOCTYPE html>

<html lang="en">

<?php 

include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
include dirname(dirname( __FILE__ )) . "/includes/preparedates.php";
include dirname(dirname( __FILE__ )) . "/includes/packagelists.php";
include dirname(dirname( __FILE__ )) . "/includes/preparesummary.php";

if (isset($_GET['benchmark1'])){
	include 'chart_multi_database.php'; 
}
else {
	include 'chart_basic_database.php';
}	

$fullinstname = institutionlookup($_GET['inst'],"Inst_abbrev")['Institution'];

?>

<head>


  <title><?php echo $consortiumname . " " . $sitename; ?>: Database Analysis</title>


  <?php include dirname(dirname( __FILE__ )) . "/includes/head.php"; ?>


</head>

<body class="">
	<div class="wrapper">
		
		<?php include "include_sidemenu.php"; ?>
		
		<div class="main-panel">

		<?php include "include_topnav.php"; ?>
		
			<div class="panel">
            <div class="row">
             <div class="col-md-12 crumb">
               
<ul class="breadcrumbround">
  <li>
    <a href="#">
    <i class="material-icons">laptop_mac</i> <?php echo $productnamefull; ?>
    </a>
  </li>
 
    <li>
    <a href="index.php?inst=<?php echo $instname; ?>">
      <i class="material-icons">school</i> Institution View
    </a>
  </li>
  <li>
    <a href="/">
    <i class="material-icons">home</i>
      <span class="text">Home</span>
    </a>
  </li>




</ul>
          
             </div>
            <div class="col-md-6 col-sm-12">
                         <h3 class="instname"><?php echo $fullinstname; ?> </h3>  
				<table class="sm-table" id="summtable">
					<tr>
						<td class="cellheading">Package Name:</td>
						<td><a href="/package/journal.php?product=<?php echo $productname; ?>"><strong><?php echo $productnamefull; ?></strong></a></td>
					</tr>
                    <tr>
						<td class="cellheading">Package Type:</td>
						<td>Database</td>
					</tr>
					<tr>
						<td class="cellheading">Dates Selected:</td>
						<td><?php echo $startdate . ' to ' . $enddate; ?></td>
					</tr>
					<tr>
						<td class="cellheading">Dates Available:</td>
						<td><?php echo $datesavail['firstdate'] . ' to ' . $datesavail['lastdate']; ?></td>
					</tr>
					<tr>
						<td class="cellheading">Vendor:</td>
						<td>
							<a href="vendor.php?inst=<?php echo $instname; ?>&product=<?php echo $vendorabbrev; ?>"><?php echo $vendornamefull; ?></a>
						</td>
					</tr>
	     <tr>
						<td class="cellheading">Download Raw Dataset:</td>
						<td>
							<a href="download.php?inst=<?php echo $instname; ?>&product=<?php echo $productname; ?>&type=<?php echo DBTABLE; ?>"><i class="material-icons">cloud_download</i></a>
						</td>
					</tr>
				</table>
			</div>
         
              <div class="col-md-6 col-sm-12">
              
        
				<?php include 'include_benchmark.php'; ?>
			</div></div>
              </div>
              </div>
            
			<div class="content">
				<div class="row">

					<div class="col-lg-12 top-left card-transition">
						<div class="card card-chart">
						
							<? if ($results): ?>

							<div class="card-header">	
										
								
								<h4 class="card-title"><i class="material-icons " id="topleft" >zoom_out_map</i> Date View</h4>
								<div class="dropdown">		
								<ul class="nav nav-pills pills-circle" role="tablist">
									<li class="nav-item">
										<a aria-controls="date-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#date-chart" id="date-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
									</li>
									<li class="nav-item">
										<a aria-controls="date-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#date-table" id="date-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
									</li>
								</ul>
	</div>
				
							</div>
							
							<div class="card-body">
								
								<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="date-chart" role="tabpanel" aria-labelledby="date-chart-tab">
  <div class="chart-area">
									<canvas id="myChartdate"></canvas>
								</div>
  </div>
  <div class="tab-pane fade" id="date-table" role="tabpanel" aria-labelledby="date-table-tab">
		<table id="datatable" class="table table-hover table-bordered compact" width="100%" cellspacing="0">
  <thead>
            <tr>
			 <th>Date</th>
			  <?php foreach($allinstsdate as $arrkey): ?>
                <th><?php echo $arrkey; ?></th>
			<?php endforeach; ?>
            </tr>
        </thead>
    <?php foreach($datatablearrdate as $key => $value): ?>
    <tr>
	<td><?php echo $key; ?></td>
    <?php foreach($value as $val): ?>

        <td><?php echo $val; ?></td>

    <?php endforeach; ?>
     </tr>
   <?php endforeach; ?>
</table>

  </div>
</div>
							</div>
							<div class="card-footer"></div>
										<? else: ?>
					  <div class="alert alert-danger" role="alert"> There are no statistics for this search:
					  <ul>
					  <li><?php echo $fullinstname; ?></li>
					  <li><?php echo $productnamefull; ?></li>
					  <li><?php echo $startdate; ?> to <?php echo $enddate; ?></li> 
					  </ul>
					  </div>
					<? endif; ?>
						</div>
					</div>
					
		
			</div>
			</div>
			<?php include dirname(dirname( __FILE__ )) . "/includes/footer.php"; ?>
		</div>
	</div>


  <!--   Core JS Files   -->
 <?php include dirname(dirname( __FILE__ )) . "/includes/packagescripts.php"; ?>


 <script>
<? if ($results): ?>

var ctx = document.getElementById("myChartdate").getContext('2d');
var myChartdate = new Chart(ctx, {
    type: '<?php echo $charttypedate; ?>',
    data: {
        labels: ['<?php echo implode("','",$keyarraydate); ?>'],
        datasets: [
		    <?php $m = 0;  $k = 0; foreach($chartarraydate as $chartkey=>$chartvalue): ?>
			{
			label: "<?php echo $chartkey; ?>",
			data: [<?php echo implode(",",$chartvalue); ?>],
		    backgroundColor: '<?php echo ${"color" . floor($m/$groupings)} ?>',
			 borderColor: '<?php echo ${"color" . floor($m/$groupings)} ?>',
			 fill: false,
            borderWidth: 1,
				 borderDash: <?php echo ${"dash" . $k}; ?>
			},
			<?php $m++; $k++; if ($k >= $groupings){$k = 0;} endforeach; ?>
		
		]
    },
    options: {
		 responsive:true,
		 	onClick: <?php echo $onclickeventdate; ?>,
  		maintainAspectRatio: false,
        scales: {
			 xAxes: [{
        stacked: false,
        beginAtZero: true,
        scaleLabel: {
            labelString: '<?php echo $xlabeldate; ?>',
			display: true
        },
		gridLines: {
			display: false,
		},
        ticks: {
            stepSize: 1,
            min: 0,
            autoSkip: false
        }
    }],
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
			scaleLabel: {
            labelString: '<?php echo $ylabeldate; ?>',
			display: true
        },
            }]
        }
    },


});

<? endif; ?>

	benchtotal = <?php echo $j; ?>;
	var autocompletelist = [
         <?php foreach ($allproducts as $prod){
			 echo '{label:"' . $prod['Product'] . '",type:"' . $prod['type'] . '",value:"' . $prod['product_abbrev']. '"},';
			 } ?>
        ];
			
$('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
		minDate: '<?php echo $firstlastdate['earliest']; ?>',
		maxDate: '<?php echo $firstlastdate['latest']; ?>',
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
	
$("#dropdowndb").parent().addClass("active");
</script>

<script src="institutionscripts.js"></script>
</body>
</html>
