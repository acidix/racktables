<?php if (defined("RS_TPL")) {?>
<div class="box box-info" style="position: relative; overflow-x: auto">
	<div class="box-header"><h3 class="box-title">Items to display in page header</h3></div>
    <div class="box-body" style="position: relative" align="center">
	<div style="text-align: left; display: inline-block;">
		<?php $this->getH('PrintOpFormIntro', 'save'); ?>
		<ul class="qlinks-form list-unstyled">
		<?php $this->startLoop('LoopArray'); ?>
			<li><label><input type='checkbox' name='page_list[]' value='<?php $this->PageNo; ?>' <?php $this->CheckedState; ?>> <?php $this->PageName; ?></label></li>
		<?php $this->endLoop(); ?>
		</ul>
		<div class="row" align="center">
			<button type="submit" class="btn btn-success btn-sm ajax_form" targetform="#save" border="0" tabindex="4" title="Save changes">Save</button>
		</div>
		</form>
	</div>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>