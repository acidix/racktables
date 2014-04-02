<?php if (defined("RS_TPL")) {?>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr><th>&nbsp;</th><th>description</th><th>&nbsp</th></tr>
	<?php if ($this->is("isAddNew", true)) { ?>
		<?php $this->printNewItem ?> 
	<?php } ?>
	<?php $this->startLoop("allDomainStats"); ?>	
		<?php $this->formIntro ?> 
		<tr><td>
		<?php $this->imageNoDestroy ?> 	
		<?php $this->linkDestroy ?> 
		</td><td><input name=vdom_descr type=text size=48 value=<?php $this->niftyStr ?>> 
		</td><td>
		<?php $this->imageUpdate ?> 
		</td></tr></form>
	<?php $this->endLoop(); ?> 
	<?php if ($this->is("isAddNew", false)) { ?>
		<?php $this->printNewItem ?> 
	<?php } ?> 
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>