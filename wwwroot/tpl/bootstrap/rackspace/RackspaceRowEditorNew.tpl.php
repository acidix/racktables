<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("Form","addRow"); ?>
	<tr>
	<td><select name=location_id tabindex=100 class="form-control">
		<?php $this->Options; ?>
		</select>
	</td>
	<td>
		<input type=text name=name tabindex=100 class="form-control">
	</td>
	<td>
		<button type="button" class="btn btn-primary" title="Add new row" tabindex="102" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
	</td>
	</tr>
	</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>