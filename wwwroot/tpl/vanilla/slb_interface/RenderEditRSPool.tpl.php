<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('updIPv4RSP')); ?> 
	<table border=0 align=center>
	<tr><th class=tdright>name:</th><td class=tdleft><input type=text name=name value='<?php $this->poolinfoName ?> '></td></tr>
	<tr><th class=tdright>VS config:</th><td class=tdleft><textarea name=vsconfig rows=20 cols=80><?php $this->poolinfoVSConfig ?></textarea></td></tr>
	<tr><th class=tdright>RS config:</th><td class=tdleft><textarea name=vsconfig rows=20 cols=80><?php $this->poolinfoRSConfig ?></textarea></td></tr>
	<tr><th class=submit colspan=2>
	<?php $this->getH("PrintImageHREF", array( 'SAVE', 'Save changes', TRUE)); ?> 
	</td></tr>
	</table></form>
	<p class="centered">
		<?php $this->getH("GetOpLink", array(array	('op' => 'cloneIPv4RSP', 'pool_id' => $this->poolinfoID), 'Clone RS pool', 'copy')); ?> 
	</p>
	<p class="centered">
	<?php if ($this->is("isPoolinfoRefcnt",true)) { ?>
		<?php $this->getH("GetOpLink", array(NULL, 'Delete RS pool', 'nodestroy', "Could not delete: there are ${this->poolinfoRefncnt} LB links")); ?> 
	<?php } else {?> 
		<?php $this->getH("GetOpLink", array(array	('op' => 'del', 'id' => $this->poolinfoID), 'Delete RS pool', 'destroy')); ?> 	
	<?php } ?>
	</p>
	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>