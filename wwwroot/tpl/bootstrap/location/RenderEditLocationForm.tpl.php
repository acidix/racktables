<?php if (defined("RS_TPL")) {?>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">
				Attributes
			</h3>
		</div>
		<div class="box-content">
			<?php $this->getH('PrintOpFormIntro', ['updateLocation',[],false,['class'=>'form-horizontal']]); ?>
			<div class="form-group">
				<label for="name" class="col-md-4 control-label">Name</label>
				<input type=text class="form-control col-md-8" name=name value='<?php $this->Locationname; ?>'>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Parent location</label>
				<div class="col-md-8"><?php $this->Getselect; ?></div>
			</div>
			<input type=hidden name=num_attrs value=<?php $this->Num_attrs; ?>>
			<?php $this->OptionalAttributes; ?>
			<div class="form-group">
				<label class="col-md-4 control-label">Actions</label>
				<div class="col-md-8">
					<?php if($this->is('Empty_Locations', TRUE)){
						$this->getH('GetOpLink', array(array('op'=>'deleteLocation'), '<spann class="glyphicon glyphicon-remove"></span>', '', 'Delete location', 'btn btn-danger need-confirmation'));
					} ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Actions</label>
				<div class="col-md-8">
					<textarea name=comment rows=10 cols=80><?php $this->Location_Comment; ?></textarea>		
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-large btn-block" name="submit">Submit</button>
			</div>
			</form>
		</div>
		
	</div>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">History</h3>
			<?php $this->Objecthistory; ?>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>