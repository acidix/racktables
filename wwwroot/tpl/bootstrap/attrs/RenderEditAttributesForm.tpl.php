<?php if (defined("RS_TPL")) {?>
<div class="box box-info" style="position: relative; overflow-x: auto">
	<div class="box-header">
	    <h3 class="box-title">Optional attributes</h3>
	</div>
	<div class="box-body" style="position: relative">
		<table class="table table-bordered table-striped" id='attrs_table' cellspacing=0 cellpadding=5 align="center">
		<thead><tr><th>&nbsp;</th><th>Name</th><th>Type</th><th>&nbsp;</th></tr></thead>
		<tbody>
		<?php if($this->is('NewTop')) : ?>
			<?php $this->getH('PrintOpFormIntro', 'add'); ?>
			<tr><td>
				<?php $this->getH('PrintImageHref', array('create', 'Create attribute', TRUE)); ?>
			</td><td><input type=text tabindex=100 name=attr_name></td><td>
				<?php $this->CreateNewSelect; ?>
			</td><td>
				<?php $this->getH('PrintImageHref', array('create', 'Create attribute', TRUE, 102)); ?>
			</td></tr></form>
		<?php endif ?>
		<?php	$this->startLoop('AllAttrMaps'); ?>
			<?php $this->OpFormIntro ?>
			<tr><td>	
			<?php $this->DestroyImg ?>
			</td><td><input type=text name=attr_name value='<?php $this->Name; ?>'></td>
			<td class=tdleft><?php $this->Type; ?></td><td>
			<input type="image" name="submit" class="icon" src="?module=chrome&amp;uri=pix/tango-document-save-16x16.png" border="0" title="Save changes">
			</td></tr></form>
			
		<?php $this->endLoop(); ?>
		<?php if(!$this->is('NewTop')) : ?>
			<?php $this->getH('PrintOpFormIntro', 'add'); ?>
			<tr><td>
				<?php $this->getH('PrintImageHref', array('create', 'Create attribute', TRUE)); ?>
			</td><td><input type=text tabindex=100 name=attr_name></td><td>
				<?php $this->CreateNewSelect; ?>
			</td><td>
				<?php $this->getH('PrintImageHref', array('create', 'Create attribute', TRUE, 102)); ?>
			</td></tr></form>
		<?php endif ?>
		</tbody>
		</table>
		<!-- DATA TABES SCRIPT -->
		<script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- DATA Tables CSS -->
		<link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
		$(function() {
			tagsDataTables('#attrs_table');
		});
		</script>
	</div>
</div>	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>