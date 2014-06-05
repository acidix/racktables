<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('add')); ?>
	<tr>
		<td><?php $this->getH("PrintImageHref", array('create', 'add a new server', TRUE, 112)); ?></td>
		<td><input type=text size=48 name=base_url tabindex=101></td>
		<td>&nbsp;</td>
		<td><?php $this->getH("PrintImageHref", array('create', 'add a new server', TRUE, 111)); ?></td>
	</tr></form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>