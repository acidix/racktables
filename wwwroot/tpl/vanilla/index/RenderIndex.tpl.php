<?php if (defined("RS_TPL")) {?>
<table border=0 cellpadding=0 cellspacing=0 width='100%'>
	<tr>
		<td>
			<div style='text-align: center; margin: 10px; '>
				<table width='100%' cellspacing=0 cellpadding=20 class=mainmenu border=0>
					<?php $this->startLoop("indexArrayOutput"); ?>	
					<tr>
						<?php $this->renderedRows ?>
					</tr>
					<?php $this->endLoop(); ?> 

					</table>
				</div>
			</td>
		</tr>
	</table>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>