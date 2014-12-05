<?php if (defined("RS_TPL")) {?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/codemirror/codemirror.js")); ?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/codemirror/rackcode.js")); ?>
	<?php $this->addRequirement("Header","HeaderCssInclude",array("path"=>"js/codemirror/codemirror.css")) ; ?>
	<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>$this->_jsRawCode)); ?>

	<?php $this->getH("PrintOpFormIntro", array('saveRackCode')); ?> 
	<div class="box box-info">
		<div class="box-body">
			<div class="row"><div class="col-md-12"><textarea rows=40 cols=100 name=rackcode id=RCTA class='codepress rackcode'><?php $this->text ?></textarea></div></div>
			<div class="row" align="center">
				<div id="ShowMessage"></div>
			</div>
			<div class="row" align="center" style="margin: 10px 0px 10px 0px;">
				<div class="btn btn-primary" onclick='verify();'>Verify</div>
				<button class="btn btn-success" submit disabled='disabled' id='SaveChanges' onclick='$(RCTA).toggleEditor();'>Save</button>
			</div>
		</div>
	</div>
	</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>