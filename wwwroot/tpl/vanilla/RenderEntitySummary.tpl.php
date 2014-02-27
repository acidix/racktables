<?php if (defined("RS_TPL")) {?>

	<div class=portlet>
		<h2> <?php $this->title ?> </h2>
			<table border=0 cellspacing=0 cellpadding=3 width='100%'>
				<?php $this->startLoop("loopArray") ?>	
					<?php if($this->is("singeVal", true)){ ?>
						<?php $this->val ?>
					<?php } else {?>
						<?php if($this->is("showTags", true)) { ?>
							<?php $this->getH("PrintTagTRs", array( $this->cell, $this->baseurl));  ?>
						<?php } else {?>
							<tr><th width='50%' class='<?php $this->class ?>'><?php $this->name ?></th><td class=tdleft><?php $this->val ?></td></tr>
						<?php } ?>
					<?php } ?>

				<?php $this->endLoop(); ?>

			</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>