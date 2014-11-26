<?php if (defined("RS_TPL")) {?>
<div class="box box-info" id='current-config' style="position: relative; overflow-x: auto">
	<div class="box-header">
        <h3 class="box-title">Current configuration</h3>
    </div>
    <div class="box-body" style="position: relative" align="center">
	<div class="row edit_row"><div class="col-sm-6 header">Option</div>
	<div class="col-sm-6 header">Value</div></div>
	<form method="post" id="updname=upd" action="?module=redirect&amp;page=ui&amp;tab=edit&amp;op=upd">

	<?php $this->startLoop('LoopArray'); ?>
		<input type=hidden name=<?php $this->Index; ?>_varname value='<?php $this->VarName; ?>'>
		<div class="row edit_row"><div class="col-sm-6 header">
			<?php $this->RenderConfig; ?>
			</div>
			<div class="col-sm-5"><input type=text name=<?php $this->Index; ?>_varvalue value='<?php $this->HtmlSpecialChars; ?>' size=24></div>
			<div class="col-sm-1">
			<?php $this->OpLink ?> 
			</div>
		</div>
	<?php $this->endLoop(); ?>
	<input type=hidden name=num_vars value=<?php $this->Index; ?>>
	<div class="row" align="center">
		<button type="submit" class="btn btn-success btn-sm ajax_form" targetform="#updname=upd" border="0" tabindex="4" title="Save changes">Save</button>
	</div>
	<!-- Save button operators -->
	<a id='confirm-btn' type='submit' class='tab-operator tab-link' target='#updname=upd'>Save</a>
	<a id='abort-btn' type='abort' class="tab-operator tab-link">Abort</a> 
	</form>
	</div>
</div>
	
<?php } else { ?>	
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>