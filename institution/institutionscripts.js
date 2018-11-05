$(document).ready(function() {



	

	

	

//set date range on menu

if (getUrlParameter("range") != null){

 var $dateradios = $('input:radio[name=range]');

$dateradios.filter('[value='+getUrlParameter("range")+']').prop('checked', true);

	$("#startdate").val(getUrlParameter('startdate'));
	$("#enddate").val(getUrlParameter('enddate'));
}

else{

//set to most recent year by default

$("#rangerec").prop('checked', true);	

}



//set institution on menu

$("#inst option[value='" + getUrlParameter("inst") + "']").prop("selected", true);





});


	

    $('#datatable').DataTable({

        "pageLength": 50,

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'csvHtml5',

        ],

    });



    $('#summarytable').DataTable({

        "pageLength": 50,

        dom: 'Brtip',

        buttons: [

            'copyHtml5',

            'csvHtml5',

        ],

    });



	$('#datatabledate').DataTable({

		"pageLength": 50,

		dom: 'Bfrtip',

		buttons: [

			'copyHtml5',

			'csvHtml5',

		],

	});

	

	

		

	$('#inst').change(function() {

		$("#reloadbench").fadeIn("slow");

	});

	$('#addbench').click(function() {

		benchtotal = benchtotal + 1;

		$("#reloadbench").fadeIn("slow");

		if (benchtotal < 5) {



	 $('#b'+benchtotal).animate({'opacity': 0}, 250, function () {

    $(this).html('<input type="checkbox" name="benchmark' + benchtotal + '" value="' + $("#benchmarks").val() + '" checked>' + $("#benchmarks option:selected").text());  $(this).toggleClass(' list-group-item-added');

}).animate({'opacity': 1}, 500);



		} else {

			$('#benchmarklist').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>You have reached the maximum number of benchmarks allowed.</div>');

		}

	});



	$('#clearbench').click(function() {

		$("#reloadbench").fadeIn("slow");

		$('#benchmarklist').html('<label id="b1" class="list-group-item list-group-item-light">No benchmark selected</label><label id="b2" class="list-group-item list-group-item-light">No benchmark selected</label><label id="b3" class="list-group-item list-group-item-light">No benchmark selected</label><label id="b4" class="list-group-item list-group-item-light">No benchmark selected</label>');

		benchtotal = 0;

	});

	

	$('#topleft').on('click', function () {

	$('.top-left').toggleClass('col-lg-12');

	});



	$('#bottomleft').on('click', function () {

	$('.bottom-left').toggleClass('col-md-12');

	});





	$('#bottomright').on('click', function () {

		$('.bottom-left').toggleClass('order-md-4');

		$('.bottom-left').toggleClass('order-md-1');

	$('.bottom-right').toggleClass('col-md-12');

	});

$('#resettable').on('click', function(event) {
$('#datatable').DataTable().columns(  ).search("").draw();
 event.preventDefault();
});




	
//set up autocomplete for package search
$(function() {

$("#quicksearch").autocomplete({
	source: autocompletelist,
	select: function( event, ui ) {
	 window.location.href = ui.item.type + ".php?inst=" + getUrlParameter("inst") + "&product=" + ui.item.value + "&range=" + $('[name="range"]:checked').val() + "&startdate=" + $('#startdate').val() + "&enddate=" + $('#enddate').val();
     return false;
    }
   });
});