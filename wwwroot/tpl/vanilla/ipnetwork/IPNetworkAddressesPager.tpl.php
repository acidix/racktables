<?php if (defined("RS_TPL")) {?>
	<?php while($this->refLoop('Pages')) { ?>
		<?php $this->B; ?><a href='<?php $this->Link(); ?>'><?php $this->I; ?></a><?php $this->BEnd; ?>
	<?php  } ?>	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>