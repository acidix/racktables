<?php
	$this->addRequirement("Header", "RackspaceLocationEditorJs",array(),"rackspace",false);
	if (defined("RS_TPL")) {?>
	<div class=portlet><h2>Locations</h2>
		<table border=0 cellspacing=0 cellpadding=5 align=center class=widetable>
			<tr><th>&nbsp;</th><th>Parent</th><th>Name</th><th>&nbsp;</th></tr>
			<?php $this->get("NewTop");?>
			<?php $this->get("LocationList"); ?>
			<?php $this->get("NewBottom"); ?>
		</table><br />
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>