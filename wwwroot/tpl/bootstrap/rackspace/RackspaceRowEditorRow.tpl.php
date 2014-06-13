<?php if (defined("RS_TPL")) {?>
	<form method=post id="updateRow" name="updateRow" action='?module=redirect&page=rackspace&tab=editrows&op=updateRow'>
	<input type=hidden name="row_id" value="<?php $this->RowId; ?>">
	<tr>
		<td>
			<select name=location_id tabindex=100 class="form-control">
				<?php $this->Options; ?>
			</select>
		</td>
		<td>
			<input type=text name=name value='<?php $this->RowName; ?>' tabindex=100 class="form-control">
		</td>
		<td>
			<div class="btn-group">
  				<button type="submit" class="btn btn-primary" title="Save changes"><span class="glyphicon glyphicon-floppy-disk"></span></button>
  				<?php if ($this->is("HasChildren")) { ?>
  					<a title="<?php $this->RackCount; ?> rack(s) here" href="#" class="btn btn-danger disabled"><span class="glyphicon glyphicon-floppy-remove"></span></a>
  				<?php } else { ?>
  					<a title="Delete row" href="?module=redirect&op=deleteRow&row_id=<?php $this->RowId; ?>&page=rackspace&tab=editrows" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span></a>
  				<?php } ?>
  			</div>
		</td>
	</tr>
</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>