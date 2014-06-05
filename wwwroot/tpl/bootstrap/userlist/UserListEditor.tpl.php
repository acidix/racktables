<?php if (defined("RS_TPL")) {?>
	<?php $this->AddNewTop; ?>
		<div class=portlet><h2>Manage existing (<?php $this->Count; ?>)</h2>
		<table cellspacing=0 cellpadding=5 align=center class=widetable>
			<tr><th>Username</th><th>Real name</th><th>Password</th><th>&nbsp;</th></tr>
			<?php $this->Users; ?>
		</table>
		<br>
		</div>
	<?php $this->AddNewBottom; ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>