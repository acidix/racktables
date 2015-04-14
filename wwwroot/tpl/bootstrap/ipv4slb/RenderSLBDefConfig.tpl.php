<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">SLB default configs</h3>
	</div>
	<div class="box-content">
		<?php $this->getH("PrintOpFormIntro", array('save')); ?>

		<div class="row edit_row">
			<div class="col-sm-4 header">VS config:</div>
			<div class="col-md-8" align="center">
					<textarea tabindex=103 name=vsconfig rows=10 cols=80><?php $this->htmlspecVSconfig ?></textarea>
			</div>
		</div>
		<div class="row edit_row">
			<div class="col-sm-4 header">RS config:</div>
			<div class="col-md-8" align="center">
					<textarea tabindex=104 name=rsconfig rows=10 cols=80><?php $this->htmlspecRSconfig ?></textarea>
			</div>
		</div>

		<div class="row edit_row">
			<div class="col-sm-4 header"></div>
			<div class="col-md-8" align="center">
				<button type="submit" class="btn btn-primary" border="0" tabindex="105" title="Save changes" ><span class="glyphicon glyphicon-ok"></span></button>
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
