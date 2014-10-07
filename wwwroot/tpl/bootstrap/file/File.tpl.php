<?php if (defined("RS_TPL")) {?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-bg-light-blue">
		<div class="box-header">
			<h3 class="box-title"><?php $this->Name; ?></h3>
		</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php $this->FileSummary; ?>
		<?php $this->FileLinks; ?>
	</div>
	<div class="col-md-12">
		<?php if($this->is('FilePreview')) { ?>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Preview</h3>
				</div>
				<div class="box-content">
					<?php $this->FilePreview; ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>