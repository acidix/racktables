<?php if (defined("RS_TPL")) {?>
	<a xlink:href="<?php $this->Link ?>">
		<rect x="<?php $this->X ?>" y="<?php $this->Y ?>" width="<?php $this->Width ?>" height="<?php $this->Height ?>" stroke="black" class="<?php $this->Class; ?>" />
	</a>
	<text text-anchor="middle" x="<?php echo ($this->_X + ($this->_Width / 2)) ?>" y="<?php echo ($this->_Y + 3) ?>"><?php $this->Name; ?></text>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>