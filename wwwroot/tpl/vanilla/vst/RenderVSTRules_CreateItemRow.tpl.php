<?php if (defined("RS_TPL")) {?>
	<tr class=row_<?php $this->Order ?> align=left>
	<td><?php $this->Rule_no ?></td>
	<td nowrap><tt><?php $this->Port_pcre ?></tt></td>
	<td nowrap><?php $this->Port_role ?></td>
	<td><?php $this->Wrt_vlans ?></td>
	<td><?php $this->Description ?></td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>