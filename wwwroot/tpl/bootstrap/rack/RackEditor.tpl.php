<?php if (defined("RS_TPL")) {?>
	<?php $this->addJS('js/racktables.js'); ?>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Attributes</h3>
		</div>
		<div class="box-content">
			<?php $this->getH('PrintOpFormIntro','updateRack'); ?>
			<div class="form-group">
				<label class="col-md-3 control-label">Rack row:</label>
    			<div class="col-md-9">
					<?php $this->RowSelect; ?>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-3 control-label">Name (required):</label>
   				<div class="col-md-9">
					<input type=text name=name value='<?php $this->Name; ?>'>
				</div>
			</div>
			<div class="form-group">
				<label for="height" class="col-md-3 control-label">Height (required):</label>
	    		<div class="col-md-9">
	    			<input type=text name=height value='<?php $this->Height; ?>'>
				</div>
			</div>
			<div class="form-group">
				<label for="asset_no" class="col-md-3 control-label">Asset tag:</label>
    			<div class="col-md-9">
    				<input type=text name=asset_no value='<?php $this->AssetTag; ?>'>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-3 control-label">Tags:</label>
    			<div class="col-md-9">
					<?php $this->TagsPicker ?>
				</div>
			</div>
			<input type=hidden name=num_attrs value=<?php $this->NumAttrs; ?>>
			<?php while($this->loop('ExtraAttrs')) { ?>
				<input type=hidden name=<?php $this->I; ?>_attr_id value=<?php $this->Id; ?>>
				<div class="form-group">
					<div class="col-md-1">
						<?php if($this->is('Deletable')) { ?>
							<?php $this->getH('GetOpLink',array(array('op'=>'clearSticker', 'attr_id'=>$this->_Id), '<span class="glyphicon glyphicon-remove"></span>', '', 'Clear value', 'need-confirmation btn btn-danger')); ?>
						<?php } ?>
					</div>
					<label for="<?php $this->I?>" class="col-md-2 control-label"><?php $this->Name; ?></label>
    				<div class="col-md-9">
					<?php if($this->is('Type','dict')) { ?>
						<?php $this->DictSelect; ?>
					<?php } else { ?>
						<input type=text name=<?php $this->I?>_value value='<?php $this->Value; ?>'>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-3 control-label">Has problems:</label>
    			<div class="col-md-9">
					<input type=checkbox name=has_problems <?php $this->HasProblems; ?>>
				</div>
			</div>
			<?php if($this->is('Deletable')) { ?>
				<div class="form-group">
					<label class="col-md-3 control-label">Actions:</label>
    				<div class="col-md-9">
						<?php $this->getH('GetOpLink',array(array ('op'=>'deleteRack'), '<span class="glyphicon glyphicon-remove"></span>', 'destroy', 'Delete rack', 'need-confirmation btn btn-danger'))?>
					</div>
				</div>
			<?php } ?>
			<div class="form-group">
				<label for="comment" class="col-md-3 control-label">Comment:</label>
    			<div class="col-md-9">
					<textarea name=comment rows=10 cols=80><?php $this->Rack_Comment; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Submit:</label>
				<div class="col-md-9">
					<button class="btn btn-success" type="submit" name="submit"><span class="glyphicon glyphicon-ok"></span></button>
				</div>
			</div>
		</div>
	</div>
	<br />
	<?php $this->History; ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>