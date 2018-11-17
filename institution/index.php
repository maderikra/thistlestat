<!DOCTYPE html>

<html lang="en">

<?php 

include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
include dirname(dirname( __FILE__ )) . "/includes/preparedates.php";
include dirname(dirname( __FILE__ )) . "/includes/packagelists.php";
include dirname(dirname( __FILE__ )) . "/includes/preparesummary.php";

$fullinstname = institutionlookup($_GET['inst'],"Inst_abbrev")['Institution'];

if(isset($_GET['inst'])){
include 'chart_basic_summary.php';
}

?>

<head>

<title><?php echo $consortiumname . " " . $sitename; ?>: Institution Summary</title>


<?php include dirname(dirname( __FILE__ )) . "/includes/head.php"; ?>


<style>
#colorlist { list-style: none; }
#colorlist li { float: left; margin-right: 10px; }
#colorlist span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; }
.myChartDiv {
 /* max-width: 800px; */
 width: 100%;
  max-height: 400px;

}
</style>


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
						 
				
					
			</div>
         
              <div class="col-md-6 col-sm-12">
              
              <div class="benchgroup">
								<h4><i class="material-icons">school</i> Change Institution</h4>
								
							
							<select name='inst' id='inst'>
								<option value=""></option>
										 <?php
									
									foreach ($allinstitutions as $res){
									echo "<option value='" . $res['Inst_abbrev'] . "'>" . $res['Institution'] . "</option>";

									}
									?>
							</select>
							
							                <input type="button" class="btn btn-local btn-sm"  id="reloadbench" value="Reload Data" onclick="reload()">

							
				</div>	
              </div>
              </div>
			</div>
			<div class="content">
				<div class="row">
	<? if (isset($_GET['inst'])): ?>
					<div class="col-lg-6 top-left card-transition">
							<div class="card card-chart">
							<div class="card-header">
								<h5 class="card-category"><i class="material-icons">description</i> Journal Packages</h5>
								<div class="dropdown">
									<button class="btn btn-round btn-default btn-simple btn-icon no-caret" id="trig" title="Expand Graph" type="button"><i class="material-icons">zoom_out_map</i></button>
								</div>
							</div>
							<div class="card-body">
								 <div class="myChartDiv">
                                 <canvas id="myChartj" width="800" height="400"></canvas>
                                </div>
					
							</div>
							<div class="card-footer"></div>
						</div>
						
					</div>
					
					<? endif; ?>

					<div class="col-lg-6 top-right card-transition">
						
							<div class="card card-chart">
							<div class="card-header">
								<h5 class="card-category"><i class="material-icons">import_contacts</i> E-Book Packages</h5>
								<div class="dropdown">
									<button class="btn btn-round btn-default btn-simple btn-icon no-caret" id="trig2" title="Expand Graph" type="button"><i class="material-icons">zoom_out_map</i></button> 
								</div>
							</div>
							<div class="card-body">
							  <div class="myChartDiv">
									<canvas id="myChartb" width="800" height="400"></canvas>

								</div>
					
							</div>
							<div class="card-footer"></div>
						</div>
						
						
						</div>
			</div>
