<?php if (defined("RS_TPL")) {?>
<script type='text/javascript' src='tpl/bootstrap/js/svg-pan-zoom.min.js'></script>
<script type="text/javascript">
    function highlightRacktables( text ) {
        var text_elems = $('g > a > text');
        for(var i = 0; i < text_elems.length; i++) {
            text_elem = text_elems.eq(i);
            console.log(text_elem.text() + " and " + text);

            if(text_elem.text().toLowerCase().indexOf(text.toLowerCase()) > -1 && text != "") {
                text_elem.siblings('rect').css('fill', 'yellow');
                text_elem.css('font-weight', 'bold');
            }
            else {
                text_elem.siblings('rect').css('fill', '');
                text_elem.css('font-weight', '');
            }

        }
    }

    $(document).ready(function() {
        svgPanZoom('.rackspace-svg-container');
    });
</script>

	<div class="row">
		<div class="col-md-12"><?php $this->RackspaceSVG; ?></div>
	<!--	<div class="col-md-4"><?php $this->get('CelLFilter'); ?><br /><?php $this->get('LocationFilter'); ?></div> -->
	</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>