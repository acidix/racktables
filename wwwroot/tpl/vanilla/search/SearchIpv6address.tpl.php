<?php if (defined("RS_TPL")) {?>
	<div class=portlet><h2> <?php $this->sectionHeader ?></h2>
		<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>
		<tr><th>Address</th><th>Description</th></tr>

		<?php $this->startLoop("IPVAddrObjs"); ?>
			<tr class=row_<?php $this->rowOrder ?>><td class=tdleft>
				<?php if($this->is("parentNetSet", true)){?>
					<a href=<?php $this->rowLink ?> ><?php $this->rowFmt ?></a></td>
				<?php } else {?>
					<a href='index.php?page=ipaddress&tab=default&ip=<?php $this->rowFmt ?>'><?php $this->rowFmt ?></a></td>
				<?php } ?>
			<td class=tdleft><?php $this->rowAddr ?></td></tr>
		<?php $this->endLoop(); ?>


		</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>