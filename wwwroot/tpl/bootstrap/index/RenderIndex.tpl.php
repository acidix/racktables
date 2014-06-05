<?php if (defined("RS_TPL")) {?>
	<?php $this->startLoop("indexArrayOutput"); ?>	
		<div class="row">
			<?php $this->renderedRows ?>
		</div>
	<?php $this->endLoop(); ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>