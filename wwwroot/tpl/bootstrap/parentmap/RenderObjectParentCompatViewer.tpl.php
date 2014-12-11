<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-body">
	<div class="row edit_row"><div class="col-sm-6 header tdright">Parent</div><div class="col-sm-6 header tdleft">Child</div></div>
	<?php while( $this->Loop('Looparray') ) { ?>
		<div class="row edit_row"><div class="col-sm-6 tdright"><?php $this->Parentname; ?></div><div class="col-sm-6 tdleft"><?php $this->Childname; ?></div></div>
	<?php } ?>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>