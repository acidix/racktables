<?php if (defined("RS_TPL")) {?>
	
	<div class=portlet>
	<h2>Optional attributes</h2>
	<table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>
	<tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr>
	
	<?php $this->startLoop('AllAttrs'); ?>	
		<tr class=row_<?php $this->Order; ?>>
		<td class=tdleft><?php $this->Name; ?></td>
		<td class=tdleft><?php $this->Type; ?></td>
		<td class=tdleft>
		<?php $this->ApplicationSet ?>
		<?php $this->AllAppAttrsMod ?>
	<?php $this->endLoop() ?> 
	</table><br></div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>