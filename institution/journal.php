<!DOCTYPE html>

<html lang="en">

<?php 

include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
include dirname(dirname( __FILE__ )) . "/includes/preparedates.php";
include dirname(dirname( __FILE__ )) . "/includes/packagelists.php";
include dirname(dirname( __FILE__ )) . "/includes/preparesummary.php";


if (isset($_GET['benchmark1'])){
	include 'chart_multi_journal.php'; 
}
else {
	include 'chart_basic_journal.php';
}	

$fullinstname = institutionlookup($_GET['inst'],"Inst_abbrev")['Institution'];

?>

<head>

<title><?php echo $consortiumname . " " . $sitename; ?>: Journal Analysis</title>

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
                <i class="material-icons">description</i> <?php echo $productnamefull; ?>
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
						<td>Journal</td>
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
						<td class="cellheading">Titles in Package:</td>
						<td>
							<a href="#datatable"><?php echo counttitles($productname,JOURNALTABLE);?></a>
						</td>
					</tr>
                    <tr>
						<td class="cellheading">Download Raw Dataset:</td>
						<td>
							<a href="download.php?inst=<?php echo $instname; ?>&product=<?php echo $productname; ?>&type=<?php echo JOURNALTABLE; ?>"><i class="material-icons">cloud_download</i></a>
						</td>
					</tr>
				</table>
			</div>
         
              <div class="col-md-6 col-sm-12">
              
         
			<?php include 'include_benchmark.php'; ?>
			</div>
			</div>
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
									<li class="nav-item">
										<a class="nav-link" href="javascript:dldatechart();" id="dl-chart-tab" role="tab" title="Download Chart"><i class="material-icons">save</i></a>
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
			<table id="datatabledate"  class="table table-hover table-bordered compact" width="100%" cellspacing="0">
  <thead>
 
            <tr>
			 <th>Title</th>
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
				<? if ($results): ?>

				<div class="row">
					<div class="col-md-6 bottom-left card-transition">
						<div class="card card-chart card-tall">
							<div class="card-header">
								<h4 class="card-title"><i class="material-icons" id="bottomleft">zoom_out_map</i> Title List</h4>
								<div class="dropdown">
									<ul class="nav nav-pills pills-circle" role="tablist">
									<li class="nav-item">
										<a aria-controls="title-chart" aria-selected="true" class="nav-link" data-toggle="pill" href="#title-chart" id="title-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
									</li>
									<li class="nav-item">
										<a aria-controls="title-table" aria-selected="false" class="nav-link active" data-toggle="pill" href="#title-table" id="title-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
									</li>
								</ul>
								</div>
							</div>
							<div class="card-body">
							<div class="tab-content" id="pills-tabContent1">
							 <div class="tab-pane fade show active" id="title-table" role="tabpanel" aria-labelledby="title-table-tab">
								<button id="resettable" class="dt-button">Clear Table Filters</button>

								<table id="datatable" class="table table-hover table-bordered compact" width="100%" cellspacing="0">
								  <thead>
											 <tr>
											 <th>Title</th>
											  <?php foreach($allinsts as $arrkey): ?>
												<th><?php echo $arrkey; ?></th>
											<?php endforeach; ?>
											</tr>
										</thead>
									<?php foreach($datatablearr as $key => $value): ?>
									<tr>
									<td><?php echo $key; ?></td>
									<?php foreach($value as $val): ?>

										<td><?php echo $val; ?></td>

									<?php endforeach; ?>
									 </tr>
								   <?php endforeach; ?>
								</table>
								</div>
								
								  <div class="tab-pane fade" id="title-chart" role="tabpanel" aria-labelledby="title-chart-tab">
								  <div class="chart-area"><canvas id="myChart"></canvas></div>
								  </div>
								 
								</div>

								
							</div>
							<div class="card-footer">
								<hr>
								<div class="stats"></div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6 bottom-right card-transition">
						<div class="card card-chart">
							<div class="card-header">
								<h4 class="card-title"><i class="material-icons" id="bottomright">zoom_out_map</i> Typical Usage</h4>
								<div class="dropdown">
									<ul class="nav nav-pills pills-circle" role="tablist">
									<li class="nav-item">
										<a aria-controls="summ-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#summ-chart" id="summ-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
									</li>
									<li class="nav-item">
										<a aria-controls="summ-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#summ-table" id="summ-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
									</li>
								</ul>
								</div>
							</div>
							<div class="card-body">
											<div class="tab-content" id="pills-tabContent2">
							 <div class="tab-pane fade" id="summ-table" role="tabpanel" aria-labelledby="summ-table-tab">
							 
							<table id="summarytable" class="table table-hover table-bordered compact" width="100%" cellspacing="0">
								  <thead>
									<tr>
									<th>Number of Uses</th>
									<?php foreach($allinsts as $arrkey): ?>
												<th># Titles (<?php echo $arrkey; ?>)</th>
									<?php endforeach; ?>
									
									</tr>
								  </thead>
									<?php foreach($grpdatatable as $usages => $totnums): ?>
											<tr>
												<td><?php echo $usages; ?></td>
													<?php foreach($totnums as $tts): ?>
													<td><?php echo $tts; ?></td>
													<?php endforeach; ?>
											 </tr>
								   <?php endforeach; ?>
								</table>
								
										</div>
							  <div class="tab-pane fade show active" id="summ-chart" role="tabpanel" aria-labelledby="summ-chart-tab">
								 
								 <div class="chart-area">
									<canvas id="myChartgrp"></canvas>
								</div>
								  </div>
								 
								</div>
								
								
						
								  
							</div>
							<div class="card-footer">
								<hr>
								<div class="stats"></div>
							</div>
						</div>
					</div>
				</div>
				<? endif; ?>
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
		<?php $i = 0; ?>
		<?php foreach($chartarraydate as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			 backgroundColor : '<?php echo ${"color" . $i} ?>',
			 borderColor: '<?php echo ${"color" . $i} ?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
	zoom: {
			enabled: true,
			mode: 'x',
			drag: false,
		},

		legend: {
      display: <?php echo $showlegenddate; ?>,
		},
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
            autoSkip: <?php echo $autoskipdate; ?>,
			maxRotation: 45,
                    minRotation: 45
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


var ctx = document.getElementById("myChartgrp").getContext('2d');
var myChartgrp = new Chart(ctx, {
    type: '<?php echo $charttypegrp; ?>',
    data: {
        labels: ['<?php echo implode("','",$keyarraygrpexpanded); ?>'],
		actualvalues: ['<?php echo implode("','",$realkeys); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($chartarraygrpexpanded as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			 backgroundColor : [],
			 borderColor: [],
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
			zoom: {
			enabled: true,
			mode: 'xy',
			drag: false,
			rangeMin: {
			// Format of min zoom range depends on scale type
			x: 0,
			y: 0
			},
				rangeMax: {
			// Format of min zoom range depends on scale type
			x: null,
			y: 8
			},
		},
		pan: {
		enabled: true,
		mode: 'xy'
	},
		tooltips: {
      callbacks: {
        title: function(tooltipItem, data) {
          return data['actualvalues'][tooltipItem[0]['index']];
		 
        },
        label: function(tooltipItem, data) {
         // return data['datasets'][tooltipItem['datasetIndex']]['data'][tooltipItem['index']];
		 return data['datasets'][tooltipItem['datasetIndex']]['label'];
        }
      }
		},
		legend: {
      display: <?php echo $showlegendgrp; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventgrp; ?>,
   		 maintainAspectRatio: false,
		 title: {
            display: true,
            text: '<?php echo $startdate . " to " . $enddate; ?>',
			fontSize: 16,
			fontColor: "#5D7B93",
        },
        scales: {
			 xAxes: [{
				 
        stacked: false,
        beginAtZero: true,
        scaleLabel: {
            labelString: '<?php echo $xlabelgrp; ?>',
			display: true
        },
		gridLines: {
			display: false,
		},
        ticks: {
            stepSize: 1,
            min: 0,
            autoSkip: <?php echo $autoskipgrp; ?>,
			maxRotation: 45,
                    minRotation: 45
        },
		afterTickToLabelConversion: function(scaleInstance) {
  // set the first and last tick to null so it does not display
  // note, ticks[0] is the last tick and ticks[length - 1] is the first
  <?php
  for($i = 1; $i<=$numoutliers; $i++) {
  echo "scaleInstance.ticks[scaleInstance.ticks.length - " . $i . "] = null;";
  } 
  ?>

  // need to do the same thing for this similiar array which is used internally
 // scaleInstance.ticksAsNumbers[0] = null;
 // scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
}
    }],
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
				        scaleLabel: {
            labelString: '<?php echo $ylabelgrp; ?>',
			display: true
        },
            }]
        }
    },


});

//make the outliers red
//first find out how many datasets there are (may be multiple if using benchmarks)
var totalsets = myChartgrp.data.datasets.length;
color0 = '<?php echo ${"color0"} ?>'; 
color1 = '<?php echo ${"color1"} ?>'; 
color2 = '<?php echo ${"color2"} ?>'; 
color3 = '<?php echo ${"color3"} ?>'; 
color4 = '<?php echo ${"color4"} ?>'; 

 for (k = 0; k < totalsets; k++) {
 for (i = 0; i < myChartgrp.data.datasets[k].data.length; i++) {
	if (i < (myChartgrp.data.datasets[k].data.length - <?php echo $numoutliers; ?>)){
		myChartgrp.data.datasets[k].backgroundColor[i] = this['color' + k] ;
		myChartgrp.data.datasets[k].borderColor[i] = this['color' + k];
	}
	else{
        myChartgrp.data.datasets[k].backgroundColor[i] = "#ff0000";
		myChartgrp.data.datasets[k].borderColor[i] = "#ff0000";
	}

 }
 }

    myChartgrp.update(); //update the chart
	



	function filtertitles(event, array){ 

	if (array.length > 0){	 
		actval = this.data.actualvalues[array[0]._index];
		//$('#datatable').DataTable().columns( 1 ).search("^" + array[0]._model.label + "$", true, false, true).draw();
		$('#datatable').DataTable().columns( 1 ).search("^" + actval + "$", true, false, true).draw();
	}
}

	
$('#title-chart-tab').on('shown.bs.tab', function(){
<? if ($totalresults > 100): ?>
$('#title-chart').html('<div class="alert alert-danger toolargealert" role="alert">There are too many titles to be displayed on this visualization.</div>');

<? else: ?>

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ['<?php echo implode("','",$keyarray); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($chartarray as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			 backgroundColor : '<?php echo ${"color" . $i} ?>',
			 borderColor: '<?php echo ${"color" . $i} ?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegend; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickevent; ?>,
    maintainAspectRatio: false,
        scales: {
			 xAxes: [{
        stacked: false,
        beginAtZero: true,
        scaleLabel: {
            labelString: '<?php echo $xlabel; ?>',
			display: true
        },
		gridLines: {
			display: false,
		},
        ticks: {
            stepSize: 1,
            min: 0,
            autoSkip: <?php echo $autoskip; ?>,
			maxRotation: 45,
                    minRotation: 45
        }
    }],
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
				        scaleLabel: {
            labelString: '<?php echo $ylabel; ?>',
			display: true
        },
            }]
        }
    },

});
<? endif; ?>


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
	
function dldatechart(){
var url_base64 = document.getElementById('myChart').toDataURL('image/png');
 var url=myChartdate.toBase64Image();
//window.location.href = 'data:application/octet-stream;base64,' + url;
}	
</script>
<script src="institutionscripts.js"></script>

</body>



</html>

