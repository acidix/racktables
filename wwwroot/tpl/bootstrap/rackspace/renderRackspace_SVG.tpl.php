<?php if (defined("RS_TPL")) {?>
	<svg width="<?php $this->OverallWidth; ?>" height="<?php $this->OverallHeight; ?>">
		<script xlink:href="SVGPan.js"/>
		<g id="viewport">
 			<?php $this->Content; ?>
 		</g>
 	</svg>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>