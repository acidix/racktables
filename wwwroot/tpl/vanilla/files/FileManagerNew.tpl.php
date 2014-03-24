<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>Upload new</h2>
		<?php $this->getH('PrintOpFormIntro',array('addFile', array (), TRUE)); ?>
		<table border=0 cellspacing=0 cellpadding='5' align='center'>
			<tr><th colspan=2>Comment</th><th>Assign tags</th></tr>
			<tr><td valign=top colspan=2><textarea tabindex=101 name=comment rows=10 cols=80></textarea></td>
			<td rowspan=2>
				<?php $this->Tags; ?>
			</td></tr>
			<tr><td class=tdleft><label>File: <input type='file' size='10' name='file' tabindex=100></label></td><td class=tdcenter>
				<?php $this->getH('PrintImageHREF',array('CREATE', 'Upload file', TRUE, 102)); ?>
			</td></tr>
			</table></form><br>
	</div>		
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>