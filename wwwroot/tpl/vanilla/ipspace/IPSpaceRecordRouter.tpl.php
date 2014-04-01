<?php if (defined("RS_TPL")) {?>
	<tr class='<?php $this->TRClass; ?>'>
		<?php $this->startLoop('RouterList'); ?>
			<?php if($this->is('printCell')) { ?>
				<?php $this->Cell; ?><br />
			<?php } else { ?>
				<a href="<?php $this->Link; ?>"><?php $this->Name; ?></a><br />
			<?php } ?>
		<?php $this->endLoop(); ?>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>