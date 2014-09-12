<?php if (defined("RS_TPL")) {?>
	<svg width="<?php $this->OverallWidth; ?>" height="<?php $this->OverallHeight; ?>" x="<?php $this->X ?>" y="<?php $this->Y ?>">
		<text x="12" y="12" fill="black">Location: <?php $this->LocationName; ?> Row: <?php $this->RowName; ?></text>
 		<?php $this->Racks; ?>
 	</svg>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>