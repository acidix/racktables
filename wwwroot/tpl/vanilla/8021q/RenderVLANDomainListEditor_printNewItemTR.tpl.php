<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('add')); ?>
	<tr><td>
	<?php $this->getH("PrintImageHREF", array( 'create', 'create domain', TRUE, 104)); ?> 
	</td><td>
	<input type=text size=48 name=vdom_descr tabindex=102>
	</td><td>
	<?php $this->getH("PrintImageHREF", array( 'create', 'create domain', TRUE, 103)); ?>
	</td></tr></form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>