<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">VLAN domains</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>description</th><th>VLANs</th><th>switches</th><th><strong class='glyphicon glyphicon glyphicon-globe'></strong></th><th>ports</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!$this->is("areVLANDomains",true)) { ?>
				<?php $this->startLoop("vdListOut"); ?>	
					<tr align=left><td><?php $this->mkA ?></td>
						<?php $this->columnOut ?>
					</tr>  
				<?php $this->endLoop(); ?> 
				<?php if ($this->is("isVDList",true)) { ?>
					<tr align=left><td>total:</td>
					<?php $this->startLoop("TotalColumnOut"); ?>	
						<td><?php $this->cName ?> </td>
					<?php $this->endLoop(); ?> 
					</tr>
				<?php } ?>
				<?php } else { ?>
					<tr><td colspan=5>No VLAN domains</td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">switch templates</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr><th>description</th><th>rules</th><th>switches</th></tr>
			</thead>
			<tbody>
				<?php if (!$this->is("areVSTCells")){ ?>
					<?php while($this->loop("vstListOut")){ ?>	
						<tr align=left valign=top>
							<td>
								<?php $this->mkA ?>
								<?php $this->serializedTags ?>
							</td>
							<td><?php $this->rulec ?></td>
							<td><?php $this->switchc ?></td>
						</tr> 
					<?php } ?>
				<?php } else { ?>
					<tr><td colspan=3>No switch templates</td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">deploy queues</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<tbody>
				<?php $this->startLoop("allDeployQueues"); ?>	
					<tr>
						<th width="50%" class=tdright><?php $this->mkA ?></th>
						<td class=tdleft><?php $this->countItems ?></td>
					</tr>  
				<?php $this->endLoop(); ?> 
				<tr>
					<th width="50%" class=tdright>Total:</th>
					<td class=tdleft><?php $this->total ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>