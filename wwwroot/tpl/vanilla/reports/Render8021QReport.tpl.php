<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>VLAN existence per domain</h2>
		<table border=1 cellspacing=0 cellpadding=5 align=center class=rackspace>
		<?php $this->startLoop("OutputArr"); ?>	
			<?php $this->header ?>
			<tr class="state_<?php $this->countStats ?>"><th class=tdright><?php $this->vlan_id ?></th>
			<?php $this->domains ?> 
			</tr>
			<?php if ($this->is("tbc",true)) { ?>
			 	<tr class="state_A"><th>...</th><td colspan=<?php $this->countDom ?> >&nbsp;</td></tr>
			 <?php } ?>  
		<?php $this->endLoop(); ?> 
		</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>