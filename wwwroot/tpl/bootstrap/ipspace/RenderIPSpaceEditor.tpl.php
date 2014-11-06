<?php if (defined("RS_TPL")) {?>
<div class="box box-info rackbox" style="position: relative; overflow-x: auto">
	<div class="box-header" style="cursor: move;">
        <h3 class="box-title">Manage existing (<?php $this->countAddrspaceList ?>)</h3>
     </div>
     <div class="box-body" style="position: relative">
	
	<?php if ($this->is("hasAddrspaceList", true)) { ?>
		<table class="table table-bordered table-striped" id="addrspacelist_table" border=0 cellpadding=5 cellspacing=0 align='center'>
			<thead><tr><th>&nbsp;</th><th>prefix</th><th>name</th><th>capacity</th></tr></thead>
			<tbody>
			<?php $this->startLoop("allNetinfo"); ?>	
				<tr valign=top><td>
				<?php $this->destroyItem ?>
				</td><td class=tdleft><?php $this->mkAIpmask ?></td>
				<td class=tdleft><?php $this->name ?>
				<?php $this->RendTags ?>
				</td>
				<td>
				<?php $this->ipnetCap ?>
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
			tagsDataTable('addrspacelist_table');
		});
		// var datatab = $("#addrspacelist_table").dataTable();
		</script>
	<?php } ?> 
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>