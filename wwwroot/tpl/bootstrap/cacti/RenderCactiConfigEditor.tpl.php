<?php if (defined("RS_TPL")) {?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Cacti editor</h3>
		</div>
		<div class="box-body no-padding">
			<table class=table>
				<tr><th>base URL</th><th>username</th><th>password</th><th>graph(s)</th><th>&nbsp;</th></tr>
				<?php if($this->is('AddTop', true)) { ?>
					<?php $this->getH("Form","add"); ?>
					<tr>
						<td><input type=text size=48 name=base_url tabindex=101></td>
						<td><input type=text size=24 name=username tabindex=102 class="form-control"></td>
						<td><input type=password size=24 name=password tabindex=103 class="form-control"></td>
						<td>&nbsp;</td>
						<td><button class="btn btn-primary" name="submit" title="add a new server" tabindex="112"><span class="glyphicon glyphicon-plus"></span></button></td>
					</tr>
					</form>
				<?php } ?>
				<?php while($this->loop('CactiServers')) { ?>
					<?php $this->getH("Form","upd"); ?>
					<input type="hidden" name="id" value="<?php $this->Id; ?>">
					<tr>
						<td><input type=text size=48 name=base_url value="<?php $this->BaseUrl; ?>" class="form-control"></td>
						<td><input type=text size=24 name=username value="<?php $this->Username; ?>" class="form-control"></td>
						<td><input type=password size=24 name=password value="<?php $this->Password; ?>" class="form-control"></td>
						<td><?php $this->NumGraphs; ?></td>
						<td>
							<div class="btn-group">
								<btn class="btn btn-success" name="submit"><span class="glyphicon glyphicon-ok"></span></btn>
								<?php if($this->is("NumGraphs", true)) { ?>
									<a href='#' class="btn btn-danger disabled" title="cannot delete, graphs exist"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } else { ?>
									<a href="?module=redirect&op=del&id=<?php $this->Id ?>&page=cacti&tab=servers" class="btn btn-danger" title="Delete this server"><span class="glyphicon glyphicon-remove"></span></a>
								<?php }?>
							</div>
						</td>
					</tr>
					</form>
				<?php } ?>
				<?php if($this->is('AddTop', false)) { ?>
					<?php $this->getH("Form","add"); ?>
					<tr>
						<td><input type=text size=48 name=base_url tabindex=101></td>
						<td><input type=text size=24 name=username tabindex=102 class="form-control"></td>
						<td><input type=password size=24 name=password tabindex=103 class="form-control"></td>
						<td>&nbsp;</td>
						<td><button class="btn btn-primary" name="submit" title="add a new server" tabindex="112"><span class="glyphicon glyphicon-plus"></span></button></td>
					</tr>
					</form>
				<?php } ?>
			</table>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>