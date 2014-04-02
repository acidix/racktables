<?php if (defined("RS_TPL")) {?>
	<input type=hidden name=<?php $this->i ?>_attr_id value=<?php $this->id ?>>
	<tr><td>
	<?php $this->value_link ?>
	</td>
	<th class=sticker><?php $this->name ?>
	<?php if (!$this->is("dateFormatTime", null)) { ?>
		(<?php $this->dateFormatTime ?>)
	<?php } ?> 	
	:</th><td class=tdleft>
	<?php if ($this->is('type','string')) { ?>
		<input type=text name=<?php $this->i ?>_value value='<?php $this->value ?>'>
	<?php } ?> 
	<?php if ($this->is('type','dict')) { ?>
		<?php $this->niftyStr ?>
	<?php } ?>
	<?php if ($this->is('type', 'date')) { ?>
	 	<input type=text name=<?php $this->i ?>_value value='<?php $this->date_value ?>'>
	<?php } ?>  		
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>