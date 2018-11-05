<!DOCTYPE html>
<html lang="en">

<?php 
include (dirname( __FILE__ )) . "/includes/config.php";
include (dirname( __FILE__ )) . "/includes/header.php";
include (dirname( __FILE__ )) . "/includes/preparedates.php";
include (dirname( __FILE__ )) . "/includes/packagelists.php";
?>

<head>
<title><?php echo $consortiumname . " " . $sitename; ?></title>

<?php include (dirname( __FILE__ )) . "/includes/head.php"; ?>
  
<style>
.main-panel {
     width: 100%;
}
 .masterlist{
     list-style:none;
     display:inline-flex;
     flex-wrap: wrap;
     justify-content:space-around;
     width:100%;
}
 .masterlist a.dropdown-toggle{
     text-decoration:none;
     background-color: #fff;
     border:1px solid #0c2646;
     color:#0c2646;
     padding: 10px;
     border-radius: 10px;
}
 .masterlist a.dropdown-toggle:hover{
     color: #fff;
     background-color: #0c2646;
}
 .masterlist li{
     white-space: nowrap;
     padding:15px;
}
 #insttable th, #insttable td{
     padding:0;
     border-top:0;
     font-size:0.9em;
}
 #insttable tr:hover{
     background-color:#b3c9e5;
}
 #insttable a{
     color:#204065;
}
 #insttable a:hover{
     text-decoration:none;
}
 .card-title{
     background-color: #b3c9e5;
     color: #204065;
     padding: 5px;
     border-top-right-radius: 10px;
     border-top-left-radius: 10px;
}
 .linkbutton{
     color:#204065;
     font-size:1.5em;
     padding: 20px 0;
}
 .about{
     margin:0;
     font-size:1em;
     letter-spacing:1px;
     color:#204065;
     text-align:center;
}
 .about i{
     margin-right:5px;
     font-size:3em;
}
</style>

</head>

