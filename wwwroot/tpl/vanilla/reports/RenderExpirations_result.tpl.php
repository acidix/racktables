<?php if (defined("RS_TPL")) {?>
	<tr class=<?php $this->classOrder ?>  valign=top>
	<td><?php $this->count ?> </td>
	<td><?php $this->mkA ?> </td>
	<td><?php $this->asset_no ?> </td>
	<td><?php $this->oem_sn_1 ?> </td>
	<td><?php $this->date_value ?> </td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>