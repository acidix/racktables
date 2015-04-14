<?php if (defined("RS_TPL")) {?>
	<table class=widetable border=0 cellpadding=10 cellspacing=0 align=center>
	<tr><th>RS pool</th><th>in service</th><th>real IP address</th><th>real port</th><th>RS configuration</th></tr>
	<?php while($this->loop("allRslist")) { ?>
		<tr valign=top class=row_<?php $this->order ?>><td>
		<?php $this->mkADname ?>
		</td><td align=center>

		<?php if($this->is('inservice', true)) {
			$this->getH('PrintImageHref', array('inservice', 'in service'));
		} else {
			$this->getH('PrintImageHref', array('notinservice', 'NOT in service'));
		} ?>
		</td><td><?php $this->mkARsinfo ?></td>
		<td><?php $this->rsport ?></td>
		<td><pre><?php $this->rsconfig ?></pre></td>
		</tr>
	<?php } ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
