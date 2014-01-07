<?php if (defined("RS_TPL")) {?>

<table>
	<?php $this->startLoop("Objects_Sticker"); ?>

		<tr><th width='50%' class=sticker><?php $this->get("Name"); ?> </th>
		<td class=sticker>" <?php $this->get("AttributValue"); ?> "</td></tr>
	<?php $this->endLoop(); ?>
</table>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>