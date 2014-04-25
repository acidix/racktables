<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>WDM standard by interface</h2>
		<table border=0 align=center cellspacing=0 cellpadding=5>
		<?php $this->startLoop("AllWDMPacks"); ?>	
			<tr><th>&nbsp;</th><th colspan=2><?php $this->PackInfo ?></th></tr>
			<?php $this->IifCont ?> 
		<?php $this->endLoop(); ?> 
		</table>
	</div>
	<div class=portlet>
		<h2>interface by interface</h2>
		<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
		<tr><th>&nbsp;</th><th class=tdleft>inner interface</th><th class=tdleft>outer interface</th></tr>
		<?php $this->AddNewTop ?> 
		<?php $this->startLoop("AllInterfaces"); ?>	
			<tr class=row_<?php $this->Order ?>><td>
			<?php $this->OpLink ?>
			 </td><td class=tdleft><?php $this->IifName ?></td><td class=tdleft><?php $this->OifName ?></td></tr>
		<?php $this->endLoop(); ?> 
		<?php $this->AddNewBottom ?> 
		</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>