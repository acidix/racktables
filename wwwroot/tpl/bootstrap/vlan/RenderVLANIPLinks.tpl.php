<?php if (defined("RS_TPL")) {?>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr>
	<?php if ($this->is("IsVLAN", true)) { ?>
		<th><?php $this->getH("PrintImageHref", array('net')); ?></th>
	<?php } ?> 
	<?php if ($this->is("IsIpv6Net",true)) { ?>
		<th>VLAN</th>
	<?php } ?> 
	<th>&nbsp;</th></tr>
	<?php $this->AddNewTop ?>
	<?php $this->startLoop("AllMinusLines"); ?>	
		<tr class=<?php $this->domainclass ?>><td>
		<?php $this->RenderedCell ?>
		<?php $this->VlanRichTxt ?>
		</td><td>
		<?php $this->OpLink ?>
		</td></tr>
	<?php $this->endLoop(); ?> 
	<?php $this->AddNewBottom ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>