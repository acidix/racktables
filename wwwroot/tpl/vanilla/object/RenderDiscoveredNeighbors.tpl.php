<?php if (defined("RS_TPL")) {?>
	<?php $this->switchPortScripts ?>
	<?php $this->getH("PrintOpFormIntro", array('importDPData')); ?>
	<br><table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr><th colspan=2>local port</th><th></th><th>remote device</th><th colspan=2>remote port</th><th><input type="checkbox" checked id="cb-toggle"></th></tr>
	<?php $this->AllNeighbors ?>
	<?php if (!$this->is("inputno",null)) { ?>
	 	<input type=hidden name=nports value=<?php $this->inputno ?>>
	 	<tr><td colspan=7 align=center><?php $this->getH("PrintImageHref", array('CREATE', 'import selected', TRUE)); ?></td></tr>
	<?php } ?>  
	</table></form>
	<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>"<<<END
$(document).ready(function () {
	$('#cb-toggle').click(function (event) {
		var list = $('.cb-makelink');
		for (var i in list) {
			var cb = list[i];
			cb.checked = event.target.checked;
		}
	}).triggerHandler('click');
});
END")); ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>