<!DOCTYPE html>

<html lang="en">

<?php 

include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
include dirname(dirname( __FILE__ )) . "/includes/preparedates.php";
include dirname(dirname( __FILE__ )) . "/includes/packagelists.php";
include dirname(dirname( __FILE__ )) . "/includes/preparesummary.php";

include "chart_database.php";


?>

<head>

  <title><?php echo $consortiumname . " " . $sitename; ?>: Database Analysis</title>

   <?php include dirname(dirname( __FILE__ )) . "/includes/head.php"; ?>


</head>

<body class="">

		<?php include "sidemenu_package.php"; ?>

		<div class="main-panel">
			<?php include "include_topnav.php"; ?>
			<div class="panel">
             <h3 class="instname">Consortium View</h3>
				<table class="sm-table" id="summtable">
					<tr>
						<td class="cellheading">Package Name:</td>
						<td><strong><?php echo $productnamefull; ?></strong></td>
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
							<a href="vendor.php?product=<?php echo $vendorabbrev; ?>"><?php echo $vendornamefull; ?></a>
						</td>
					</tr>
				</table>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-lg-4 top-left card-transition">
						<div class="card card-chart">
							<div class="card-header">
								<h4 class="card-title"><i class="material-icons" id="trig">zoom_out_map</i>Institution Type</h4>
								<div class="dropdown">
									<ul class="nav nav-pills pills-circle" role="tablist">
									<li class="nav-item">
										<a aria-controls="type-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#type-chart" id="type-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
									</li>
									<li class="nav-item">
										<a aria-controls="type-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#type-table" id="type-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
									</li>
								</ul>
									
								</div>
							</div>
							<div class="card-body">
								<div class="tab-content" id="pills-tabContent">
								  <div class="tab-pane fade show active" id="type-chart" role="tabpanel" aria-labelledby="type-chart-tab">
									<div class="chart-area">
										<canvas id="myCharttype"></canvas>
									</div>
								  </div>
								  <div class="tab-pane fade" id="type-table" role="tabpanel" aria-labelledby="type-table-tab">
									<table cellspacing="0" class="table table-hover table-bordered compact" id="typetable" width="100%">
										<thead>
											<tr>
												<th>Institution Type</th>
												<?php foreach($datatypesgrp as $dtype1g): ?>
												<th><?php echo $dtype1g; ?></th>
												<?php endforeach; ?>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($tablearrgrp as $grpn => $grpv): ?>
											<tr>
												<td><?php $tg = 0; echo $grpn; ?></td>
												<?php foreach($grpv as $grpvv): ?>
												<td><?php echo $grpvv; $tg = $tg + $grpvv; ?></td>
												<?php endforeach; ?>
												<td><?php echo $tg; ?></td>
											</tr><?php endforeach; ?>
										</tbody>
									</table>
								  </div>
								</div>
							
							</div>
							<div class="card-footer"></div>
						</div>
					</div>
					
					<div class="col-lg-8 top-right card-transition">
						<div class="card card-chart">
						<div class="card-header">
								<h4 class="card-title"><i class="material-icons" id="trig1">zoom_out_map</i> Date View</h4>
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
							
								<div class="tab-content" id="pills-tabContent1">
									<div class="tab-pane fade show active" id="date-chart" role="tabpanel" aria-labelledby="date-chart-tab">
							
								<ul class="nav nav-pills nav-wizard" id="datetabs" role="tablist">
									<li class="nav-item">
										<a aria-controls="date-all" aria-selected="true" class="nav-link active" data-toggle="tab" href="#date-all" id="date-tab-0" role="tab">All Groups</a>
									</li>
									<li class="nav-item">
										<a aria-controls="date-doctoral" aria-selected="true" class="nav-link" data-toggle="tab" href="#date-doctoral" id="date-tab-1" role="tab">Public Doctoral</a>
									</li>
									<li class="nav-item">
										<a aria-controls="date-fouryear" aria-selected="false" class="nav-link" data-toggle="tab" href="#date-fouryear" id="date-tab-2" role="tab">Public 4-Year</a>
									</li>
									<li class="nav-item">
										<a aria-controls="date-private" aria-selected="false" class="nav-link" data-toggle="tab" href="#date-private" id="date-tab-3" role="tab">Private Non-Profit</a>
									</li>
									<li class="nav-item">
										<a aria-controls="date-twoyear" aria-selected="false" class="nav-link" data-toggle="tab" href="#date-twoyear" id="date-tab-4" role="tab">Public 2-Year</a>
									</li>
								</ul>
								<div class="tab-content" id="myTabContent">
									<div aria-labelledby="date-tab-0" class="tab-pane fade show active" id="date-all" role="tabpanel">
										<div class="chart-area">
											<canvas id="myChartdate"></canvas>
										</div>
									</div>
									<div aria-labelledby="date-tab-1" class="tab-pane fade" id="date-doctoral" role="tabpanel">
										<div class="chart-area">
											<canvas id="myChartdatedoctoral"></canvas>
										</div>
									</div>
									<div aria-labelledby="date-tab-2" class="tab-pane fade" id="date-fouryear" role="tabpanel">
										<div class="chart-area">
											<canvas id="myChartdatefouryear"></canvas>
										</div>
									</div>
									<div aria-labelledby="date-tab-3" class="tab-pane fade" id="date-private" role="tabpanel">
										<div class="chart-area">
											<canvas id="myChartdateprivate"></canvas>
										</div>
									</div>
									<div aria-labelledby="date-tab-4" class="tab-pane fade" id="date-twoyear" role="tabpanel">
										<div class="chart-area">
											<canvas id="myChartdatetwoyear"></canvas>
										</div>
									</div>
								</div>
							
								  </div>
								  <div class="tab-pane fade" id="date-table" role="tabpanel" aria-labelledby="date-table-tab">
									<table cellspacing="0" class="table table-hover table-bordered compact" id="datetable" width="100%">
										<thead>
											<tr>
												<th>Institution</th>
												<th>Institution Type</th><?php foreach($alldates as $adt): ?>
												<th><?php echo $adt; ?></th><?php endforeach; ?>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($instdatearray as $gtyp => $gps): ?><?php foreach($gps as $iname => $dates): ?>
											<tr>
												<td><?php echo $iname; ?></td>
												<td><?php echo $gtyp; ?></td><?php $tot = 0; ?><?php foreach($dates as $dates1): ?>
												<td><?php echo $dates1; ?></td><?php $tot += $dates1; ?><?php endforeach; ?>
												<td><?php echo $tot; ?></td>
											</tr><?php endforeach; ?><?php endforeach; ?>
										</tbody>
									</table>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 bottom-left card-transition">
						<div class="card card-chart card-tall">
							<div class="card-header">
								<h4 class="card-title"><i class="material-icons" id="trig2">zoom_out_map</i> All Institutions</h4>
								<div class="dropdown">
									<ul class="nav nav-pills pills-circle" role="tablist">
										<li class="nav-item">
											<a aria-controls="all-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#all-chart" id="all-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
										</li>
										<li class="nav-item">
											<a aria-controls="all-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#all-table" id="all-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
										</li>
									</ul>		
								</div>
							</div>
							<div class="card-body">
							<div class="tab-content" id="pills-tabContent2">
								  <div class="tab-pane fade show active" id="all-chart" role="tabpanel" aria-labelledby="all-chart-tab">
									<div class="chart-area">
										<canvas id="myChartinst"></canvas>
									</div>
								  </div>
								  <div class="tab-pane fade" id="all-table" role="tabpanel" aria-labelledby="all-table-tab">
									<table cellspacing="0" class="table table-hover table-bordered compact" id="institutiontable" width="100%">
										<thead>
											<tr>
												<th>Institution</th>
												<th>Institution Type</th>
												<?php foreach($datatypes as $dtype1): ?>
												<th><?php echo $dtype1; ?></th>
												<?php endforeach; ?>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($tablearr as $instn => $instv): ?>
											<tr>
												<td><?php $t = 0; echo $instn; ?></td>
												<?php foreach($instv as $instvv): ?>
												<td><?php echo $instvv; $t = $t + $instvv; ?></td>
												<?php endforeach; ?>
												<td><?php echo $t; ?></td>
											</tr><?php endforeach; ?>
										</tbody>
									</table>
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
			</div>
						<?php include dirname(dirname( __FILE__ )) . "/includes/footer.php"; ?>
		</div>
	</div>

