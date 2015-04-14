<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Add new RS group</h3>
	</div>
	<div class="box-content">
		<?php $this->getH("PrintOpFormIntro", array('add')); ?>

		<div class="row edit_row">
			<div class="col-sm-4 header">Name:</div>
			<div class="col-md-8" align="center"><input type=text name=name></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">Tags:</div>
			<div class="col-md-8" align="center"><?php $this->TagsPicker ?></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">VS config:</div>
			<div class="col-md-8" align="center"><textarea name=rsconfig rows=10 cols=80 tabindex=103></textarea></div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">RS config:</div>
			<div class="col-md-8" align="center"><textarea name=rsconfig rows=10 cols=80 tabindex=103></textarea></div>
		</div>

		<div class="row edit_row">
			<div class="col-sm-4 header"></div>
			<div class="col-md-8" align="center">
				<button type="submit" class="btn btn-success" border="0" tabindex="104" title="Create real server pool" ><span class="glyphicon glyphicon-ok"></span></button>
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
