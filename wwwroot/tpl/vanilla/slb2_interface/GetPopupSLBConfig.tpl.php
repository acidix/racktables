<?php if (defined("RS_TPL")) {?>
	<div class="slbconf-btn">…</div>
	<div class="slbconf popup-box">
	<?php if ($this->is("do_vs", true)) { ?>
		<h1>VS config:</h1>
		<?php $this->row_vsconfig ?> 
	<?php } ?> 

	<?php if ($this->is("do_rs", true)) { ?>
		<h1>RS config:</h1>
		<?php $this->row_rsconfig ?> 
	<?php } ?> 
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>