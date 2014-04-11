<?php if (defined("RS_TPL")) {?>
	<tr class=<?php $this->classOrder ?>  valign=top>
	<td><?php $this->Count ?> </td>
	<td><?php $this->Mka ?> </td>
	<td><?php $this->AssetNo ?> </td>
	<td><?php $this->OemSn1 ?> </td>
	<td><?php $this->DateValue ?> </td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>