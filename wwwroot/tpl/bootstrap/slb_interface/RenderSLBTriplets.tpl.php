<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">VS instances (<?php $this->countTriplets ?>)</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr>
					<?php while($this->loop("cellRealmHeaders")) { ?>	
						<th><?php $this->header ?> </th>
					<?php } ?>
					<?php while($this->loop("cellHeaders")) { ?>	
						<th><?php $this->header ?> </th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php $this->startLoop("tripletsOutArray"); ?>	
					<tr valign=top class='row_<?php $this->order ?>  triplet-row'>
						<?php $this->cellsOutput ?>
						<td class=slbconf> <?php $this->vsconfig ?> </td>
						<td class=slbconf> <?php $this->rsconfig ?> </td>
						<td class=slbconf> <?php $this->prio ?> </td>	 
					</tr>
				<?php $this->endLoop(); ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>