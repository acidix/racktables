<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>Edit rows</h2>
		<table border=0 cellspacing=0 cellpadding=5 align=center class=widetable>
			<tr><th>&nbsp;</th><th>Location</th><th>Name</th><th>&nbsp;</th></tr>
			<?php $this->NewTop; ?>
			<?php $this->RowList; ?>
			<?php $this->NewBottom; ?>
		</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>