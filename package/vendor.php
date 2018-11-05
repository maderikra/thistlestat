<!DOCTYPE html>

<html lang="en">

<?php 

include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
include dirname(dirname( __FILE__ )) . "/includes/preparedates.php";
include dirname(dirname( __FILE__ )) . "/includes/packagelists.php";
include dirname(dirname( __FILE__ )) . "/includes/preparesummary.php";

include "chart_vendor.php";

$productnamefull = 	vendorlookup($productname,'vendor_abbrev','Vendor')['Vendor'];

?>

<head>

  <title><?php echo $consortiumname . " " . $sitename; ?>: Vendor Analysis</title>

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
						<td class="cellheading">Vendor Name:</td>
						<td><strong><?php echo $productnamefull; ?></strong></td>
					</tr>
					<tr>
						<td class="cellheading">Dates Selected:</td>
						<td><?php echo $startdate . ' to ' . $enddate; ?></td>
					</tr>
			
				</table>
				<ul class="nav nav-pills nav-wizard-lg" role="tablist">
									<li class="nav-item">
										<a aria-controls="packlist" aria-selected="true" class="nav-link active" data-toggle="tab" href="#packlist1" id="main-tab-0" role="tab">Package List</a>
									</li>
									<li class="nav-item">
										<a aria-controls="packview" aria-selected="true" class="nav-link" data-toggle="tab" href="#packview1" id="main-tab-1" role="tab">Package View</a>
									</li>
									<li class="nav-item">
										<a aria-controls="dateview" aria-selected="false" class="nav-link" data-toggle="tab" href="#dateview1" id="main-tab-2" role="tab">Date View</a>
									</li>
								
								</ul>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-lg-6 top-left card-transition">
						<div class="card card-chart">
							<div class="card-header">
								<h5 class="card-category"><i class="material-icons">description</i> Journal Packages</h5>
								<div class="dropdown">
									<button class="btn btn-round btn-default btn-simple btn-icon no-caret" id="trig" title="Expand Graph" type="button"><i class="material-icons">zoom_out_map</i></button> <button class="btn btn-round btn-default btn-simple btn-icon no-caret" data-target="#Modal1" data-toggle="modal" title="Show Data Table" type="button"><i class="material-icons">list</i></button>
								</div>
							</div>
							<div class="card-body">
								
								<div class="tab-content" id="pills-tabContent">
								  <div class="tab-pane fade show active" id="packlist1" role="tabpanel" aria-labelledby="pills-home-tab">
								  
								  <? if ($resultsj): ?>

									<table id="journalstable" class="table table-hover table-bordered compact" width="100%" cellspacing="0">

										<thead>
											<tr>
												<th>Product</th>
												<th># Institutions</th>
												<th># Titles</th>
												<th>Total Usage</th>
												<th>Avg. Usage/Title</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($resultsj as $value): ?>
											<tr>
												<td>
													<a href="journal.php?product=<?php echo $value['product_abbrev']; ?>&range=all&startdate=&enddate=">
														<?php echo $value[ 'Product']; ?>
													</a>
												</td>
												<td>
													<?php echo $value[ 'totinsts']; ?>
												</td>
												<td>
													<?php echo $value[ 'tottitles']; ?>
												</td>
												<td>
													<?php echo $value[ 'totals']; ?>
												</td>
												<td>
													<?php echo round($value[ 'totals']/$value[ 'tottitles']); ?>
												</td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
									<? else: ?>
									<span class="text-muted">There are no journal packages from this vendor.</span>

									<? endif; ?>
								  
								  </div>
								  <div class="tab-pane fade" id="packview1" role="tabpanel" aria-labelledby="pills-profile-tab">
								  <? if ($resultsj): ?>
									<div class="myChartDiv">
										<canvas id="myChartj" width="1200" height="500"></canvas>
									</div>

									<? else: ?>
									<span class="text-muted">There are no journal packages from this vendor.</span>

									<? endif; ?>
								  </div>
								  <div class="tab-pane fade" id="dateview1" role="tabpanel" aria-labelledby="pills-contact-tab">
								  <? if ($resultsjdate): ?>
									<div class="myChartDiv">
										<canvas id="myChartjdate" width="1200" height="500"></canvas>
									</div>

									<? else: ?>
									<span class="text-muted">There are no journal packages from this vendor.</span>

									<? endif; ?>
								  </div>
								</div>

							</div>
							<div class="card-footer"></div>
						</div>
					</div>
					
					<div class="col-lg-6 top-right card-transition">
						<div class="card card-chart">
							<div class="card-header">
								<h5 class="card-category"><i class="material-icons">import_contacts</i> E-Book Packages</h5>
								<div class="dropdown">
									<button class="btn btn-round btn-default btn-simple btn-icon no-caret" id="trig1" title="Expand Graph" type="button"><i class="material-icons">zoom_out_map</i></button> <button class="btn btn-round btn-default btn-simple btn-icon no-caret" data-target="#datemodal" data-toggle="modal" title="Show Data Table" type="button"><i class="material-icons">list</i></button>
								</div>
							</div>
							<div class="card-body">
							<ul class="nav nav-pills nav-wizard d-none" id="tabs2" role="tablist">
									<li class="nav-item">
										<a aria-controls="packlist2" aria-selected="true" class="nav-link active" data-toggle="tab" href="#packlist2" id="main-tab-0" role="tab">Package List</a>
									</li>
									<li class="nav-item">
										<a aria-controls="packview2" aria-selected="true" class="nav-link" data-toggle="tab" href="#packview2" id="main-tab-1" role="tab">Package View</a>
									</li>
									<li class="nav-item">
										<a aria-controls="dateview2" aria-selected="false" class="nav-link" data-toggle="tab" href="#dateview2" id="main-tab-2" role="tab">Date View</a>
									</li>
								
								</ul>
								<div class="tab-content" id="pills-tabContent">
								  <div class="tab-pane fade show active" id="packlist2" role="tabpanel" aria-labelledby="pills-home-tab">
								  <? if ($resultsb): ?>

										<table id="ebookstable" class="table table-hover table-bordered compact" width="100%" cellspacing="0">

											<thead>
												<tr>
													<th>Product</th>
													<th># Institutions</th>
													<th># Titles</th>

													<th>Total Usage</th>
													<th>Avg. Usage/Title</th>

												</tr>
											</thead>
											<?php foreach($resultsb as $value): ?>
											<tr>
												<td>
													<a href="ebook.php?product=<?php echo $value['product_abbrev']; ?>&range=all&startdate=&enddate=">
														<?php echo $value[ 'Product']; ?>
													</a>
												</td>
												<td>
													<?php echo $value[ 'totinsts']; ?>
												</td>
												<td>
													<?php echo $value[ 'tottitles']; ?>
												</td>

												<td>
													<?php echo $value[ 'totals']; ?>
												</td>
												<td>
													<?php echo round($value[ 'totals']/$value[ 'tottitles']); ?>
												</td>

											</tr>
											<?php endforeach; ?>

										</table>
										<? else: ?>
										<span class="text-muted">There are no e-book packages from this vendor.</span>

										<? endif; ?>
								  </div>
								  <div class="tab-pane fade" id="packview2" role="tabpanel" aria-labelledby="pills-profile-tab">
								  <? if ($resultsb): ?>
									<div class="myChartDiv">
										<canvas id="myChartb" width="1200" height="500"></canvas>
									</div>
									<? else: ?>
									<span class="text-muted"> There are no e-book packages from this vendor. </span>

									<? endif; ?>
								  </div>
								  <div class="tab-pane fade" id="dateview2" role="tabpanel" aria-labelledby="pills-contact-tab">
								  <? if ($resultsbdate): ?>
									<div class="myChartDiv">
										<canvas id="myChartbdate" width="1200" height="500"></canvas>
									</div>
									<? else: ?>
									<span class="text-muted">There are no e-book packages from this vendor.</span>

									<? endif; ?>
								</div>
							</div>
							
							</div>
						</div>
					</div>
				</div>
		
				<div class="row">
					<div class="col-md-6 bottom-left card-transition">
						<div class="card card-chart">
							<div class="card-header">
								<h5 class="card-category"><i class="material-icons">laptop_mac</i> Database Packages</h5>
								<div class="dropdown">
									<button class="btn btn-round btn-default btn-simple btn-icon no-caret" id="trig2" title="Expand Graph" type="button"><i class="material-icons">zoom_out_map</i></button> <button class="btn btn-round btn-default btn-simple btn-icon no-caret" data-target="#instmodal" data-toggle="modal" title="Show Data Table" type="button"><i class="material-icons">list</i></button>
								</div>
							</div>
							<div class="card-body">
								
								<ul class="nav nav-pills nav-wizard d-none" id="tabs3" role="tablist">
									<li class="nav-item">
										<a aria-controls="packlist3" aria-selected="true" class="nav-link active" data-toggle="tab" href="#packlist3" id="main-tab-0" role="tab">Package List</a>
									</li>
									<li class="nav-item">
										<a aria-controls="packview3" aria-selected="true" class="nav-link" data-toggle="tab" href="#packview3" id="main-tab-1" role="tab">Package View</a>
									</li>
									<li class="nav-item">
										<a aria-controls="dateview3" aria-selected="false" class="nav-link" data-toggle="tab" href="#dateview3" id="main-tab-2" role="tab">Date View</a>
									</li>
								
								</ul>
								<div class="tab-content" id="pills-tabContent">
								  <div class="tab-pane fade show active" id="packlist3" role="tabpanel" aria-labelledby="pills-home-tab">
								  <? if ($resultsdb): ?>

										<table id="dbtable" class="table table-hover table-bordered compact" width="100%" cellspacing="0">

											<thead>
												<tr>
													<th>Name</th>
													<th># Institutions</th>
													<?php foreach($keyarray as $key): ?>
													<th>
														<?php echo $key; ?>
													</th>
													<?php endforeach; ?>
												</tr>
											</thead>
											<?php foreach($resultsdb as $pack=> $value): ?>
											<tr>
												<td>
													<a href="database.php?product=<?php echo $value[0]['product_abbrev']; ?>&range=all&startdate=&enddate=">
														<?php echo $pack; ?>
													</a>
												</td>

												<td>
													<?php echo $value[0][ 'totinsts']; ?>
												</td>
												<?php foreach($value as $val): ?>
												<td>
													<?php echo $val[ 'totals']; ?>
												</td>

												<?php endforeach; ?>
											</tr>
											<?php endforeach; ?>

										</table>
										<? else: ?>
										<span class="text-muted">There are no database packages from this vendor.</span>

										<? endif; ?>
								  </div>
								  <div class="tab-pane fade" id="packview3" role="tabpanel" aria-labelledby="pills-profile-tab">
								  <? if ($resultsdb): ?>
									<div class="myChartDiv">
										<canvas id="myChartdb" width="1200" height="500"></canvas>
									</div>
									<? else: ?>
									<span class="text-muted">There are no database packages from this vendor.</span>

									<? endif; ?>
								  </div>
								  <div class="tab-pane fade" id="dateview3" role="tabpanel" aria-labelledby="pills-contact-tab">
								  <? if ($resultsddate): ?>
									<div class="myChartDiv">
										<canvas id="myChartddate" width="1200" height="500"></canvas>
									</div>
									<? else: ?>
									<span class="text-muted">There are no database packages from this vendor.</span>

									<? endif; ?>
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



