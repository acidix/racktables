<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is('Resampled',true)) { ?>
		<a href='?module=download&file_id=<?php $this->Id; ?>&asattach=no' class='thumbnail'>
	<?php } else { ?>
		<a href='#' class='thumbnail'>
	<?php } ?>
	<img width=<?php $this->Width; ?> height=<?php $this->Height; ?> src='?module=image&img=preview&file_id=<?php $this->Id; ?>'>
	</a>
	<?php if ($this->is('Resampled',true)) { ?>
		<br>(click to zoom)
	<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>