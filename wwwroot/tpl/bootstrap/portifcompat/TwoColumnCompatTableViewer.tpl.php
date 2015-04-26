<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
				<tr><th>Key</th><th style="text-align: center"><?php $this->LeftHeader ?></th><th>Key</th><th style="text-align: center"><?php $this->RightHeader ?></th></tr>
			</thead>
			<tbody>
				<?php while($this->loop("AllCompats")) { ?>
					<tr class=row_<?php $this->Order ?>>
						<td><?php $this->LeftKey ?></td>
						<td><?php $this->LeftValue ?></td>
						<td><?php $this->RightKey ?></td>
						<td><?php $this->RightValue ?></td>
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
