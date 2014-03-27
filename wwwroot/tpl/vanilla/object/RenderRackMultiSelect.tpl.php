<?php if (defined("RS_TPL")) {?>
	<select name=<?php $this->sname ?> multiple size=<?php $this->maxselsize ?> onchange='getElementsByName(\"updateObjectAllocation\")[0].submit()'>
	<?php $this->startLoop("allRowData"); ?>	
		<option value=<?php $this->rack_id ?>
		<?php if ($this->is("is_selected", true)) { ?>
			' selected'
		<?php } ?> 
		><?php $this->rack_name ?></option>
	<?php $this->endLoop(); ?> 
	</select>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>