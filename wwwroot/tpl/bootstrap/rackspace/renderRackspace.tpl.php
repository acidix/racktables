<?php if (defined("RS_TPL")) {?>
	<table class=objview border=0 width='100%'>
		<tr>
			<td class=pcleft>
				<?php $this->RackspaceSVG; ?>
			</td><td class=pcright width="25%">
				<?php $this->get("CellFilter"); ?>
				<br />
				<?php $this->get("LocationFilter"); ?>
			</td>
		</tr>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>