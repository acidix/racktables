<?php if (defined("RS_TPL")) {?>
	<tr class='tdleft $tr_class'>
		<td><a class='$history_class' $title name='ip-$dottedquad' href='<?php $this->Link; ?>'><?php $this->IP; ?></a></td>
		<td><span class='rsvtext <?php $this->Editable; ?> id-<?php $this->QuadIP; ?> op-upd-ip-name'><?php $this->Name; ?></span></td>
		<td><span class='rsvtext <?php $this->Editable; ?> id-<?php $this->QuadIP; ?> op-upd-ip-comment'><?php $this->Comment; ?></span></td>
		<td>
			<?php if ($this->is('Reserved')) { ?>
				<strong>RESERVED</strong> ; 
			<?php } ?>
			<?php if ($this->is('Allocs')) { ?>
				<?php $this->startLoop('Allocs'); ?>
				<a href='<?php $this->Link; ?>'>
					<?php $this->Name; ?>
				</a>
				<?php $this->endLoop(); ?>
			<?php } ?>
			<br />
			<?php if ($this->is('VSList')) { ?>
				<?php $this->startLoop('VSList'); ?>
				
				<?php $this->endLoop('VSList'); ?>
			<?php } ?>
		</td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>