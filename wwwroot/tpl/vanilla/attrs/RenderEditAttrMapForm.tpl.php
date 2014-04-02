<?php if (defined("RS_TPL")) {?>
<div class=portlet><h2>Attribute map</h2>
	<table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>
		<tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr>
		
		<?php 
		$this->Newtop;
		$this->startLoop('Looparray');
		?>
			<tr class=row_<?php $this->Order; ?>><td class=tdleft><?php $this->Name; ?></td>
				<td class=tdleft><?php $this->Attrtypes; ?></td><td colspan=2 class=tdleft>
				<?php $this->AllAttrApps ?>		 
			</td></tr>
		<?php	$this->endLoop();
			$this->Newbottom; ?>

			</table></div>

		<?php } else { ?>
		Don't use this page directly, it's supposed <br />
		to get loaded within the main page. <br />
		Return to the index. <br />
		<?php }?>