$('#main-tab-2').on('shown.bs.tab', function(){
<? if ($resultsbdate): ?> 
var ctx = document.getElementById("myChartbdate").getContext('2d');
 myChartbdate = new Chart(ctx, {
    type: '<?php echo $charttypebd; ?>',
    data: {
        labels: ['<?php echo implode("','",$datearrb); ?>'],
        datasets: [
		    <?php foreach($chartarraybd as $chartkey=>$chartvalue): ?>
			{
			label: '<?php echo $chartkey; ?>',
			data: [<?php echo implode(",",$chartvalue); ?>],
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
			 fill: false,
            borderWidth: 1,
			},
			<?php endforeach; ?>
		
		]
    },
    options: {
		 responsive:true,
    maintainAspectRatio: false,
		 title: {
            display: true,
            text: '<?php echo $startdate . " to " . $enddate; ?>',
			fontSize: 16,
			fontColor: "#3535b2",
        },
        scales: {
			 xAxes: [{
        stacked: false,
        beginAtZero: true,
        scaleLabel: {
            labelString: '<?php echo $xlabelbd; ?>',
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
            labelString: '<?php echo $ylabelbd; ?>',
			display: true
        },
            }]
        }
    },
});
<?php endif; ?>

<? if ($resultsddate): ?> 
var ctx = document.getElementById("myChartddate").getContext('2d');
 myChartddate = new Chart(ctx, {
    type: '<?php echo $charttypedd; ?>',
    data: {
        labels: ['<?php echo implode("','",$datearrd); ?>'],
        datasets: [
		    <?php $i = 0; foreach($chartarraydd as $chartkey=>$chartvalue): ?>
			{
			label: "<?php echo $chartkey; ?>",
			data: [<?php echo implode(",",$chartvalue); ?>],
			fill:false,
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
            borderWidth: 1,
			},
			<?php $i++; endforeach; ?>
		
		]
    },
    options: {
		 responsive:true,
    maintainAspectRatio: false,
		 title: {
            display: true,
            text: '<?php echo $startdate . " to " . $enddate; ?>',
			fontSize: 16,
			fontColor: "#3535b2",
        },
        scales: {
			 xAxes: [{
        stacked: false,
        beginAtZero: true,
        scaleLabel: {
            labelString: '<?php echo $xlabeldd; ?>',
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
            labelString: '<?php echo $ylabeldd; ?>',
			display: true
        },
            }]
        }
    },
});
<?php endif; ?>

<? if ($resultsjdate): ?> 
var ctx = document.getElementById("myChartjdate").getContext('2d');
 myChartjdate = new Chart(ctx, {
    type: '<?php echo $charttypejd; ?>',
    data: {
        labels: ['<?php echo implode("','",$datearrj); ?>'],
        datasets: [
		    <?php foreach($chartarrayjd as $chartkey=>$chartvalue): ?>
			{
			label: "<?php echo $chartkey; ?>",
			data: [<?php echo implode(",",$chartvalue); ?>],
			backgroundColor: '#<?php $thiscolr = substr(md5(rand()), 0, 6); echo $thiscolr; ?>',
			borderColor: '#<?php echo $thiscolr;?>',
			 fill: false,
            borderWidth: 1,
			},
			<?php endforeach; ?>
		
		]
    },
    options: {
		 responsive:true,
    maintainAspectRatio: false,
		 title: {
            display: true,
            text: '<?php echo $startdate . " to " . $enddate; ?>',
			fontSize: 16,
			fontColor: "#3535b2",
        },
        scales: {
			 xAxes: [{
        stacked: false,
        beginAtZero: true,
        scaleLabel: {
            labelString: '<?php echo $xlabeljd; ?>',
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
            labelString: '<?php echo $ylabeljd; ?>',
			display: true
        },
            }]
        }
    },
});
<?php endif; ?>

});

