<?php if (defined("RS_TPL")) {?>
		<tr align=left valign=top>
			<td><?php $this->BaseUrl; ?></td>
			<td><?php $this->UserName; ?></td>
			<td class=tdright><?php $this->NumGraphs; ?></td>
		</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>