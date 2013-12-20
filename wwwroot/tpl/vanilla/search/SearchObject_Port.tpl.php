<?php if (defined("RS_TPL")) {?>

<table>
	<?php $this->startLoop("Objects_Port"); ?>
		<tr><td><?php $this->get("Href"); ?></td>
		<td class=tdleft><?php $this->get("Text"); ?></td></tr>
	<?php $this->endLoop(); ?>
</table>


<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>