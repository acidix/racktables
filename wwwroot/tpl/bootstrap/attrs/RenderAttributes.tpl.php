<?php if (defined("RS_TPL")) {?>
<div class="box" style="position: relative; overflow-x: auto">
	<div class="box-header">
	    <h3 class="box-title">Optional attributes</h3>
	</div>
	<div class="box-body" style="position: relative">
		<table class="table table-bordered table-striped datatable" id='attrs_table' border=0 cellpadding=5 cellspacing=0 align='center'>
		<thead><tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr></thead>
		<tbody>
		<?php while($this->refLoop('AllAttrs')) { ?>
			<tr class=row_<?php $this->Order; ?>>
			<td class=tdleft><?php $this->Name; ?></td>
			<td class=tdleft><?php $this->Type; ?></td>
			<td class=tdleft>
			<?php $this->ApplicationSet ?>
			<?php while ($this->loop('AllAttrsMap')) : ?>
				<?php $this->ObjType ?>
				<?php $this->DictCont ?>
				<br>
			<?php endwhile ?>
			</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		<!-- DATA TABES SCRIPT -->
		<script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- DATA Tables CSS -->
		<link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
