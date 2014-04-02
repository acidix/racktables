<?php if (defined("RS_TPL")) {?>
		<center>
		<table>
			<?php $this->TagList; ?>
		</table>
	</center>		
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>