<?php if (defined("RS_TPL")) {?>
<div class="list-group">
	<?php $this->startLoop('allPages');?>
		<a href='index.php?page=<?php $this->Cpageno; ?>' class="list-group-item"><?php $this->Title; ?></a>
	<?php $this->endLoop(); ?>
</div>
<?php  } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>