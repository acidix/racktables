<?php if (defined("RS_TPL")) {?>
	<?php $this->startLoop("singleRowCont"); ?>	
		<?php $this->IsNull ?>
		<?php $this->Permitted ?>
		<?php $this->IndexItem ?>
	<?php $this->endLoop(); ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>