<?php if (defined("RS_TPL")) {?>
	<section class="connectedSortable ui-sortable">
		<?php $this->Content; ?>
 	</section>
 	<?php $this->addJS('js/jquery.mousewheel.min.js');?> 
 	<?php $this->addJS('js/jquery.panzoom.min.js');?> 
 	<script type="text/javascript">
 	// Make sortable
 	$(function() {
	 	$(".connectedSortable").sortable({
	        placeholder: "sort-highlight",
	        connectWith: ".connectedSortable",
	        handle: ".box-header, .nav-tabs",
	        forcePlaceholderSize: true,
	        zIndex: 999999
	    }).disableSelection();
	    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
		// Zoom function vor svgs:
		var rackDivs = $('#contentarea > section.content > div > div.col-md-12 > section > .rackbox');
		
		function callZoomBtns (event) {
			var ind = parseInt($(this).attr("counter")) + 1;
			if(event.deltaY > 0)
				$("#contentarea > section.content > div > div.col-md-12 > section > div:nth-child(" + ind + ") > div.box-body > div > button.zoom-in").click();
			if(event.deltaY < 0) 
				$("#contentarea > section.content > div > div.col-md-12 > section > div:nth-child(" + ind + ") > div.box-body > div > button.zoom-out").click();
			event.preventDefault();
			return false;
		};
		// Set zoom actions and triggers
		for (var i = 0; i < rackDivs.length; i++) {
			rackDivs.eq(i).find('.box-body > svg').panzoom({
			  $zoomIn: 		rackDivs.eq(i).find('.box-body > .zoom-overlay > .zoom-overlay-btn.zoom-in'),
			  $zoomOut: 	rackDivs.eq(i).find('.box-body > .zoom-overlay > .zoom-overlay-btn.zoom-out'),
			  $zoomRange: 	rackDivs.eq(i).find('.box-body > .zoom-overlay > .zoom-overlay-btn.zoom-range'),
			  $reset: 		rackDivs.eq(i).find('.box-body > .zoom-overlay > .zoom-overlay-btn.reset')
			});
			rackDivs.eq(i).find('.box-body > svg').mousewheel(callZoomBtns);
		}
	});

	function showZoomNav(rackdiv) {
		$("#contentarea > section.content > div > div.col-md-12 > section > div:nth-child(" + (parseInt(rackdiv) + 1) + ") > div.box-body > .zoom-overlay").fadeIn();
	}

	function hideZoomNav(rackdiv) {
		$("#contentarea > section.content > div > div.col-md-12 > section > div:nth-child(" + (parseInt(rackdiv) + 1) + ") > div.box-body > .zoom-overlay").fadeOut();
	}
	</script>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>