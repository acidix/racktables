<?php if (defined("RS_TPL")) {?>
	<div class="row">
		<div class="col-md-6">
			<?php $this->InfoPortlet ?>
			<?php $this->FilesPortlet ?>
		</div>
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Rack diagram</h3>
				</div>
				<div class="box-content">
					<?php $this->RenderedRack ?>		
				</div>
			</div>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>