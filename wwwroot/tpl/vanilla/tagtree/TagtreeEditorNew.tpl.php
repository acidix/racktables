<?php if (defined("RS_TPL")) {?>
	<?php $this->getH('PrintOpFormIntro','createTag'); ?>
	<tr>
		<td align=left style="padding-left: 16px;"><?php $this->getH('PrintImageHREF',array('create', 'Create tag', TRUE)); ?></td>
		<td><input type=text size=48 name=tag_name tabindex=100></td>
		<td class=tdleft> <?php $this->getH("PrintSelect", array(array ('yes' => 'yes', 'no' => 'no'), array ('name' => 'is_assignable', 'tabindex' => 105), 'yes')); ?></td>
		<td><?php $this->Select; ?></td>
		<td><?php $this->getH('PrintImageHREF',array('create', 'Create tag', TRUE, 120)); ?></td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>