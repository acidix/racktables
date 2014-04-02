<?php if (defined("RS_TPL")) {?>
	<?php $this->startLoop('AllAppAtts'); ?>
		<?php $this->Objtype ?>
		<?php $this->dictCont ?>
		<br> 
	<?php $this->endLoop(); ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>