<body class="">
	<div class="wrapper">

		<div class="main-panel">
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute bg-primary fixed-top">
				<div class="container-fluid">
					<button aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navigation" data-toggle="collapse" type="button"><span class="navbar-toggler-bar navbar-kebab"></span> <span class="navbar-toggler-bar navbar-kebab"></span> <span class="navbar-toggler-bar navbar-kebab"></span></button>
					<div class="collapse navbar-collapse justify-content-end" id="navigation">
						<form>
							<div class="input-group no-border">
								<input class="form-control" id="tags" placeholder="Search packages" type="text" value="">
								<div class="input-group-append">
									<div class="input-group-text">
										<i class="material-icons">search</i>
									</div>
								</div>
							</div>
						</form>
					
					</div>
				</div>
			</nav><!-- End Navbar -->
		<div class="panel-header">
        <div class="header text-center">
            <div class="title maintitle"><img src="<?php echo $imgpath; ?>" style="height:60px;" /> <span class="titletextsm"><?php echo $sitename; ?></span></div>

        </div>
      </div>
			<div class="content">
    <div class="row  justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div class="card card-chart">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <p class="about">This site contains usage statistics and visualizations for electronic resources provided through the Virtual Library of Virginia, Virginia's academic library consortium. The tool was developed by Rachel Maderik in collaboration with the VIVA Central Office. It is open source, constructed in PHP and MySQL, and available on GitHub.
                        <br /> <i class="material-icons">timeline</i>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 top-left card-transition">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="material-icons">account_balance</i> Consortium View</h5>
                </div>
                <div class="card-body">
                    <strong><i class="material-icons">account_balance</i> Consortium View</strong> provides usage information for journal, e-book, and database packages across the consortium with data available down to the title level. All institution types and institutions are placed in context for a full view of the resource across the consortium.
                    <div class="row">
                        <div class="col-lg-12 align-items-center d-flex justify-content-center">
                            <a href="/package" class="linkbutton">Go to Consortium Summary <i class="material-icons">keyboard_arrow_right</i></a>
                        </div>
                        <div class="col-lg-12">
                            <div class="linkbutton  align-items-center d-flex justify-content-center">or Jump to Package <i class="material-icons">keyboard_arrow_down</i></div>
                            <ul class="masterlist">
                                <li class="dropdown">
                                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownvendor" role="button"><i class="material-icons">shopping_cart</i> Vendors</a>
                                    <div style="width:98%">
                                        <div aria-labelledby="dropdownvendor" class="optionmenu dropdown-menu">
											<?php foreach($allvendors as $db): ?>
                                            <a class="dropdown-item" href="/package/vendor.php?product=<?php echo $db['vendor_abbrev']; ?>"><?php echo $db['Vendor']; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownMenuLink" role="button"><i class="material-icons">laptop_mac</i> Databases</a>
                                        <div aria-labelledby="dropdownMenuLink" class="optionmenu dropdown-menu">
                                            <?php foreach($alldatabases as $db): ?>
                                            <a class="dropdown-item" href="/package/database.php?product=<?php echo $db['product_abbrev']; ?>"><?php echo $db['Product']; ?></a>
                                            <?php endforeach; ?>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownjournal" role="button"><i class="material-icons">description</i> Journals</a>
                                    <div aria-labelledby="dropdownjournal" class="optionmenu dropdown-menu">
                                         <?php foreach($alljournals as $db): ?>
                                            <a class="dropdown-item" href="/package/journal.php?product=<?php echo $db['product_abbrev']; ?>"><?php echo $db['Product']; ?></a>
                                            <?php endforeach; ?>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownbook" role="button"><i class="material-icons">import_contacts</i> E-Books</a>
                                    <div aria-labelledby="dropdownbook" class="optionmenu dropdown-menu">
                                         <?php foreach($allebooks as $db): ?>
                                            <a class="dropdown-item" href="/package/ebook.php?product=<?php echo $db['product_abbrev']; ?>"><?php echo $db['Product']; ?></a>
                                            <?php endforeach; ?>
                                    </div>
                                </li>
        				 </ul>
						</div>
                       </div>
                     </div>
					<div class="card-footer"></div>
						</div>
					</div>
					
    <div class="col-lg-6 top-right card-transition">
        <div class="card card-benchmark">
            <div class="card-header">
                <h5 class="card-title"><i class="material-icons">school</i> Institution View</h5>
    
            </div>
            <div class="card-body">
            <strong><i class="material-icons">school</i> Institution View</strong> provides package and title-level data for individual institutions. All VIVA content is placed in context for your institution, and you can add benchmarks to other institutions at the package level.

							<table id="insttable" class="table"><thead><th>Institution</th><th>Institution Type</th></thead>
							<tbody>
							 <?php foreach($allinstitutions as $res): ?>
								<tr><td><a href="/institution/index.php?inst=<?php echo $res['Inst_abbrev']; ?>"><?php echo $res['Institution']; ?></a></td><td><?php echo str_replace(" Nonprofit","",$res['inst_type']); ?></td></tr>
								<?php endforeach; ?>
								</tbody>
								</table>
						</div>
					</div>
				</div>
			</div>

			<?php include dirname( __FILE__ ) . "/includes/footer.php"; ?>
			</div>
		</div>
	</div>


  <!--   Core JS Files   -->
 <?php include dirname( __FILE__ ) . "/includes/packagescripts.php"; ?>


 <script>
//set up autocomplete for package search
$(function() {
    var autocompletelist = [
         <?php foreach ($allproducts as $prod){
			 echo '{label:"' . $prod['Product'] . '",type:"' . $prod['type'] . '",value:"' . $prod['product_abbrev']. '"},';
			 } ?>
        ];
    $("#tags").autocomplete({
        source: autocompletelist,
        select: function(event, ui) {
            window.location.href = "/package/" + ui.item.type + ".php?product=" + ui.item.value;
            return false;
        }
    });
});
$(document).ready(function() {

    $('#insttable').DataTable({
        "paging": false,

        dom: 'frt',

        initComplete: function() {
            this.api().columns([1]).every(function(index) {
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
});

</script>		 
</body>
</html>