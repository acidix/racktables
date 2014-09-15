<?php if (defined("RS_TPL")) {?>
	<div class="row">
		<div class="col-md-8"><?php $this->RackspaceSVG; ?></div>
		<div class="col-md-4"><?php $this->get('CelLFilter'); ?><br /><?php $this->get('LocationFilter'); ?></div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>