<?php if (defined("RS_TPL")) {?>

	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr><th>&nbsp;</th><th>description</th><th>&nbsp</th></tr>
	
	<?php 
	$this->NewTop;
	$this->Merge;
	$this->NewBottom;
	?>
	
	
	</table>



<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>