<?php if (defined("RS_TPL")) {?>
	<div class="slbconf-btn">…</div>
	<div class="slbconf popup-box">
	<?php if ($this->is("do_vs", true)) { ?>
		<h1>VS config:</h1>
		<?php $this->row_vsconfig ?> 
	<?php } ?> 

	<?php if ($this->is("do_rs", true)) { ?>
		<h1>VS config:</h1>
		<?php $this->row_rsconfig ?> 
	<?php } ?> 

	</div>

	<?php if ($this->is("loadjs", true)) { ?>
		<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/jquery.thumbhover.js")); ?>
		<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>"
		$(document).ready (function () {
	    $('.slbconf-btn').each (function () {
		$(this).thumbPopup($(this).siblings('.slbconf.popup-box'), { showFreezeHint: false });
        });
        });")); ?>
	<?php } ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>