<? if (isset($_GET['inst'])): ?>

				<div class="row">
				
					
					<div class="col-md-12 bottom-right card-transition">
											<div class="card card-chart">
							<div class="card-header">
								<h5 class="card-category"><i class="material-icons">laptop_mac</i> Database Packages</h5>
								<div class="dropdown">
									<button class="btn btn-round btn-default btn-simple btn-icon no-caret" id="expandtable" title="Expand Graph" type="button"><i class="material-icons">zoom_out_map</i></button>
								</div>
							</div>
							<div class="card-body">
											<ul class="nav nav-pills nav-wizard" role="tablist">
									<li class="nav-item">
										<a aria-controls="packlist" aria-selected="true" class="nav-link active" data-toggle="tab" href="#stacked" id="main-tab-0" role="tab">Stacked View</a>
									</li>
									<li class="nav-item">
										<a aria-controls="packview" aria-selected="true" class="nav-link" data-toggle="tab" href="#separate" id="main-tab-1" role="tab">Separate View</a>
									</li>
							
								</ul>
								
								<div class="tab-content" id="pills-tabContent">
								  <div class="tab-pane fade show active" id="stacked" role="tabpanel" aria-labelledby="pills-home-tab">
											
									  <div class="myChartDiv">
										<canvas id="myChartstacked" width="800" height="400"></canvas>
									</div>	
								  
								  </div>
								  <div class="tab-pane fade" id="separate" role="tabpanel" aria-labelledby="pills-profile-tab">
								 
									    <div class="myChartDiv">
										<div id="colorkey">
										<ul id="colorlist">
										</ul>
										</div>
											  <canvas id="myChart" width="800" height="400"></canvas>
											</div>
								  </div>
								</div>
							</div>
							<div class="card-footer">
							</div>
						</div>
					</div>
				</div>
				<? endif; ?>
				<div class="row">
					<div class="col-md-12 ">
										<div class="card card-chart">
										<div class="card-header">
								<h5 class="card-category"><i class="material-icons">list_alt</i> Package List</h5>
							
							</div>
											<div class="card-body">
											
										<table id="totaltable" class="table table-hover table-bordered compact"  width="100%" cellspacing="0">
                                          <thead>   
                                                     <tr>
                                                     <th>Report Type</th>
                                                      <th>Vendor</th>
                                                       <th>Abbrev</th>
                                                       <th>Product</th>
                                                        <th># Titles</th>
                                                         <th>Total Usage</th>
                                                          <th>Avg. Use/Title</th>
                                                
                                                    </tr>
                                                </thead>
                                        <tbody>
                                        <? if (isset($_GET['inst'])): ?>
                                            <?php foreach($datatablearr as $valuek => $value): ?>
                                            <tr>
                                            <?php $i = 0; foreach($value as $valk => $val): ?>
                                        
                                                <td>
                                                <? if ($i == 0): ?>
                                                 <?php echo $reporttypearray[$val]['name']; ?>
                                                <? elseif ($i == 3): ?>
                                                <a href="<?php echo $reporttypearray[$value['report_type']]['page']; ?>?inst=<?php echo $_GET['inst'];?>&product=<?php echo $value['product_abbrev']; ?>&type=title&range=all&startdate=&enddate="><?php echo $val; ?></a>
                                                
                                                <? else: ?>
                                                 <?php echo $val; ?>
                                                <? endif; ?>
                                                
                                                </td>
                                        
                                            <?php $i++; endforeach; ?>
                                             </tr>
                                           <?php endforeach; ?>
                                           </tbody>
                                                <? endif; ?>
                                        
                                        </table>
									</div>
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

<? if (isset($_GET['inst'])): ?>


