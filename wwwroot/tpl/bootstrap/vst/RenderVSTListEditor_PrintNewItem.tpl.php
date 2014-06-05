<?php if (defined("RS_TPL")) {?>
	<?php $this->getH('PrintOpFormIntro', 'add'); ?>
	<tr>
	<td> <?php $this->getH('PrintImageHref', array('create', 'create template', TRUE, 104)); ?> </td>
	<td><input type=text size=48 name=vst_descr tabindex=101></td>
	<td> <?php $this->getH('PrintImageHref', array('create', 'create template', TRUE, 103)); ?> </td>
	</tr></form>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>