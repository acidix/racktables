<?php if (defined("RS_TPL")) {?>
	<table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
	<tr><th>Key</th><th class=tdleft><?php $this->LeftHeader ?></th><th>Key</th><th class=tdleft><?php $this->RightHeader ?></th></tr>
	<?php while($this->loop("AllCompats")) { ?>
		<tr class=row_<?php $this->Order ?>>
			<td  class=tdright><?php $this->LeftKey ?></td>
			<td class=tdleft><?php $this->LeftValue ?></td>
			<td  class=tdright><?php $this->RightKey ?></td>
			<td class=tdleft><?php $this->RightValue ?></td>
		</tr>
	<?php } ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
