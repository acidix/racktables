<?php if (defined("RS_TPL")) {?>
<g class="<?php $this->Class ?>">

	<?php if (!$this->is('Link','#')) { ?><a <!--- xlink:href="<?php $this->Link ?>" ---> ><?php } ?>
		<rect x="<?php $this->X ?>" y="<?php $this->Y ?>" width="<?php $this->Width ?>" height="<?php $this->Height ?>" stroke="black" />
		<text style="font-size: 9px;" text-anchor="middle" x="<?php echo ($this->_X + ($this->_Width / 2)) ?>" y="<?php echo ($this->_Y + 8) ?>"><?php $this->Name; ?></text>
	<?php if (!$this->is('Link','#')) { ?></a><?php } ?>
</g>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>