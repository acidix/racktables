<?php if (defined("RS_TPL")) {?>
	<table border=0 class=objectview cellspacing=0 cellpadding=0>
		<tr>
			<td class=pcleft>
			<div class='portlet'><h2><?php $this->RowName ; ?></h2>
				<table border=0 cellspacing=0 cellpadding=3 width='100%'>
				<?php if($this->is('HasLocation',true)) { ?>
					<tr><th width='50%' class=tdright>Location:</th><td class=tdleft><?php $this->LocationLink; ?></td></tr>
				<?php } ?>
				<tr><th width='50%' class=tdright>Racks:</th><td class=tdleft><?php $this->RackCount; ?></td></tr>
				<tr><th width='50%' class=tdright>Units:</th><td class=tdleft><?php $this->RowSum; ?></td></tr>
				<tr><th width='50%' class=tdright>% used:</th><td class=tdleft><?php $this->ProgressBar; ?></td></tr>
				</table><br>
			</div>
			<?php $this->CellFilterPortlet; ?>
			<?php $this->FilesPortlet; ?>
			</td>
			<td class=pcright>
				<div class='portlet'><h2>Racks</h2>
				<table border=0 cellspacing=5 align='center'><tr>
					<?php $this->Racks; ?>
				</tr></table>
			</td>
		</tr>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>