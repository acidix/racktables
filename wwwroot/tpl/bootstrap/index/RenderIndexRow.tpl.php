<?php if (defined("RS_TPL")) {?>
	<?php $this->startLoop("singleRowCont"); ?>	
		<div class="panel panel-default col-md-3" style="height: 300px" >
			<?php $this->IsNull ?>
			<?php $this->Permitted ?>
			<?php $this->IndexItem ?>
		</div>
	<?php $this->endLoop(); ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>