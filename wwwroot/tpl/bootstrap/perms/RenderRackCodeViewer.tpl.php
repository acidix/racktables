<?php if (defined("RS_TPL")) {?>
<div class="box box-info">
	<div class="box-body">
	<?php $this->startLoop("allLines"); ?>	
		<div class="row">
			<div class="col-sm-1 pull-left"><a name=line${lineno}><?php $this->lineno ?></a></div>
			<div class="col-sm-11"><?php $this->line ?></div>
		</div>
	<?php $this->endLoop(); ?> 
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>