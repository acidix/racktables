<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title"><?php $this->Title; ?></h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>sequence</th><th>regexp</th><th>role</th><th>VLAN IDs</th><th>comment</th></tr>
			</thead>
			<tbody>
				<?php if($this->is('Rules_empty', TRUE)){ ?>
					<tr><td colspan=5>No rules.</td></tr>
				<?php } ?>
				<?php while($this->Loop("VstRows")) { ?>
					<tr>
						<td><?php $this->Rule_no ?></td>
						<td nowrap><?php $this->Port_pcre ?></td>
						<td nowrap><?php $this->Port_role ?></td>
						<td><?php $this->Wrt_vlans ?></td>
						<td><?php $this->Description ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>