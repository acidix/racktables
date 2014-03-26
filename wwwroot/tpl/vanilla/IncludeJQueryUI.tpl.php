<?php if (defined("RS_TPL")) {?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/jquery-ui-1.8.21.min.js")); ?>
	<?php if ($this->is("do_css",true)) { ?>
		<?php $this->addRequirement("Header","HeaderCssInclude",array("path"=>"css/jquery-ui-1.8.22.redmond.css")); ?>
	<?php } ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>