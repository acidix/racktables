<?php if (defined("RS_TPL")) {?>
	<tr <?php if($this->is('assignable',false)) { ?>
			<?php if ($this->is('hasChildren',true)) { ?>
				class=trnull
			<?php } else { ?>
				class=trwarning
			<?php } ?>
		<?php } ?>
	>
	<td align=left style='padding-left: " <?php $this->Level; ?> "px;'>
	<?php if ($this->is('hasChildren')) { ?>
		<img width="16" border="0" height="16" src="?module=chrome&uri=pix/node-expanded-static.png"></img>
	<?php } ?>
	<?php if ($this->is('hasReferences') || $this->is('hasChildren')) { ?>
		<img width="16" border="0" height="16" src="?module=chrome&uri=pix/tango-user-trash-16x16-gray.png" title="<?php $this->References; ?> references, <?php $this->Children; ?> subtags'?>"></img>
	<?php } else { ?>
		<?php $this->getH('GetOpLink',array(array ('op' => 'destroyTag', 'tag_id' => $taginfo['id']), '', 'destroy', 'Delete tag')); ?>	
	<?php } ?>
	<?php $this->getH('Form',array('updateTag', array ('tag_id' => $taginfo['id']))) ; ?>
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
		
	</td>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<span title="<?php $this->Stats; ?>" class="<?php $this->Spanclass; ?>">
		<?php $this->Tag; ?>
		<i> <?php $this->Refc; ?></i>
	</span>
	</td>
	</tr>
	<?php $this->Taglist; ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>