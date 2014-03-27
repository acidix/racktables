<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>Allocations</h2>
		<table cellspacing=0 cellpadding='5' align='center' class='widetable'><tr>
		<th>&nbsp;</th>
		<th>OS interface</th>
		<th>IP address</th>
		<?php if ($this->is("isExt_ipv4",true)) { ?>
			<th>network</th>
			<th>routed by</th>
		<?php } ?> 
		<th>type</th>
		<th>misc</th>
		<th>&nbsp</th>
		</tr>
		<?php if ($this->is('isAddNewOnTop', true)) { ?>
			<?php $this->alloc_elems ?>
		<?php } ?> 
		<?php $this->printNewItemTR_mod ?>
		<?php if (!$this->is('isAddNewOnTop', true)) { ?>
			<?php $this->alloc_elems ?>
		<?php } ?>
		</table><br>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>