<?php if (defined("RS_TPL")) {?>
	<?php $this->JQuery ?>
	<?php if ($this->is('Taglist')) { 
		$this->addJS ('var GLOBAL_TAGLIST = ' . $this->_Taglist . ' ; console.log('. $this->_Taglist . ');', TRUE);
	} ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>