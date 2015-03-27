<?php
	if (defined("RS_TPL")) {
	$js = <<<JS
	function locationeditor_showselectbox(e) {
		$(this).load('index.php', {module: 'ajax', ac: 'get-location-select', locationid: this.id});
		$(this).unbind('mousedown', locationeditor_showselectbox);
	}
	$(document).ready(function () {
		$('select.locationlist-popup').bind('mousedown', locationeditor_showselectbox);
	});
JS;
	$this->addJS($js,true);?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Locations</h3>
		</div>
		<div class="box-body no-padding">
			<table class=table>
			<tr><th>&nbsp;</th><th>Parent</th><th>Name</th><th>&nbsp;</th></tr>
			<?php if($this->is('renderNewTop')) : ?>
				<form method=post id=addLocation name=addLocation action='?module=redirect&page=rackspace&tab=editlocations&op=addLocation'>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<select name=parent_id tabindex=100 class="form-control">
							<?php $this->RenderNewFormOptions; ?>
						</select>
					</td>
					<td>
						<input type=text size=48 name=name tabindex=101 class="form-control">
					</td>
					<td>
						<button type="submit" class="btn btn-primary btn-sm" border="0" tabindex="102" title="Add new location"><span class="glyphicon glyphicon-plus"></span></button>
					</td>
				</tr>
				</form>
			<?php endif ?>
			<?php while($this->loop('LocationList')) { ?>
				<tr>
					<td align=leftffor style='padding-left: <?php echo ($this->_Level * 16 + 10); ?>px'>
					<form method=post id="updateLocation" name="updateLocation" action='?module=redirect&page=rackspace&tab=editlocations&op=updateLocation'>
					<?php if($this->is("HasSublocations")) { ?>
						<span class="glyphicon glyphicon-chevron-right"></span>
					<?php } else { ?>
						<i class="fa fa-bars"></i>
					<?php } ?>
					</td>
					<td class=tdleft>
						<input type=hidden name="location_id" value="<?php $this->LocationId; ?>">
						<select name="parent_id" id="locationid_<?php $this->LocationId; ?>" class='locationlist-popup form-control'>
						<?php while ($this->loop('Parentselect')) { ?>
							<option value='<?php $this->ParenListId; ?>' <?php $this->ParentListSelected; ?>><?php $this->ParentListContent; ?></option>
						<?php } ?>
						</select>
					</td>
					<td class=tdleft>
						<input type=text size=48 name=name value='<?php $this->LocationName; ?>' class='form-control'/>
					</td>
					<td>
						<div class='btn-group'>
							<button class="btn btn-success" title="Save changes" type="submit"><span class="glyphicon glyphicon-ok"></span></button>
							<?php if($this->is("IsDeletable")) { ?>
							<a class="btn btn-danger" title="Delete location" href="?module=redirect&op=deleteLocation&location_id=<?php $this->LocationId; ?>&page=rackspace&tab=editlocations">
    							<span class="glyphicon glyphicon-remove"></span>
    						</a>
							<?php } else { ?>
							<a class="btn btn-danger disabled" href="#">
    							<span class="glyphicon glyphicon-remove"></span>
    						</a>
							<?php } ?>
						</div>
					</form>
					</td>
				</tr>
			<?php } ?>
			<?php if(!$this->is('renderNewTop')) : ?>
				<form method=post id=addLocation name=addLocation action='?module=redirect&page=rackspace&tab=editlocations&op=addLocation'>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<select name=parent_id tabindex=100 class="form-control">
							<?php $this->RenderNewFormOptions; ?>
						</select>
					</td>
					<td>
						<input type=text size=48 name=name tabindex=101 class="form-control">
					</td>
					<td>
						<button type="submit" class="btn btn-primary btn-sm" border="0" tabindex="102" title="Add new location"><span class="glyphicon glyphicon-plus"></span></button>
					</td>
				</tr>
				</form>
			<?php endif ?>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>