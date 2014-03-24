<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>WDM standard by interface</h2>
		<table border=0 align=center cellspacing=0 cellpadding=5>
		<?php $this->startLoop("allWDM_Packs"); ?>	
			<tr><th>&nbsp;</th><th colspan=2><?php $this->packinfo ?> </th></tr
			<?php $this->iif_ids ?> 
		<?php $this->endLoop(); ?> 
		</table>
	</div>
	<div class=portlet>
		<h2>interface by interface</h2>
		<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
		<tr><th>&nbsp;</th><th class=tdleft>inner interface</th><th class=tdleft>outer interface</th></tr>
		<?php $this->isAddNewItemTop ?> 
		<?php $this->startLoop("allInterfaces"); ?>	
			<tr class=row_<?php $this->order ?>><td>
			<?php $this->opLink ?>
			 </td><td class=tdleft><?php $this->iif_name ?></td><td class=tdleft><?php $this->oif_name ?></td></tr>
		<?php $this->endLoop(); ?> 
		<?php $this->isntAddNewItemTop ?> 
		</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>