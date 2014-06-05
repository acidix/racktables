<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>Add new VS group</h2>
		<?php $this->getH("PrintOpFormIntro", array('add')); ?>
		<table border=0 cellpadding=10 cellspacing=0 align=center>
		<tr valign=bottom><th>name</th><th>Assign tags</th></tr>
		<tr valign=top><td><input type=text name=name><p>
		<?php $this->getH("PrintImageHref", array('CREATE', 'create virtual service', TRUE)); ?>
		</p></td><td>
		<?php $this->entityTags ?>
		</td></tr></table></form>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>