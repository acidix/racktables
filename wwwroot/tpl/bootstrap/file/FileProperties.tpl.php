<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">File properties</h3>
	</div>
	<div class="box-content">
		<?php $this->getH('PrintOpFormIntro','updateFile'); ?>
		<div class="row">
			<div class="col-md-4"><label for="file_type">MIME-type:</label></div>
			<div class="col-md-12"><input tabindex=101 type=text name=file_type value='<?php $this->Type; ?>' class="form-control"></div>
		</div>
		<div class="row">
			<div class="col-md-4"><label for="file_type">Filename:</label></div>
			<div class="col-md-12"><input tabindex=102 type=text name=file_name value='<?php $this->Name; ?>' class="form-control"></div>
		</div>
		<div class="row">
			<div class="col-md-4"><label for="file_comment">Comment:</label></div>
			<div class="col-md-12"><textarea tabindex=103 name=file_comment rows=10 cols=80 class="form-control"><?php $this->Comment; ?></textarea></div>
		</div>
		<div class="row">
			<div class="col-md-4"><label>Actions:</label></div>
			<div class="col-md-12">
				<button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
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