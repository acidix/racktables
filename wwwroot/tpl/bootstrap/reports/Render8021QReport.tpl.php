<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">VLAN existence per domain</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped table-bordered">
			<tbody>
				<?php while($this->refLoop("OutputArr")) { ?>	
					<?php $this->Header; ?>
					<tr class="state_<?php $this->CountStats ?>"><th class=tdright><?php $this->VlanId ?></th>
						<?php $this->Domains; ?> 
					</tr>
					<?php $this->TbcLine ?>  
				<?php } ?> 
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>