$('#main-tab-1').on('shown.bs.tab', function(){

<? if ($resultsj): ?> 
var ctx = document.getElementById("myChartj").getContext('2d');
 myChartj = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ['<?php echo implode("','",$keyarrayj); ?>'],
		productabbrev: ['<?php echo implode("','",$abbrevarrayj);  ?>'],
        datasets: [

		
		{
            label: 'Uses',
            data: [<?php echo implode(",",$resultsarrj); ?>],
			fill: false,
			 backgroundColor : '<?php echo $color0; ?>',
			 borderColor: '<?php echo $color0; ?>',
            borderWidth: 1
        },
	
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegendj; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventj; ?>,
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
            labelString: '<?php echo $xlabelj; ?>',
			display: true
        },
		gridLines: {
			display: false,
		},
        ticks: {
            stepSize: 1,
            min: 0,
            autoSkip: <?php echo $autoskipj; ?>,
			maxRotation: 45,
                    minRotation: 45
        }
    }],
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
				        scaleLabel: {
            labelString: '<?php echo $ylabelj; ?>',
			display: true
        },
            }]
        }
    },
});
<?php endif; ?>

<? if ($resultsb): ?> 
var ctx = document.getElementById("myChartb").getContext('2d');
 myChartb = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ['<?php echo implode("','",$keyarrayb); ?>'],
		productabbrev: ['<?php echo implode("','",$abbrevarrayb);  ?>'],
        datasets: [

		
		{
            label: 'Uses',
            data: [<?php echo implode(",",$resultsarrb); ?>],
			fill: false,
			 backgroundColor : 'color0',
			 borderColor: 'color0',
            borderWidth: 1
        },
	
		]
    },
    options: {
		legend: {
      display: <?php echo $showlegendb; ?>,
		},
		 responsive:true,
		 onClick: <?php echo $onclickeventb; ?>,
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
            labelString: '<?php echo $xlabelb; ?>',
			display: true
        },
		gridLines: {
			display: false,
		},
        ticks: {
            stepSize: 1,
            min: 0,
            autoSkip: <?php echo $autoskipb; ?>,
			maxRotation: 45,
                    minRotation: 45
        }
    }],
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
				        scaleLabel: {
            labelString: '<?php echo $ylabelb; ?>',
			display: true
        },
            }]
        }
    },
});
<?php endif; ?>

  <? if ($resultsdb): ?> 
