<?php if (defined("RS_TPL")) {?>
	<?php $this->getH('PrintOpFormIntro',array('rollTags', array ('realsum' => $this->_sum))); ?>
	<div class='box'>
		<div class='box-header'>
			<h3 class='box-title'>Tag roller</h3>
			<div class="box-tools pull-right">
        		<button data-original-title="Collapse" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        	</div>
		</div>
		<div class='box-body'>
			<p>This special tool allows assigning tags to physical contents (racks <strong>and all contained objects</strong>) of the current ack row.<br>
			The tag(s) selected below will be appended to already assigned tag(s) of each particular entity.</p>
			
			<div class="form-group">
				<label>Tags</label><br />
				<?php $this->Tags; ?>
			</div>
			
			<div class="form-group">
				<label for="sum">Control questions: the sum of <?php $this->a;?> and <?php $this->b;?></label>
				<input type=text name=sum id=sum class="form-control">
			</div>
			
			<div class="text-center">
				<button type="submit" class="btn btn-success btn-lg">Submit</button>
			</div>
		</div>
	</div>
	</form>
	<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>