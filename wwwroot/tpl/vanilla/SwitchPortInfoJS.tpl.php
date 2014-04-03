<?php if (defined("RS_TPL")) {?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/jquery.thumbhover.js")); ?>
	<?php $this->addRequirement("Header","HeaderCSSInclude",array("path"=>"css/jquery.contextmenu.css")); ?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/jquery.contextmenu.js")); ?>
	<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>"enabled_elements = [ $this->list ];")); ?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/portinfo.js")); ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>