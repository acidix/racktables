<?php if (defined("RS_TPL")) {?>
	<tr class="<?php $this->tr_class ?>">	
	<?php if ($this->is("isInitialRow", true)) { ?>
		<?php $this->td_class ?>
		<td rowspan="<?php $this->count ?>" <?php $this->td_class ?> NOWRAP>
		<?php if ($this->is("id_port_link_local")) { ?>
			<?php $this->id_port_link_local ?>
		<?php } else {?>
		 	<a class='interactive-portname port-menu nolink'><?php $this->localport ?></a>
		</td>
	<?php } ?>
	<td><?php $this->portIIFOIFLocal ?></td>
	<td><?php $this->ifTypeVariants ?></td>
	<td><?php $this->device ?></td>
	<?php if (!$this->is("id_port_link_remote")) { ?>
		<td><?php $this->id_port_link_remote ?></td>
	<?php } ?> 
	<td><?php $this->portIIFOIFRemote ?></td>
	<td><?php if ($this->is("inputno",null)) { ?>
		<input type=checkbox name=do_<?php $this->inputno ?> class='cb-makelink'>
	<?php } ?></td>
	<?php if ($this->is("error_message")) { ?>
		<td style="background-color: white; border-top: none"><?php $this->error_message ?></td>
	<?php } ?> 
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>