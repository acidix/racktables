<?php if (defined("RS_TPL")) {?>
<div class="box box-solid bg-light-blue">
	<div class="box-header">
	    <h3 class="box-title">Tags picker</h3>
	</div>
	<div class="box-body">
	    <input type='text' data-tagit-valuename='<?php $this->Input_Name ?>' data-tagit='yes' placeholder='new tags here...' class='ui-autocomplete-input tagspicker' autocomplete='off' role='textbox' aria-autocomplete='list' aria-haspopup='true'>
		<span title='show tag tree' class='icon-folder-open tagit_input_<?php $this->Input_Name ?>'></span>
	</div><!-- /.box-body -->
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>