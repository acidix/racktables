<?php if (defined("RS_TPL")) {?>
	<tr valign=top><th align=center>Count</th><th align=center>Name</th>
	<th align=center>Asset Tag</th><th align=center>OEM S/N 1</th><th align=center>Date Warranty <br> Expires</th></tr>
	<?php $this->startLoop('Expiration_Results'); ?>	
		<tr class=<?php $this->ClassOrder; ?> valign=top>
		<td><?php $this->Count ?> </td>
		<td><?php $this->Mka ?> </td>
		<td><?php $this->AssetNo ?> </td>
		<td><?php $this->OemSn1 ?> </td>
		<td><?php $this->DateValue ?> </td>
		</tr>
	<?php $this->endLoop(); ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>