<!DOCTYPE html>

<html lang="en">

<?php 
include dirname(dirname( __FILE__ )) . "/includes/config.php";
include dirname(dirname( __FILE__ )) . "/includes/header.php";
include dirname(dirname( __FILE__ )) . "/includes/preparedates.php";
include dirname(dirname( __FILE__ )) . "/includes/packagelists.php";
include "chart_summary.php";
?>

<head>

  <title><?php echo $consortiumname . " " . $sitename; ?>: Consortium Summary</title>

   <?php include dirname(dirname( __FILE__ )) . "/includes/head.php"; ?>

 <style>
.vendorentry{
     padding: 5px 0;
     border-bottom:1px solid #efefef;
}
 .labelrow{
     margin-left:-20px;
}
 .vendorlist ul{
     list-style:none;
}
 .badge-list{
     background-color:#b3c9e5;
}
 .sublist{
     display:inline;
}
 .small-tables{
     font-size:0.8em;
}
.card-chart .chart-area {
    height: 490px;
}
</style>

</head>



<body class="">

 
<?php include "sidemenu_package.php"; ?>

    <div class="main-panel">
	
	<?php include "include_topnav.php"; ?>

	         <div class="panel">


 		<h3 class="instname">Consortium View</h3>
						<table class="sm-table" id="summtable">
							<tr>
								<td class="cellheading">Dates Selected:</td>
								<td><?php echo $startdate . ' to ' . $enddate; ?></td>
							</tr>
						</table>
	  </div>
      <div class="content">

        <div class="row">

          <div class="col-lg-6 top-left card-transition">

            <div class="card card-chart">

              <div class="card-header">

                <h4 class="card-title"><i class="material-icons" id="trig">zoom_out_map</i> Journal Packages</h4>

                <div class="dropdown">
				
				<ul class="nav nav-pills pills-circle" role="tablist">
					<li class="nav-item">
						<a aria-controls="journal-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#journal-chart" id="journal-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
					</li>
					<li class="nav-item">
						<a aria-controls="journal-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#journal-table" id="journal-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
					</li>
				</ul>
                </div>

              </div>

              <div class="card-body"> 
			  
			<div class="tab-content" id="pills-tabContent">
				  <div class="tab-pane fade show active" id="journal-chart" role="tabpanel" aria-labelledby="journal-chart-tab">
					<div class="chart-area">
					  <canvas id="chartjournalsmall"></canvas>
					</div>
				  </div>
				  <div class="tab-pane fade" id="journal-table" role="tabpanel" aria-labelledby="journal-table-tab">
				 <table id="journaltable" class="small-tables table table-hover table-bordered compact" width="100%" cellspacing="0">
					<thead>
					<tr>
					<th>Report Type</th>
					<th>Abbrev</th>
					<th>Vendor</th>
					<th>Product</th>
					<?php foreach($itypesuniq as $ityp): ?>
					<th><?php echo $ityp; ?></th>
					<?php endforeach; ?>
					<th>Total</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($datatablearrj as $value): ?>
					<tr>
					<?php foreach($value as $valk => $val): ?>
					<td>
					<? if ($valk == 'Product'): ?>
					<a href="<?php echo strtolower($value['report_type']);?>.php?product=<?php echo $value['abbrev']; ?>&range=all&startdate=&enddate="><?php echo $val; ?></a>
					<? else: ?>
					<?php echo $val; ?>
					<? endif; ?>
					</td>
					<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
										

				  </div>
				</div>

              </div>

              <div class="card-footer">

              </div>
            </div>
          </div>
	
          <div class="col-lg-6 top-right card-transition">
            <div class="card card-chart">
              <div class="card-header">
                <h4 class="card-title"><i class="material-icons" id="trig1">zoom_out_map</i> E-Book Packages</h4>
                <div class="dropdown">
					<ul class="nav nav-pills pills-circle" role="tablist">
						<li class="nav-item">
							<a aria-controls="book-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#book-chart" id="book-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
						</li>
						<li class="nav-item">
							<a aria-controls="book-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#book-table" id="book-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
						</li>
					</ul>
                </div>

              </div>

              <div class="card-body">

				<div class="tab-content" id="pills-tabContent">
				  <div class="tab-pane fade show active" id="book-chart" role="tabpanel" aria-labelledby="book-chart-tab">
					<div class="chart-area">
					  <canvas id="chartebooksmall"></canvas>
					</div>
				  </div>
				  <div class="tab-pane fade" id="book-table" role="tabpanel" aria-labelledby="book-table-tab">
					 <table id="booktable" class="small-tables table table-hover table-bordered compact" width="100%" cellspacing="0">
					<thead>
					<tr>
					<th>Report Type</th>
					<th>Abbrev</th>
					<th>Vendor</th>
					<th>Product</th>
					<?php foreach($itypesuniqb as $ityp): ?>
					<th><?php echo $ityp; ?></th>
					<?php endforeach; ?>
					<th>Total</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($datatablearrb as $value): ?>
					<tr>
					<?php foreach($value as $valk => $val): ?>
					<td>
					<? if ($valk == 'Product'): ?>
					<a href="<?php echo strtolower($value['report_type']);?>.php?product=<?php echo $value['abbrev']; ?>&range=all&startdate=&enddate="><?php echo $val; ?></a>
					<? else: ?>
					<?php echo $val; ?>
					<? endif; ?>
					</td>
					<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
									
				  </div>
				</div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 bottom-left card-transition">
            <div class="card  card-chart">
             <div class="card-header">
                <h4 class="card-title"><i class="material-icons" id="trig2">zoom_out_map</i> Database Packages</h4>
                <div class="dropdown">
				<ul class="nav nav-pills pills-circle" role="tablist">
						<li class="nav-item">
							<a aria-controls="db-chart" aria-selected="true" class="nav-link active" data-toggle="pill" href="#db-chart" id="db-chart-tab" role="tab" title="Show Chart"><i class="material-icons">show_chart</i></a>
						</li>
						<li class="nav-item">
							<a aria-controls="db-table" aria-selected="false" class="nav-link" data-toggle="pill" href="#db-table" id="db-table-tab" role="tab" title="Show Data Table"><i class="material-icons">list_alt</i></a>
						</li>
					</ul>
                </div>

              </div>

              <div class="card-body ">
				<div class="tab-content" id="pills-tabContent">
				  <div class="tab-pane fade show active" id="db-chart" role="tabpanel" aria-labelledby="db-chart-tab">
					<div class="chart-area">
					  <canvas id="chartdatabasesmall"></canvas>
					</div>
				  </div>
				  <div class="tab-pane fade" id="db-table" role="tabpanel" aria-labelledby="db-table-tab">
					 <table id="dbtable" class="small-tables table table-hover table-bordered compact" width="100%" cellspacing="0">
					<thead>
					<tr>
					<th>Report Type</th>
					<th>Abbrev</th>
					<th>Vendor</th>
					<th>Product</th>
					<?php foreach($itypesuniqdb as $ityp): ?>
					<th><?php echo $ityp; ?></th>
					<?php endforeach; ?>
					<th>Total</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($datatablearrd as $value): ?>
					<tr>
					<?php foreach($value as $valk => $val): ?>
					<td>
					<? if ($valk == 'Product'): ?>
					<a href="<?php echo strtolower($value['report_type']);?>.php?product=<?php echo $value['abbrev']; ?>&range=all&startdate=&enddate="><?php echo $val; ?></a>
					<? else: ?>
					<?php echo $val; ?>
					<? endif; ?>
					</td>
					<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>

				  </div>
				</div>

              </div>

         

            </div>

          </div>

		   <div class="col-md-6 bottom-right card-transition">
		        <div class="card  card-chart">
             <div class="card-header">
                <h4 class="card-title"><i class="material-icons" id="trig3">zoom_out_map</i> Vendors</h4>
			</div>
			<div class="card-body ">
			<ul class="vendorlist">
			<?php foreach($vendorarr as $vname => $vamts): ?>
			<li class="vendorentry"><a href="vendor.php?product=<?php echo vendorlookup($vname,'Vendor','vendor_abbrev')['vendor_abbrev']; ?>"><?php echo $vname; ?></a>
			<ul class="labelrow">
			<?php foreach($vamts as $vtype1 => $vcnt): ?>
			<li class="sublist"><span class="badge badge-list"><?php echo $vtype1; ?> <span class="badge badge-light"><?php echo $vcnt; ?></span></span></li>
			<?php endforeach; ?>
			</ul>
			</li>
			<?php endforeach; ?>
				</ul>
			</div>
		   </div>
		   </div>
		   
		   </div>
           <div class="row">

		 

		   	<div class="col-md-12 bottom-right card-transition">
            <div class="card ">
             <div class="card-header">
                <h5 class="card-category">All Packages</h5>
                <div class="dropdown">
                 <button type="button" class="btn btn-round btn-default btn-simple btn-icon no-caret" id="expandtable" title="Show Data Table">
				<i class="material-icons">zoom_out_map</i>
                  </button>
                </div>
              </div>
              <div class="card-body ">

        

		 <table id="summarytable" class="table table-hover table-bordered compact"  width="100%" cellspacing="0">

 		 <thead>
			 <tr>
			 <th>Report Type</th>
			  <th>Abbrev</th>
			   <th>Vendor</th>
			   <th>Product</th>
		  <?php foreach($allitypes as $ityp): ?>
		  <th><?php echo $ityp; ?></th>
		      <?php endforeach; ?>
			<th>Total</th>
            </tr>
        </thead>
		<tbody>
		<?php foreach($datatablearr as $value): ?>
        <tr>
        <?php foreach($value as $valk => $val): ?>
        <td>
		<? if ($valk == 'Product'): ?>
		<a href="<?php echo strtolower($value['report_type']);?>.php?product=<?php echo $value['abbrev']; ?>&range=all&startdate=&enddate="><?php echo $val; ?></a>
		<? else: ?>
		 <?php echo $val; ?>
		<? endif; ?>
		</td>
		<?php endforeach; ?>
         </tr>
       <?php endforeach; ?>
       </tbody>
    </table>

              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                </div>
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