var ctx = document.getElementById("myChartdb").getContext('2d');
 myChartdb = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ['<?php echo implode("','",array_keys($newarr)); ?>'],
		productabbrev: ['<?php echo implode("','",$abbrevarrayd); ?>'],
        datasets: [
		<?php $i = 0; ?>
		<?php foreach($arr1 as $chartk => $chartvalue): ?>
		
		{
            label: "<?php echo $chartk; ?>",
            data: [<?php echo implode(",",$chartvalue); ?>],
			fill: true,
			 backgroundColor: '<?php echo ${"color" . $i} ?>',
            borderWidth: 1
        },
		<?php $i++; ?>
		<?php endforeach; ?>
		]
    },
    options: {
		 responsive:true,
		 onClick: <?php echo $onclickeventdb; ?>,
    maintainAspectRatio: false,
		 title: {
            display: true,
            text: '<?php echo $startdate . " to " . $enddate; ?>',
			fontSize: 16,
			fontColor: "#5D7B93",
        },
        scales: {
			 xAxes: [{
        stacked: true,
        beginAtZero: true,
        scaleLabel: {
            labelString: 'Month'
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
				 stacked: true,
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
});
<?php endif; ?>

});


$(document).ready(function() {
	$('#journalstable').DataTable({
		"pageLength": 25,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'csvHtml5',
		],
	});
	$('#ebookstable').DataTable({
		"pageLength": 25,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'csvHtml5',
		],
	});
	$('#dbtable').DataTable({
		"pageLength": 25,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'csvHtml5',
		],
	});
	
	
	$('#main-tab-0').click(function(e) {
		$('.nav-pills a[href="#packlist2"]').tab('show');
		$('.nav-pills a[href="#packlist3"]').tab('show');
	});
	$('#main-tab-1').click(function(e) {
		$('.nav-pills a[href="#packview2"]').tab('show');
		$('.nav-pills a[href="#packview3"]').tab('show');
	});
	
	$('#main-tab-2').click(function(e) {
	$('.nav-pills a[href="#dateview2"]').tab('show');
	$('.nav-pills a[href="#dateview3"]').tab('show');
	});

});

$('#trig').on('click', function() {
    $('.top-left').toggleClass('col-lg-12');
});

$('#trig2').on('click', function() {
    $('.bottom-left').toggleClass('col-lg-12');
});

$('#trig1').on('click', function() {
    $('.top-left').toggleClass('order-lg-12');
    $('.top-left').toggleClass('order-lg-1');
    $('.top-right').toggleClass('col-lg-12');
});


$('#expandtable').on('click', function() {
    $('.bottom-left').toggleClass('order-lg-4');
    $('.bottom-left').toggleClass('order-lg-1');
    $('.bottom-right').toggleClass('col-lg-12');

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
	
function loadjournals(event, array) {
    if (array.length > 0) {
        var thisabb = this.data.productabbrev[array[0]._index];
        window.location.href = "journal.php?product=" + thisabb + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loadbooks(event, array) {
    if (array.length > 0) {
        var thisabb = this.data.productabbrev[array[0]._index];
        window.location.href = "ebook.php?product=" + thisabb + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loaddatabase(event, array) {
    if (array.length > 0) {
        var thisindex = array[0]._index;
        var thisabb = this.data.productabbrev[thisindex];
        window.location.href = "database.php?product=" + thisabb + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}
</script>

   
</body>



</html>