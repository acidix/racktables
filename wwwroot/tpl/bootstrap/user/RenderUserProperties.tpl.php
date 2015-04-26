<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
	</div>
	<div class="box-content">
		<?php $this->getH("PrintOpFormIntro", array('edit',array(),false,array('class'=>'form form-horizontal'))); ?>
		<div class="form-group">
		    <label class="col-md-3 control-label">Tags:</label>
    		<div class="col-md-9">
    			<?php $this->TagsPicker ?>
      		</div>
		</div>
		<div class="form-group">
    		<div class="col-md-offset-3 col-md-9">
    			<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-remove"></span></button>
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
