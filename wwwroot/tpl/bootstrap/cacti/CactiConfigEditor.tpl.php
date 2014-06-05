<?php if (defined("RS_TPL")) {?>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
		<tr><th>&nbsp;</th><th>base URL</th><th>username</th><th>password</th><th>graph(s)</th><th>&nbsp;</th></tr>
		<?php $this->AddNewTop; ?>
		<?php $this->List; ?>
		<?php $this->AddNewBottom; ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>