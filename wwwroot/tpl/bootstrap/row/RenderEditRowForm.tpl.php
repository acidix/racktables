<?php if (defined("RS_TPL")) {?>
	<div class='box'>
		<div class='box-header'>
			<h3 class='box-title'>Attributes</h3>
			<div class="box-tools pull-right">
        		<button data-original-title="Collapse" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        	</div>
		</div>
		<div class='box-body'>
			<?php $this->getH('PrintOpFormIntro', array('updateRow')); ?>
				<div class="form-group">
					<label for="location_id">
						Location:
					</label>
					<?php $this->getH("PrintSelect", array($this->_Locations, array ('name' => 'location_id','id' => 'location_id', 'class'=>'form-control'), $this->_Location_ID)); ?>
				</div>
				
				<div class="form-group">
					<label for="name">
						Name (required):
					</label>
					<input type=text name=name id=name class='form-control' value='<?php $this->Row_Name ?>'>
				</div>
				
				<?php while($this->loop('AllRecords')) { ?>
					<input type=hidden name='<?php $this->I ?>_attr_id' value=<?php $this->Record_ID ?>>
					<div class="form-group has-warning">
						<label class="control-label">
							<?php $this->Record_name; ?>
						</label>
						<div class="input-group">
							<div class="input-group-btn">
								<?php if ($this->is('HasValue', true)) { ?>
									<?php $this->getH('GetOpLink', array(array('op'=>'clearSticker', 'attr_id'=>$this->_Record_ID), '<i class="fa fa-fw fa-times"></i>', '', 'Clear value', 'need-confirmation btn btn-danger btn-sm')); ?>
								<?php } else { ?>
									<a href="#" class="btn btn-danger btn-sm disabled"><i class="fa fa-fw fa-times"></i></a>
								<?php } ?>
							</div>
							<?php if ($this->is('PrintInput', true)) { ?>
								<input type=text class="form-control" name="<?php $this->I ?>_value" value="<?php $this->RecordValue ?>">
							<?php } else { ?>
								<?php $this->NiftySelChapter ?>
							<?php } ?> 
						</div>
					</div>
				<?php } ?>
				
				<div class="text-center">
					<div class="btn-group">
						<?php if ($this->is("hasRows")) { ?>
							<?php $this->getH("GetOpLink", array(array ('op'=>'deleteRow'), 'Delete', '', 'Delete row', 'need-confirmation btn btn-lg btn-danger')); ?>
						<?php } else { ?>
							<button type="button" class="btn btn-danger btn-lg disabled">Delete</button>
						<?php } ?>
						<button type="submit" class="btn btn-success btn-lg">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class=box>
		<div class="box-header">
			<h3 class="box-title">History</h3>
			<div class="box-tools pull-right">
        		<button data-original-title="Collapse" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        	</div>
		</div>
		<div class="box-body no-padding">
			<?php $this->ObjectHistory ?>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>