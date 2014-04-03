<?php if (defined("RS_TPL")) {?>
	<?php if($this->is("singleVal", true)){ ?>
		<?php $this->val ?>
	<?php } else {?>
		<?php if($this->is("showTags", true)) { ?>
			<?php $this->getH("PrintTagTRs", array( $this->_cell, $this->baseurl));  ?> 
		<?php } else {?>
			<tr><th width='50%' class='<?php $this->class ?>'><?php $this->name ?></th><td class=tdleft><?php $this->val ?></td></tr> 
		<?php } ?>
	<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>