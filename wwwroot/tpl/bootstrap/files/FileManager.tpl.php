<?php if (defined("RS_TPL")) {?>
	<?php $this->NewTop; ?>
	<?php if($this->is('Content')) { ?>
	<div class=portlet>
		<h2>Manage existing (<?php $this->Count; ?>)</h2>
		<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>File</th><th>Unlink</th><th>Destroy</th></tr>
			<?php $this->Content; ?>
		</table>
	</div>		
	<?php } ?>
	<?php $this->NewBottom; ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>