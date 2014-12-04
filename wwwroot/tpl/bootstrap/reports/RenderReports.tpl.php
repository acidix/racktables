<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Reports</h3>
	</div>
	<div class="box-body">
		<?php while( $this->refLoop("ItemContent") ) { ?>	
			<h3><?php $this->Title; ?></h3>
			<?php $this->Cont; ?>
		<?php } ?>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>