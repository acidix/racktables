<?php if (defined("RS_TPL")) {?>
	<tr>
		<?php $this->get("CellFilterAnd"); ?>
		<?php $this->get("CellFilterOr"); ?>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>