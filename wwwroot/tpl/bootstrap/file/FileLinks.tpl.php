<?php if (defined("RS_TPL")) {?>
	<div class="box">
	<div class="box-header">
		<h3 class="box-title">Links (<?php $this->Count; ?>)</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped">
			<tbody>
				<?php $this->Links ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>