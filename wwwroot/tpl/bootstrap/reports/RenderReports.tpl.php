<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Reports</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<tbody>
				<?php $this->startLoop("ItemContent"); ?>	
					<tr><th><h3><?php $this->Title; ?> </h3></th></tr>
					<?php $this->Cont; ?> 
					<tr><td><hr></td></tr>
				<?php $this->endLoop(); ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>