<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('add')); ?> 
	<tr><th class=tdleft>
	<?php $this->getH("PrintImageHref", array('add', 'add pair', TRUE)); ?> 
	</th><th class=tdleft>
	<?php $this->iffOptions ?> 
	</th><th class=tdleft>
	<?php $this->chapter ?> 
	</th></tr></form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>