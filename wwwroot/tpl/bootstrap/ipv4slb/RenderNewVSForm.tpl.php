<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Add new virtual service</h3>
	</div>
	<div class="box-content">
		<?php $this->getH("PrintOpFormIntro", array('add')); ?>

		<div class="row edit_row">
			<div class="col-md-4 header">VIP:</div>
			<div class="col-md-8"><input type=text name=vip tabindex=101></textarea></div>
		</div>
		<div class="row edit_row">
			<div class="col-md-4 header">Port:</div>
			<div class="col-md-8"><input type=text name=vport size=5 value='<?php $this->Default_port ?>' tabindex=102></div>
		</div>
		<div class="row edit_row">
			<div class="col-md-4 header">Proto:</div>
			<!-- Ignore warning here -->
			<div class="col-md-8"><?php $this->getH('PrintSelect',array( $this->_Vs_proto, array ('name' => 'proto'), array_shift (array_keys ($this->_vs_keys))))?></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">Name:</div>
			<div class="col-md-8" align="center"><input type=text name=name tabindex=104></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">Tags:</div>
			<div class="col-md-8" align="center"><?php $this->TagsPicker ?></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">VS configuration:</div>
			<div class="col-md-8" align="center"><textarea name=vsconfig rows=10 cols=80></textarea></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">RS configuration:</div>
			<div class="col-md-8" align="center"><textarea name=rsconfig rows=10 cols=80></textarea></div>
		</div>

		<div class="row edit_row">
			<div class="col-sm-4 header"></div>
			<div class="col-md-8" align="center">
				<button type="submit" class="btn btn-success" border="0" tabindex="102" title="Create virtual service" ><span class="glyphicon glyphicon-ok"></span></button>
			</div>
		</div>

		</form>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
