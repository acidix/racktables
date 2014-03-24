<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is('HasPagination')) { ?>
		<h3><?php $this->StartIP; ?> ~ <?php $this->EndIP; ?></h3>
	<?php } ?>
	
	<?php $this->Pager; ?>
	
	<table class='widetable' border=0 cellspacing=0 cellpadding=5 align='center' width='100%'>
		<tr><th>Address</th><th>Name</th><th>Comment</th><th>Allocation</th></tr>
		<?php $this->IPList; ?>
	</table>
	
	<?php $this->Pager; ?>
		
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>