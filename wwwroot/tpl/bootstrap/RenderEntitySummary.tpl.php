<?php if (defined("RS_TPL")) {?>
	<div class="box">
 		<div class="box-header"><h3 class="box-title"><?php $this->Title ?></h3></div>
 		<div class="box-body">
			<table border=0 cellspacing=0 cellpadding=3 class="table table-condensed">
				<?php $this->LoopMod ?>
			</table>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>