<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-header">
	    <h3 class="box-title">Optional attributes</h3>
	</div>
	<div class="box-body" style="position: relative">
		<table class="table table-bordered table-striped" id='attrs_table' cellspacing=0 cellpadding=5 align="center">
		<thead><tr><th>&nbsp;</th><th>Name</th><th>Type</th><th>&nbsp;</th></tr></thead>
		<tbody>
		<?php if($this->is('NewTop')) : ?>
			<tr>
				<?php $this->getH('PrintOpFormIntro', 'add'); ?>
				<td><button type="submit" class="btn btn-primary btn-sm" tabindex="99" title="Create attribute"><span class='glyphicon glyphicon-plus'></span></button></td>
				<td><input type=text tabindex=100 name=attr_name></td>
				<td><?php $this->CreateNewSelect; ?></td>
				<td><button type="submit" class="btn btn-primary btn-sm" tabindex="102" title="Create attribute"><span class='glyphicon glyphicon-plus'></span></button></td>
				</form>
			</tr>
		<?php endif ?>

		<?php	while($this->loop('AllAttrMaps')) : ?>
			<tr>
				<?php $this->OpFormIntro; ?>
				<td>
					<?php if($this->is('AttrId')) { ?>
							<a class="btn btn-danger btn-sm" href="?module=redirect&amp;op=del&amp;attr_id=<?php $this->AttrId ?>&amp;page=attrs&amp;tab=editattrs" title="Remove attribute"><span class='glyphicon glyphicon-minus'></span></a>
						<?php } else { ?>
							<button class="btn btn-danger disabled btn-sm" title="Remove attribute"><span class='glyphicon glyphicon-minus'></span></button>
					  <?php } ?>
				</td>
				<td><input type=text name=attr_name value='<?php $this->Name; ?>'></td>
			<td class=tdleft><?php $this->Type; ?></td><td>
				<a class="btn btn-success btn-sm"  title="Save changes">
					<span class='glyphicon glyphicon-ok'></span>
			 </a>
			</td>
			</form>
			</tr>
		<?php endwhile ?>

		<?php if(!$this->is('NewTop')) : ?>
			<tr>
				<?php $this->getH('PrintOpFormIntro', 'add'); ?>
				<td><button type="submit" class="btn btn-primary btn-sm" tabindex="99" title="Create attribute"><span class='glyphicon glyphicon-plus'></span></button></td>
				<td><input type=text tabindex=100 name=attr_name></td>
				<td><?php $this->CreateNewSelect; ?></td>
				<td><button type="submit" class="btn btn-primary btn-sm" tabindex="102" title="Create attribute"><span class='glyphicon glyphicon-plus'></span></button></td>
				</form>
			</tr>
		<?php endif; ?>
		</tbody>
		</table>

		<!-- DATA TABES SCRIPT -->
		<script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- DATA Tables CSS -->
		<link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
		$(function() {
			tagsDataTable('#attrs_table');
		});
		</script>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
