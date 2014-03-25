<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>Add new virtual service</h2>
		<?php $this->getH("PrintOpFormIntro", array('add')); ?>
		<table border=0 cellpadding=10 cellspacing=0 align=center>
		<tr valign=bottom><td>&nbsp;</td><th>VIP</th><th>port</th><th>proto</th><th>name</th><th>&nbsp;</th><th>Assign tags</th></tr>
		<tr valign=top><td><td>&nbsp;</td>
		<td><input type=text name=vip tabindex=101></td>
		<td><input type=text name=vport size=5 value='<?php $this->default_port ?>' tabindex=102></td><td>
		</td><td><input type=text name=name tabindex=104></td><td>
		<?php $this->getH("PrintImageHref", array('CREATE', 'create virtual service', TRUE, 105)); ?>
		</td><td rowspan=3>
		<?php $this->entityTags ?>
		</td></tr><tr><th>VS configuration</th><td colspan=5 class=tdleft><textarea name=vsconfig rows=10 cols=80></textarea></td>
		<tr><th>RS configuration</th><td colspan=5 class=tdleft><textarea name=rsconfig rows=10 cols=80></textarea></td></tr>
		</table></form>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>