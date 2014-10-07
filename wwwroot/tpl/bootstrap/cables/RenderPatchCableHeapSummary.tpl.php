<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Heaps</h3>
	</div>
	<div class="box-content no-padding">
		<table class=table>
			<thead>
				<tr><th>Amount</th><th>End 1</th><th>Cable type</th><th>End 2</th><th>Length</th><th>Description</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php while($this->refLoop('AllHeaps')) { ?>	
					<tr>
						<td><?php $this->HeapAmount ?></td>
						<td><?php $this->HeapEndCon1 ?></td>
						<td><?php $this->HeapPCType ?></td>
						<td><?php $this->HeapEndCon2 ?></td>
						<td><?php $this->HeapLength ?></td>
						<td><?php $this->HeapDesc ?></td>
						<td><?php $this->HeapPatchCalbeLength ?></td>
					</tr>
				<?php } ?> 
			</tbody>
		</table>
	</div>
</div>
<?php if ($this->is('ZoomOrEventLog')) { ?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Event log</h3>
	</div>
	<div class="box-content no-padding">
		<table class=table>
			<thead>
				<tr><th>Date</th><th>User</th><th>Message</th></tr>
			</thead>
			<tbody>
				<?php while($this->startLoop('AllEvents')) : ?>	
					<tr>
						<td><?php $this->EventDate ?></td>
						<td><?php $this->EventUser ?></td>
						<td><?php $this->EventMessage ?></td>
					</tr>
				<?php endwhile ?> 
			</tbody>
		</table>
	</div>
</div>
<?php } ?> 	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>