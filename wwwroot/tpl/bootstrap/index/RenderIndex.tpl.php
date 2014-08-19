<?php if (defined("RS_TPL")) {?>

<?php $this->getH('RunMainpageWidgets'); ?>

<div class="row">
	<div class="col.md-6">
		<?php $this->Col1; ?>
	</div>
	<div class="col.md-6">
		<?php $this->Col2; ?>
	</div>
</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>