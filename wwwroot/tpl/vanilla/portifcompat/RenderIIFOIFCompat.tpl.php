<?php if (defined("RS_TPL")) {?>
	<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
	<tr><th class=tdleft>inner interface</th><th></th><th class=tdleft>outer interface</th><th></th></tr>
	<?php $this->startLoop("AllRecords"); ?>	
		<tr class=row_<?php $this->Order ?>><td class=tdleft><?php $this->IifName ?> </td><td><?php $this->IffId ?></td><td class=tdleft><?php $this->OifName ?></td><td><?php $this->OifId ?></td></tr>
	<?php $this->endLoop(); ?> 
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>