<?php include dirname(dirname( __FILE__ )) . "/includes/packagescripts.php"; ?>


 <script>
//set up autocomplete for package search
$(function() {
var autocompletelist = [
         <?php foreach ($allproducts as $prod){
			 echo '{label:"' . $prod['Product'] . '",type:"' . $prod['type'] . '",value:"' . $prod['product_abbrev']. '"},';
			 } ?>
        ];
$("#quicksearch").autocomplete({
	source: autocompletelist,
	select: function( event, ui ) {
	 window.location.href = ui.item.type + ".php?product=" + ui.item.value;
     return false;
    }
   });
});

var ctx = document.getElementById("myChartinst").getContext('2d');
var myChart = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ["<?php echo implode('","',$labelsarr); ?>"],
		types: ["<?php echo implode('","',$typearr); ?>"],
		abbrevs: ["<?php echo implode('","',$abbrevarr); ?>"],
		
		 datasets: [
		<?php foreach($dataset as $dtyp=>$dset): ?>
      {
            label: '<?php echo $dtyp; ?>',
			data: [<?php echo implode(",",$dset); ?>],
			backgroundColor: [],
        },
    <?php endforeach; ?>
      ]
    },
    options: {
		 legend: {
            display: true
         },
		responsive:true,
		onClick: <?php echo $onclickevent; ?>,
		maintainAspectRatio: false,
        scales: {
			xAxes: [{
				stacked: true,
				beginAtZero: true,
				gridLines: {
					display: false,
				}
			}],
            yAxes: [{
				stacked: true,
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
});

var ctx = document.getElementById("myCharttype").getContext('2d');
var myCharttype = new Chart(ctx, {
    type: '<?php echo $charttypetype; ?>',
    data: {
        labels: ["<?php echo implode('","',$labelsarrtype); ?>"],
		types: ["<?php echo implode('","',$typearrtype); ?>"],
       	datasets: [
		<?php foreach($datasetgrp as $dtypg=>$dsetg): ?>
      {
            label: '<?php echo $dtypg; ?>',
			data: [<?php echo implode(",",$dsetg); ?>],
			backgroundColor: [],
        },
    <?php endforeach; ?>
      ]
    },
    options: {
		 legend: {
            display: true
         },
		 responsive:true,
		 onClick: <?php echo $onclickeventtype; ?>,
		 maintainAspectRatio: false,
		scales: {
			xAxes: [{
				ticks: {
					autoSkip: false,
				},
				stacked: true,
				beginAtZero: true,
				gridLines: {
					display: false,
				}
			}],
            yAxes: [{
				stacked: true,
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
});


var ctx = document.getElementById("myChartdate").getContext('2d');
var myChartdate = new Chart(ctx, {
    type: '<?php echo $charttypedate; ?>',
    data: {
        labels: ['<?php echo implode("','",$alldatearr); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($newarr2 as $chartk => $chartvalue): ?>
		
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




<? if (array_key_exists("Private Nonprofit",$instdatearray)): ?>

$('#date-tab-3').on('shown.bs.tab', function(){
var ctx = document.getElementById("myChartdateprivate").getContext('2d');
var myChartdateprivate = new Chart(ctx, {
    type: '<?php echo $charttypedate; ?>',
    data: {
        labels: ['<?php echo implode("','",$alldates); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($instdatearray['Private Nonprofit'] as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
			abbrev: "<?php echo institutionlookup($chartk,'Institution')['Inst_abbrev']; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegenddate; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventdateinst; ?>,
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


});

<? else: ?>
$( "#date-private" ).html( "There are no institutions in this category." );
<? endif; ?>


<? if (array_key_exists("Public 2 Year",$instdatearray)): ?>



$('#date-tab-4').on('shown.bs.tab', function(){
var ctx = document.getElementById("myChartdatetwoyear").getContext('2d');
var myChartdatetwoyear = new Chart(ctx, {
    type: '<?php echo $charttypedate; ?>',
    data: {
        labels: ['<?php echo implode("','",$alldates); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($instdatearray['Public 2 Year'] as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
			abbrev: "<?php echo institutionlookup($chartk,'Institution')['Inst_abbrev']; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegenddate; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventdateinst; ?>,
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


});

<? else: ?>
$( "#date-twoyear" ).html( "There are no institutions in this category." );
<? endif; ?>


<? if (array_key_exists("Public 4 Year",$instdatearray)): ?>


$('#date-tab-2').on('shown.bs.tab', function(){
var ctx = document.getElementById("myChartdatefouryear").getContext('2d');
var myChartdatefouryear = new Chart(ctx, {
    type: '<?php echo $charttypedate; ?>',
    data: {
        labels: ['<?php echo implode("','",$alldates); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($instdatearray['Public 4 Year'] as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
			abbrev: "<?php echo institutionlookup($chartk,'Institution')['Inst_abbrev']; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegenddate; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventdateinst; ?>,
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


});

<? else: ?>
$( "#date-fouryear" ).html( "There are no institutions in this category." );
<? endif; ?>

<? if (array_key_exists("Public Doctoral",$instdatearray)): ?>

$('#date-tab-1').on('shown.bs.tab', function(){
var ctx = document.getElementById("myChartdatedoctoral").getContext('2d');
var myChartdatedoctoral = new Chart(ctx, {
    type: '<?php echo $charttypedate; ?>',
    data: {
        labels: ['<?php echo implode("','",$alldates); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($instdatearray['Public Doctoral'] as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
			abbrev: "<?php echo institutionlookup($chartk,'Institution')['Inst_abbrev']; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: false,
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegenddate; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventdateinst; ?>,
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


});

<? else: ?>
$( "#date-doctoral" ).html( "There are no institutions in this category." );
<? endif; ?>
//custom colors must be set after the chart loads
for (k = 0; k < myChart.data.datasets.length; k++) {
    myChart.data.datasets[k].backgroundColor = [];
    for (i = 0; i < myChart.data.datasets[k].data.length; i++) {
        var curgroup = myChart.data.types[i];
        var newcol = LightenDarkenColor(groupcolors[curgroup].color, k * 20);
        myChart.data.datasets[k].backgroundColor.push(newcol);
    }
}
// myChart.legend.legendItems[0].fillStyle = "#ccc";
//console.log(myChart.legend.legendItems);
myChart.update(); //update the chart

for (k = 0; k < myCharttype.data.datasets.length; k++) {
    myCharttype.data.datasets[k].backgroundColor = [];
    for (i = 0; i < myCharttype.data.datasets[k].data.length; i++) {
        var curgroup = myCharttype.data.types[i];
        var newcol = LightenDarkenColor(groupcolors[curgroup].color, k * 20);
        myCharttype.data.datasets[k].backgroundColor.push(newcol);
    }
}
myCharttype.update(); //update the chart

function loadinstitution(event, array) {
    if (array.length > 0) {
        var lab = array[0]._chart.config.data.abbrevs[array[0]._index];
        window.location = '/institution/database.php?inst=' + lab + '&product=' + getUrlParameter('product') + '&range=' + getUrlParameter('range') + '&startdate=' + getUrlParameter('startdate') + '&enddate=' + getUrlParameter('enddate');

    }
}


function drilldown(event, array) {
    if (array.length > 0) {
        var thisset = this.getDatasetAtEvent(event)[0]._datasetIndex;
        var lab = array[0]._chart.config.data.datasets[thisset].label;
        if (lab == "Public Doctoral") {
            $('#date-tab-1').tab('show');
        } else if (lab == "Public 4 Year") {
            $('#date-tab-2').tab('show');
        } else if (lab == "Private Nonprofit") {
            $('#date-tab-3').tab('show');
        } else if (lab == "Public 2 Year") {
            $('#date-tab-4').tab('show');
        }
    }
}


function gotoinstitution(event, array) {
    if (array.length > 0) {
        var thisset = this.getDatasetAtEvent(event)[0]._datasetIndex;
        var lab = array[0]._chart.config.data.datasets[thisset].abbrev;
        window.location = '/institution/database.php?inst=' + lab + '&product=' + getUrlParameter('product') + '&range=' + getUrlParameter('range') + '&startdate=' + getUrlParameter('startdate') + '&enddate=' + getUrlParameter('enddate');
    }
}

$(document).ready(function() {

    $('#datetable').DataTable({
        "scrollX": true,
        "pageLength": 25,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
    });

    $('#institutiontable').DataTable({
        "pageLength": 25,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
    });

    dtable = $('#titletable').DataTable({
        "paging": true,
        "pageLength": 25,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
    });

    //count all columns
    totalcols = dtable.columns()[0].length;

    //hide all but first 4
    for (var i = 1; i < totalcols - 1; i++) {
        dtable.column(i).visible(false, false);
    }
    //dtable.column(3 ).visible( false, false );
    dtable.columns.adjust().draw(false); // adjust column sizing and redraw

});

$('#trig').on('click', function () {
	$('.top-left').toggleClass('col-lg-12');
	});
	$('#trig2').on('click', function () {
	$('.bottom-left').toggleClass('col-lg-12');
	});

	$('#trig1').on('click', function () {
		$('.top-left').toggleClass('order-lg-12');
		$('.top-left').toggleClass('order-lg-1');
		$('.top-right').toggleClass('col-lg-12');
	});

	
	$('#expandtable').on('click', function() {
    $('.bottom-left').toggleClass('order-lg-4');
    $('.bottom-left').toggleClass('order-lg-1');
    $('.bottom-right').toggleClass('col-lg-12');

    var dtable = $('#titletable').DataTable();
    //count visible columns
    var viscols = dtable.columns().visible();
    var countvis = viscols.filter(function(s) {
        return s;
    }).length;
    //if only 2 are visible, expand
    if (countvis == 2) {
        for (var i = 0; i <= totalcols; i++) {
            dtable.column(i).visible(true, true);
        }
    } else {
        for (var i = 1; i < totalcols - 1; i++) {
            dtable.column(i).visible(false, false);
        }

    }

    dtable.columns.adjust().draw(false); // adjust column sizing and redraw
});



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

</script>

  
</body>

</html>