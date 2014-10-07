<?php if (defined("RS_TPL")) {?>
	<a xlink:href="<?php $this->RackLink ?>"><text x="<?php $this->X?>" y="<?php $this->Y ?>"><?php $this->RackName ?></text></a>
	<rect x="<?php $this->X?>" y="<?php echo $this->_Y + 10 ?>" width="190" height="<?php $this->Height; ?>" fill="none" stroke="black"/>
	<rect x="<?php echo ($this->_X + 5) ?>" y="<?php echo ($this->_Y + 15) ?>" width="180" height="<?php echo $this->_Height - 10; ?>" fill="#63a5cc" stroke="black"/>
	<svg width="180" height="<?php echo ($this->_Height - 10) ?>" x="<?php echo ($this->_X + 5) ?>" y="<?php echo ($this->_Y + 15) ?>">
		<defs>
			<style>
				.element rect{ fill: #a9cee3; }
				.element:hover rect { fill: #74a5c1; }
				.unusable rect { fill: #e4e4e4; }
				.unusable : hover rect{ fill: #9e9e9e; }
				.deactivated rect{ fill: #a0a0a0; stroke: #6b6b6b }	
			</style>
		</defs>
		<?php $this->Elements; ?>
	</svg>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>