ctx = document.getElementById('chartjournalsmall').getContext("2d");

var chartjournalsmall = new Chart(ctx, {
    type: '<?php echo $charttype; ?>',
    data: {
        labels: ["<?php echo implode('", "', $labelsarr); ?>"],
        abbrevs: ["<?php echo implode('", "',$typearr); ?>"],
        datasets: [
            <?php  foreach($datasetsj as $dkey => $value): ?> {
                label: "<?php echo $dkey; ?>",
                data: [<?php echo implode(",",$value); ?>],
                productabbrev: ["<?php echo $dkey; ?>"],
                backgroundColor: groupcolors["<?php echo $dkey; ?>"].color,
            },
            <?php endforeach; ?>
        ]
    },
    options: {
        legend: {
            display: true
        },
        responsive: true,
        onClick: <?php echo $onclickeventj; ?>,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                stacked: true,
                beginAtZero: true,
                gridLines: {
                    display: false,
                },
                ticks: {
                    minRotation: 65,
                    autoSkip: false
                }

            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    display: true,
                    beginAtZero: true
                }
            }]
        }
    },

});



ctx = document.getElementById('chartebooksmall').getContext("2d");
var chartebooksmall = new Chart(ctx, {
     type: '<?php echo $charttypeb; ?>',
    data: {
        labels: ["<?php echo implode('","', $labelsarrb); ?>"],
		abbrevs: ["<?php echo implode('","',$typearrb); ?>"],
        datasets: [
		    <?php  foreach($datasetsb as $dkey => $value): ?>
		{
		label: "<?php echo $dkey; ?>",
         data: [<?php echo implode(",",$value); ?>],
		 productabbrev: ["<?php echo $dkey; ?>"],
         backgroundColor: groupcolors["<?php echo $dkey; ?>"].color,
        },
		    <?php endforeach; ?>
		]
    },
    options: {
		 legend: {
            display: true
         },
		 responsive:true,
		onClick: <?php echo $onclickeventb; ?>,
  	    maintainAspectRatio: false,
        scales: {
			 xAxes: [{
       		   stacked: true,
		       minRotation: 65,
        beginAtZero: true,
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
					display: true,
                    beginAtZero:true
                }
            }]
        }
    },
});

