<?php if (defined("RS_TPL")) { 
	$this->addJS(
		'$(document).ready( function () {' .
    	'$("#object_table").DataTable(); ' .
		'} );',
	true); 
?>
<div class='row'>
	<div class='col-md-10'>
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Objects</h3>
			</div>
			<div class="box-body">
				<table id="object_table" class="display">
					<thead>
						<tr><th>Common name</th><th>Visible label</th><th>Asset tag</th><th>Row/Rack or Container</th></tr>
					</thead>
					<tbody>
						<?php $this->startLoop("AllObjects"); ?>	
							<tr class='<?php $this->Problem ?>'>
								<td>
									<?php $this->Mka ?> 
									<?php $this->RenderedTags ?>
								</td>
								<td>
									<?php $this->Label ?>
								</td>
								<td>
									<?php $this->Asset_no ?>
								</td>
								<td>
									<?php $this->Places ?>
								</td>
							</tr>
						<?php $this->endLoop(); ?>
					</tbody>
					<tfoot>
						<tr><th>Common name</th><th>Visible label</th><th>Asset tag</th><th>Row/Rack or Container</th></tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class='col-md-2'>
		<?php $this->CellFilterPortlet; ?>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>