<?php if (defined("RS_TPL")) {?>
	<div class="row">
		<div class="col-md-9">
			<?php $this->getH("H2",array("%%RackspaceOverviewHeadline")); ?>
			<?php $this->get("RackspaceOverviewTable"); ?>
		</div>
		<div class="col-md-3">
			<?php $this->get("CellFilter"); ?><br />
			<?php $this->get("LocationFilter"); ?>
		</div>
	</div>	

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>