ctx = document.getElementById('chartdatabasesmall').getContext("2d");
var chartdatabasesmall = new Chart(ctx, {
    type: '<?php echo $charttypedb; ?>',
    data: {
        labels: ["<?php echo implode('","', $labelsarrdb); ?>"],
		abbrevs: ["<?php echo implode('","',$typearrdb); ?>"],
        datasets: [
		    <?php  foreach($datasetsdb as $dkey => $value): ?>
		{
		label: "<?php echo $dkey; ?>",
         data: [<?php echo implode(",",$value); ?>],
		 productabbrev: ["<?php echo $dkey; ?>"],
         backgroundColor: groupcolors["<?php echo $dkey; ?>"].color,
        },
		    <?php endforeach; ?>
		]
    },
    options: {
		 legend: {
            display: true
         },
		 responsive:true,
		 onClick: <?php echo $onclickeventdb; ?>,
    maintainAspectRatio: false,
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
			 minRotation: 65,
            autoSkip: false
        }
    }],
            yAxes: [{
				  stacked: true,
                ticks: {
					display:true,
                    beginAtZero:true
                }
            }]
        }
    },
});

function loadjournals(event, array) {
    if (array.length > 0) {
        window.location.href = "journal.php?product=" + this.data.abbrevs[array[0]._index] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loadbooks(event, array) {
    if (array.length > 0) {
        window.location.href = "ebook.php?product=" + this.data.abbrevs[array[0]._index] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

function loaddatabases(event, array) {
    if (array.length > 0) {
        window.location.href = "database.php?product=" + this.data.abbrevs[array[0]._index] + "&range=" + $("input[name='range']").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
    }
}

$(document).ready(function() {
 jtable = $('#journaltable').DataTable({
        "paging": false,
        columnDefs: [{
            "targets": [0,1,2],
            "visible": false,
        }],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ]
    });
	
	 btable = $('#booktable').DataTable({
        "paging": false,
        columnDefs: [{
            "targets": [0,1,2],
            "visible": false,
        }],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ]
    });

	 dbtable = $('#dbtable').DataTable({
        "paging": false,
        columnDefs: [{
            "targets": [0,1,2],
            "visible": false,
        }],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ]
    });	
  dtable = $('#summarytable').DataTable({
        "paging": false,
        columnDefs: [{
            "targets": [1],
            "visible": false,
        }],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        initComplete: function() {
            this.api().columns([0]).every(function(index) {
                var column = this;
                var colname = this.header().innerHTML;
                var select = $('<select><option value="">' + colname + '</option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });

//count all columns
// totalcols = dtable.columns()[0].length;

//hide all but first 4
 //for ( var i=4 ; i<=totalcols ; i++ ) {
 // jtable.column( i ).visible( false, false );
//}
//dtable.column(3 ).visible( false, false );
//jtable.columns.adjust().draw( false ); // adjust column sizing and redraw
	
});


$('#trig').on('click', function () {
	$('.top-left').toggleClass('col-lg-12');
	});

	$('#trig2').on('click', function () {
	$('.bottom-left').toggleClass('col-md-12');
	});
	$('#trig3').on('click', function () {
		$('.bottom-right').toggleClass('col-md-12');
		$('.bottom-left').toggleClass('order-md-12');
		$('.bottom-left').toggleClass('order-md-1');
	});


	$('#trig1').on('click', function () {
		$('.top-left').toggleClass('order-lg-12');
		$('.top-left').toggleClass('order-lg-1');
		$('.top-right').toggleClass('col-lg-12');
	});


	$('#expandtable').on('click', function () {
		$('.bottom-left').toggleClass('order-md-4');
		$('.bottom-left').toggleClass('order-md-1');
		$('.bottom-right').toggleClass('col-md-12');
		
		var table = $('#summarytable').DataTable();
		//count visible columns
		var viscols = table.columns().visible();
		var countvis = viscols.filter(function(s) { return s; }).length;
		//if only 3 are visible, expand
		if (countvis == 3){
		 for ( var i=4 ; i<= totalcols ; i++ ) {
			table.column( i ).visible( true, true );
		 }
		}
		else{
			 for ( var i=4 ; i<= totalcols ; i++ ) {
			table.column( i ).visible( false, false );
		}		
				
			}

		table.columns.adjust().draw( false ); // adjust column sizing and redraw
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

$("#dropdownsumm").parent().addClass("active");
</script>

</body>



</html>
