<?php if (defined("RS_TPL")) {?>
	<table border=0 class=objectview cellspacing=0 cellpadding=0>
		<?php if ($this->is("isPoolInfo",true)) { ?>
			<tr><td colspan=2 align=center><h1><?php $this->poolInfo ?></h1></td></tr>
		<?php } ?> 
		<tr><td class=pcleft>
		<?php $this->renderedEntity ?> 
		<?php $this->RSPoolSrvPortlet ?>
		</td><td class=pcright>
		<?php $this->renderedSLBTrip2 ?> 
		<?php $this->renderedSLBTrip ?> 
		</td></tr><tr><td colspan=2>
		<?php $this->renderedFiles ?> 
		</td></tr></table>
	</td></tr></table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>