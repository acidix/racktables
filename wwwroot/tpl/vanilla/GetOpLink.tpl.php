<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is("loadJS", true)) { ?>
		<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/racktables.js")); ?>
	<?php } ?> 

	<?php if ($this->is("issetParams", true)) { ?>
		<a href="<?php $this->href ?>"
	<?php } else {?> 
		<a href="#" onclick="return false;"
	<?php } ?>
	<?php if ($this->is("showComment",true)) { ?>
		 title="<?php $this->htmlComment ?> "
	<?php } ?>
	<?php if ($this->is("showClass",true)) { ?>
		 class="<?php $this->htmlClass ?> "
	<?php } ?>
	<?php if ($this->is("showComment",true)) { ?>
		  title="<?php $this->htmlComment ?> "
	<?php } ?>
	>
	<?php if ($this->is("loadImage",true)) { ?>
		<?php $this->getH("getImageHREF", array( $this->imgName, $this->comment)); ?>  
	<?php } ?> 
	<?php $this->title ?> </a>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>