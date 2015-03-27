<?php if (defined("RS_TPL")) {?>
	<?php $this->addJS('js/jquery.mousewheel.min.js');?>
 	<?php $this->addJS('js/jquery.panzoom.min.js');?>
 	<div class="box box-info rackbox" style="position: relative; overflow-x: auto">
		<div class="box-header" style="cursor: move;">
	        <i class="fa fa-bars"></i>
	        <h3 class="box-title"></h3>
	    	<div class="box-tools pull-right">
	            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        </div>
	    </div>
	    <div class="box-body" style="position: relative">
			<input class="form-control input-lg col-xs-12" style="width: 100%; margin-bottom: 5px" type="text" placeholder="Search rackspace" onkeyup="highlightRacktables($(this).val())">
			<br>
		<!--	<div class='zoom-overlay'>
			    <button class="zoom-overlay-btn zoom-in"><span class='glyphicon glyphicon-plus'></span></button></br>
			    <button class="zoom-overlay-btn reset"><span class='glyphicon glyphicon-refresh'></span></button></br>
				<button class="zoom-overlay-btn zoom-out"><span class='glyphicon glyphicon-minus'></span></button>
				<input type="range" class="zoom-range"></br>
			</div> -->
	    	<svg class="rackspace-svg-container" counter="<?php $this->Counter; ?>" width="100%" height="<?php $this->OverallHeight; ?>" x="<?php $this->X ?>" y="<?php $this->Y?>">
				<g class="svg-pan-zoom_viewport">
					<?php $this->Content; ?>
				</g>
	 		</svg>
	    </div>
	</div>
 	<script type="text/javascript">
/*
 	// Make sortable
 	$(function() {
	 	/*$(".connectedSortable").sortable({
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
	} */
	</script>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>