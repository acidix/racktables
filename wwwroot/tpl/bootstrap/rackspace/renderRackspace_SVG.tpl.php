<?php if (defined("RS_TPL")) {?>
	<svg width="<?php $this->OverallWidth; ?>" height="<?php $this->OverallHeight; ?>" id="viewport">
		<script xlink:href="./js/SVGPan.js"/>
 		<?php $this->Content; ?>
 	</svg>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>