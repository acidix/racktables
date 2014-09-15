<?php if (defined("RS_TPL")) {?>
	<rect x="<?php $this->X?>" y="<?php $this->Y ?>" width="190" height="<?php $this->Height; ?>" fill="none" stroke="black"/>
	<rect x="<?php echo ($this->_X + 5) ?>" y="<?php echo ($this->_Y + 5) ?>" width="180" height="<?php echo $this->_Height - 10; ?>" fill="#668aff" stroke="black"/>
	<svg width="180" height="<?php echo ($this->_Height - 11) ?>" x="<?php echo ($this->_X + 6) ?>" y="<?php echo ($this->_Y + 6) ?>">
		<defs>
			<style>
				.element rect{ fill: #6555ff; }
				.element:hover rect { fill: #3000ff; }
				.unusable rect { fill: #ff3c3c; }
				.unusable : hover rect{ fill: red; }
				.deactivated rect{ fill: #96A0A0; stroke: #96A0A0 }
				
			</style>
		</defs>
		<?php $this->Elements; ?>
	</svg>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>