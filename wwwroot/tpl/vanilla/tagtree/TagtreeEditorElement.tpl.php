<?php if (defined("RS_TPL")) {?>
	<tr <?php if($this->is('assignable',false)) { ?>
			<?php if ($this->is('hasChildren',true)) { ?>
				class=trnull
			<?php } else { ?>
				class=trwarning
			<?php } ?>
		<?php } ?>>
	<td align=left style='padding-left: " <?php $this->Level; ?> "px;'>
	<?php if ($this->is('hasChildren')) { ?>
		<img width="16" border="0" height="16" src="?module=chrome&uri=pix/node-expanded-static.png"></img>
	<?php } ?>
	<?php if ($this->is('hasReferences') || $this->is('hasChildren')) { ?>
		<img width="16" border="0" height="16" src="?module=chrome&uri=pix/tango-user-trash-16x16-gray.png" title="<?php $this->References; ?> references, <?php $this->Subtags; ?> subtags'?>"></img>
	<?php } else { ?>
		<?php $this->getH('GetOpLink',array(array ('op' => 'destroyTag', 'tag_id' => $this->_ID), '', 'destroy', 'Delete tag')); ?>	
	<?php } ?>
	<?php $this->getH('PrintOpFormIntro',array('updateTag', array ('tag_id' => $this->_ID))) ; ?>
		<input type=text size=48 name=tag_name value="<?php $this->Tag; ?>">
	</td>
	<td class=tdleft>
		<select name='is_assignable'>
			<?php if(!$this->is('hasReferences')) { ?>
				<option value='no' <?php if (!$this->is('Assigned')) { ?> selected <?php } ?>>no</option>
			<?php }?>
			<option value='yes' <?php if ($this->is('Assigned')) { ?> selected <?php } ?>>yes</option>
		</select>
	</td>
	<td class=tdleft>
		<?php $this->ParentSelect; ?>
	</td>
	<td>
		<?php $this->getH('PrintImageHREF',array('save', 'Save changes', TRUE)); ?> </form>
	</td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>