<?php if (defined("RS_TPL")) {?>
	<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
	<tr><th class=tdleft>inner interface</th><th></th><th class=tdleft>outer interface</th><th></th></tr>
	<?php $this->startLoop("allRecords"); ?>	
		<tr class=row_<?php $this->order ?>><td class=tdleft><?php $this->iif_name ?> </td><td><?php $this->iff_id ?></td><td class=tdleft><?php $this->oif_name ?></td><td><?php $this->oif_id ?></td></tr>
	<?php $this->endLoop(); ?> 
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>