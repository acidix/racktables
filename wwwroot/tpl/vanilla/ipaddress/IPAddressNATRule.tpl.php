<?php if (defined("RS_TPL")) {?>
	<tr>
		<td><?php $this->Proto; ?></td>
		<td><a href="<?php $this->FromLink; ?>"><?php $this->FromIP; ?> : <?php $this->FromPort; ?></a></td>
		<td><a href="<?php $this->ToLink; ?>"><?php $this->ToIP; ?> : <?php $this->ToPort; ?></a></td>
		<td><?php $this->Description; ?></td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>