var ctxb = document.getElementById("myChartb").getContext('2d');
 myChartb = new Chart(ctxb, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ["<?php echo implode('","', array_keys($totalsarrb)); ?>"],
        productabbrev: ["<?php echo  implode('","', array_column($totalsarrb, 'product_abbrev')); ?>"],
        datasets: [{
            label: 'Usage',
            data: [<?php echo implode(',', array_column($totalsarrb, 'totals')); ?>],
			backgroundColor: '#116611',
			//borderColor: "#ccc",
            borderWidth: 1
        }]
    },
    options: {
		 legend: {
            display: false
         },
		 responsive:true,
		 onClick: loadbooks,
  		 maintainAspectRatio: false,
		 title: {
            display: true,
            text: 'E-Book Packages',
			fontSize: 16,
			fontColor: "#3535b2",
        },
        scales: {
			 xAxes: [{
        stacked: false,
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
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },

 
});
	
	
	
var ctx = document.getElementById("myChartstacked").getContext('2d');
 myChartstacked = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ["<?php echo implode('","', $vendorlist); ?>"],
        datasets: [
		    <?php  $p = 0; foreach($stackedarray as $value): ?>
		{
		label: "<?php echo $value['label']; ?>",
         data: [<?php echo implode(",",$value['data']); ?>],
		 productabbrev: ["<?php echo $value['product_abbrev']; ?>"],
         backgroundColor: getRandomColor(),
		 borderColor: '#000',
		// borderWidth: 1,
        },
		    <?php $p++; endforeach; ?>

		]
    },
    options: {
		 legend: {
            display: false
         },
		 responsive:true,
		 onClick: loadvendors,
   		 maintainAspectRatio: false,
		 title: {
            display: true,
            text: 'Database Packages',
			fontSize: 16,
			fontColor: "#3535b2",
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




var ctx = document.getElementById("myChart").getContext('2d');
 myChart = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ["<?php echo implode('","', array_keys($totalsarr)); ?>"],
		vendorname: ["<?php echo  implode('","', array_column($totalsarr, 'vendor')); ?>"],
        productabbrev: ["<?php echo  implode('","', array_column($totalsarr, 'product_abbrev')); ?>"],
        datasets: [{
            label: 'Usage',
            data: [<?php echo implode(',', array_column($totalsarr, 'totals')); ?>],
			backgroundColor: [],
			borderColor: [],
            borderWidth: 1
        }]
    },
    options: {
		 legend: {
            display: false
         },
		 responsive:true,
		 onClick: loaddatabases,
   		 maintainAspectRatio: false,
		 title: {
            display: true,
            text: 'Database Packages',
			fontSize: 16,
			fontColor: "#3535b2",
        },
        scales: {
			 xAxes: [{
        stacked: false,
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
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },

 
});

//count how many db groups, so we know how many colors needed
var totgroups = <?php echo count(array_unique(array_column($totalsarr, 'vendor'))); ?>;

var curgroup = '';
var vendorarray = [];
//make counter
var k = -1;

 for (i = 0; i < myChart.data.datasets[0].data.length; i++) {
     //if it's the same, use the same color
     if (curgroup == myChart.data.vendorname[i]){
        myChart.data.datasets[0].borderColor.push(rainbow(totgroups,k));
		myChart.data.datasets[0].backgroundColor.push(rainbow(totgroups,k));
     }
     //otherwise, reset color and group name
     else{
        k++;
        curgroup = myChart.data.vendorname[i];
        vendorarray.push(myChart.data.vendorname[i]);
        myChart.data.datasets[0].borderColor.push(rainbow(totgroups,k));
        myChart.data.datasets[0].backgroundColor.push(rainbow(totgroups,k));
     }
   
 }
    myChart.update(); //update the chart
	
	
//add color key
for (i = 0; i < vendorarray.length; i++) {
$("#colorlist").append('<li><span style="background-color:' + rainbow(totgroups,i) + '"></span> ' + vendorarray[i] + '</li>');
}

$(document).ready( function () {
	
	
    $('#totaltable').DataTable({
		  "paging": false,
		columnDefs: [
            {
                "targets": [ 2 ],
                "visible": false,
            }],	
		 dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
		   initComplete: function () {
            this.api().columns([0,1]).every( function (index) {
                var column = this;
				
				var colname = this.header().innerHTML;
             var select = $('<select><option value="">' + colname + '</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
		  });
} );

var ctxj = document.getElementById("myChartj").getContext('2d');
var myChartj = new Chart(ctxj, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ["<?php echo implode('","', array_keys($totalsarrj)); ?>"],
        productabbrev: ["<?php echo  implode('","', array_column($totalsarrj, 'product_abbrev')); ?>"],
        datasets: [{
            label: 'Usage',
            data: [<?php echo implode(',', array_column($totalsarrj, 'totals')); ?>],
			backgroundColor: '#801515',
			//borderColor: "#ccc",
            borderWidth: 1
        }]
    },
    options: {
		 legend: {
            display: false
         },
		 responsive:true,
		 onClick: loadjournals,
    maintainAspectRatio: false,
		 title: {
            display: true,
            text: 'Journal Packages',
			fontSize: 16,
			fontColor: "#3535b2",
        },
        scales: {
			 xAxes: [{
        stacked: false,
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
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },

 
});



	<? endif; ?>

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
	
	$('#expandtable').on('click', function () {
		$('.bottom-left').toggleClass('order-lg-4');
		$('.bottom-left').toggleClass('order-lg-1');
	$('.bottom-right').toggleClass('col-lg-12');
	});


			$('#inst').change(function() {
		$("#reloadbench").fadeIn("slow");
	});

function loaddatabases(event, array) {
    if (array.length > 0) {
        window.location.href = "database.php?inst=" + $("#inst").val() + "&type=&product=" + this.data.productabbrev[array[0]._index] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loadjournals(event, array) {
    if (array.length > 0) {

        window.location.href = "journal.php?inst=" + $("#inst").val() + "&type=&product=" + this.data.productabbrev[array[0]._index] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loadbooks(event, array) {
    if (array.length > 0) {
        window.location.href = "ebook.php?inst=" + $("#inst").val() + "&type=&product=" + this.data.productabbrev[array[0]._index] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loadvendors(event, array) {
    if (array.length > 0) {

        var curelem = myChartstacked.getElementAtEvent(event)[0]._datasetIndex;
        window.location.href = "vendor.php?inst=" + $("#inst").val() + "&type=&product=" + this.data.datasets[curelem].productabbrev[0] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function rainbow(numOfSteps, step) {
    // This function generates vibrant, "evenly spaced" colours (i.e. no clustering). This is ideal for creating easily distinguishable vibrant markers in Google Maps and other apps.
    // Adam Cole, 2011-Sept-14
    // HSV to RBG adapted from: http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
    var r, g, b;
    var h = step / numOfSteps;
    var i = ~~(h * 6);
    var f = h * 6 - i;
    var q = 1 - f;
    switch (i % 6) {
        case 0:
            r = 1;
            g = f;
            b = 0;
            break;
        case 1:
            r = q;
            g = 1;
            b = 0;
            break;
        case 2:
            r = 0;
            g = 1;
            b = f;
            break;
        case 3:
            r = 0;
            g = q;
            b = 1;
            break;
        case 4:
            r = f;
            g = 0;
            b = 1;
            break;
        case 5:
            r = 1;
            g = 0;
            b = q;
            break;
    }
    var c = "#" + ("00" + (~~(r * 255)).toString(16)).slice(-2) + ("00" + (~~(g * 255)).toString(16)).slice(-2) + ("00" + (~~(b * 255)).toString(16)).slice(-2);
    return (c);
}

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
$("#dropdownsumm").parent().addClass("active");
</script>
<script src="institutionscripts.js"></script>
   
</body>
</html>
