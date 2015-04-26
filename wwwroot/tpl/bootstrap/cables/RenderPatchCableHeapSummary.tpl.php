<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Heaps</h3>
	</div>
	<div class="box-body">
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
						<td><?php $this->HeapPatchCableLength ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
    $(function() {
     	// Replace images with glyphicons
			$('img[src*="tango-system-search-22x22.png"]').each(function () {
				console.log($(this));
				$(this).parent().addClass('glyphicon glyphicon-zoom-in');
				$(this).parent().css('font-size', '25px');
				$(this).remove();
			});
			$('img[src*="tango-view-fullscreen-22x22.png"]').each(function () {
				console.log($(this));
				$(this).parent().addClass('glyphicon glyphicon-zoom-out');
				$(this).parent().css('font-size', '25px');
				$(this).remove();
			});

    });
</script>

<?php if ($this->is('ZoomOrEventLog')) { ?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Event log</h3>
	</div>
	<div class="box-content">
		<table class=table>
			<thead>
				<tr><th>Date</th><th>User</th><th>Message</th></tr>
			</thead>
			<tbody>
				<?php while($this->loop('AllEvent')) : ?>
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
