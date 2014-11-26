<?php if (defined("RS_TPL")) {
	$this->addJs('js/lineeditor.js');
?>
<div class="box box-primary" id="addObjectsBox">
	<form method="post" id="addObjects" name="addObjects" action="?module=redirect&amp;page=depot&amp;tab=addmore&amp;op=addObjects"> 
	<input type="hidden" name="rowcount" value="<?php $this->rowCountDefault; ?>">
	<div class="box-header">
		<h3 class="box-title">Add objects</h3>
	</div>
	<div class="box-body no-padding" style="overflow-x: auto">
		<div class="table-responsive">
			<table class="table lineeditor-table">
				<thead>
					<tr>
						<th>Type</th>
						<th>Common name</th>
						<th>Visible label</th>
						<th>Asset tag</th>
						<th>Tags</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while($this->loop('AddTable')) { ?>
					<tr count="<?php $this->i ?>" >
						<td><?php $this->NiftySelect; ?></td>
						<td><input type=text name=<?php $this->i ?>_object_name></td>
						<td><input type=text name=<?php $this->i ?>_object_label ></td>
						<td><input type=text name=<?php $this->i ?>_object_asset_no ></td>
						<td style="min-width: 100px"><?php $this->TagsPicker; ?></td>
						<td style="min-width: 100px">
							<div class="btn-group" style="inline-table">
								<a class="btn btn-danger" name="<?php $this->i ?>_btn_remove" title="Remove this line" onclick="removeLine(<?php $this->i ?>)"><span class="glyphicon glyphicon-remove"></span></a>
								<a class="btn btn-primary" name="<?php $this->i ?>_btn_clone" title="Clone this line" onclick="cloneLine(<?php $this->i ?>)"><span class="glyphicon glyphicon-plus"></span></a>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="box-footer">
		<button class="btn btn-success btn-block ajax_form" reload-target='#addObjectsBox' targetform="addObjects">Submit</button>
	</div>
	</form>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>