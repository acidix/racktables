<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">TITLE HERE</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>Origin</th><th>Key</th><th><?php $this->ColHeader ?></th></tr>
			</thead>
			<tbody>
				<?php while($this->refLoop('AllRows')) { ?>
					<tr>
						<td>
							<?php if ($this->is('OriginIsDefault')) { ?>
								<?php $this->getH('PrintImageHref', array('computer', 'default')); ?><!-- @TODO Put the symbols for default/custom here -->
							<?php } else { ?>
								<?php $this->getH("PrintImageHref", array('favorite', 'custom')); ?>
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