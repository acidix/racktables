<?php if (defined("RS_TPL")) {?>
	<table class="table" align=center>
	<tbody>
	<?php $this->startLoop("ItemContent"); ?>	
		<tr><th><h3><?php $this->Title; ?> </h3></th></tr>
		<?php $this->Cont; ?> 
		<tr><td><hr></td></tr>
	<?php $this->endLoop(); ?>
	</tbody> 
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>