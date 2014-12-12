<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-body">
		<table class="table">
			<thead>
				<tr><th>Origin</th><th>Key</th><th><?php $this->ColHeader ?></th></tr>
			</thead>
			<tbody>
				<?php while($this->refLoop('AllRows')) { ?>
					<tr>
						<td>
							<?php if ($this->is('OriginIsDefault')) { ?>
								<span class="glyphicon glyphicon-home"></span>
							<?php } else { ?>
								<span style="color: red" class="glyphicon glyphicon-heart"></span>
							<?php } ?> 
						</td>
						<td><?php $this->RowColumnKey ?></td>
						<td><?php $this->RowString ?></td>
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