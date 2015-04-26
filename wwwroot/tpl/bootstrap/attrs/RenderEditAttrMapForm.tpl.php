<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-header">
        <h3 class="box-title">Attribute map</h3>
    </div>
    <div class="box-body">
		<table class="table table-bordered table-striped" id='attribute_map_table' border=0 cellpadding=5 cellspacing=0 align='center'>
			<thead><tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr></thead>
			<tbody>
			<?php if ($this->is('NewTop')) : ?>
				<tr>
					<?php $this->getH('PrintOpFormIntro', 'add'); ?>
					<td >
						<select class="form-control pull-left" name=attr_id tabindex=100>
							<?php while($this->loop('CreateNewAttrMaps')) : ?>
								<option value=<?php $this->Id; ?> >[<?php $this->Shorttype; ?>] <?php $this->Name; ?></option>
							<?php endwhile ?>
						</select>
					</td>
					<td>&nbsp;</td>
					<td>
						<?php $this->CreateNewSelect;	?>
						<select class="form-control" name=chapter_no tabindex=102><option value=0>-- dictionary chapter for [D] attributes --</option>
						<?php $this->startLoop('CreateNewChapters'); ?>
							<option value='<?php $this->Id; ?>'><?php $this->Name; ?></option>
						<?php $this->endLoop(); ?>
						</select>
						<button submit class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
					</td>
					</form>
				</tr>
			<?php endif ?>
			<?php while ($this->loop('AttrMap')) : ?>
				<tr class=row_<?php $this->Order; ?>>
					<td class=tdleft><?php $this->Name; ?></td>
					<td class=tdleft><?php $this->AttrTypes; ?></td>
					<td colspan=2 class=tdleft>
						<?php while($this->loop('AttrMapChilds')) : ?>
							<?php if ($this->is('Sticky', 'yes')) { ?>
								<a style="color: lightgrey" title="system mapping'">
									<i class="fa fa-minus"></i>
								</a>
							<?php } elseif ($this->is('RefCnt', true) ){ ?>
								<a style="color: lightgrey" title="<?php $this->RefCnt ?> value(s) stored for objects'">
									<i class="fa fa-minus"></i>
								</a>
							<?php } else { ?>
								<a href="?module=redirect&op=del&attr_id=<?php $this->Id ?>&objtype_id=<?php $this->ObjId ?>&page=attrs&tab=editmap" title="Remove mapping">
									<i class="fa fa-minus"></i>
								</a>
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
					<?php $this->getH('PrintOpFormIntro', 'add'); ?>
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
					</form>
				</tr>
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
