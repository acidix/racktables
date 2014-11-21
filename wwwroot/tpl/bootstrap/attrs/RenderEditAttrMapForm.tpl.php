<?php if (defined("RS_TPL")) {?>
<div class="box box-info rackbox" style="position: relative; overflow-x: auto">
	<div class="box-header">
        <h3 class="box-title">Attribute map</h3>
    </div>
    <div class="box-body" style="position: relative">
		<table class="table table-bordered table-striped" id='attribute_map_table' border=0 cellpadding=5 cellspacing=0 align='center'>
			<thead><tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr></thead>
			<tbody>
			<?php if ($this->is('NewTop')) : ?>
				<?php $this->getH('PrintOpFormIntro', 'add'); ?>
				<tr>
					<td colspan=2 class=tdleft>
						<select class="form-control" name=attr_id tabindex=100>
							<?php $this->startLoop('CreateNewAttrMaps'); ?>
							<option value=<?php $this->Id; ?> >[<?php $this->Shorttype; ?>] <?php $this->Name; ?></option>
							<?php $this->endLoop(); ?>
						</select>
					</td>
					<td class=tdleft>
						<?php $this->getH('PrintImageHref', array('add', '', TRUE)); echo ' '; 
			 			 	  $this->CreateNewSelect;	?>
	   					<select class="form-control" name=chapter_no tabindex=102><option value=0>-- dictionary chapter for [D] attributes --</option>
						<?php $this->startLoop('CreateNewChapters'); ?>
							<option value='<?php $this->Id; ?>'><?php $this->Name; ?></option>
						<?php $this->endLoop(); ?>
						</select>
					</td>
				</tr>
				</form>
			<?php endif ?>
			<?php while ($this->loop('AttrMap')) : ?>
				<tr class=row_<?php $this->Order; ?>>
					<td class=tdleft><?php $this->Name; ?></td>
					<td class=tdleft><?php $this->AttrTypes; ?></td>
					<td colspan=2 class=tdleft>
						<?php while($this->loop('AttrMapChilds')) : ?>
							<?php if ($this->is('Sticky', 'yes')) { ?>
								<?php $this->getH("PrintImageHref", array('nodelete', 'system mapping')); ?>	
							<?php } elseif ($this->is('RefCnt', true) ){ ?>
								<?php $this->getH("PrintImageHref", array('nodelete', $this->_RefCnt . ' value(s) stored for objects')); ?> 
							<?php } else { ?>
								<?php $this->getH("GetOpLink", array(array('op'=>'del', 'attr_id'=>$this->_Id, 'objtype_id'=>$this->_ObjId), '', 'delete', 'Remove mapping')); ?>
							<?php } ?>
							<?php $this->DecObj ?>
							<?php if ($this->is("Type",'dict')) { ?>
								(values from '<?php $this->ChapterName ?>')
							<?php } ?>
							<br />	
						<?php endwhile ?>	 
					</td>
				</tr>
			<?php endwhile ?>
			<?php if (!$this->is('NewTop')) : ?>
				<?php $this->getH('PrintOpFormIntro', 'add'); ?>
				<tr>
					<td colspan=2 class=tdleft>
						<select name=attr_id tabindex=100>
							<?php $this->startLoop('CreateNewAttrMaps'); ?>
							<option value=<?php $this->Id; ?> >[<?php $this->Shorttype; ?>] <?php $this->Name; ?></option>
							<?php $this->endLoop(); ?>
						</select>
					</td>
					<td class=tdleft>
						<?php $this->getH('PrintImageHref', array('add', '', TRUE)); echo ' '; 
			 			 	  $this->CreateNewSelect;	?>
	   					<select name=chapter_no tabindex=102><option value=0>-- dictionary chapter for [D] attributes --</option>
						<?php $this->startLoop('CreateNewChapters'); ?>
							<option value='<?php $this->Id; ?>'><?php $this->Name; ?></option>
						<?php $this->endLoop(); ?>
						</select>
					</td>
				</tr>
				</form>
			<?php endif ?>
			</tbody>
		</table>
		<!-- DATA TABES SCRIPT -->
		<script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- DATA Tables CSS -->
		<link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
		$(function() {
			tagsDataTable('#attribute_map_table');
		});
		</script>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>