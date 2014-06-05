<?php if (defined("RS_TPL")) {?>
	<center><h1><?php $this->Ip; ?></h1></center>
	<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center'>
		<tr><th>&nbsp;</th><th>object</th><th>OS interface</th><th>allocation type</th><th>&nbsp;</th></tr>
		<?php $this->NewTop; ?>
		<?php if($this->is('Reserved')) { ?>
		<tr class='<?php $this->Class; ?>'><td colspan=3>&nbsp;</td><td class=tdleft><strong>RESERVED</strong></td><td>&nbsp;</td></tr>
		<?php } ?>
		<?php $this->List; ?>
		<?php $this->NewBottom; ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>