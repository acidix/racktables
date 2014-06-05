<?php if (defined("RS_TPL")) {?>
	<input type=hidden name=<?php $this->I; ?>_attr_id value=<?php $this->Id; ?>>
	<tr>
	<td>
		<?php if($this->is('Deletable')) { ?>
			<?php $this->getH('GetOpLink',array(array('op'=>'clearSticker', 'attr_id'=>$this->_Id), '', 'clear', 'Clear value', 'need-confirmation')); ?>
		<?php } else { ?>
			&nbsp;
		<?php } ?>
	</td>
	<th class=sticker><?php $this->Name; ?></th>
	<td class=tdleft>
		<?php if($this->is('Type','dict')) { ?>
			<?php $this->DictSelect; ?>
		<?php } else { ?>
			<input type=text name=<?php $this->I?>_value value='<?php $this->Value; ?>'>
		<?php } ?>
	</td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>