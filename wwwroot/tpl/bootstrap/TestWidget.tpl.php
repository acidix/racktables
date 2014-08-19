<?php if (defined("RS_TPL")) {?>
	<div class="box box-danger">
		<div class="box-header">
			Testwidget
		</div>
		<div class="box-body">
			<?php $this->Test1; ?>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>