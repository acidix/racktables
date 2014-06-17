<?php if (defined("RS_TPL")) {?>
	<form method=post id=addLocation name=addLocation action='?module=redirect&page=rackspace&tab=editlocations&op=addLocation'>
		<tr>
			<td>
			</td>
			<td>
				<select class="form-control" name=parent_id tabindex=100 >
				<?php $this->Options; ?>
				</select>
			</td>
			<td>

				<input class="form-control" type=text size=48 name=name tabindex=101 placeholder="Enter new location">

			</td>
			<td>
			
  				<button type="submit" class="btn btn-primary">
  				<span class="glyphicon glyphicon-floppy-disk"></span>
  				</button>
 

				
			</td>
		</tr>
	</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>