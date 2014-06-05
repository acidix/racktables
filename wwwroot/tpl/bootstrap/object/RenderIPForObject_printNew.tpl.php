<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('add')); ?>
	<tr><td>
	<?php $this->getH("PrintImageHref", array('add', 'allocate', TRUE)); ?>
	</td>
	<td class=tdleft><input type='text' size='10' name='bond_name' tabindex=100></td>
	<td class=tdleft><input type=text name='ip' tabindex=101></td>
	<?php if ($this->is("isExt_ipv4", true)) { ?>
		<td colspan=2>&nbsp;</td>
	<?php } ?> 
	<td><?php $this->bondPrintSel ?></td>
	</td><td>&nbsp;</td><td>
	<?php $this->getH("PrintImageHref", array('add', 'allocate', TRUE, 103)); ?>
	</td></tr></form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>