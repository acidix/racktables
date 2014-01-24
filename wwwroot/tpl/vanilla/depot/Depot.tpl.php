<?php if (defined("RS_TPL")) { ?>
	<table border=0 class=objectview>
		<tr>
			<td class=pcleft>
				<?php if($this->is("NoObjects")) { ?>
					<h2>No objects exist</h2>
				<?php } else { ?>
					<?php $this->Content; ?>
				<?php } ?>
			</td><td class=pcright width='25%'>
				<?php $this->CellFilterPortlet; ?>
			</td>
		</tr>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>