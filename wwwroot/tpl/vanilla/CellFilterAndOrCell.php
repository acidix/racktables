<?php if (defined("RS_TPL")) {?>
	<td class='<?php $this->get("Class"); ?>' >
		<label>
			<input type=radio name=andor value=<?php $this->get("Boolop"); $this->get("Checked"); ?>><?php $this->get("Boolop"); ?></input>
		</label>
	</td>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>