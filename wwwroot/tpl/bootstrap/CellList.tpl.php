<?php if (defined("RS_TPL")) {?>
<?php if(!$this->is("EmptyResults")) { ?>
	<div class="box" style="position: relative; overflow-x: auto">
	<div class="box-header">
	    <h3 class="box-title"><?php $this->Title; ?> (<?php $this->CellCount; ?>)</h3>
	</div>
	<div class="box-body" style="position: relative">
		<table class="table table-bordered table-striped" id="cellListTable">
			<thead><th>File</th></thead>
			<tbody>
				<?php $this->startLoop("CellListContent"); ?>
				<tr class=row_<?php $this->Order; ?>>
					<td>
					<?php $this->CellContent; ?>
					</td>
				</tr>
			<?php $this->endLoop(); ?>
			</tbody>
		</table>
		<!-- DATA TABES SCRIPT -->
		<script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- DATA Tables CSS -->
		<link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
		$(function() {
			tagsDataTable('#cellListTable');
		});
		</script>
	</div>
	</div>
<?php } else { ?>
	<?php $this->EmptyResults; ?>
<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
