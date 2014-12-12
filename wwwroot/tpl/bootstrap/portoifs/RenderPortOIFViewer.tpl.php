<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
				<tr><th>Origin</th><th>Key</th><th>Refcnt</th><th>Outer Interface</th></tr>
			</thead>
			<tbody>
				<?php while($this->loop('AllOptions')) : ?>	
					<tr class=row_<?php $this->Order ?>>
						<td class=tdleft><span class="glyphicon glyphicon-home"></span></td>
						<td class=tdright><?php $this->Oif_id ?></td>
						<td class=tdright><?php $this->Refcnt ?></td>
						<td class=tdleft><?php $this->NiftyString ?></td>
					</tr>
				<?php endwhile ?> 
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>