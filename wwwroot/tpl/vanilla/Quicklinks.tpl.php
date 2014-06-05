<?php if (defined("RS_TPL")) {?>
	<?php $this->startLoop("Quicklinks_Data"); ?>		
		<li><a href=<?php $this->get("href")?>><?php $this->get("title");?></a></li>
	<?php $this->endLoop(); ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>