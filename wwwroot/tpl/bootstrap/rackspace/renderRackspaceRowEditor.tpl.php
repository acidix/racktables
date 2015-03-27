<?php if (defined("RS_TPL")) {?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Edit rows</h3>
		</div>
		<div class="box-body no-padding">
			<table class=table>
				<tr><th>Location</th><th>Name</th><th>&nbsp;</th></tr>
				<?php if ($this->is('NewTop')) : ?>
					<?php $this->getH("Form","addRow"); ?>
					<tr>
						<td></td>
						<td align="center">
							<select name=location_id tabindex=100 class="form-control">
								<?php $this->LocationNewOptions; ?>
							</select>
						</td>
						<td>
							<input type=text name=name tabindex=100 class="form-control">
						</td>
						<td>
							<button submit class="btn btn-primary" ><i class="fa fa-fw fa-plus"></i></button>
						</td>
					</tr>
					</form>
			<?php endif ?>
			<?php while ($this->loop('RowList')) : ?>
				<form method=post id="updateRow" name="updateRow" action='?module=redirect&page=rackspace&tab=editrows&op=updateRow'>
					<input type=hidden name="row_id" value="<?php $this->RowId; ?>">
					<tr>
						<td align=left style='padding-left: <?php echo ($this->_Level * 3 + 10); ?>px'>
						<?php if($this->is("HasSublocations")) { ?>
							<span class="glyphicon glyphicon-chevron-right"></span>
						<?php } else { ?>
							<i class="fa fa-bars"></i>
						<?php } ?>
						</td>
						<td align="center" style='padding-left: <?php $this->Level; ?>px'>
							<select name=location_id tabindex=100 class="form-control">
								<?php $this->LocationEditOptions; ?>
							</select>
						</td><td>
							<input type=text name=name value='<?php $this->RowName; ?>' tabindex=100 class="form-control">
						</td><td>
							<div class="btn-group">
								<button submit class="btn btn-success" name="submit"><span class="glyphicon glyphicon-ok"></span></button>
								<?php if($this->is("HasChildren")) { ?>
									<a href='#' class="btn btn-danger disabled" title="<?php $this->RackCount; ?> rack(s) here"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } else { ?>
									<a href="?module=redirect&op=deleteRow&row_id=<?php $this->RowId; ?>&page=rackspace&tab=editrows" class="btn btn-danger" title="Delete row"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } ?>
							</div>
						</td>
					</tr>
				</form>
			<?php endwhile ?>
			<?php if (!$this->is('NewTop')) : ?>
				<?php $this->getH("Form","addRow"); ?>
					<tr>
						<td></td>
						<td align="center"s>
							<select name=location_id tabindex=100 class="form-control">
								<?php $this->LocationNewOptions; ?>
							</select>
						</td>
						<td>
							<input type=text name=name tabindex=100 class="form-control">
						</td>
						<td>
							<button class="btn btn-primary" name="submit"><i class="fa fa-fw fa-plus"></i></button>
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