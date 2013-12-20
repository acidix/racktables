<?php if (defined("RS_TPL")) {?>

<ul>
	<?php $this->startLoop("Objects_NAT"); ?>
		<li><?php $this->get("Comment"); ?></li>
	<?php $this->endLoop(); ?>

</ul>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>