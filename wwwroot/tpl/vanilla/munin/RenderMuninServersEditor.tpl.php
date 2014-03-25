<?php if (defined("RS_TPL")) {?>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr><th>&nbsp;</th><th>base URL</th><th>graph(s)</th><th>&nbsp;</th></tr>
	<?php $this->AddNewTop ?>
	<?php $this->startLoop("allMuninServers"); ?>	
		<?php $this->formIntro ?>
		<tr><td>
		<?php $this->destroyImg ?>
		</td>
		<td><input type=text size=48 name=base_url value="<?php $this->specialCharSrv ?>"></td>
		<td class=tdright><?php $this->num_graphs ?></td>
		<td><?php $this->imageSave ?></td>
		</tr></form>
	<?php $this->endLoop(); ?> 
	<?php $this->AddNewBottom ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>